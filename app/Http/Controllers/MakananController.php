<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\KategoriMakanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makanans = Makanan::with('kategoriMakanan')->paginate(10);
        return view('pages.inner.makanans.index', compact('makanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriMakanans = KategoriMakanan::all();
        return view('pages.inner.makanans.create', compact('kategoriMakanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => ['required', 'string', 'max:255'],
            'kategori_makanan_id' => ['nullable', 'exists:kategori_makanans,id'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Makanan::create([
            'nama_makanan' => $request->nama_makanan,
            'kategori_makanan_id' => $request->kategori_makanan_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('makanans.index')->with('success', 'Makanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Makanan $makanan)
    {
        $makanan->load('kategoriMakanan');
        return view('pages.inner.makanans.show', compact('makanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Makanan $makanan)
    {
        $kategoriMakanans = KategoriMakanan::all();
        return view('pages.inner.makanans.edit', compact('makanan', 'kategoriMakanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Makanan $makanan)
    {
        $request->validate([
            'nama_makanan' => ['required', 'string', 'max:255'],
            'kategori_makanan_id' => ['nullable', 'exists:kategori_makanans,id'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $makanan->update([
            'nama_makanan' => $request->nama_makanan,
            'kategori_makanan_id' => $request->kategori_makanan_id,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('makanans.index')->with('success', 'Makanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Makanan $makanan)
    {
        $makanan->delete();
        return redirect()->route('makanans.index')->with('success', 'Makanan berhasil dihapus.');
    }
}
