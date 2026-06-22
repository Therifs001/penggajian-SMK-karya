<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>QuickStart - Laravel</title>

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>

  <!-- Vendor CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

<!-- HEADER -->
<header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('assets/img/smkkarya.jpeg') }}">
      <h1 class="sitename ms-2">SMK Karya Pembangunan Cicalengka</h1>
    </a>

    <nav id="navbar" class="navmenu">
      <ul>
        <li><a href="#hero" class="nav-link active">Home</a></li>
        <li><a href="#features" class="nav-link">Fitur</a></li>
        <li><a href="#cara-akses" class="nav-link">Cara Akses</a></li>
        <li><a href="#contact" class="nav-link">Kontak</a></li>
      </ul>
    </nav>

    <a href="{{ route('login') }}" class="btn btn-primary">Login Guru</a>

  </div>
</header>

<!-- MAIN -->
<main class="main">

<!-- HERO -->
<section id="hero" class="hero section d-flex align-items-center">

  <!-- Background Image -->
  <div class="hero-bg">
    <img src="{{ asset('assets/img/smkkarya.jpeg') }}" alt="">
  </div>

  <div class="container text-center">

    <h1 data-aos="fade-down" data-aos-duration="1000">
      Sistem Penggajian Guru
    </h1>

    <h2 data-aos="fade-up" data-aos-delay="200">
      SMA Karya Pembangunan Cicalengka
    </h2>

    <p data-aos="fade-up" data-aos-delay="400">
      Memudahkan pengelolaan gaji guru secara cepat, transparan, dan akurat.
    </p>

    <a href="{{ route('login') }}"
       class="btn-get-started"
       data-aos="zoom-in"
       data-aos-delay="600">
       Akses Login
    </a>

  </div>
</section>

<!-- INFORMASI SISTEM -->
<section id="features" class="section py-5 bg-light">
  <div class="container text-center">

    <h2 class="fw-bold" data-aos="fade-up">
      Fitur Unggulan Sistem Penggajian
    </h2>

    <p class="text-muted mb-5" data-aos="fade-up" data-aos-delay="200">
      Kami menyediakan sistem penggajian yang dirancang khusus untuk kemudahan dan kenyamanan para guru.
    </p>

    <div class="row g-4">

      <!-- CARD -->
      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <div class="mb-3">
            <div class="bg-light rounded-3 d-inline-block p-3 icon-box">
              <i class="bi bi-check-circle text-success fs-2"></i>
            </div>
          </div>
          <h5 class="fw-bold">Transparan & Akurat</h5>
          <p class="text-muted">
            Sistem penggajian yang transparan dengan rincian gaji yang jelas dan akurat untuk setiap guru.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <div class="mb-3">
            <div class="bg-light rounded-3 d-inline-block p-3 icon-box">
              <i class="bi bi-clock text-primary fs-2"></i>
            </div>
          </div>
          <h5 class="fw-bold">Tepat Waktu</h5>
          <p class="text-muted">
            Pembayaran gaji dilakukan tepat waktu setiap bulannya tanpa keterlambatan.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <div class="mb-3">
            <div class="bg-light rounded-3 d-inline-block p-3 icon-box">
              <i class="bi bi-phone fs-2 text-primary"></i>
            </div>
          </div>
          <h5 class="fw-bold">Akses Mudah</h5>
          <p class="text-muted">
            Akses informasi gaji Anda kapan saja dan dimana saja melalui platform digital.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 feature-card">
          <div class="mb-3">
            <div class="bg-light rounded-3 d-inline-block p-3 icon-box">
              <i class="bi bi-shield-check text-primary fs-2"></i>
            </div>
          </div>
          <h5 class="fw-bold">Aman & Terpercaya</h5>
          <p class="text-muted">
            Data pribadi dan informasi gaji Anda dijamin keamanannya dengan sistem enkripsi tingkat tinggi.
          </p>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- CARA AKSES -->
<section id="cara-akses" class="section bg-light py-5">
  <div class="container text-center">

    <h2 class="fw-bold" data-aos="fade-up">
      Cara Mengakses Sistem Penggajian
    </h2>

    <p class="text-muted mb-5" data-aos="fade-up" data-aos-delay="200">
      Ikuti langkah-langkah sederhana berikut untuk mulai mengakses informasi gaji Anda.
    </p>

    <div class="row justify-content-center align-items-center mb-5">

      <!-- STEP 1 -->
      <div class="col-md-3 text-center" data-aos="fade-right">
        <div class="position-relative d-inline-block mb-3 step-box">
          <div class="bg-primary text-white rounded-4 p-4 shadow">
            <i class="bi bi-file-earmark-text fs-2"></i>
          </div>
          <span class="badge bg-success step-number">1</span>
        </div>
        <h5 class="fw-bold">Dapatkan Akun</h5>
      </div>

      <!-- STEP 2 -->
      <div class="col-md-3 text-center" data-aos="fade-up">
        <div class="position-relative d-inline-block mb-3 step-box">
          <div class="bg-primary text-white rounded-4 p-4 shadow">
            <i class="bi bi-lock fs-2"></i>
          </div>
          <span class="badge bg-success step-number">2</span>
        </div>
        <h5 class="fw-bold">Login ke Sistem</h5>
      </div>

      <!-- STEP 3 -->
      <div class="col-md-3 text-center" data-aos="fade-left">
        <div class="position-relative d-inline-block mb-3 step-box">
          <div class="bg-primary text-white rounded-4 p-4 shadow">
            <i class="bi bi-cash fs-2"></i>
          </div>
          <span class="badge bg-success step-number">3</span>
        </div>
        <h5 class="fw-bold">Akses Informasi Gaji</h5>
      </div>

    </div>

  </div>
</section>

<!-- KONTAK -->
<section id="contact" class="section">
  <div class="container">
    <h2 class="text-center mb-4" data-aos="fade-up">Kontak Sekolah / Admin</h2>

    <div class="row text-center">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <h5>📍 Alamat</h5>
        <p>SMA Karya Pembangunan Cicalengka</p>
      </div>

      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <h5>📞 Telepon</h5>
        <p>+62 812-xxxx-xxxx</p>
      </div>

      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <h5>📧 Email</h5>
        <p>admin@smakpcicalengka.sch.id</p>
      </div>
    </div>
  </div>
</section>

</main>

<!-- FOOTER -->
<footer class="footer text-center p-4">
  <p>© {{ date('Y') }} QuickStart Laravel</p>
</footer>

<!-- JS -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true,
    easing: 'ease-in-out'
  });
</script>

</body>
</html>