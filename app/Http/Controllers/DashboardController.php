<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('dashboard', compact(
            'totalSiswa',
            'siswaHadir',
            'siswaTidakHadir',
            'totalSekolah',
            'totalMakanan',
            'namaSekolah'
        ));
    }
}
