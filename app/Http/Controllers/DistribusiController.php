<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\Sekolah;
use App\Models\JadwalMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DistribusiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator Sekolah')) {
            abort(403);
        }

        $sekolah = $user->sekolah;
        if (!$sekolah) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di sekolah manapun.');
        }

        // Get filter parameters
        $bulan = $request->get('bulan', now()->format('Y-m'));
        $status = $request->get('status');

        $query = Distribusi::where('sekolah_id', $sekolah->id)
            ->with(['sppg', 'jadwalMenu.details.menu', 'jadwalMenu.details.kategoriMenu'])
            ->whereYear('tanggal_distribusi', '=', substr($bulan, 0, 4))
            ->whereMonth('tanggal_distribusi', '=', substr($bulan, 5, 2))
            ->orderBy('tanggal_distribusi', 'desc');

        if ($status) {
            $query->where('status_pengantaran', $status);
        }

        $distribusis = $query->paginate(20);

        return view('pages.inner.distribusi.index', compact('distribusis', 'sekolah', 'bulan', 'status'));
    }

    public function konfirmasi(Request $request, Distribusi $distribusi)
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator Sekolah')) {
            abort(403);
        }

        // Check if distribusi belongs to user's sekolah
        if ($distribusi->sekolah_id !== $user->sekolah->id) {
            abort(403);
        }

        $request->validate([
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $distribusi->update([
            'status_pengantaran' => 'sudah_diterima',
            'keterangan' => $request->keterangan,
            'tanggal_konfirmasi' => now(),
        ]);

        return redirect()->back()->with('success', 'Distribusi berhasil dikonfirmasi.');
    }

    public function batalKonfirmasi(Distribusi $distribusi)
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator Sekolah')) {
            abort(403);
        }

        // Check if distribusi belongs to user's sekolah
        if ($distribusi->sekolah_id !== $user->sekolah->id) {
            abort(403);
        }

        $distribusi->update([
            'status_pengantaran' => 'belum_diterima',
            'keterangan' => null,
            'tanggal_konfirmasi' => null,
        ]);

        return redirect()->back()->with('success', 'Konfirmasi distribusi berhasil dibatalkan.');
    }

    public function today()
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator Sekolah')) {
            abort(403);
        }

        $sekolah = $user->sekolah;
        if (!$sekolah) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di sekolah manapun.');
        }

        // Get today's date
        $today = Carbon::today();

        // Get today's distribusi
        $distribusiToday = Distribusi::where('sekolah_id', $sekolah->id)
            ->where('tanggal_distribusi', $today)
            ->with(['sppg', 'jadwalMenu.details.menu', 'jadwalMenu.details.kategoriMenu'])
            ->first();

        return view('pages.inner.distribusi.today', compact('distribusiToday', 'sekolah', 'today'));
    }

    public function generateDistribusi()
    {
        $user = Auth::user();

        if (!$user->hasRole('Admin')) {
            abort(403);
        }

        $generated = 0;
        $sekolahs = Sekolah::all();
        $today = Carbon::today();

        foreach ($sekolahs as $sekolah) {
            if (!$sekolah->sppg_id) {
                continue;
            }

            // Get active jadwal menus for this SPPG
            $jadwalMenus = JadwalMenu::where('sppg_id', $sekolah->sppg_id)
                ->where(function ($query) use ($today) {
                    $query->whereNull('tanggal_mulai')
                        ->orWhere(function ($q) use ($today) {
                            $q->where('tanggal_mulai', '<=', $today)
                                ->where(function ($q2) use ($today) {
                                    $q2->whereNull('tanggal_selesai')
                                        ->orWhere('tanggal_selesai', '>=', $today);
                                });
                        });
                })
                ->get();

            foreach ($jadwalMenus as $jadwal) {
                // Generate for periode
                $startDate = $jadwal->tanggal_mulai ?? $today;
                $endDate = $jadwal->tanggal_selesai ?? $today->copy()->addDays(30);

                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    // Skip Saturday and Sunday
                    if ($currentDate->dayOfWeek != Carbon::SATURDAY && $currentDate->dayOfWeek != Carbon::SUNDAY) {
                        // Check if hari matches
                        $hariMap = [
                            1 => 'senin',
                            2 => 'selasa',
                            3 => 'rabu',
                            4 => 'kamis',
                            5 => 'jumat',
                        ];

                        if (isset($hariMap[$currentDate->dayOfWeek]) && $hariMap[$currentDate->dayOfWeek] === $jadwal->hari) {
                            // Check if already exists
                            $exists = Distribusi::where('sekolah_id', $sekolah->id)
                                ->where('jadwal_menu_id', $jadwal->id)
                                ->where('tanggal_distribusi', $currentDate)
                                ->exists();

                            if (!$exists) {
                                Distribusi::create([
                                    'sekolah_id' => $sekolah->id,
                                    'sppg_id' => $sekolah->sppg_id,
                                    'jadwal_menu_id' => $jadwal->id,
                                    'tanggal_distribusi' => $currentDate,
                                    'status_pengantaran' => 'belum_diterima',
                                ]);
                                $generated++;
                            }
                        }
                    }
                    $currentDate->addDay();
                }
            }
        }

        return redirect()->back()->with('success', "Berhasil generate $generated data distribusi.");
    }

    public function generateBySppg($sppgId)
    {
        $user = Auth::user();

        if (!$user->hasRole('Admin|Operator BGN|Operator SPPG')) {
            abort(403);
        }

        // Operator SPPG can only generate for their own SPPG
        // if ($user->hasRole('Operator SPPG') && $user->sppg_id != $sppgId) {
        //     abort(403);
        // }

        $generated = 0;
        $sekolahs = Sekolah::where('sppg_id', $sppgId)->get();
        $today = Carbon::today();

        foreach ($sekolahs as $sekolah) {
            // Get active jadwal menus for this SPPG
            $jadwalMenus = JadwalMenu::where('sppg_id', $sppgId)
                ->where(function ($query) use ($today) {
                    $query->whereNull('tanggal_mulai')
                        ->orWhere(function ($q) use ($today) {
                            $q->where('tanggal_mulai', '<=', $today)
                                ->where(function ($q2) use ($today) {
                                    $q2->whereNull('tanggal_selesai')
                                        ->orWhere('tanggal_selesai', '>=', $today);
                                });
                        });
                })
                ->get();

            foreach ($jadwalMenus as $jadwal) {
                // Generate for periode
                $startDate = $jadwal->tanggal_mulai ?? $today;
                $endDate = $jadwal->tanggal_selesai ?? $today->copy()->addDays(30);

                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    // Skip Saturday and Sunday
                    if ($currentDate->dayOfWeek != Carbon::SATURDAY && $currentDate->dayOfWeek != Carbon::SUNDAY) {
                        // Check if hari matches
                        $hariMap = [
                            1 => 'senin',
                            2 => 'selasa',
                            3 => 'rabu',
                            4 => 'kamis',
                            5 => 'jumat',
                        ];

                        if (isset($hariMap[$currentDate->dayOfWeek]) && $hariMap[$currentDate->dayOfWeek] === $jadwal->hari) {
                            // Check if already exists
                            $exists = Distribusi::where('sekolah_id', $sekolah->id)
                                ->where('jadwal_menu_id', $jadwal->id)
                                ->where('tanggal_distribusi', $currentDate)
                                ->exists();

                            if (!$exists) {
                                Distribusi::create([
                                    'sekolah_id' => $sekolah->id,
                                    'sppg_id' => $sppgId,
                                    'jadwal_menu_id' => $jadwal->id,
                                    'tanggal_distribusi' => $currentDate,
                                    'status_pengantaran' => 'belum_diterima',
                                ]);
                                $generated++;
                            }
                        }
                    }
                    $currentDate->addDay();
                }
            }
        }

        return redirect()->back()->with('success', "Berhasil generate $generated data distribusi untuk SPPG ini.");
    }

    public function cancelBySppg($sppgId)
    {
        $user = Auth::user();

        if (!$user->hasRole('Admin|Operator SPPG')) {
            abort(403);
        }

        // Operator SPPG can only cancel for their own SPPG
        if ($user->hasRole('Operator SPPG') && $user->sppg_id != $sppgId) {
            abort(403);
        }

        // Delete all distribusi with status belum_diterima for this SPPG
        $deleted = Distribusi::where('sppg_id', $sppgId)
            ->where('status_pengantaran', 'belum_diterima')
            ->delete();

        return redirect()->back()->with('success', "Berhasil membatalkan $deleted data distribusi yang belum diterima untuk SPPG ini.");
    }
}
