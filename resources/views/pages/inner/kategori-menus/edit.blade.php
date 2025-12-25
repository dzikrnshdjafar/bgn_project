@section('title', 'Edit Kategori Menu')

<x-app-layout>
    <x-form-card :title="'Form Edit Kategori Menu'" :backLink="route('kategori-menus.index')">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('kategori-menus.update', $kategoriMenu) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="{{ old('nama_kategori', $kategoriMenu->nama_kategori) }}" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" class="form-control" id="keterangan" rows="4">{{ old('keterangan', $kategoriMenu->keterangan) }}</textarea>
            </div>

            <hr class="my-4">
            <h5>Daftar Menu</h5>
            <input type="hidden" id="deleted-menus-input" name="deleted_menus" value="">
            <div id="menus-container">
                @if(old('menus'))
                    @foreach(old('menus') as $index => $menu)
                        <div class="menu-item card mb-3" data-menu-id="{{ $menu['id'] ?? '' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Menu #<span class="menu-number">{{ $index + 1 }}</span></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-menu">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                                @if(isset($menu['id']))
                                    <input type="hidden" name="menus[{{ $index }}][id]" value="{{ $menu['id'] }}">
                                @endif
                                
                                <div class="form-group">
                                    <label>Mode Input <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input mode-radio" type="radio" name="menus[{{ $index }}][mode]" id="mode_manual_{{ $index }}" value="manual" {{ ($menu['mode'] ?? 'manual') === 'manual' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mode_manual_{{ $index }}">
                                                Input Manual
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input mode-radio" type="radio" name="menus[{{ $index }}][mode]" id="mode_existing_{{ $index }}" value="existing" {{ ($menu['mode'] ?? 'manual') === 'existing' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mode_existing_{{ $index }}">
                                                Pilih dari Menu yang Ada
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="manual-input-group" style="display: {{ ($menu['mode'] ?? 'manual') === 'manual' ? 'block' : 'none' }};">
                                    <div class="form-group">
                                        <label>Nama Menu <span class="text-danger">*</span></label>
                                        <input type="text" name="menus[{{ $index }}][nama_menu]" class="form-control nama-menu-input" value="{{ $menu['nama_menu'] ?? '' }}" {{ ($menu['mode'] ?? 'manual') === 'manual' ? 'required' : '' }}>
                                        <small class="text-muted">Pastikan nama menu belum ada di sistem</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="menus[{{ $index }}][deskripsi]" class="form-control" rows="2">{{ $menu['deskripsi'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="existing-input-group" style="display: {{ ($menu['mode'] ?? 'manual') === 'existing' ? 'block' : 'none' }};">
                                    <div class="form-group">
                                        <label>Pilih Menu <span class="text-danger">*</span></label>
                                        <select name="menus[{{ $index }}][existing_menu_id]" class="form-control existing-menu-select" {{ ($menu['mode'] ?? 'manual') === 'existing' ? 'required' : '' }}>
                                            <option value="">-- Pilih Menu --</option>
                                            @foreach($existingMenus as $existingMenu)
                                                <option value="{{ $existingMenu->id }}" {{ ($menu['existing_menu_id'] ?? '') == $existingMenu->id ? 'selected' : '' }}>
                                                    {{ $existingMenu->nama_menu }}{{ $existingMenu->deskripsi ? ' - ' . $existingMenu->deskripsi : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Menu yang belum memiliki kategori</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach($kategoriMenu->menus as $index => $menu)
                        <div class="menu-item card mb-3" data-menu-id="{{ $menu->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Menu #<span class="menu-number">{{ $index + 1 }}</span></h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-menu">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="menus[{{ $index }}][id]" value="{{ $menu->id }}">
                                
                                <div class="form-group">
                                    <label>Mode Input <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input mode-radio" type="radio" name="menus[{{ $index }}][mode]" id="mode_manual_existing_{{ $index }}" value="manual" checked>
                                            <label class="form-check-label" for="mode_manual_existing_{{ $index }}">
                                                Input Manual
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input mode-radio" type="radio" name="menus[{{ $index }}][mode]" id="mode_existing_existing_{{ $index }}" value="existing">
                                            <label class="form-check-label" for="mode_existing_existing_{{ $index }}">
                                                Pilih dari Menu yang Ada
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="manual-input-group">
                                    <div class="form-group">
                                        <label>Nama Menu <span class="text-danger">*</span></label>
                                        <input type="text" name="menus[{{ $index }}][nama_menu]" class="form-control nama-menu-input" value="{{ $menu->nama_menu }}" required>
                                        <small class="text-muted">Pastikan nama menu belum ada di sistem</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="menus[{{ $index }}][deskripsi]" class="form-control" rows="2">{{ $menu->deskripsi }}</textarea>
                                    </div>
                                </div>

                                <div class="existing-input-group" style="display: none;">
                                    <div class="form-group">
                                        <label>Pilih Menu <span class="text-danger">*</span></label>
                                        <select name="menus[{{ $index }}][existing_menu_id]" class="form-control existing-menu-select" disabled>
                                            <option value="">-- Pilih Menu --</option>
                                            @foreach($existingMenus as $existingMenu)
                                                <option value="{{ $existingMenu->id }}">
                                                    {{ $existingMenu->nama_menu }}{{ $existingMenu->deskripsi ? ' - ' . $existingMenu->deskripsi : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Menu yang belum memiliki kategori</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="btn btn-success mb-3" id="add-menu">
                <i class="bi bi-plus-lg me-1"></i> Tambah Menu
            </button>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </div>
        </form>
    </x-form-card>

    <script>
        let menuIndex = {{ old('menus') ? count(old('menus')) : count($kategoriMenu->menus) }};
        let deletedMenus = [];
        const existingMenus = @json($existingMenus);

        document.getElementById('add-menu').addEventListener('click', function() {
            const container = document.getElementById('menus-container');
            const menuItem = document.createElement('div');
            menuItem.className = 'menu-item card mb-3';
            menuItem.innerHTML = `
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Menu #<span class="menu-number">${menuIndex + 1}</span></h6>
                        <button type="button" class="btn btn-sm btn-danger remove-menu">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                    
                    <div class="form-group">
                        <label>Mode Input <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input mode-radio" type="radio" name="menus[${menuIndex}][mode]" id="mode_manual_${menuIndex}" value="manual" checked>
                                <label class="form-check-label" for="mode_manual_${menuIndex}">
                                    Input Manual
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input mode-radio" type="radio" name="menus[${menuIndex}][mode]" id="mode_existing_${menuIndex}" value="existing">
                                <label class="form-check-label" for="mode_existing_${menuIndex}">
                                    Pilih dari Menu yang Ada
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="manual-input-group">
                        <div class="form-group">
                            <label>Nama Menu <span class="text-danger">*</span></label>
                            <input type="text" name="menus[${menuIndex}][nama_menu]" class="form-control nama-menu-input" required>
                            <small class="text-muted">Pastikan nama menu belum ada di sistem</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="menus[${menuIndex}][deskripsi]" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="existing-input-group" style="display: none;">
                        <div class="form-group">
                            <label>Pilih Menu <span class="text-danger">*</span></label>
                            <select name="menus[${menuIndex}][existing_menu_id]" class="form-control existing-menu-select" disabled>
                                <option value="">-- Pilih Menu --</option>
                                ${existingMenus.map(menu => `
                                    <option value="${menu.id}">${menu.nama_menu}${menu.deskripsi ? ' - ' + menu.deskripsi : ''}</option>
                                `).join('')}
                            </select>
                            <small class="text-muted">Menu yang belum memiliki kategori</small>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(menuItem);
            
            // Add event listeners for the newly added item
            const newItem = container.lastElementChild;
            setupModeToggle(newItem);
            
            menuIndex++;
            updateMenuNumbers();
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-menu') || e.target.closest('.remove-menu')) {
                const button = e.target.classList.contains('remove-menu') ? e.target : e.target.closest('.remove-menu');
                const menuItem = button.closest('.menu-item');
                const menuId = menuItem.getAttribute('data-menu-id');
                
                if (menuId) {
                    deletedMenus.push(menuId);
                    document.getElementById('deleted-menus-input').value = JSON.stringify(deletedMenus);
                }
                
                menuItem.remove();
                updateMenuNumbers();
            }
        });

        function setupModeToggle(menuItem) {
            const radios = menuItem.querySelectorAll('.mode-radio');
            const manualGroup = menuItem.querySelector('.manual-input-group');
            const existingGroup = menuItem.querySelector('.existing-input-group');
            const namaMenuInput = menuItem.querySelector('.nama-menu-input');
            const existingMenuSelect = menuItem.querySelector('.existing-menu-select');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'manual') {
                        manualGroup.style.display = 'block';
                        existingGroup.style.display = 'none';
                        namaMenuInput.required = true;
                        namaMenuInput.disabled = false;
                        existingMenuSelect.required = false;
                        existingMenuSelect.disabled = true;
                    } else {
                        manualGroup.style.display = 'none';
                        existingGroup.style.display = 'block';
                        namaMenuInput.required = false;
                        namaMenuInput.disabled = true;
                        existingMenuSelect.required = true;
                        existingMenuSelect.disabled = false;
                    }
                });
            });
        }

        // Setup existing menu items on page load (for old input)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.menu-item').forEach(item => {
                setupModeToggle(item);
            });
        });

        function updateMenuNumbers() {
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach((item, index) => {
                item.querySelector('.menu-number').textContent = index + 1;
            });
        }
    </script>
</x-app-layout>
