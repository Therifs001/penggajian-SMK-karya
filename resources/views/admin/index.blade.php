<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Penggajian Guru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-RXf+QSDCUqsV4K45E2p6XZh2nFQ0hHzC7QxR3uyGm5WehZ2au1V9qO2eZB4EvjwB6TQ5kx0stJZ3X3E2L1gdkQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <div class="logo">PG</div>
                <div class="title">Penggajian Guru</div>
                <button id="sidebarToggle" class="icon-btn sidebar-toggle-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav>
                <a href="#" class="menu-link active" data-page="dashboard"><span class="icon"><i class="fas fa-chart-line"></i></span><span class="label">Dashboard</span></a>
                <a href="#" class="menu-link" data-page="data-guru"><span class="icon"><i class="fas fa-users"></i></span><span class="label">Data Guru</span></a>
                <a href="#" class="menu-link" data-page="data-gaji"><span class="icon"><i class="fas fa-wallet"></i></span><span class="label">Data Gaji</span></a>
                <a href="#" class="menu-link" data-page="absensi"><span class="icon"><i class="fas fa-calendar-check"></i></span><span class="label">Absensi</span></a>
                <a href="#" class="menu-link" data-page="tunjangan"><span class="icon"><i class="fas fa-gifts"></i></span><span class="label">Tunjangan</span></a>
                <a href="#" class="menu-link" data-page="potongan"><span class="icon"><i class="fas fa-minus-circle"></i></span><span class="label">Potongan</span></a>
                <a href="#" class="menu-link" data-page="laporan"><span class="icon"><i class="fas fa-file-alt"></i></span><span class="label">Laporan</span></a>
                <a href="#" class="menu-link" data-page="pengaturan"><span class="icon"><i class="fas fa-cog"></i></span><span class="label">Pengaturan</span></a>
                <a href="{{ route('login') }}" class="menu-link"><span class="icon"><i class="fas fa-sign-out-alt"></i></span><span class="label">Logout</span></a>
            </nav>
            <div class="sidebar-footer">
                <div class="profile-avatar">AD</div>
                <div class="profile-text">
                    <span>Admin</span>
                    <span>Administrator</span>
                </div>
            </div>
        </aside>

        <main class="main-content" id="mainContent">
            <div class="navbar">
                <div class="navbar-left">
                    <button class="menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
                    <div>
                        <p class="breadcrumb"><i class="fas fa-home"></i> Admin Panel</p>
                        <h2 class="heading">Dashboard Penggajian Guru</h2>
                    </div>
                </div>
                <div class="navbar-right">
                    <button class="icon-btn notification" title="Notifikasi"><i class="fas fa-bell"></i></button>
                    <button class="icon-btn" title="Bantuan"><i class="fas fa-question-circle"></i></button>
                    <div class="profile-menu">
                        <div class="profile-avatar">A</div>
                        <div class="profile-details">
                            <span>{{ optional(Auth::user())->name ?? 'Admin' }}</span>
                            <span>Admin Manajemen</span>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section active" id="dashboard">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-chart-pie"></i> Ringkasan</p>
                        <h1>Overview Guru & Gaji</h1>
                    </div>
                    <button class="button primary"><i class="fas fa-plus"></i> Tambah Data</button>
                </div>

                <div class="grid grid-4">
                    <div class="card stat-card">
                        <div class="info">
                            <span>Total Guru</span>
                            <h3>128</h3>
                            <p>Jumlah guru aktif dalam sistem.</p>
                        </div>
                        <div class="stat-badge dashboard"><i class="fas fa-user"></i></div>
                    </div>
                    <div class="card stat-card">
                        <div class="info">
                            <span>Total Gaji Bulan Ini</span>
                            <h3>Rp 345.670.000</h3>
                            <p>Total pengeluaran gaji saat ini.</p>
                        </div>
                        <div class="stat-badge gaji"><i class="fas fa-coins"></i></div>
                    </div>
                    <div class="card stat-card">
                        <div class="info">
                            <span>Guru Aktif</span>
                            <h3>92</h3>
                            <p>Guru tetap yang menerima gaji rutin.</p>
                        </div>
                        <div class="stat-badge aktif"><i class="fas fa-user-check"></i></div>
                    </div>
                    <div class="card stat-card">
                        <div class="info">
                            <span>Guru Kontrak</span>
                            <h3>36</h3>
                            <p>Guru kontrak dengan gaji fleksibel.</p>
                        </div>
                        <div class="stat-badge kontrak"><i class="fas fa-handshake"></i></div>
                    </div>
                </div>

                <div class="grid grid-2 card-grid-top">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">Pengeluaran Gaji Per Bulan</h3>
                                <p class="card-subtitle">Grafik ringkas perkembangan pengeluaran selama 12 bulan terakhir.</p>
                            </div>
                            <div class="pill paid">Terakhir: Rp 29.500.000</div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="salaryChart"></canvas>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">Gaji Terbaru</h3>
                                <p class="card-subtitle">Lihat riwayat transaksi terakhir.</p>
                            </div>
                            <button class="button secondary"><i class="fas fa-filter"></i> Filter</button>
                        </div>
                        <div class="card-scroll">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Guru</th>
                                        <th>Status</th>
                                        <th>Total Gaji</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Rina Wulandari</td>
                                        <td><span class="pill tetap">Tetap</span></td>
                                        <td>Rp 4.250.000</td>
                                        <td>12 Apr 2026</td>
                                    </tr>
                                    <tr>
                                        <td>Andi Susanto</td>
                                        <td><span class="pill kontrak">Kontrak</span></td>
                                        <td>Rp 3.120.000</td>
                                        <td>11 Apr 2026</td>
                                    </tr>
                                    <tr>
                                        <td>Siti Ramadhani</td>
                                        <td><span class="pill tetap">Tetap</span></td>
                                        <td>Rp 4.540.000</td>
                                        <td>09 Apr 2026</td>
                                    </tr>
                                    <tr>
                                        <td>Budi Santoso</td>
                                        <td><span class="pill kontrak">Kontrak</span></td>
                                        <td>Rp 2.980.000</td>
                                        <td>08 Apr 2026</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" id="data-guru">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-users"></i> Master Data</p>
                        <h1>Data Guru</h1>
                    </div>
                    <button class="button primary"><i class="fas fa-user-plus"></i> Tambah Guru</button>
                </div>

                <div class="card">
                    <div class="card-header--compact">
                        <div>
                            <h3 class="card-title">Daftar guru terdaftar</h3>
                            <p class="card-subtitle--tight">Kelola profil, status, dan jabatan guru Anda.</p>
                        </div>
                        <button class="button secondary"><i class="fas fa-download"></i> Ekspor</button>
                    </div>
                    <div class="card-scroll">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Status</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Aulia Maharani</td>
                                    <td>19870512</td>
                                    <td><span class="pill tetap">Tetap</span></td>
                                    <td>Guru Matematika</td>
                                    <td class="table-actions">
                                        <button class="button secondary button-small"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="button secondary button-small"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lina Puspita</td>
                                    <td>19921124</td>
                                    <td><span class="pill kontrak">Kontrak</span></td>
                                    <td>Guru Bahasa</td>
                                    <td class="table-actions">
                                        <button class="button secondary button-small"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="button secondary button-small"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fajar Nugraha</td>
                                    <td>19890205</td>
                                    <td><span class="pill tetap">Tetap</span></td>
                                    <td>Guru IPA</td>
                                    <td class="table-actions">
                                        <button class="button secondary button-small"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="button secondary button-small"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="section" id="data-gaji">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-wallet"></i> Penggajian</p>
                        <h1>Data Gaji</h1>
                    </div>
                    <button class="button primary"><i class="fas fa-plus"></i> Input Gaji</button>
                </div>

                <div class="grid grid-2">
                    <div class="card">
                        <h3 class="card-title">Form Input Gaji</h3>
                        <p class="card-subtitle">Lengkapi data gaji guru dan lihat total secara instan.</p>
                        <div class="form-grid">
                            <div class="input-group">
                                <label for="guruSelect">Pilih Guru</label>
                                <select id="guruSelect">
                                    <option value="Rina Wulandari">Rina Wulandari</option>
                                    <option value="Andi Susanto">Andi Susanto</option>
                                    <option value="Siti Ramadhani">Siti Ramadhani</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="gajiPokok">Gaji Pokok</label>
                                <input id="gajiPokok" type="number" value="4250000" min="0">
                            </div>
                            <div class="input-group">
                                <label for="tunjangan">Tunjangan</label>
                                <input id="tunjangan" type="number" value="550000" min="0">
                            </div>
                            <div class="input-group">
                                <label for="potongan">Potongan</label>
                                <input id="potongan" type="number" value="150000" min="0">
                            </div>
                            <div class="input-group">
                                <label>Total Gaji</label>
                                <input id="totalGaji" type="text" value="Rp 4.650.000" readonly>
                            </div>
                            <div class="input-group">
                                <button class="button primary card-full-width">Simpan Gaji</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header--compact">
                            <div>
                                <h3 class="card-title">Riwayat Gaji</h3>
                                <p class="card-subtitle--tight">Catatan transaksi gaji terakhir.</p>
                            </div>
                            <button class="button secondary"><i class="fas fa-eye"></i> Lihat Semua</button>
                        </div>
                        <div class="card-scroll">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Guru</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Rina Wulandari</td>
                                        <td>12 Apr 2026</td>
                                        <td>Rp 4.650.000</td>
                                        <td><span class="pill paid">Lunas</span></td>
                                    </tr>
                                    <tr>
                                        <td>Andi Susanto</td>
                                        <td>11 Apr 2026</td>
                                        <td>Rp 3.120.000</td>
                                        <td><span class="pill pending">Proses</span></td>
                                    </tr>
                                    <tr>
                                        <td>Siti Ramadhani</td>
                                        <td>09 Apr 2026</td>
                                        <td>Rp 4.540.000</td>
                                        <td><span class="pill paid">Lunas</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" id="laporan">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-file-alt"></i> Laporan</p>
                        <h1>Generasi Laporan</h1>
                    </div>
                    <div class="cta-group">
                        <button class="button secondary"><i class="fas fa-file-pdf"></i> Export PDF</button>
                        <button class="button primary"><i class="fas fa-file-excel"></i> Export Excel</button>
                    </div>
                </div>

                <div class="card">
                    <div class="form-grid grid-triple">
                        <div class="input-group">
                            <label for="filterBulan">Bulan</label>
                            <select id="filterBulan">
                                <option>April</option>
                                <option>Maret</option>
                                <option>Februari</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="filterTahun">Tahun</label>
                            <select id="filterTahun">
                                <option>2026</option>
                                <option>2025</option>
                                <option>2024</option>
                            </select>
                        </div>
                        <div class="input-group align-end">
                            <button class="button primary card-full-width"><i class="fas fa-filter"></i> Tampilkan Laporan</button>
                        </div>
                    </div>
                </div>

                <div class="card margin-top-24">
                    <h3 class="card-title">Ringkasan Laporan</h3>
                    <p class="card-subtitle">Ekspor ringkasan gaji untuk periode yang dipilih.</p>
                    <div class="summary-box">
                        <div class="total-card">
                            <div class="detail">
                                <span>Total Pengeluaran</span>
                                <strong>Rp 345.670.000</strong>
                            </div>
                            <div class="detail">
                                <span>Total Transaksi</span>
                                <strong>128</strong>
                            </div>
                        </div>
                        <div class="total-card">
                            <div class="detail">
                                <span>Guru Aktif</span>
                                <strong>92</strong>
                            </div>
                            <div class="detail">
                                <span>Guru Kontrak</span>
                                <strong>36</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" id="absensi">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-calendar-check"></i> Absensi</p>
                        <h1>Absensi Guru</h1>
                    </div>
                    <button class="button secondary"><i class="fas fa-clock"></i> Atur Jadwal Absen</button>
                </div>

                <div class="card">
                    <div class="card-header--compact">
                        <div>
                            <h3 class="card-title">Jam Absen Dibuka</h3>
                            <p class="card-subtitle--tight">Tetapkan waktu mulai dan akhir absensi harian.</p>
                        </div>
                    </div>
                    <div class="form-grid grid-triple">
                        <div class="input-group">
                            <label for="attendanceOpenTime">Jam Mulai</label>
                            <input id="attendanceOpenTime" type="time" value="07:00">
                        </div>
                        <div class="input-group">
                            <label for="attendanceCloseTime">Jam Tutup</label>
                            <input id="attendanceCloseTime" type="time" value="09:00">
                        </div>
                        <div class="input-group align-end">
                            <button id="attendanceSaveButton" class="button primary card-full-width"><i class="fas fa-save"></i> Simpan Jadwal</button>
                        </div>
                    </div>
                </div>

                <div class="card margin-top-24">
                    <h3 class="card-title">Status Jadwal Absensi</h3>
                    <p class="card-subtitle">Informasi jadwal absen yang sedang berlaku untuk hari ini.</p>
                    <div class="summary-box">
                        <div class="total-card">
                            <div class="detail">
                                <span>Jam Buka Absensi</span>
                                <strong id="attendanceOpenLabel">07:00</strong>
                            </div>
                            <div class="detail">
                                <span>Jam Tutup Absensi</span>
                                <strong id="attendanceCloseLabel">09:00</strong>
                            </div>
                        </div>
                        <div class="total-card">
                            <div class="detail">
                                <span>Status Saat Ini</span>
                                <strong id="attendanceStatus">Belum dibuka</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" id="tunjangan">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-gifts"></i> Tunjangan</p>
                        <h1>Pengaturan Tunjangan</h1>
                    </div>
                </div>
                <div class="section-empty">
                    Modul tunjangan dirancang dengan tampilan profesional. <br> Tambahkan data tunjangan dan alur manajemen di sini.
                </div>
            </section>

            <section class="section" id="potongan">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-minus-circle"></i> Potongan</p>
                        <h1>Potongan Gaji</h1>
                    </div>
                </div>
                <div class="section-empty">
                    Halaman potongan tersedia untuk menambahkan atau mengelola pengurangan gaji.
                </div>
            </section>

            <section class="section" id="pengaturan">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-cog"></i> Pengaturan</p>
                        <h1>Pengaturan Akun</h1>
                    </div>
                </div>
                <div class="section-empty">
                    Dashboard pengaturan dapat digunakan untuk konfigurasi pengguna, notifikasi, dan preferensi sistem.
                </div>
            </section>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const menuLinks = document.querySelectorAll('.menu-link');
        const sections = document.querySelectorAll('.section');
        const totalGajiInput = document.getElementById('totalGaji');
        const gajiPokokInput = document.getElementById('gajiPokok');
        const tunjanganInput = document.getElementById('tunjangan');
        const potonganInput = document.getElementById('potongan');
        const attendanceOpenInput = document.getElementById('attendanceOpenTime');
        const attendanceCloseInput = document.getElementById('attendanceCloseTime');
        const attendanceSaveButton = document.getElementById('attendanceSaveButton');
        const attendanceOpenLabel = document.getElementById('attendanceOpenLabel');
        const attendanceCloseLabel = document.getElementById('attendanceCloseLabel');
        const attendanceStatusLabel = document.getElementById('attendanceStatus');

        function setPage(pageId) {
            sections.forEach(section => {
                section.classList.toggle('active', section.id === pageId);
            });
            menuLinks.forEach(link => {
                link.classList.toggle('active', link.dataset.page === pageId);
            });
            if (window.innerWidth <= 1200) {
                sidebar.classList.remove('open');
            }
        }

        function updateTotal() {
            const pokok = parseFloat(gajiPokokInput.value || 0);
            const tunjangan = parseFloat(tunjanganInput.value || 0);
            const potongan = parseFloat(potonganInput.value || 0);
            const total = pokok + tunjangan - potongan;
            totalGajiInput.value = total >= 0 ? `Rp ${total.toLocaleString('id-ID')}` : 'Rp 0';
        }

        function getCurrentTimeString() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function updateAttendanceLabels(openTime, closeTime) {
            if (attendanceOpenInput) attendanceOpenInput.value = openTime;
            if (attendanceCloseInput) attendanceCloseInput.value = closeTime;
            if (attendanceOpenLabel) attendanceOpenLabel.textContent = openTime;
            if (attendanceCloseLabel) attendanceCloseLabel.textContent = closeTime;
        }

        function updateAttendanceStatus() {
            if (!attendanceOpenLabel || !attendanceCloseLabel || !attendanceStatusLabel) return;

            const openTime = attendanceOpenLabel.textContent.trim();
            const closeTime = attendanceCloseLabel.textContent.trim();
            const [openHour, openMinute] = openTime.split(':').map(Number);
            const [closeHour, closeMinute] = closeTime.split(':').map(Number);
            const now = new Date();
            const openDate = new Date(now);
            const closeDate = new Date(now);
            openDate.setHours(openHour, openMinute, 0, 0);
            closeDate.setHours(closeHour, closeMinute, 0, 0);

            let status = 'Jadwal tidak valid';
            if (openDate < closeDate) {
                if (now < openDate) status = 'Belum dibuka';
                else if (now > closeDate) status = 'Sudah ditutup';
                else status = 'Sedang terbuka';
            }

            attendanceStatusLabel.textContent = status;
        }

        function loadAttendanceSchedule() {
            const storedOpen = localStorage.getItem('attendanceOpenTime') || '07:00';
            const storedClose = localStorage.getItem('attendanceCloseTime') || '09:00';
            updateAttendanceLabels(storedOpen, storedClose);
            updateAttendanceStatus();
        }

        function saveAttendanceSchedule() {
            if (!attendanceOpenInput || !attendanceCloseInput) return;
            const openTime = attendanceOpenInput.value;
            const closeTime = attendanceCloseInput.value;
            localStorage.setItem('attendanceOpenTime', openTime);
            localStorage.setItem('attendanceCloseTime', closeTime);
            updateAttendanceLabels(openTime, closeTime);
            updateAttendanceStatus();
            attendanceSaveButton.textContent = 'Disimpan';
            setTimeout(() => {
                attendanceSaveButton.innerHTML = '<i class="fas fa-save"></i> Simpan Jadwal';
            }, 1800);
        }

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            sidebar.classList.remove('open');
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

        [gajiPokokInput, tunjanganInput, potonganInput].forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        if (attendanceSaveButton) {
            attendanceSaveButton.addEventListener('click', saveAttendanceSchedule);
        }

        loadAttendanceSchedule();
        updateTotal();
        setPage('dashboard');
        setInterval(updateAttendanceStatus, 60000);

        const ctx = document.getElementById('salaryChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [{
                    label: 'Pengeluaran Gaji',
                    data: [24000000, 25500000, 26200000, 27800000, 28500000, 29800000, 30500000, 31000000, 32500000, 33400000, 34000000, 34500000],
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.16)',
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#4f46e5',
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
                        cornerRadius: 16,
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

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1200) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>

