@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p>Nama Guru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ auth()->user()->nip }}</h3>
                    <p>NIP</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-card"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ auth()->user()->matapelajaran }}</h3>
                    <p>Mata Pelajaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Absensi Hari Ini</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Gunakan tombol di bawah untuk melakukan absen hadir atau izin.</p>
                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-primary mr-2"><i class="fas fa-calendar-check mr-1"></i> Absen Hadir</a>
                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-warning"><i class="fas fa-comment-alt mr-1"></i> Izin / Alasan</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan Gaji</h3>
                </div>
                <div class="card-body">
                    <div class="info-box bg-light mb-3">
                        <span class="info-box-icon bg-success"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Gaji Terakhir</span>
                            <span class="info-box-number">Rp 4.650.000</span>
                        </div>
                    </div>
                    <div class="info-box bg-light mb-3">
                        <span class="info-box-icon bg-info"><i class="fas fa-hand-holding-dollar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tunjangan</span>
                            <span class="info-box-number">Rp 550.000</span>
                        </div>
                    </div>
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-warning"><i class="fas fa-history"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Riwayat Slip</span>
                            <span class="info-box-number">3 Bulan Terakhir</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <a href="{{ route('guru.absensi.index') }}" class="block p-4 bg-white rounded shadow">Absensi</a>
        <a href="{{ route('guru.gaji.index') }}" class="block p-4 bg-white rounded shadow">Riwayat Gaji</a>
    </div>
@endsection<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Penggajian</title>
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
                <div class="logo">G</div>
                <div class="title">Penggajian Guru</div>
                <button id="sidebarToggle" class="icon-btn sidebar-toggle-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
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
                <div class="profile-avatar">{{ strtoupper(substr(optional(Auth::user())->name ?? 'GURU', 0, 1)) }}</div>
                <div class="profile-text">
                    {{ optional(Auth::user())->name ?? 'Nama Guru' }}<br>
                    {{ optional(Auth::user())->email ?? 'guru@email.com' }}
                </div>
            </div>
        </aside>

        <main class="main-content" id="mainContent">
            <div class="navbar">
                <div class="navbar-left">
                    <button class="menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
                    <div>
                        <p class="breadcrumb"><i class="fas fa-home"></i> Dashboard Guru</p>
                        <h2 class="heading">Penggajian Guru</h2>
                    </div>
                </div>
                <div class="navbar-right">
                    <button class="icon-btn notification" title="Notifikasi"><i class="fas fa-bell"></i></button>
                    <button class="icon-btn" title="Bantuan"><i class="fas fa-question-circle"></i></button>
                    <div class="profile-menu">
                        <div class="profile-avatar">{{ strtoupper(substr(optional(Auth::user())->name ?? 'GURU', 0, 1)) }}</div>
                        <div class="profile-details">
                            <span>{{ optional(Auth::user())->name ?? 'Guru' }}</span>
                            <span>{{ optional(Auth::user())->matapelajaran ?? 'Guru Mata Pelajaran' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section active" id="dashboard">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-chart-pie"></i> Ringkasan</p>
                        <h1>Overview Penghasilan & Absensi</h1>
                    </div>
                    <button class="button primary"><i class="fas fa-file-invoice-dollar"></i> Lihat Slip</button>
                </div>

                <div class="grid grid-4">
                    <div class="card stat-card">
                        <div class="meta">
                            <h3>Gaji Bulan Ini</h3>
                            <strong id="dashboardSalary">Rp 4.650.000</strong>
                        </div>
                        <div class="stat-badge dashboard"><i class="fas fa-wallet"></i></div>
                    </div>
                    <div class="card stat-card">
                        <div class="meta">
                            <h3>Total Tunjangan</h3>
                            <strong id="dashboardAllowance">Rp 550.000</strong>
                        </div>
                        <div class="stat-badge gaji"><i class="fas fa-hand-holding-dollar"></i></div>
                    </div>
                    <div class="card stat-card">
                        <div class="meta">
                            <h3>Status Absensi</h3>
                            <strong id="todayAttendanceStatus">Belum Absen</strong>
                            <p>Status kehadiran hari ini.</p>
                        </div>
                        <div class="stat-badge aktif"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>

                <div class="grid grid-2 card-grid-top">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">Trend Gaji 6 Bulan</h3>
                                <p class="card-subtitle">Grafik perkembangan penghasilan Anda.</p>
                            </div>
                            <div class="pill paid">Terakhir: Rp 4.650.000</div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="salaryTrendChart"></canvas>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">Slip Gaji Terbaru</h3>
                                <p class="card-subtitle">Ringkasan pembayaran terbaru.</p>
                            </div>
                            <button class="button secondary"><i class="fas fa-download"></i> Unduh</button>
                        </div>
                        <div class="card-scroll">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>April 2026</td>
                                        <td>Rp 4.650.000</td>
                                        <td><span class="pill paid">Lunas</span></td>
                                        <td><button class="button secondary button-small">Detail</button></td>
                                    </tr>
                                    <tr>
                                        <td>Maret 2026</td>
                                        <td>Rp 4.650.000</td>
                                        <td><span class="pill paid">Lunas</span></td>
                                        <td><button class="button secondary button-small">Detail</button></td>
                                    </tr>
                                    <tr>
                                        <td>Februari 2026</td>
                                        <td>Rp 4.650.000</td>
                                        <td><span class="pill pending">Pending</span></td>
                                        <td><button class="button secondary button-small">Detail</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" id="absensi">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-calendar-check"></i> Absensi</p>
                        <h1>Catatan Kehadiran</h1>
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
                                <strong id="attendanceBadge"><span class="pill pending">Belum Hadir</span></strong>
                            </div>
                        </div>

                        <div style="display:flex;flex-wrap:wrap;gap:16px;margin-top:18px;">
                            <button id="checkInButton" class="button primary">Absen Masuk</button>
                            <button id="checkOutButton" class="button secondary" disabled>Absen Pulang</button>
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
                            <div class="data-item">
                                <span>Total Kehadiran Minggu Ini</span>
                                <strong id="weeklyAttendanceCount">0</strong>
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
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-file-invoice-dollar"></i> Slip Gaji</p>
                        <h1>Rincian Gaji</h1>
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
                        <button class="button primary" id="downloadSlipButton"><i class="fas fa-file-pdf"></i> Download PDF</button>
                    </div>
                </div>
            </section>

            <section class="section" id="riwayat-gaji">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-history"></i> Riwayat</p>
                        <h1>Riwayat Gaji</h1>
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
                                    <td><span class="pill paid">Lunas</span></td>
                                    <td><button class="button secondary">Detail</button></td>
                                </tr>
                                <tr>
                                    <td>Maret 2026</td>
                                    <td>Rp 4.650.000</td>
                                    <td><span class="pill paid">Lunas</span></td>
                                    <td><button class="button secondary">Detail</button></td>
                                </tr>
                                <tr>
                                    <td>Februari 2026</td>
                                    <td>Rp 4.650.000</td>
                                    <td><span class="pill pending">Pending</span></td>
                                    <td><button class="button secondary">Detail</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="section" id="profil">
                <div class="page-header">
                    <div class="heading">
                        <p class="breadcrumb"><i class="fas fa-user"></i> Profil</p>
                        <h1>Profil Saya</h1>
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
                const statusClass = record.status === 'Hadir' ? 'paid' : record.status === 'Telat' ? 'pending' : 'pending';
                return `
                    <tr>
                        <td>${record.date}</td>
                        <td>${record.checkIn || '-'}</td>
                        <td>${record.checkOut || '-'}</td>
                        <td><span class="pill ${statusClass}">${record.status}</span></td>
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
                attendanceBadge.innerHTML = `<span class="pill ${today.status === 'Hadir' ? 'paid' : today.status === 'Telat' ? 'pending' : 'pending'}">${today.status}</span>`;
                checkInButton.disabled = Boolean(today.checkIn);
                checkOutButton.disabled = !today.checkIn || Boolean(today.checkOut);
            } else {
                attendanceIn.textContent = '-';
                attendanceOut.textContent = '-';
                attendanceBadge.innerHTML = `<span class="pill pending">Belum Hadir</span>`;
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