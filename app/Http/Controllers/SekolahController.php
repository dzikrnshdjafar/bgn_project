<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SekolahController extends Controller
{
    /**
     * Show the form for editing the authenticated user's school data.
     */
    public function edit()
    {
        $user = Auth::user();

        // Check if user has 'Operator Sekolah' role
        if (!$user->hasRole('Operator Sekolah')) {
            abort(403, 'Unauthorized action.');
        }

        // Get or create sekolah data for the user
        $sekolah = $user->sekolah ?? new Sekolah();

        return view('pages.inner.sekolah.edit', compact('sekolah'));
    }

    /**
     * Update the authenticated user's school data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Check if user has 'Operator Sekolah' role
        if (!$user->hasRole('Operator Sekolah')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'alamat_sekolah' => ['required', 'string', 'max:255'],
        ]);

        // Update or create sekolah data
        $user->sekolah()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_sekolah' => $request->nama_sekolah,
                'alamat_sekolah' => $request->alamat_sekolah,
            ]
        );

        return redirect()->route('sekolah.edit')->with('success', 'Data sekolah berhasil diperbarui.');
    }
}
