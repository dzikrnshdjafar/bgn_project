<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
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
}
