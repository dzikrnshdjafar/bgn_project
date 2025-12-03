<?php

namespace App\Http\Controllers;

use App\Models\DapurSehat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DapurSehatController extends Controller
{
    /**
     * Show the form for editing the authenticated user's Dapur Sehat data.
     */
    public function edit()
    {
        $user = Auth::user();

        // Check if user has 'Operator SPPG' role
        if (!$user->hasRole('Operator SPPG')) {
            abort(403, 'Unauthorized action.');
        }

        // Get or create dapur_sehat data for the user
        $dapurSehat = $user->dapurSehat ?? new DapurSehat();

        return view('pages.inner.dapur_sehat.edit', compact('dapurSehat'));
    }

    /**
     * Update the authenticated user's Dapur Sehat data.
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

        // Update or create dapur_sehat data
        $user->dapurSehat()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_dapur' => $request->nama_dapur,
                'alamat' => $request->alamat,
            ]
        );

        return redirect()->route('dapur_sehat.edit')->with('success', 'Data dapur berhasil diperbarui.');
    }
}
