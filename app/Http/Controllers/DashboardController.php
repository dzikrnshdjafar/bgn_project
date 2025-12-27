<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
use App\Models\Sekolah;
use App\Models\User;
use App\Models\Distribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect ke view sesuai role
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard();
        }

        if ($user->hasRole('Operator SPPG')) {
            return $this->sppgDashboard();
        }

        if ($user->hasRole('Operator Sekolah')) {
            return $this->sekolahDashboard();
        }

        return view('pages.inner.dashboard.dashboard');
    }

    private function adminDashboard()
    {
        $totalSppg = Sppg::count();
        $totalSekolah = Sekolah::count();
        $totalSiswa = Sekolah::sum('jumlah_siswa');

        $sekolahTerbanyak = Sekolah::with('sppg')
            ->orderBy('jumlah_siswa', 'desc')
            ->take(5)
            ->get();

        $distribusiHariIni = Distribusi::whereDate('tanggal_distribusi', today())->count();
        $distribusiDiterima = Distribusi::whereDate('tanggal_distribusi', today())
            ->where('status_pengantaran', 'sudah_diterima')
            ->count();

        // Data distribusi per SPPG untuk grafik
        $distribusiPerSppg = Sppg::withCount([
            'distribusis as total_diterima' => function ($query) {
                $query->where('status_pengantaran', 'sudah_diterima');
            }
        ])->get();

        return view('pages.inner.dashboard.dashboard-admin', compact(
            'totalSppg',
            'totalSekolah',
            'totalSiswa',
            'sekolahTerbanyak',
            'distribusiHariIni',
            'distribusiDiterima',
            'distribusiPerSppg'
        ));
    }

    private function sppgDashboard()
    {
        $user = Auth::user();
        $sppg = $user->sppg;

        $totalSekolah = $sppg ? $sppg->sekolahs()->count() : 0;
        $totalSiswa = $sppg ? $sppg->sekolahs()->sum('jumlah_siswa') : 0;

        $sekolahTerbanyak = $sppg ? $sppg->sekolahs()
            ->orderBy('jumlah_siswa', 'desc')
            ->take(5)
            ->get() : collect();

        $distribusiHariIni = $sppg ? Distribusi::where('sppg_id', $sppg->id)
            ->whereDate('tanggal_distribusi', today())
            ->count() : 0;

        $distribusiDiterima = $sppg ? Distribusi::where('sppg_id', $sppg->id)
            ->whereDate('tanggal_distribusi', today())
            ->where('status_pengantaran', 'sudah_diterima')
            ->count() : 0;

        return view('pages.inner.dashboard.dashboard-sppg', compact(
            'sppg',
            'totalSekolah',
            'totalSiswa',
            'sekolahTerbanyak',
            'distribusiHariIni',
            'distribusiDiterima'
        ));
    }

    private function sekolahDashboard()
    {
        $user = Auth::user();
        $sekolah = $user->sekolah;

        $distribusiBulanIni = $sekolah ? Distribusi::where('sekolah_id', $sekolah->id)
            ->whereMonth('tanggal_distribusi', now()->month)
            ->count() : 0;

        $distribusiDiterima = $sekolah ? Distribusi::where('sekolah_id', $sekolah->id)
            ->whereMonth('tanggal_distribusi', now()->month)
            ->where('status_pengantaran', 'sudah_diterima')
            ->count() : 0;

        $distribusiHariIni = $sekolah ? Distribusi::where('sekolah_id', $sekolah->id)
            ->whereDate('tanggal_distribusi', today())
            ->first() : null;

        return view('pages.inner.dashboard.dashboard-sekolah', compact(
            'sekolah',
            'distribusiBulanIni',
            'distribusiDiterima',
            'distribusiHariIni'
        ));
    }
}
