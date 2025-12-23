<?php

namespace App\Http\Controllers;

use App\Models\KategoriMakanan;
use Illuminate\Http\Request;

class KategoriMakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriMakanans = KategoriMakanan::withCount('makanans')->paginate(10);
        return view('pages.inner.kategori-makanans.index', compact('kategoriMakanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.inner.kategori-makanans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        KategoriMakanan::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kategori-makanans.index')->with('success', 'Kategori makanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriMakanan $kategoriMakanan)
    {
        $kategoriMakanan->load('makanans');
        return view('pages.inner.kategori-makanans.show', compact('kategoriMakanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriMakanan $kategoriMakanan)
    {
        return view('pages.inner.kategori-makanans.edit', compact('kategoriMakanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriMakanan $kategoriMakanan)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $kategoriMakanan->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kategori-makanans.index')->with('success', 'Kategori makanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriMakanan $kategoriMakanan)
    {
        $kategoriMakanan->delete();
        return redirect()->route('kategori-makanans.index')->with('success', 'Kategori makanan berhasil dihapus.');
    }
}
