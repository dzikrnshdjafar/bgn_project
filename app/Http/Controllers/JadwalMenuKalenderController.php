<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMenu;
use App\Models\DapurSehat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JadwalMenuKalenderController extends Controller
{
    /**
     * Display kalender jadwal menu.
     */
    public function index()
    {
        $user = auth()->user();

        // Get dapur_sehat_id dari user's sekolah
        $dapurSehatId = null;
        if ($user->sekolah) {
            $dapurSehatId = $user->sekolah->dapur_sehat_id;
        }

        // Get jadwal menu untuk SPPG user tersebut
        $jadwalMenus = [];
        if ($dapurSehatId) {
            $jadwalMenus = JadwalMenu::where('dapur_sehat_id', $dapurSehatId)
                ->with(['makanans.kategoriMakanan'])
                ->get();

            // Get all likes dengan tanggal untuk bulan ini dari counter table
            $currentMonth = now()->format('Y-m');
            foreach ($jadwalMenus as $menu) {
                $likes = DB::table('jadwal_menu_likes')
                    ->where('jadwal_menu_id', $menu->id)
                    ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$currentMonth])
                    ->select('tanggal', 'like_count')
                    ->get();

                $menu->likes_by_date = $likes->pluck('like_count', 'tanggal')->toArray();
            }
        }

        return view('pages.inner.kalender-menu.index', compact('jadwalMenus'));
    }

    /**
     * Get detail jadwal menu by hari.
     */
    public function getMenuByHari(Request $request)
    {
        $hari = $request->hari;
        $tanggal = $request->tanggal; // Format: YYYY-MM-DD
        $user = auth()->user();

        // Get dapur_sehat_id dari user's sekolah
        $dapurSehatId = null;
        if ($user->sekolah) {
            $dapurSehatId = $user->sekolah->dapur_sehat_id;
        }

        if (!$dapurSehatId) {
            return response()->json([
                'success' => false,
                'message' => 'Sekolah Anda belum terdaftar di SPPG manapun'
            ], 404);
        }

        $jadwalMenu = JadwalMenu::where('dapur_sehat_id', $dapurSehatId)
            ->where('hari', $hari)
            ->with(['makanans.kategoriMakanan'])
            ->first();

        if (!$jadwalMenu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu untuk hari ini belum tersedia'
            ], 404);
        }

        // Get like count dari counter table
        $likeRecord = DB::table('jadwal_menu_likes')
            ->where('jadwal_menu_id', $jadwalMenu->id)
            ->where('tanggal', $tanggal)
            ->first();

        $likesCount = $likeRecord ? $likeRecord->like_count : 0;
        $jumlahSisa = $likeRecord ? $likeRecord->jumlah_sisa : 0;

        // Group makanans by kategori
        $makananByKategori = $jadwalMenu->makanans->groupBy('kategoriMakanan.nama_kategori');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $jadwalMenu->id,
                'hari' => $jadwalMenu->hari,
                'keterangan' => $jadwalMenu->keterangan,
                'makanans' => $makananByKategori,
                'likesCount' => $likesCount,
                'jumlahSisa' => $jumlahSisa,
            ]
        ]);
    }

    /**
     * Add like untuk jadwal menu dengan counter system.
     */
    public function toggleLike(Request $request, $id)
    {
        $jadwalMenu = JadwalMenu::findOrFail($id);
        $tanggal = $request->tanggal; // Format: YYYY-MM-DD

        // Use firstOrCreate untuk get or create row, lalu increment
        $like = DB::table('jadwal_menu_likes')
            ->where('jadwal_menu_id', $jadwalMenu->id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($like) {
            // Increment existing counter
            DB::table('jadwal_menu_likes')
                ->where('jadwal_menu_id', $jadwalMenu->id)
                ->where('tanggal', $tanggal)
                ->increment('like_count');
            $likesCount = $like->like_count + 1;
        } else {
            // Create new row with count = 1
            DB::table('jadwal_menu_likes')->insert([
                'jadwal_menu_id' => $jadwalMenu->id,
                'tanggal' => $tanggal,
                'like_count' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $likesCount = 1;
        }

        return response()->json([
            'success' => true,
            'action' => 'liked',
            'likesCount' => $likesCount,
        ]);
    }

    /**
     * Get likes count per date untuk bulan tertentu
     */
    public function getLikesByMonth(Request $request)
    {
        $yearMonth = $request->year_month; // Format: YYYY-MM
        $user = auth()->user();

        // Get dapur_sehat_id dari user's sekolah
        $dapurSehatId = null;
        if ($user->sekolah) {
            $dapurSehatId = $user->sekolah->dapur_sehat_id;
        }

        if (!$dapurSehatId) {
            return response()->json([
                'success' => false,
                'message' => 'Sekolah Anda belum terdaftar di SPPG manapun'
            ], 404);
        }

        // Get jadwal menus untuk SPPG ini
        $jadwalMenus = JadwalMenu::where('dapur_sehat_id', $dapurSehatId)->get();

        $likesByDate = [];
        foreach ($jadwalMenus as $menu) {
            // Get likes dari counter table
            $likes = DB::table('jadwal_menu_likes')
                ->where('jadwal_menu_id', $menu->id)
                ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$yearMonth])
                ->select('tanggal', 'like_count')
                ->get();

            $likesByDate[$menu->hari] = $likes->pluck('like_count', 'tanggal')->toArray();
        }

        return response()->json([
            'success' => true,
            'likes_by_date' => $likesByDate
        ]);
    }

    /**
     * Update jumlah sisa makanan
     */
    public function updateJumlahSisa(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_sisa' => 'required|integer|min:0'
        ]);

        $jadwalMenu = JadwalMenu::findOrFail($id);
        $tanggal = $request->tanggal;
        $jumlahSisa = $request->jumlah_sisa;

        // Get or create record
        $like = DB::table('jadwal_menu_likes')
            ->where('jadwal_menu_id', $jadwalMenu->id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($like) {
            // Update existing record
            DB::table('jadwal_menu_likes')
                ->where('jadwal_menu_id', $jadwalMenu->id)
                ->where('tanggal', $tanggal)
                ->update([
                    'jumlah_sisa' => $jumlahSisa,
                    'updated_at' => now()
                ]);
        } else {
            // Create new record
            DB::table('jadwal_menu_likes')->insert([
                'jadwal_menu_id' => $jadwalMenu->id,
                'tanggal' => $tanggal,
                'like_count' => 0,
                'jumlah_sisa' => $jumlahSisa,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'jumlahSisa' => $jumlahSisa,
            'message' => 'Jumlah sisa makanan berhasil diperbarui'
        ]);
    }
}
