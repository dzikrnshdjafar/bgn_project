@section('title', 'Kalender Menu Mingguan')

<x-app-layout>
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-month"></i> Kalender Menu - 
                        <span id="current-month-year"></span>
                    </h5>
                    <div>
                        <button class="btn btn-sm btn-outline-primary" id="prev-month">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary" id="today-btn">Hari Ini</button>
                        <button class="btn btn-sm btn-outline-primary" id="next-month">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if ($jadwalMenus->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Jadwal menu belum tersedia. Sekolah Anda mungkin
                            belum terdaftar di SPPG manapun.
                        </div>
                    @else
                        <style>
                            .calendar-grid {
                                display: grid;
                                grid-template-columns: repeat(7, 1fr);
                                gap: 5px;
                            }
                            .calendar-header {
                                text-align: center;
                                font-weight: bold;
                                padding: 10px;
                                background-color: #435ebe;
                                color: white;
                                border-radius: 5px;
                            }
                            .calendar-day {
                                min-height: 80px;
                                border: 1px solid #dee2e6;
                                border-radius: 5px;
                                padding: 8px;
                                text-align: center;
                                cursor: pointer;
                                transition: all 0.3s ease;
                                position: relative;
                            }
                            .calendar-day:hover {
                                background-color: #f8f9fa;
                                transform: translateY(-2px);
                                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                            }
                            .calendar-day.today {
                                background-color: #e3f2fd;
                                border: 2px solid #435ebe;
                            }
                            .calendar-day.other-month {
                                color: #ccc;
                                background-color: #fafafa;
                                cursor: default;
                            }
                            .calendar-day.other-month:hover {
                                transform: none;
                                box-shadow: none;
                            }
                            .calendar-day.weekend {
                                background-color: #fff3cd;
                            }
                            .calendar-day.has-menu {
                                background-color: #d1f2eb;
                            }
                            .calendar-day.has-menu:hover {
                                background-color: #a7e7d4;
                            }
                            .day-number {
                                font-size: 1.2rem;
                                font-weight: 600;
                                margin-bottom: 5px;
                            }
                            .day-name {
                                font-size: 0.75rem;
                                color: #6c757d;
                                margin-bottom: 5px;
                            }
                            .like-badge {
                                position: absolute;
                                bottom: 5px;
                                right: 5px;
                                font-size: 0.7rem;
                            }
                        </style>

                        <div class="calendar-grid mb-2">
                            <div class="calendar-header">Min</div>
                            <div class="calendar-header">Sen</div>
                            <div class="calendar-header">Sel</div>
                            <div class="calendar-header">Rab</div>
                            <div class="calendar-header">Kam</div>
                            <div class="calendar-header">Jum</div>
                            <div class="calendar-header">Sab</div>
                        </div>
                        <div class="calendar-grid" id="calendar-dates">
                            <!-- Calendar dates will be generated by JavaScript -->
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <span class="badge" style="background-color: #d1f2eb; color: #000;">█</span> Ada Menu
                                <span class="badge" style="background-color: #fff3cd; color: #000; margin-left: 10px;">█</span> Weekend
                                <span class="badge bg-primary" style="margin-left: 10px;">█</span> Hari Ini
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal 1: Input Sisa Makanan (Only for Operator Sekolah) -->
            @role('Operator Sekolah')
            <div class="modal fade" id="modalSisaMakanan" tabindex="-1" aria-labelledby="modalSisaMakananLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h6 class="modal-title" id="modalSisaMakananLabel">
                                <i class="bi bi-box-seam"></i> Input Sisa Makanan
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-sisa-loading" class="text-center py-3">
                                <div class="spinner-border spinner-border-sm text-warning" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <div id="modal-sisa-content" style="display: none;">
                                <p class="mb-3">
                                    <strong>Menu:</strong> <span id="sisa-hari-text"></span>
                                </p>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-box-seam"></i> Jumlah Sisa (Porsi)
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="input-jumlah-sisa" 
                                           min="0" placeholder="0" value="0">
                                    <small class="text-muted">Jumlah porsi makanan yang tersisa</small>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-warning" type="button" id="btn-save-sisa">
                                        <i class="bi bi-check-lg"></i> Simpan & Lanjut ke Like
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="btn-skip-sisa">
                                        Lewati
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endrole

            <!-- Modal 2: Detail Menu & Like -->
            <div class="modal fade" id="modalDetailMenu" tabindex="-1" aria-labelledby="modalDetailMenuLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h6 class="modal-title" id="modalDetailMenuLabel">
                                <i class="bi bi-calendar-day"></i> <span id="modal-hari"></span>
                            </h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-loading" class="text-center py-3">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <div id="modal-content" style="display: none;">
                                <!-- Menu Items - Simple List -->
                                <ul class="list-unstyled mb-3" id="modal-makanan-list"></ul>

                                <!-- Like Section -->
                                <div class="d-grid gap-2">
                                    <button type="button" id="btn-toggle-like" class="btn btn-primary" data-jadwal-id="">
                                        <i class="bi bi-hand-thumbs-up-fill"></i>
                                        Like (<span id="modal-likes-count">0</span>)
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentJadwalId = null;
                let currentTanggal = null;
                let currentHariName = null;
                
                const modalDetailElement = document.getElementById('modalDetailMenu');
                const modalDetail = new bootstrap.Modal(modalDetailElement);
                
                // Modal sisa makanan (only for Operator Sekolah)
                const modalSisaElement = document.getElementById('modalSisaMakanan');
                const modalSisa = modalSisaElement ? new bootstrap.Modal(modalSisaElement) : null;
                
                let currentDate = new Date();
                let likesByDate = {}; // Store likes data by date
                
                // Check user role from Laravel
                const isOperatorSekolah = {{ auth()->user()->hasRole('Operator Sekolah') ? 'true' : 'false' }};
                
                // Jadwal menu data from Laravel
                const jadwalMenus = @json($jadwalMenus);

                // Initialize calendar
                fetchLikesAndRender(currentDate);

                // Month navigation
                document.getElementById('prev-month').addEventListener('click', function() {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    fetchLikesAndRender(currentDate);
                });

                document.getElementById('next-month').addEventListener('click', function() {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    fetchLikesAndRender(currentDate);
                });

                document.getElementById('today-btn').addEventListener('click', function() {
                    currentDate = new Date();
                    fetchLikesAndRender(currentDate);
                });

                function fetchLikesAndRender(date) {
                    const yearMonth = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
                    
                    // Fetch likes for this month
                    fetch('{{ route('kalender-menu.getLikesByMonth') }}?year_month=' + yearMonth)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                likesByDate = response.likes_by_date;
                                renderCalendar(date);
                            } else {
                                renderCalendar(date);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching likes:', error);
                            renderCalendar(date);
                        });
                }

                function renderCalendar(date) {
                    const year = date.getFullYear();
                    const month = date.getMonth();
                    
                    // Update header
                    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    document.getElementById('current-month-year').textContent = `${monthNames[month]} ${year}`;

                    // Get first day of month and number of days
                    const firstDay = new Date(year, month, 1);
                    const lastDay = new Date(year, month + 1, 0);
                    const numDays = lastDay.getDate();
                    const startingDayOfWeek = firstDay.getDay(); // 0 = Sunday

                    // Get previous month's last days
                    const prevMonthLastDay = new Date(year, month, 0).getDate();
                    const prevMonthDays = startingDayOfWeek;

                    // Calculate total cells needed
                    const totalCells = Math.ceil((numDays + startingDayOfWeek) / 7) * 7;

                    const calendarDates = document.getElementById('calendar-dates');
                    calendarDates.innerHTML = '';

                    const today = new Date();
                    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                    for (let i = 0; i < totalCells; i++) {
                        const dayCell = document.createElement('div');
                        dayCell.className = 'calendar-day';
                        
                        let dayNumber, currentMonth, currentYear, dayOfWeek;

                        if (i < prevMonthDays) {
                            // Previous month days
                            dayNumber = prevMonthLastDay - (prevMonthDays - i - 1);
                            currentMonth = month - 1;
                            currentYear = month === 0 ? year - 1 : year;
                            dayCell.classList.add('other-month');
                        } else if (i >= prevMonthDays + numDays) {
                            // Next month days
                            dayNumber = i - (prevMonthDays + numDays) + 1;
                            currentMonth = month + 1;
                            currentYear = month === 11 ? year + 1 : year;
                            dayCell.classList.add('other-month');
                        } else {
                            // Current month days
                            dayNumber = i - prevMonthDays + 1;
                            currentMonth = month;
                            currentYear = year;

                            const cellDate = new Date(currentYear, currentMonth, dayNumber);
                            dayOfWeek = cellDate.getDay();
                            const hariName = dayNames[dayOfWeek];

                            // Check if today
                            if (cellDate.toDateString() === today.toDateString()) {
                                dayCell.classList.add('today');
                            }

                            // Check if weekend
                            if (dayOfWeek === 0 || dayOfWeek === 6) {
                                dayCell.classList.add('weekend');
                            }

                            // Check if has menu (weekday only)
                            const menu = jadwalMenus.find(m => m.hari === hariName);
                            if (menu && menu.makanans && menu.makanans.length > 0) {
                                dayCell.classList.add('has-menu');
                                
                                // Format tanggal untuk match dengan database (YYYY-MM-DD)
                                const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
                                
                                // Get likes count untuk tanggal ini dari data yang di-fetch
                                let likesForDate = 0;
                                if (likesByDate[hariName] && likesByDate[hariName][dateStr]) {
                                    likesForDate = likesByDate[hariName][dateStr];
                                }
                                
                                // Add like badge only if there are likes
                                if (likesForDate > 0) {
                                    const likeBadge = document.createElement('span');
                                    likeBadge.className = 'badge bg-info like-badge';
                                    likeBadge.innerHTML = `<i class="bi bi-heart-fill"></i> ${likesForDate}`;
                                    dayCell.appendChild(likeBadge);
                                }
                            }

                            // Add click event for weekdays with menu
                            if (dayOfWeek >= 1 && dayOfWeek <= 5) {
                                dayCell.style.cursor = 'pointer';
                                dayCell.addEventListener('click', function() {
                                    openModalForDay(hariName, cellDate);
                                });
                            }

                            // Add day name
                            const dayNameEl = document.createElement('div');
                            dayNameEl.className = 'day-name';
                            dayNameEl.textContent = hariName.substring(0, 3);
                            dayCell.appendChild(dayNameEl);
                        }

                        // Add day number
                        const dayNumberEl = document.createElement('div');
                        dayNumberEl.className = 'day-number';
                        dayNumberEl.textContent = dayNumber;
                        dayCell.insertBefore(dayNumberEl, dayCell.firstChild);

                        calendarDates.appendChild(dayCell);
                    }
                }

                function openModalForDay(hari, date) {
                    // Format tanggal untuk backend (YYYY-MM-DD)
                    const tanggalStr = date.toISOString().split('T')[0];
                    currentTanggal = tanggalStr;
                    currentHariName = hari;
                    
                    const dateText = `${hari}, ${date.getDate()} ${getMonthName(date.getMonth())} ${date.getFullYear()}`;

                    // Operator Sekolah: Show modal sisa makanan first
                    if (isOperatorSekolah && modalSisa) {
                        modalSisa.show();
                        document.getElementById('sisa-hari-text').textContent = dateText;
                        
                        // Show loading
                        document.getElementById('modal-sisa-loading').style.display = 'block';
                        document.getElementById('modal-sisa-content').style.display = 'none';

                        // Fetch menu data to get jumlah sisa
                        fetch('{{ route('kalender-menu.getByHari') }}?hari=' + encodeURIComponent(hari) + '&tanggal=' + tanggalStr)
                            .then(response => response.json())
                            .then(response => {
                                if (response.success) {
                                    const data = response.data;
                                    currentJadwalId = data.id;

                                    // Update jumlah sisa input
                                    document.getElementById('input-jumlah-sisa').value = data.jumlahSisa || 0;

                                    // Hide loading, show content
                                    document.getElementById('modal-sisa-loading').style.display = 'none';
                                    document.getElementById('modal-sisa-content').style.display = 'block';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal memuat data menu.');
                                modalSisa.hide();
                            });
                    } else {
                        // Non Operator Sekolah: Show modal detail directly
                        showModalDetail(hari, date, tanggalStr, dateText);
                    }
                }

                function showModalDetail(hari, date, tanggalStr, dateText) {
                    modalDetail.show();
                    document.getElementById('modal-hari').textContent = dateText;

                    // Show loading
                    document.getElementById('modal-loading').style.display = 'block';
                    document.getElementById('modal-content').style.display = 'none';

                    // Fetch menu data
                    fetch('{{ route('kalender-menu.getByHari') }}?hari=' + encodeURIComponent(hari) + '&tanggal=' + tanggalStr)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                const data = response.data;
                                currentJadwalId = data.id;

                                // Populate makanan list - Simple flat list
                                let makananHtml = '';
                                Object.keys(data.makanans).forEach(kategori => {
                                    const items = data.makanans[kategori];
                                    items.forEach(item => {
                                        makananHtml += `<li class="mb-2"><i class="bi bi-circle-fill text-success" style="font-size: 0.5rem;"></i> ${item.nama_makanan}</li>`;
                                    });
                                });
                                document.getElementById('modal-makanan-list').innerHTML = makananHtml;

                                // Update like count
                                document.getElementById('modal-likes-count').textContent = data.likesCount;
                                
                                // Store jadwal_id and tanggal in button
                                document.getElementById('btn-toggle-like').setAttribute('data-jadwal-id', data.id);
                                document.getElementById('btn-toggle-like').setAttribute('data-tanggal', tanggalStr);

                                // Hide loading, show content
                                document.getElementById('modal-loading').style.display = 'none';
                                document.getElementById('modal-content').style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal memuat data menu.');
                            modalDetail.hide();
                        });
                }

                function getMonthName(month) {
                    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    return months[month];
                }

                // Toggle like
                document.getElementById('btn-toggle-like').addEventListener('click', function() {
                    const jadwalId = this.getAttribute('data-jadwal-id');
                    const tanggal = this.getAttribute('data-tanggal');
                    const button = this;

                    button.disabled = true;

                    fetch(`/kalender-menu/${jadwalId}/toggle-like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            tanggal: tanggal
                        })
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            // Update like count in modal
                            document.getElementById('modal-likes-count').textContent = response.likesCount;

                            // Re-fetch likes and re-render calendar to update like badges
                            fetchLikesAndRender(currentDate);
                        }
                        button.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memproses like.');
                        button.disabled = false;
                    });
                });

                // Save jumlah sisa (only for Operator Sekolah)
                const btnSaveSisa = document.getElementById('btn-save-sisa');
                if (btnSaveSisa) {
                    btnSaveSisa.addEventListener('click', function() {
                        const jumlahSisa = document.getElementById('input-jumlah-sisa').value;
                        const button = this;

                        button.disabled = true;

                        fetch(`/kalender-menu/${currentJadwalId}/update-jumlah-sisa`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                tanggal: currentTanggal,
                                jumlah_sisa: parseInt(jumlahSisa)
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                // Close modal sisa and open modal detail
                                modalSisa.hide();
                                
                                // Show modal detail for like
                                const dateText = document.getElementById('sisa-hari-text').textContent;
                                const dateParts = currentTanggal.split('-');
                                const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                                showModalDetail(currentHariName, dateObj, currentTanggal, dateText);
                            } else {
                                alert('Gagal menyimpan data sisa makanan.');
                            }
                            button.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal menyimpan data sisa makanan.');
                            button.disabled = false;
                        });
                    });
                }

                // Skip button - go directly to like modal
                const btnSkipSisa = document.getElementById('btn-skip-sisa');
                if (btnSkipSisa) {
                    btnSkipSisa.addEventListener('click', function() {
                        modalSisa.hide();
                        
                        const dateText = document.getElementById('sisa-hari-text').textContent;
                        const dateParts = currentTanggal.split('-');
                        const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                        showModalDetail(currentHariName, dateObj, currentTanggal, dateText);
                    });
                }

                // Reset modal on close
                modalDetailElement.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('modal-loading').style.display = 'block';
                    document.getElementById('modal-content').style.display = 'none';
                    document.getElementById('modal-makanan-list').innerHTML = '';
                    currentJadwalId = null;
                });

                // Reset modal sisa on close
                if (modalSisaElement) {
                    modalSisaElement.addEventListener('hidden.bs.modal', function() {
                        document.getElementById('modal-sisa-loading').style.display = 'block';
                        document.getElementById('modal-sisa-content').style.display = 'none';
                        document.getElementById('input-jumlah-sisa').value = 0;
                    });
                }
            });
        </script>
    @endpush
        </section>
    </section>
</x-app-layout>
