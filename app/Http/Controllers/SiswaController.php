<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Jika Operator Sekolah, hanya tampilkan siswa dari sekolahnya
        if ($user->hasRole('Operator Sekolah') && $user->sekolah) {
            $siswas = Siswa::with(['sekolah', 'makananKesukaan'])
                ->where('sekolah_id', $user->sekolah->id)
                ->paginate(10);
        } else {
            // Admin dan Operator BGN bisa melihat semua siswa
            $siswas = Siswa::with(['sekolah', 'makananKesukaan'])->paginate(10);
        }

        return view('pages.inner.siswas.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Jika Operator Sekolah, hanya bisa menambah siswa ke sekolahnya
        if ($user->hasRole('Operator Sekolah') && $user->sekolah) {
            $sekolahs = Sekolah::where('id', $user->sekolah->id)->get();
        } else {
            // Admin dan Operator BGN bisa memilih sekolah mana saja
            $sekolahs = Sekolah::all();
        }

        $makanans = Makanan::all();

        return view('pages.inner.siswas.create', compact('sekolahs', 'makanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nis' => ['required', 'string', 'max:255', 'unique:siswas,nis'],
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'makanan_kesukaan_id' => ['nullable', 'exists:makanans,id'],
        ]);

        // Jika Operator Sekolah, pastikan sekolah_id adalah sekolah mereka sendiri
        $sekolahId = $request->sekolah_id;
        if ($user->hasRole('Operator Sekolah') && $user->sekolah) {
            $sekolahId = $user->sekolah->id;
        }

        Siswa::create([
            'nis' => $request->nis,
            'sekolah_id' => $sekolahId,
            'nama_siswa' => $request->nama_siswa,
            'makanan_kesukaan_id' => $request->makanan_kesukaan_id,
        ]);

        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load(['sekolah', 'makananKesukaan']);
        return view('pages.inner.siswas.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $user = Auth::user();

        // Jika Operator Sekolah, hanya bisa edit siswa dari sekolahnya
        if ($user->hasRole('Operator Sekolah') && $user->sekolah && $siswa->sekolah_id != $user->sekolah->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->hasRole('Operator Sekolah') && $user->sekolah) {
            $sekolahs = Sekolah::where('id', $user->sekolah->id)->get();
        } else {
            $sekolahs = Sekolah::all();
        }

        $makanans = Makanan::all();

        return view('pages.inner.siswas.edit', compact('siswa', 'sekolahs', 'makanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $user = Auth::user();

        // Jika Operator Sekolah, hanya bisa update siswa dari sekolahnya
        if ($user->hasRole('Operator Sekolah') && $user->sekolah && $siswa->sekolah_id != $user->sekolah->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nis' => ['required', 'string', 'max:255', 'unique:siswas,nis,' . $siswa->nis . ',nis'],
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'makanan_kesukaan_id' => ['nullable', 'exists:makanans,id'],
        ]);

        // Jika Operator Sekolah, pastikan sekolah_id adalah sekolah mereka sendiri
        $sekolahId = $request->sekolah_id;
        if ($user->hasRole('Operator Sekolah') && $user->sekolah) {
            $sekolahId = $user->sekolah->id;
        }

        $siswa->update([
            'nis' => $request->nis,
            'sekolah_id' => $sekolahId,
            'nama_siswa' => $request->nama_siswa,
            'makanan_kesukaan_id' => $request->makanan_kesukaan_id,
        ]);

        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $user = Auth::user();

        // Jika Operator Sekolah, hanya bisa hapus siswa dari sekolahnya
        if ($user->hasRole('Operator Sekolah') && $user->sekolah && $siswa->sekolah_id != $user->sekolah->id) {
            abort(403, 'Unauthorized action.');
        }

        $siswa->delete();
        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Toggle kehadiran siswa
     */
    public function toggleKehadiran(Siswa $siswa)
    {
        $user = Auth::user();

        // Jika Operator Sekolah, hanya bisa toggle siswa dari sekolahnya
        if ($user->hasRole('Operator Sekolah') && $user->sekolah && $siswa->sekolah_id != $user->sekolah->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $siswa->kehadiran = !$siswa->kehadiran;
        $siswa->save();

        return response()->json([
            'success' => true,
            'kehadiran' => $siswa->kehadiran,
            'message' => 'Status kehadiran berhasil diperbarui.'
        ]);
    }
}
