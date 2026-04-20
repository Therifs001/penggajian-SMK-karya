<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login Guru - SIPG</title>

    <!-- CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6ea8fe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s ease;
        }

        .login-card h3 {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-login {
            border-radius: 10px;
            padding: 12px;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: scale(1.05);
        }

        .logo {
            width: 60px;
            margin-bottom: 15px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="login-card text-center" data-aos="zoom-in">

        <img src="{{ asset('assets/img/logo.png') }}" class="logo">

        <h3>Login</h3>
        <p class="text-muted mb-4">Sistem Penggajian Guru</p>

        @if (session('success'))
            <div class="alert alert-success text-start">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- EMAIL / USERNAME -->
            <div class="mb-3 text-start">
                <label class="form-label">Email / NIP</label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary w-100 btn-login">
                Login
            </button>
            <div class="text-center mt-3">
                <small>
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary fw-bold">
                        Daftar disini
                    </a>
                </small>
            </div>
            <!-- BACK -->
            <a href="{{ url('/') }}" class="d-block mt-3 text-decoration-none">
                ← Kembali ke Beranda
            </a>

        </form>

    </div>

    <!-- JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

</body>

</html>