<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMenu;
use App\Models\KategoriMakanan;

class JadwalMenuController extends Controller
{
    /**
     * Display a listing of jadwal menu for SPPG's schools.
     * Auto-create default schedule (Senin-Jumat) if not exists.
     */
    public function index()
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        // Auto-create jadwal menu untuk hari Senin-Jumat jika belum ada
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($hariList as $hari) {
            JadwalMenu::firstOrCreate([
                'dapur_sehat_id' => $dapurSehat->id,
                'hari' => $hari,
            ]);
        }

        // Get jadwal menu dengan urutan hari
        $jadwalMenus = JadwalMenu::where('dapur_sehat_id', $dapurSehat->id)
            ->with(['dapurSehat', 'makanans.kategoriMakanan'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->get();

        return view('pages.inner.jadwal-menu.index', compact('jadwalMenus', 'dapurSehat'));
    }

    /**
     * Display the specified jadwal menu.
     */
    public function show($id)
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        $jadwalMenu = JadwalMenu::where('dapur_sehat_id', $dapurSehat->id)
            ->with(['dapurSehat', 'makanans.kategoriMakanan'])
            ->findOrFail($id);

        return view('pages.inner.jadwal-menu.show', compact('jadwalMenu', 'dapurSehat'));
    }

    /**
     * Show the form for editing the specified jadwal menu.
     */
    public function edit($id)
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        $jadwalMenu = JadwalMenu::where('dapur_sehat_id', $dapurSehat->id)
            ->with(['dapurSehat', 'makanans'])
            ->findOrFail($id);

        $kategoriMakanans = KategoriMakanan::with('makanans')->get();

        return view('pages.inner.jadwal-menu.edit', compact('jadwalMenu', 'kategoriMakanans', 'dapurSehat'));
    }

    /**
     * Update the specified jadwal menu.
     */
    public function update(Request $request, $id)
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        $jadwalMenu = JadwalMenu::where('dapur_sehat_id', $dapurSehat->id)->findOrFail($id);

        $request->validate([
            'makanan_kategori' => 'required|array|min:1',
            'makanan_kategori.*' => 'required|exists:makanans,id',
            'keterangan' => 'nullable|string',
        ]);

        $jadwalMenu->update([
            'keterangan' => $request->keterangan,
        ]);

        // Sync makanans (array values dari radio buttons)
        $jadwalMenu->makanans()->sync(array_values($request->makanan_kategori));

        return redirect()->route('jadwal-menu.index')->with('success', 'Jadwal menu berhasil diperbarui');
    }
}
