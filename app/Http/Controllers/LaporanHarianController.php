<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use App\Models\Makanan;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = LaporanHarian::with(['sekolah', 'makanan']);

        // Role-based filtering
        if ($user->hasRole('Operator Sekolah')) {
            if (!$user->sekolah) {
                abort(403, 'Sekolah tidak ditemukan untuk user ini.');
            }
            $query->where('sekolah_id', $user->sekolah->id);
        }

        // Date filter
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $laporans = $query->latest('tanggal')->paginate(15);

        // Get all makanan for Operator SPPG
        $makanans = $user->hasRole('Operator SPPG') ? Makanan::all() : collect();

        return view('pages.inner.laporan-harian.index', compact('laporans', 'makanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('Operator Sekolah')) {
            if (!$user->sekolah) {
                abort(403, 'Sekolah tidak ditemukan untuk user ini.');
            }

            $sekolah = $user->sekolah;
            $today = now()->format('Y-m-d');

            // Check if laporan already exists for today
            $existingLaporan = LaporanHarian::where('sekolah_id', $sekolah->id)
                ->where('tanggal', $today)
                ->first();

            if ($existingLaporan) {
                return redirect()->route('laporan-harian.show', $existingLaporan->id)
                    ->with('info', 'Laporan untuk hari ini sudah dibuat.');
            }

            // Auto-calculate attendance
            $totalSiswa = $sekolah->jumlah_siswa;
            $siswaHadir = Siswa::where('sekolah_id', $sekolah->id)
                ->where('kehadiran', true)
                ->count();
            $siswaTidakHadir = Siswa::where('sekolah_id', $sekolah->id)
                ->where('kehadiran', false)
                ->count();

            return view('pages.inner.laporan-harian.create', compact('sekolah', 'totalSiswa', 'siswaHadir', 'siswaTidakHadir'));
        }

        abort(403, 'Hanya Operator Sekolah yang dapat membuat laporan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator Sekolah') || !$user->sekolah) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'total_siswa' => 'required|integer|min:0',
            'siswa_hadir' => 'required|integer|min:0',
            'siswa_tidak_hadir' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Validate that siswa_hadir doesn't exceed total_siswa
        if ($validated['siswa_hadir'] > $validated['total_siswa']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['siswa_hadir' => 'Jumlah siswa hadir tidak boleh melebihi total siswa.']);
        }

        // Check if laporan already exists for this date
        $existing = LaporanHarian::where('sekolah_id', $user->sekolah->id)
            ->where('tanggal', $validated['tanggal'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tanggal' => 'Laporan untuk tanggal ini sudah ada.']);
        }

        // Auto-calculate siswa_tidak_hadir
        $validated['siswa_tidak_hadir'] = $validated['total_siswa'] - $validated['siswa_hadir'];
        $validated['sekolah_id'] = $user->sekolah->id;

        LaporanHarian::create($validated);

        return redirect()->route('laporan-harian.index')
            ->with('success', 'Laporan harian berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $laporan = LaporanHarian::with(['sekolah', 'makanan'])->findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if ($user->hasRole('Operator Sekolah') && (!$user->sekolah || $laporan->sekolah_id !== $user->sekolah->id)) {
            abort(403, 'Unauthorized action.');
        }

        $makanans = $user->hasRole('Operator SPPG') ? Makanan::all() : collect();

        return view('pages.inner.laporan-harian.show', compact('laporan', 'makanans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $laporan = LaporanHarian::with('sekolah')->findOrFail($id);
        $user = Auth::user();

        // Authorization check - only Operator Sekolah can edit their own laporan
        if (!$user->hasRole('Operator Sekolah')) {
            abort(403, 'Hanya Operator Sekolah yang dapat mengedit laporan.');
        }

        if (!$user->sekolah || $laporan->sekolah_id !== $user->sekolah->id) {
            abort(403, 'Anda tidak dapat mengedit laporan sekolah lain.');
        }

        return view('pages.inner.laporan-harian.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $laporan = LaporanHarian::findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if (!$user->hasRole('Operator Sekolah') || !$user->sekolah || $laporan->sekolah_id !== $user->sekolah->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'total_siswa' => 'required|integer|min:0',
            'siswa_hadir' => 'required|integer|min:0',
            'siswa_tidak_hadir' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Validate that siswa_hadir doesn't exceed total_siswa
        if ($validated['siswa_hadir'] > $validated['total_siswa']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['siswa_hadir' => 'Jumlah siswa hadir tidak boleh melebihi total siswa.']);
        }

        // Auto-calculate siswa_tidak_hadir
        $validated['siswa_tidak_hadir'] = $validated['total_siswa'] - $validated['siswa_hadir'];

        $laporan->update($validated);

        return redirect()->route('laporan-harian.index')
            ->with('success', 'Laporan harian berhasil diperbarui.');
    }

    /**
     * Update status pengantaran makanan.
     */
    public function updateStatusPengantaran(Request $request, string $id)
    {
        $laporan = LaporanHarian::findOrFail($id);
        $user = Auth::user();

        // Only Operator SPPG can update status
        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Hanya Operator SPPG yang dapat mengubah status pengantaran.');
        }

        // Validate makanan_id when changing to "Telah Diantarkan"
        if ($laporan->status_pengantaran === 'Belum Diantarkan') {
            $validated = $request->validate([
                'makanan_id' => 'required|exists:makanans,id',
            ], [
                'makanan_id.required' => 'Silakan pilih menu makanan yang diantarkan.',
                'makanan_id.exists' => 'Menu makanan tidak valid.',
            ]);

            $laporan->update([
                'status_pengantaran' => 'Telah Diantarkan',
                'makanan_id' => $validated['makanan_id'],
            ]);

            return redirect()->back()
                ->with('success', 'Status pengantaran berhasil diubah menjadi: Telah Diantarkan');
        } else {
            // When canceling, keep the makanan_id but change status
            $laporan->update(['status_pengantaran' => 'Belum Diantarkan']);

            return redirect()->back()
                ->with('success', 'Status pengantaran berhasil diubah menjadi: Belum Diantarkan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
