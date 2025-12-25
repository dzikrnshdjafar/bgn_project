<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SppgController extends Controller
{
    /**
     * Display a listing of all SPPGs (Admin only)
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $sppgs = Sppg::with('user')->paginate(10);

        return view('pages.inner.sppg.index', compact('sppgs'));
    }

    /**
     * Show the form for editing the authenticated user's SPPG data.
     */
    public function edit()
    {
        $user = Auth::user();

        // Check if user has 'Operator SPPG' role
        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Unauthorized action.');
        }

        // Get or create sppg data for the user
        $sppg = $user->sppg ?? new Sppg();

        return view('pages.inner.sppg.edit', compact('sppg'));
    }

    /**
     * Update the authenticated user's SPPG data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Check if user has 'Operator SPPG' role
        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_dapur' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        // Update or create sppg data
        $user->sppg()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_dapur' => $request->nama_dapur,
                'alamat' => $request->alamat,
            ]
        );

        return redirect()->route('sppg.edit')->with('success', 'Data dapur berhasil diperbarui.');
    }

    /**
     * Show list of schools assigned to this SPPG (for Operator SPPG)
     * or for a specific SPPG (for Admin)
     */
    public function sekolahs($sppgId = null)
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Admin can view any SPPG's schools
            if (!$sppgId) {
                return redirect()->route('admin.sppgs.index')->with('error', 'Pilih SPPG terlebih dahulu.');
            }
            $sppg = Sppg::findOrFail($sppgId);
        } elseif ($user->hasRole('Operator SPPG')) {
            // Operator SPPG can only view their own SPPG's schools
            $sppg = $user->sppg;
            if (!$sppg) {
                return redirect()->route('sppg.edit')->with('error', 'Silakan lengkapi data dapur terlebih dahulu.');
            }
        } else {
            abort(403, 'Unauthorized action.');
        }

        $sekolahs = $sppg->sekolahs()->paginate(10);
        $availableSekolahs = Sekolah::whereNull('sppg_id')->get();

        return view('pages.inner.sppg.sekolahs', compact('sppg', 'sekolahs', 'availableSekolahs'));
    }

    /**
     * Attach a school to SPPG with zona
     */
    public function attachSekolah(Request $request, $sppgId = null)
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Admin can attach to any SPPG
            if (!$sppgId) {
                return back()->with('error', 'SPPG tidak ditemukan.');
            }
            $sppg = Sppg::findOrFail($sppgId);
        } elseif ($user->hasRole('Operator SPPG')) {
            // Operator SPPG can only attach to their own SPPG
            $sppg = $user->sppg;
            if (!$sppg) {
                return redirect()->route('sppg.edit')->with('error', 'Silakan lengkapi data dapur terlebih dahulu.');
            }
        } else {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
        ]);

        $sekolah = Sekolah::find($request->sekolah_id);

        // Check if school already has SPPG
        if ($sekolah->sppg_id) {
            return back()->with('error', 'Sekolah sudah terdaftar di dapur lain.');
        }

        $sekolah->update([
            'sppg_id' => $sppg->id,
        ]);

        return back()->with('success', 'Sekolah berhasil ditambahkan ke zona pengantaran.');
    }

    /**
     * Detach a school from SPPG
     */
    public function detachSekolah($sekolahId, $sppgId = null)
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Admin can detach from any SPPG
            if (!$sppgId) {
                return back()->with('error', 'SPPG tidak ditemukan.');
            }
            $sppg = Sppg::findOrFail($sppgId);
        } elseif ($user->hasRole('Operator SPPG')) {
            // Operator SPPG can only detach from their own SPPG
            $sppg = $user->sppg;
            if (!$sppg) {
                return redirect()->route('sppg.edit')->with('error', 'Silakan lengkapi data dapur terlebih dahulu.');
            }
        } else {
            abort(403, 'Unauthorized action.');
        }

        $sekolah = Sekolah::where('id', $sekolahId)
            ->where('sppg_id', $sppg->id)
            ->firstOrFail();

        $sekolah->update([
            'sppg_id' => null,
        ]);

        return back()->with('success', 'Sekolah berhasil dihapus dari zona pengantaran.');
    }
}
