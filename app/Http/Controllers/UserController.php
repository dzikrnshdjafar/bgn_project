<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles', 'sekolah', 'sppg'])->paginate(10);
        return view('pages.inner.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['Operator Sekolah', 'Operator SPPG'])->get();
        return view('pages.inner.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
            'nama_sekolah' => ['nullable', 'required_if:role,Operator Sekolah', 'string', 'max:255'],
            'alamat_sekolah' => ['nullable', 'required_if:role,Operator Sekolah', 'string', 'max:255'],
            'nama_dapur' => ['nullable', 'required_if:role,Operator SPPG', 'string', 'max:255'],
            'alamat' => ['nullable', 'required_if:role,Operator SPPG', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);

            if ($request->role === 'Operator Sekolah') {
                $user->sekolah()->create([
                    'nama_sekolah' => $request->nama_sekolah,
                    'alamat_sekolah' => $request->alamat_sekolah,
                ]);
            } elseif ($request->role === 'Operator SPPG') {
                $user->sppg()->create([
                    'nama_dapur' => $request->nama_dapur,
                    'alamat' => $request->alamat,
                ]);
            }
        });

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.inner.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load(['sekolah', 'sppg']);
        $roles = Role::whereIn('name', ['Operator Sekolah', 'Operator SPPG'])->get();
        return view('pages.inner.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
            'nama_sekolah' => ['nullable', 'required_if:role,Operator Sekolah', 'string', 'max:255'],
            'alamat_sekolah' => ['nullable', 'required_if:role,Operator Sekolah', 'string', 'max:255'],
            'nama_dapur' => ['nullable', 'required_if:role,Operator SPPG', 'string', 'max:255'],
            'alamat' => ['nullable', 'required_if:role,Operator SPPG', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($request, $user) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            $user->syncRoles([$request->role]);

            if ($request->role === 'Operator Sekolah') {
                $user->sekolah()->updateOrCreate([], [
                    'nama_sekolah' => $request->nama_sekolah,
                    'alamat_sekolah' => $request->alamat_sekolah,
                ]);
                $user->sppg()->delete(); // Hapus data sppg jika ada
            } elseif ($request->role === 'Operator SPPG') {
                $user->sppg()->updateOrCreate([], [
                    'nama_dapur' => $request->nama_dapur,
                    'alamat' => $request->alamat,
                ]);
                $user->sekolah()->delete(); // Hapus data sekolah jika ada
            } else {
                // Jika rolenya bukan keduanya, hapus data sekolah dan sppg
                $user->sekolah()->delete();
                $user->sppg()->delete();
            }
        });


        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
