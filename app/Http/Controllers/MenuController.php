<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategoriMenu')->paginate(10);
        return view('pages.inner.menus.index', compact('menus'));
    }

    public function create()
    {
        $kategoriMenus = KategoriMenu::all();
        return view('pages.inner.menus.create', compact('kategoriMenus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_menu_id' => ['required', 'exists:kategori_menus,id'],
            'nama_menu' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Menu::create($request->all());

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function show(Menu $menu)
    {
        $menu->load('kategoriMenu');
        return view('pages.inner.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $kategoriMenus = KategoriMenu::all();
        return view('pages.inner.menus.edit', compact('menu', 'kategoriMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'kategori_menu_id' => ['required', 'exists:kategori_menus,id'],
            'nama_menu' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $menu->update($request->all());

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
