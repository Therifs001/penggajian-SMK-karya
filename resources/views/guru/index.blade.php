<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Penggajian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-RXf+QSDCUqsV4K45E2p6XZh2nFQ0hHzC7QxR3uyGm5WehZ2au1V9qO2eZB4EvjwB6TQ5kx0stJZ3X3E2L1gdkQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/guru-dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="guru-shell">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <div class="logo">G</div>
                <h1>Guru</h1>
                <button id="sidebarToggle" class="icon-btn"><i class="fas fa-bars"></i></button>
            </div>
            <nav>
                <a href="#" class="menu-link active" data-page="dashboard"><span class="icon"><i class="fas fa-chart-line"></i></span><span class="label">Dashboard</span></a>
                <a href="#" class="menu-link" data-page="absensi"><span class="icon"><i class="fas fa-calendar-check"></i></span><span class="label">Absensi</span></a>
                <a href="#" class="menu-link" data-page="slip-gaji"><span class="icon"><i class="fas fa-file-invoice-dollar"></i></span><span class="label">Slip Gaji</span></a>
                <a href="#" class="menu-link" data-page="riwayat-gaji"><span class="icon"><i class="fas fa-history"></i></span><span class="label">Riwayat Gaji</span></a>
                <a href="#" class="menu-link" data-page="profil"><span class="icon"><i class="fas fa-user"></i></span><span class="label">Profil Saya</span></a>
                <a href="{{ route('login') }}" class="menu-link"><span class="icon"><i class="fas fa-sign-out-alt"></i></span><span class="label">Logout</span></a>
            </nav>
            <div class="sidebar-footer">
                <div class="avatar">{{ strtoupper(substr(optional(Auth::user())->name ?? 'GURU', 0, 1)) }}</div>
                <div class="footer-text">
                    {{ optional(Auth::user())->name ?? 'Nama Guru' }}<br>
                    {{ optional(Auth::user())->email ?? 'guru@email.com' }}
                </div>
            </div>
        </aside>

        <main class="main-content" id="mainContent">
            <div class="topbar">
                <div class="page-heading">
                    <div>
                        <p class="badge primary">Halo, {{ optional(Auth::user())->name ?? 'Bapak/Ibu Guru' }}</p>
                        <h2>Selamat datang kembali</h2>
                        <p>Semoga harimu menyenangkan dan produktif.</p>
                    </div>
                </div>
                <div class="top-actions">
                    <button class="icon-btn" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
                    <button class="icon-btn" title="Notifikasi"><i class="fas fa-bell"></i></button>
                    <button class="icon-btn" title="Profil"><i class="fas fa-user-circle"></i></button>
                </div>
            </div>

            <section class="section active" id="dashboard">
                <div class="page-heading">
                    <div>
                        <h2>Dashboard</h2>
                        <p>Ringkasan penggajian dan status absensi Anda.</p>
                    </div>
                    <div class="badge tetapan" id="employmentStatus">Tetap</div>
                </div>

                <div class="grid grid-3">
                    <div class="card stat-card">
                        <div class="meta">
                            <h3>Gaji Bulan Ini</h3>
                            <strong id="dashboardSalary">Rp 4.650.000</strong>
                        </div>
                        <div class="badge primary"><i class="fas fa-wallet"></i></div>
                    </div>
                    <div class="card stat-card">
                        <div class="meta">
                            <h3>Total Tunjangan</h3>
                            <strong id="dashboardAllowance">Rp 550.000</strong>
                        </div>
                        <div class="badge success"><i class="fas fa-hand-holding-dollar"></i></div>
                    </div>
                    <div class="card stat-card">
                        <div class="meta">
                            <h3>Total Potongan</h3>
                            <strong id="dashboardDeduction">Rp 150.000</strong>
                        </div>
                        <div class="badge warning"><i class="fas fa-minus-circle"></i></div>
                    </div>
                </div>

                <!-- <div class="grid grid-2">
                    <div class="card chart-card">
                        <div class="card-header--compact">
                            <div>
                                <h3 class="card-title">Riwayat Gaji 6 Bulan</h3>
                                <p class="card-subtitle--tight">Grafik nominal gaji bulanan Anda.</p>
                            </div>
                        </div>
                        <canvas id="salaryTrendChart"></canvas>
                    </div>
                    <div class="card">
                        <h3 class="card-title">Informasi Cepat</h3>
                        <div class="data-panel">
                            <div class="data-item">
                                <span>Jabatan</span>
                                <strong>{{ optional(Auth::user())->matapelajaran ?? 'Guru Mata Pelajaran' }}</strong>
                            </div>
                            <div class="data-item">
                                <span>NIP</span>
                                <strong>{{ optional(Auth::user())->nip ?? '1234567890' }}</strong>
                            </div>
                            <div class="data-item">
                                <span>Status Absensi Hari Ini</span>
                                <strong id="todayAttendanceStatus">Belum Absen</strong>
                            </div>
                        </div>
                    </div>
                </div> -->
            </section>

            <section class="section" id="absensi">
                <div class="page-heading">
                    <div>
                        <h2>Absensi</h2>
                        <p>Catat kehadiran harian Anda dengan cepat.</p>
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="card">
                        <div class="card-header--compact">
                            <div>
                                <h3 class="card-title">Absensi Hari Ini</h3>
                                <p class="card-subtitle--tight">Tanggal dan status hadir sekarang.</p>
                            </div>
                        </div>

                        <div class="data-panel">
                            <div class="data-item">
                                <span>Tanggal</span>
                                <strong id="attendanceDate">-</strong>
                            </div>
                            <div class="data-item">
                                <span>Jam Masuk</span>
                                <strong id="attendanceIn">-</strong>
                            </div>
                            <div class="data-item">
                                <span>Jam Pulang</span>
                                <strong id="attendanceOut">-</strong>
                            </div>
                            <div class="data-item">
                                <span>Status</span>
                                <strong id="attendanceBadge"><span class="badge danger">Belum Hadir</span></strong>
                            </div>
                        </div>

                        <div style="display:flex;flex-wrap:wrap;gap:16px;margin-top:18px;">
                            <button id="checkInButton" class="button success">Absen Masuk</button>
                            <button id="checkOutButton" class="button info" disabled>Absen Pulang</button>
                        </div>
                    </div>
                    <div class="card">
                        <h3 class="card-title">Opsi Tambahan</h3>
                        <div class="data-panel">
                            <div class="data-item">
                                <span>Lokasi (opsional)</span>
                                <strong id="attendanceLocation">GPS tidak aktif</strong>
                            </div>
                            <div class="data-item">
                                <span>Foto Selfie</span>
                                <strong>Tambahkan saat absen</strong>
                            </div>
                        </div>
                        <p style="margin-top:14px;color:var(--muted);">Untuk fitur lengkap, dapat ditambahkan lokasi dan bukti foto saat integrasi backend.</p>
                    </div>
                </div>

                <div class="card margin-top-24">
                    <div class="card-header--compact">
                        <div>
                            <h3 class="card-title">Riwayat Absensi</h3>
                            <p class="card-subtitle--tight">Catatan hadir selama 7 hari terakhir.</p>
                        </div>
                    </div>
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceHistoryTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="section" id="slip-gaji">
                <div class="page-heading">
                    <div>
                        <h2>Slip Gaji</h2>
                        <p>Lihat ringkasan gaji bulan ini dan cetak PDF jika diperlukan.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="grid grid-2">
                        <div>
                            <div class="data-panel">
                                <div class="data-item"><span>Nama</span><strong>{{ optional(Auth::user())->name ?? 'Nama Guru' }}</strong></div>
                                <div class="data-item"><span>NIP</span><strong>{{ optional(Auth::user())->nip ?? '1234567890' }}</strong></div>
                                <div class="data-item"><span>Bulan</span><strong id="salaryMonth">April 2026</strong></div>
                            </div>
                        </div>
                        <div>
                            <div class="data-panel">
                                <div class="data-item"><span>Gaji Pokok</span><strong id="salaryBase">Rp 4.250.000</strong></div>
                                <div class="data-item"><span>Tunjangan</span><strong id="salaryAllowance">Rp 550.000</strong></div>
                                <div class="data-item"><span>Potongan</span><strong id="salaryDeduction">Rp 150.000</strong></div>
                                <div class="data-item"><span>Total Gaji</span><strong id="salaryTotal">Rp 4.650.000</strong></div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:24px;display:flex;justify-content:flex-end;">
                        <button class="button info" id="downloadSlipButton"><i class="fas fa-file-pdf"></i> Download PDF</button>
                    </div>
                </div>
            </section>

            <section class="section" id="riwayat-gaji">
                <div class="page-heading">
                    <div>
                        <h2>Riwayat Gaji</h2>
                        <p>Daftar gaji bulanan dan status pembayaran.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Total Gaji</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>April 2026</td>
                                    <td>Rp 4.650.000</td>
                                    <td><span class="badge success">Lunas</span></td>
                                    <td><button class="button secondary">Detail</button></td>
                                </tr>
                                <tr>
                                    <td>Maret 2026</td>
                                    <td>Rp 4.650.000</td>
                                    <td><span class="badge success">Lunas</span></td>
                                    <td><button class="button secondary">Detail</button></td>
                                </tr>
                                <tr>
                                    <td>Februari 2026</td>
                                    <td>Rp 4.650.000</td>
                                    <td><span class="badge warning">Pending</span></td>
                                    <td><button class="button secondary">Detail</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="section" id="profil">
                <div class="page-heading">
                    <div>
                        <h2>Profil Saya</h2>
                        <p>Kelola data pribadi dan informasi kontak Anda.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="grid grid-2">
                        <div>
                            <div class="input-group">
                                <label>Nama</label>
                                <input type="text" value="{{ optional(Auth::user())->name ?? 'Nama Guru' }}" disabled>
                            </div>
                            <div class="input-group">
                                <label>Email</label>
                                <input type="email" value="{{ optional(Auth::user())->email ?? 'guru@email.com' }}" disabled>
                            </div>
                            <div class="input-group">
                                <label>No HP</label>
                                <input type="text" value="{{ optional(Auth::user())->phone ?? '+62 812-3456-7890' }}" disabled>
                            </div>
                        </div>
                        <div>
                            <div class="input-group">
                                <label>Status</label>
                                <input type="text" value="{{ optional(Auth::user())->status ?? 'Tetap' }}" disabled>
                            </div>
                            <div class="input-group">
                                <label>Jabatan</label>
                                <input type="text" value="{{ optional(Auth::user())->matapelajaran ?? 'Guru Mata Pelajaran' }}" disabled>
                            </div>
                            <div class="input-group">
                                <label>Alamat</label>
                                <input type="text" value="{{ optional(Auth::user())->alamat ?? 'Jl. Pendidikan No. 12' }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:24px;display:flex;justify-content:flex-end;">
                        <button class="button primary">Edit Profil</button>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="toast" id="toastMessage">
        <div class="loader" id="toastLoader"></div>
        <span id="toastText">Menyimpan data...</span>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const menuLinks = document.querySelectorAll('.menu-link');
        const sections = document.querySelectorAll('.section');
        const checkInButton = document.getElementById('checkInButton');
        const checkOutButton = document.getElementById('checkOutButton');
        const attendanceDate = document.getElementById('attendanceDate');
        const attendanceIn = document.getElementById('attendanceIn');
        const attendanceOut = document.getElementById('attendanceOut');
        const attendanceBadge = document.getElementById('attendanceBadge');
        const attendanceLocation = document.getElementById('attendanceLocation');
        const attendanceHistoryTable = document.getElementById('attendanceHistoryTable');
        const todayAttendanceStatus = document.getElementById('todayAttendanceStatus');
        const toast = document.getElementById('toastMessage');
        const toastText = document.getElementById('toastText');

        const salaryTrendChart = document.getElementById('salaryTrendChart');

        const todayKey = new Date().toISOString().slice(0, 10);

        function setPage(pageId) {
            sections.forEach(section => {
                section.classList.toggle('active', section.id === pageId);
            });
            menuLinks.forEach(link => {
                link.classList.toggle('active', link.dataset.page === pageId);
            });
            if (window.innerWidth <= 900) {
                sidebar.classList.remove('open');
            }
        }

        function formatTime(date) {
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        function formatDate(date) {
            return date.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        }

        function showToast(message) {
            toastText.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2400);
        }

        function getAttendanceRecords() {
            return JSON.parse(localStorage.getItem('attendanceRecords') || '[]');
        }

        function saveAttendanceRecords(records) {
            localStorage.setItem('attendanceRecords', JSON.stringify(records));
        }

        function renderAttendanceHistory() {
            const records = getAttendanceRecords();
            attendanceHistoryTable.innerHTML = records.slice(-7).reverse().map(record => {
                const statusClass = record.status === 'Hadir' ? 'hadir' : record.status === 'Telat' ? 'telat' : 'tidak-hadir';
                return `
                    <tr>
                        <td>${record.date}</td>
                        <td>${record.checkIn || '-'}</td>
                        <td>${record.checkOut || '-'}</td>
                        <td><span class="badge ${statusClass}">${record.status}</span></td>
                    </tr>
                `;
            }).join('');
        }

        function getTodayRecord() {
            const records = getAttendanceRecords();
            return records.find(record => record.date === todayKey);
        }

        function updateAttendancePanel() {
            const now = new Date();
            const today = getTodayRecord();
            attendanceDate.textContent = formatDate(now);

            if (today) {
                attendanceIn.textContent = today.checkIn || '-';
                attendanceOut.textContent = today.checkOut || '-';
                todayAttendanceStatus.textContent = today.status;
                attendanceBadge.innerHTML = `<span class="badge ${today.status === 'Hadir' ? 'hadir' : today.status === 'Telat' ? 'telat' : 'tidak-hadir'}">${today.status}</span>`;
                checkInButton.disabled = Boolean(today.checkIn);
                checkOutButton.disabled = !today.checkIn || Boolean(today.checkOut);
            } else {
                attendanceIn.textContent = '-';
                attendanceOut.textContent = '-';
                attendanceBadge.innerHTML = `<span class="badge danger">Belum Hadir</span>`;
                todayAttendanceStatus.textContent = 'Belum Absen';
                checkInButton.disabled = false;
                checkOutButton.disabled = true;
            }

            attendanceLocation.textContent = 'GPS tidak aktif';
            renderAttendanceHistory();
        }

        function processAttendance(action) {
            checkInButton.disabled = true;
            checkOutButton.disabled = true;
            const originalCheckIn = checkInButton.innerHTML;
            const originalCheckOut = checkOutButton.innerHTML;

            if (action === 'in') {
                checkInButton.innerHTML = '<div class="loader"></div> Menyimpan';
            } else {
                checkOutButton.innerHTML = '<div class="loader"></div> Menyimpan';
            }

            setTimeout(() => {
                const now = new Date();
                const time = formatTime(now);
                const records = getAttendanceRecords();
                let today = records.find(record => record.date === todayKey);

                if (!today) {
                    today = { date: todayKey, checkIn: null, checkOut: null, status: 'Hadir' };
                    records.push(today);
                }

                if (action === 'in') {
                    today.checkIn = time;
                    const threshold = new Date(now);
                    threshold.setHours(8, 0, 0, 0);
                    today.status = now > threshold ? 'Telat' : 'Hadir';
                } else {
                    today.checkOut = time;
                }

                saveAttendanceRecords(records);
                updateAttendancePanel();
                showToast(action === 'in' ? 'Berhasil absen masuk' : 'Berhasil absen pulang');
                checkInButton.innerHTML = originalCheckIn;
                checkOutButton.innerHTML = originalCheckOut;
            }, 1200);
        }

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        menuLinks.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const page = link.dataset.page;
                if (page) {
                    setPage(page);
                }
            });
        });

        if (checkInButton) {
            checkInButton.addEventListener('click', () => processAttendance('in'));
        }

        if (checkOutButton) {
            checkOutButton.addEventListener('click', () => processAttendance('out'));
        }

        setPage('dashboard');
        updateAttendancePanel();

        new Chart(salaryTrendChart, {
            type: 'line',
            data: {
                labels: ['Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [{
                    label: 'Gaji Total',
                    data: [4300000, 4450000, 4500000, 4620000, 4550000, 4650000],
                    borderColor: '#4f9cff',
                    backgroundColor: 'rgba(79, 156, 255, 0.18)',
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#4f9cff',
                    fill: true,
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        cornerRadius: 12,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b' }
                    },
                    y: {
                        grid: { color: 'rgba(15, 23, 42, 0.08)' },
                        ticks: {
                            color: '#64748b',
                            callback: value => `Rp ${value.toLocaleString('id-ID')}`
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>