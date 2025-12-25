<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Http\Request;

class KategoriMenuController extends Controller
{
    public function index()
    {
        $kategoriMenus = KategoriMenu::withCount('menus')->paginate(10);
        return view('pages.inner.kategori-menus.index', compact('kategoriMenus'));
    }

    public function create()
    {
        $existingMenus = Menu::whereNull('kategori_menu_id')->get();
        return view('pages.inner.kategori-menus.create', compact('existingMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'menus' => ['nullable', 'array'],
            'menus.*.mode' => ['required_with:menus', 'in:manual,existing'],
            'menus.*.nama_menu' => ['required_if:menus.*.mode,manual', 'nullable', 'string', 'max:255'],
            'menus.*.deskripsi' => ['nullable', 'string'],
            'menus.*.existing_menu_id' => ['required_if:menus.*.mode,existing', 'nullable', 'exists:menus,id'],
        ]);

        $kategoriMenu = KategoriMenu::create($request->only(['nama_kategori', 'keterangan']));

        // Create or assign menus if provided
        if ($request->has('menus')) {
            foreach ($request->menus as $menuData) {
                if ($menuData['mode'] === 'manual') {
                    if (!empty($menuData['nama_menu'])) {
                        // Check if menu name already exists
                        $existingMenu = Menu::where('nama_menu', $menuData['nama_menu'])->first();
                        if ($existingMenu) {
                            return back()->withErrors(['menus' => "Menu dengan nama '{$menuData['nama_menu']}' sudah ada. Silakan gunakan mode 'Pilih dari Menu yang Ada' atau gunakan nama lain."])->withInput();
                        }

                        $kategoriMenu->menus()->create([
                            'nama_menu' => $menuData['nama_menu'],
                            'deskripsi' => $menuData['deskripsi'] ?? null,
                        ]);
                    }
                } elseif ($menuData['mode'] === 'existing' && !empty($menuData['existing_menu_id'])) {
                    // Assign existing menu to this kategori
                    Menu::where('id', $menuData['existing_menu_id'])->update([
                        'kategori_menu_id' => $kategoriMenu->id,
                    ]);
                }
            }
        }

        return redirect()->route('kategori-menus.index')->with('success', 'Kategori menu berhasil ditambahkan.');
    }

    public function show(KategoriMenu $kategoriMenu)
    {
        $kategoriMenu->load('menus');
        return view('pages.inner.kategori-menus.show', compact('kategoriMenu'));
    }

    public function edit(KategoriMenu $kategoriMenu)
    {
        $kategoriMenu->load('menus');
        $existingMenus = Menu::whereNull('kategori_menu_id')->get();
        return view('pages.inner.kategori-menus.edit', compact('kategoriMenu', 'existingMenus'));
    }

    public function update(Request $request, KategoriMenu $kategoriMenu)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'menus' => ['nullable', 'array'],
            'menus.*.id' => ['nullable', 'exists:menus,id'],
            'menus.*.nama_menu' => ['required_with:menus', 'string', 'max:255'],
            'menus.*.deskripsi' => ['nullable', 'string'],
            'deleted_menus' => ['nullable', 'string'],
        ]);

        $kategoriMenu->update($request->only(['nama_kategori', 'keterangan']));

        // Delete removed menus
        if ($request->filled('deleted_menus')) {
            $deletedMenuIds = json_decode($request->deleted_menus, true);
            if (is_array($deletedMenuIds) && count($deletedMenuIds) > 0) {
                $kategoriMenu->menus()->whereIn('id', $deletedMenuIds)->delete();
            }
        }

        // Update or create menus
        if ($request->has('menus')) {
            foreach ($request->menus as $menuData) {
                if ($menuData['mode'] === 'manual') {
                    if (!empty($menuData['nama_menu'])) {
                        if (isset($menuData['id'])) {
                            // Update existing menu - check for duplicate
                            $duplicate = Menu::where('nama_menu', $menuData['nama_menu'])
                                ->where('id', '!=', $menuData['id'])
                                ->first();
                            if ($duplicate) {
                                return back()->withErrors(['menus' => "Menu dengan nama '{$menuData['nama_menu']}' sudah ada."])->withInput();
                            }

                            $kategoriMenu->menus()->where('id', $menuData['id'])->update([
                                'nama_menu' => $menuData['nama_menu'],
                                'deskripsi' => $menuData['deskripsi'] ?? null,
                            ]);
                        } else {
                            // Create new menu - check for duplicate
                            $duplicate = Menu::where('nama_menu', $menuData['nama_menu'])->first();
                            if ($duplicate) {
                                return back()->withErrors(['menus' => "Menu dengan nama '{$menuData['nama_menu']}' sudah ada. Silakan gunakan mode 'Pilih dari Menu yang Ada' atau gunakan nama lain."])->withInput();
                            }

                            $kategoriMenu->menus()->create([
                                'nama_menu' => $menuData['nama_menu'],
                                'deskripsi' => $menuData['deskripsi'] ?? null,
                            ]);
                        }
                    }
                } elseif ($menuData['mode'] === 'existing' && !empty($menuData['existing_menu_id'])) {
                    // Assign existing menu to this kategori
                    Menu::where('id', $menuData['existing_menu_id'])->update([
                        'kategori_menu_id' => $kategoriMenu->id,
                    ]);
                }
            }
        }

        return redirect()->route('kategori-menus.index')->with('success', 'Kategori menu berhasil diperbarui.');
    }

    public function destroy(KategoriMenu $kategoriMenu)
    {
        $kategoriMenu->delete();
        return redirect()->route('kategori-menus.index')->with('success', 'Kategori menu berhasil dihapus.');
    }
}
