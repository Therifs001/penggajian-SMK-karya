
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register Guru - SIPG</title>

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

        .register-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 720px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .register-card {
                max-width: 640px;
                padding: 32px;
            }
        }

        @media (max-width: 767.98px) {
            .register-card {
                max-width: 95%;
                padding: 20px;
                border-radius: 14px;
            }

            .logo {
                width: 48px;
                margin-bottom: 10px;
            }

            .form-control {
                padding: 10px;
            }

            .btn-register {
                padding: 10px;
            }
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-register {
            border-radius: 10px;
            padding: 12px;
            transition: 0.3s;
        }

        .btn-register:hover {
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

    <div class="register-card text-center" data-aos="zoom-in">

        <img src="{{ asset('assets/img/smkkarya.jpeg') }}" class="logo">

        <h3 class="fw-bold">Registrasi Guru</h3>
        <p class="text-muted mb-4">Buat akun untuk mengakses sistem penggajian</p>

        <form method="POST" action="{{ route('register.perform') }}">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- NAMA -->
            <div class="mb-3 text-start">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autocomplete="name">
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">NIP / Id Guru</label>
                <input type="text" name="nip" value="{{ old('nip') }}" class="form-control" required autocomplete="off">
            </div>

            <!-- Mata pelajaran dan Status dihapus -->

            <div class="mb-3 text-start">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-3 text-start" id="subjects-wrapper" style="display:none;">
                <label class="form-label">Mata Pelajaran (untuk Guru)</label>
                <select id="subjects-select" class="form-control" multiple></select>
                <input type="hidden" name="matapelajaran" id="matapelajaran" value="">
            </div>

            <input type="hidden" name="status" id="status" value="aktif">

            <!-- EMAIL -->
            <div class="mb-3 text-start">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="email">
            </div>

            <!-- PASSWORD -->
            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- KONFIRMASI -->
            <div class="mb-3 text-start">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary w-100 btn-register">
                Daftar
            </button>

            <!-- LINK LOGIN -->
            <div class="text-center mt-3">
                <small>
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="fw-bold text-primary">
                        Login disini
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        $(function(){
            // initialize Select2 with existing subjects from server
            var subjects = [];
            @if(isset($subjects))
                @foreach($subjects as $s)
                    subjects.push({ id: '{{ $s->id }}', text: '{{ addslashes($s->name) }}' });
                @endforeach
            @endif

            $('#subjects-select').select2({
                data: subjects,
                tags: true,
                tokenSeparators: [','],
                width: '100%'
            });

            // If old matapelajaran exists (validation error), pre-select them
            @if(old('matapelajaran'))
                var oldMat = "{{ addslashes(old('matapelajaran')) }}".split(/,\s*/).filter(Boolean);
                // ensure options exist for each old value
                oldMat.forEach(function(v){
                    var found = $('#subjects-select').find('option').filter(function(){ return $(this).text() === v || $(this).val() === v; }).first();
                    if (!found.length) {
                        var newOpt = new Option(v, v, true, true);
                        $('#subjects-select').append(newOpt);
                    } else {
                        found.prop('selected', true);
                    }
                });
                $('#subjects-select').trigger('change');
            @endif

            // show/hide subjects when role changes
            $('select[name="role"]').on('change', function(){
                if ($(this).val() === 'guru') {
                    $('#subjects-wrapper').show();
                } else {
                    $('#subjects-wrapper').hide();
                    $('#subjects-select').val(null).trigger('change');
                }
            }).trigger('change');

            // before submit, serialize selected subjects into hidden matapelajaran
            $('form').on('submit', function(){
                var vals = $('#subjects-select').val() || [];
                // join by comma
                $('#matapelajaran').val(vals.join(', '));
            });
        });
    </script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

</body>

</html>