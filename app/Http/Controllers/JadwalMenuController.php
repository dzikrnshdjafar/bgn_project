<?php

namespace App\Http\Controllers;

use App\Models\JadwalMenu;
use App\Models\Sppg;
use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalMenuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin|Operator BGN')) {
            $jadwalMenus = JadwalMenu::with(['sppg', 'details.menu', 'details.kategoriMenu'])->paginate(10);
            $sppgs = Sppg::all();
        } else if ($user->hasRole('Operator SPPG')) {
            $sppg = $user->sppg;
            $jadwalMenus = JadwalMenu::where('sppg_id', $sppg->id)
                ->with(['details.menu', 'details.kategoriMenu'])
                ->paginate(10);
            $sppgs = null;
        } else {
            abort(403);
        }

        return view('pages.inner.jadwal-menus.index', compact('jadwalMenus', 'sppgs'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $sppgs = Sppg::all();
            $sppgId = request('sppg_id');
        } else if ($user->hasRole('Operator SPPG')) {
            $sppgs = null;
            $sppgId = $user->sppg->id;
        } else {
            abort(403);
        }

        $kategoriMenus = KategoriMenu::with('menus')->get();

        return view('pages.inner.jadwal-menus.create', compact('sppgs', 'kategoriMenus', 'sppgId'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'menus' => ['required', 'array'],
            'menus.senin' => ['required', 'array'],
            'menus.selasa' => ['required', 'array'],
            'menus.rabu' => ['required', 'array'],
            'menus.kamis' => ['required', 'array'],
            'menus.jumat' => ['required', 'array'],
        ];

        if ($user->hasRole('Admin')) {
            $rules['sppg_id'] = ['required', 'exists:sppgs,id'];
        }

        $validated = $request->validate($rules);

        if ($user->hasRole('Operator SPPG')) {
            $validated['sppg_id'] = $user->sppg->id;
        }

        $hariOptions = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        $createdCount = 0;

        foreach ($hariOptions as $hari) {
            // Check if jadwal already exists for this SPPG and hari
            $existing = JadwalMenu::where('sppg_id', $validated['sppg_id'])
                ->where('hari', $hari)
                ->first();

            if ($existing) {
                continue; // Skip if already exists
            }

            // Create jadwal menu for this day
            $jadwalMenu = JadwalMenu::create([
                'sppg_id' => $validated['sppg_id'],
                'hari' => $hari,
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
            ]);

            // Store menu selections for each kategori for this day
            foreach ($request->menus[$hari] as $kategoriId => $menuId) {
                $menu = Menu::find($menuId);
                if ($menu) {
                    $jadwalMenu->details()->create([
                        'menu_id' => $menuId,
                        'kategori_menu_id' => $menu->kategori_menu_id,
                    ]);
                }
            }

            $createdCount++;
        }

        if ($createdCount === 0) {
            return back()->withErrors(['sppg_id' => 'Semua jadwal untuk SPPG ini sudah ada.'])->withInput();
        }

        return redirect()->route('jadwal-menus.index')->with('success', "Berhasil menambahkan $createdCount jadwal menu.");
    }

    public function show(JadwalMenu $jadwalMenu)
    {
        $user = Auth::user();

        if ($user->hasRole('Operator SPPG') && $jadwalMenu->sppg_id !== $user->sppg->id) {
            abort(403);
        }

        $jadwalMenu->load(['sppg', 'details.menu', 'details.kategoriMenu']);
        return view('pages.inner.jadwal-menus.show', compact('jadwalMenu'));
    }

    public function edit(JadwalMenu $jadwalMenu)
    {
        $user = Auth::user();

        if ($user->hasRole('Operator SPPG') && $jadwalMenu->sppg_id !== $user->sppg->id) {
            abort(403);
        }

        if ($user->hasRole('Admin')) {
            $sppgs = Sppg::all();
        } else {
            $sppgs = null;
        }

        $kategoriMenus = KategoriMenu::with('menus')->get();

        // Load all jadwal for this SPPG
        $jadwalMenus = JadwalMenu::where('sppg_id', $jadwalMenu->sppg_id)
            ->with('details.menu')
            ->get()
            ->keyBy('hari');

        return view('pages.inner.jadwal-menus.edit', compact('jadwalMenu', 'jadwalMenus', 'sppgs', 'kategoriMenus'));
    }

    public function update(Request $request, JadwalMenu $jadwalMenu)
    {
        $user = Auth::user();

        if ($user->hasRole('Operator SPPG') && $jadwalMenu->sppg_id !== $user->sppg->id) {
            abort(403);
        }

        $rules = [
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'menus' => ['required', 'array'],
            'menus.senin' => ['required', 'array'],
            'menus.selasa' => ['required', 'array'],
            'menus.rabu' => ['required', 'array'],
            'menus.kamis' => ['required', 'array'],
            'menus.jumat' => ['required', 'array'],
        ];

        if ($user->hasRole('Admin')) {
            $rules['sppg_id'] = ['required', 'exists:sppgs,id'];
        }

        $validated = $request->validate($rules);

        $sppgId = $user->hasRole('Admin') ? $validated['sppg_id'] : $user->sppg->id;
        $hariOptions = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

        foreach ($hariOptions as $hari) {
            // Find or create jadwal for this day
            $jadwal = JadwalMenu::where('sppg_id', $sppgId)
                ->where('hari', $hari)
                ->first();

            if ($jadwal) {
                // Update existing jadwal
                $jadwal->update([
                    'tanggal_mulai' => $validated['tanggal_mulai'],
                    'tanggal_selesai' => $validated['tanggal_selesai'],
                ]);

                // Delete old details
                $jadwal->details()->delete();
            } else {
                // Create new jadwal if doesn't exist
                $jadwal = JadwalMenu::create([
                    'sppg_id' => $sppgId,
                    'hari' => $hari,
                    'tanggal_mulai' => $validated['tanggal_mulai'],
                    'tanggal_selesai' => $validated['tanggal_selesai'],
                ]);
            }

            // Create new details for this day
            foreach ($request->menus[$hari] as $kategoriId => $menuId) {
                $menu = Menu::find($menuId);
                if ($menu) {
                    $jadwal->details()->create([
                        'menu_id' => $menuId,
                        'kategori_menu_id' => $menu->kategori_menu_id,
                    ]);
                }
            }
        }

        return redirect()->route('jadwal-menus.index')->with('success', 'Jadwal menu berhasil diperbarui.');
    }

    public function destroy(JadwalMenu $jadwalMenu)
    {
        $user = Auth::user();

        if ($user->hasRole('Operator SPPG') && $jadwalMenu->sppg_id !== $user->sppg->id) {
            abort(403);
        }

        $jadwalMenu->delete();
        return redirect()->route('jadwal-menus.index')->with('success', 'Jadwal menu berhasil dihapus.');
    }

    public function exportPdf()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Get all SPPGs
            $sppgs = Sppg::all();
            $jadwalData = [];

            foreach ($sppgs as $sppg) {
                $jadwalMenus = JadwalMenu::where('sppg_id', $sppg->id)
                    ->with(['details.menu', 'details.kategoriMenu'])
                    ->orderBy('hari')
                    ->get();

                if ($jadwalMenus->isNotEmpty()) {
                    // Group by periode
                    $grouped = $jadwalMenus->groupBy(function ($item) {
                        return ($item->tanggal_mulai?->format('Y-m-d') ?? 'null') . '|' . ($item->tanggal_selesai?->format('Y-m-d') ?? 'null');
                    });

                    $jadwalData[$sppg->id] = [
                        'sppg' => $sppg,
                        'periodes' => $grouped
                    ];
                }
            }
        } else if ($user->hasRole('Operator SPPG')) {
            $sppg = $user->sppg;
            $jadwalMenus = JadwalMenu::where('sppg_id', $sppg->id)
                ->with(['details.menu', 'details.kategoriMenu'])
                ->orderBy('hari')
                ->get();

            if ($jadwalMenus->isNotEmpty()) {
                $grouped = $jadwalMenus->groupBy(function ($item) {
                    return ($item->tanggal_mulai?->format('Y-m-d') ?? 'null') . '|' . ($item->tanggal_selesai?->format('Y-m-d') ?? 'null');
                });

                $jadwalData[$sppg->id] = [
                    'sppg' => $sppg,
                    'periodes' => $grouped
                ];
            }
        } else {
            abort(403);
        }

        $pdf = Pdf::loadView('pages.inner.jadwal-menus.pdf', [
            'jadwalData' => $jadwalData,
            'isAdmin' => $user->hasRole('Admin'),
            'tanggalCetak' => now()->format('d/m/Y H:i')
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('jadwal-menu-' . now()->format('Y-m-d') . '.pdf');
    }

    public function indexSekolah()
    {
        $user = Auth::user();

        if (!$user->hasRole('Operator Sekolah')) {
            abort(403);
        }

        $sekolah = $user->sekolah;

        if (!$sekolah || !$sekolah->sppg_id) {
            return view('pages.inner.jadwal-menus.sekolah-index', [
                'sekolah' => $sekolah,
                'jadwalData' => []
            ]);
        }

        // Get all jadwal for this sekolah's SPPG
        $jadwalMenus = JadwalMenu::where('sppg_id', $sekolah->sppg_id)
            ->with(['details.menu', 'details.kategoriMenu'])
            ->orderBy('hari')
            ->get();

        // Group by periode
        $jadwalData = [];
        if ($jadwalMenus->isNotEmpty()) {
            $grouped = $jadwalMenus->groupBy(function ($item) {
                return ($item->tanggal_mulai?->format('Y-m-d') ?? 'null') . '|' . ($item->tanggal_selesai?->format('Y-m-d') ?? 'null');
            });

            foreach ($grouped as $key => $periodeJadwals) {
                $parts = explode('|', $key);
                $jadwalData[] = [
                    'tanggal_mulai' => $parts[0] !== 'null' ? \Carbon\Carbon::parse($parts[0]) : null,
                    'tanggal_selesai' => $parts[1] !== 'null' ? \Carbon\Carbon::parse($parts[1]) : null,
                    'jadwals' => $periodeJadwals->keyBy('hari')
                ];
            }
        }

        return view('pages.inner.jadwal-menus.sekolah-index', compact('sekolah', 'jadwalData'));
    }
}
