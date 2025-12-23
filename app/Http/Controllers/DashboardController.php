<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Inisialisasi statistik
        $totalSiswa = 0;
        $siswaHadir = 0;
        $siswaTidakHadir = 0;
        $totalSekolah = 0;
        $totalMakanan = 0;

        // Jika Operator Sekolah, hanya statistik sekolahnya
        if ($user->hasRole('Operator Sekolah') && $user->sekolah) {
            $totalSiswa = Siswa::where('sekolah_id', $user->sekolah->id)->count();
            $siswaHadir = Siswa::where('sekolah_id', $user->sekolah->id)
                ->where('kehadiran', true)
                ->count();
            $siswaTidakHadir = Siswa::where('sekolah_id', $user->sekolah->id)
                ->where('kehadiran', false)
                ->count();
            $totalSekolah = 1; // Hanya sekolahnya sendiri
            $namaSekolah = $user->sekolah->nama_sekolah;
        }
        // Admin dan Operator BGN melihat semua
        else {
            $totalSiswa = Siswa::count();
            $siswaHadir = Siswa::where('kehadiran', true)->count();
            $siswaTidakHadir = Siswa::where('kehadiran', false)->count();
            $totalSekolah = Sekolah::count();
            $namaSekolah = null;
        }

        $totalMakanan = Makanan::count();

        // Get makanan dengan like terbanyak (aggregate dari counter table)
        $topLikedMakanans = DB::table('makanans as m')
            ->join('jadwal_menu_makanan as jmm', 'm.id', '=', 'jmm.makanan_id')
            ->join('jadwal_menu_likes as jml', 'jmm.jadwal_menu_id', '=', 'jml.jadwal_menu_id')
            ->select('m.id', 'm.nama_makanan', DB::raw('SUM(jml.like_count) as total_likes'))
            ->groupBy('m.id', 'm.nama_makanan')
            ->orderBy('total_likes', 'DESC')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalSiswa',
            'siswaHadir',
            'siswaTidakHadir',
            'totalSekolah',
            'totalMakanan',
            'namaSekolah',
            'topLikedMakanans'
        ));
    }
}
