<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SppgController extends Controller
{
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
     * Show list of schools assigned to this SPPG
     */
    public function sekolahs()
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Unauthorized action.');
        }

        $sppg = $user->sppg;

        if (!$sppg) {
            return redirect()->route('sppg.edit')->with('error', 'Silakan lengkapi data dapur terlebih dahulu.');
        }

        $sekolahs = $sppg->sekolahs()->paginate(10);
        $availableSekolahs = Sekolah::whereNull('sppg_id')->get();

        return view('pages.inner.sppg.sekolahs', compact('sppg', 'sekolahs', 'availableSekolahs'));
    }

    /**
     * Attach a school to SPPG with zona
     */
    public function attachSekolah(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Unauthorized action.');
        }

        $sppg = $user->sppg;

        if (!$sppg) {
            return redirect()->route('sppg.edit')->with('error', 'Silakan lengkapi data dapur terlebih dahulu.');
        }

        $request->validate([
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
            'zona' => ['required', 'string', 'max:255'],
        ]);

        $sekolah = Sekolah::find($request->sekolah_id);

        // Check if school already has SPPG
        if ($sekolah->sppg_id) {
            return back()->with('error', 'Sekolah sudah terdaftar di dapur lain.');
        }

        $sekolah->update([
            'sppg_id' => $sppg->id,
            'zona' => $request->zona,
        ]);

        return back()->with('success', 'Sekolah berhasil ditambahkan ke zona pengantaran.');
    }

    /**
     * Update zona for a school
     */
    public function updateSekolah(Request $request, $sekolahId)
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Unauthorized action.');
        }

        $sppg = $user->sppg;

        if (!$sppg) {
            return redirect()->route('sppg.edit')->with('error', 'Silakan lengkapi data dapur terlebih dahulu.');
        }

        $request->validate([
            'zona' => ['required', 'string', 'max:255'],
        ]);

        $sekolah = Sekolah::where('id', $sekolahId)
            ->where('sppg_id', $sppg->id)
            ->firstOrFail();

        $sekolah->update(['zona' => $request->zona]);

        return back()->with('success', 'Zona pengantaran berhasil diperbarui.');
    }

    /**
     * Detach a school from SPPG
     */
    public function detachSekolah($sekolahId)
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Unauthorized action.');
        }

        $sppg = $user->sppg;

        if (!$sppg) {
            return redirect()->route('sppg.edit')->with('error', 'Silakan lengkapi data dapur terlebih dahulu.');
        }

        $sekolah = Sekolah::where('id', $sekolahId)
            ->where('sppg_id', $sppg->id)
            ->firstOrFail();

        $sekolah->update([
            'sppg_id' => null,
            'zona' => null,
        ]);

        return back()->with('success', 'Sekolah berhasil dihapus dari zona pengantaran.');
    }
}
