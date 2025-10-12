<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationSet;
use Illuminate\Support\Facades\Storage;

class ApplicationSetController extends Controller
{

    public function edit()
    {
        // Ambil data dari database jika diperlukan
        $appset = ApplicationSet::first(); // Atau logika lain untuk mendapatkan data

        if (!$appset) {
            return redirect()->route('dashboard')->with('error', 'Data AppSet tidak ditemukan.');
        }

        return view('pages.inner.appsets.edit', compact('appset'));
    }


    public function update(Request $request)
    {
        $appset = ApplicationSet::orderBy('id', 'asc')->first();
        if (!$appset) {
            return redirect()->route('appsets.edit')->with('error', 'Data tidak ditemukan.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'brand_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:15',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
        ]);

        $appset->name = $request->input('name');
        $appset->address = $request->input('address');
        $appset->email = $request->input('email');
        $appset->phone_number = $request->input('phone_number');
        $appset->facebook = $request->input('facebook');
        $appset->instagram = $request->input('instagram');
        $appset->twitter = $request->input('twitter');

        if ($request->hasFile('brand_image')) {
            if ($appset->brand_image) {
                Storage::disk('public')->delete($appset->brand_image);
            }

            $imagePath = $request->file('brand_image')->store('brandImages', 'public');
            $appset->brand_image = $imagePath;
        }

        $appset->save();

        return redirect()->route('appsets.edit')->with('success', 'Data berhasil diupdate.');
    }
}
