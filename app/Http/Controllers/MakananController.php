<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makanans = Makanan::paginate(10);
        return view('pages.inner.makanans.index', compact('makanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.inner.makanans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Makanan::create([
            'nama_makanan' => $request->nama_makanan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('makanans.index')->with('success', 'Makanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Makanan $makanan)
    {
        return view('pages.inner.makanans.show', compact('makanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Makanan $makanan)
    {
        return view('pages.inner.makanans.edit', compact('makanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Makanan $makanan)
    {
        $request->validate([
            'nama_makanan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $makanan->update([
            'nama_makanan' => $request->nama_makanan,
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
