<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\DapurSehat;

class SppgSekolahController extends Controller
{
    /**
     * Display a listing of sekolah for the logged-in SPPG.
     */
    public function index()
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        $sekolahs = $dapurSehat->sekolahs()->with('user')->paginate(10);

        return view('pages.inner.sppg-sekolah.index', compact('sekolahs', 'dapurSehat'));
    }

    /**
     * Show the form for creating a new sekolah.
     */
    public function create()
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        // Get all sekolah that are not yet assigned to any SPPG
        $availableSekolahs = Sekolah::whereNull('dapur_sehat_id')->with('user')->get();

        return view('pages.inner.sppg-sekolah.create', compact('availableSekolahs', 'dapurSehat'));
    }

    /**
     * Store a newly created sekolah assignment.
     */
    public function store(Request $request)
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
        ]);

        $sekolah = Sekolah::findOrFail($request->sekolah_id);

        // Check if sekolah is already assigned
        if ($sekolah->dapur_sehat_id) {
            return back()->with('error', 'Sekolah sudah terdaftar pada SPPG lain');
        }

        $sekolah->update([
            'dapur_sehat_id' => $dapurSehat->id,
        ]);

        return redirect()->route('sppg-sekolah.index')->with('success', 'Sekolah berhasil ditambahkan');
    }

    /**
     * Remove the sekolah assignment from SPPG.
     */
    public function destroy($id)
    {
        $dapurSehat = auth()->user()->dapurSehat;

        if (!$dapurSehat) {
            abort(403, 'Anda tidak terdaftar sebagai SPPG');
        }

        $sekolah = Sekolah::where('dapur_sehat_id', $dapurSehat->id)->findOrFail($id);

        $sekolah->update([
            'dapur_sehat_id' => null,
        ]);

        return redirect()->route('sppg-sekolah.index')->with('success', 'Sekolah berhasil dihapus dari daftar');
    }
}
