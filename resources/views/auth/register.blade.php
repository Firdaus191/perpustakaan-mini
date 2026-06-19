<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrasi - Sistem Informasi Perpustakaan</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon_io/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon_io/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        html,
        body {

            height: 100%;
            margin: 0;

        }

        .login-form-bg {

            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .login-form-bg .container {

            width: 100%;

        }
    </style>

    <style>
        /* 1. Global Background & Text */
        body,
        .main-wrapper,
        .auth-wrapper,
        .login-box,
        .content-wrapper {
            background-color: #0F172A !important;
            color: #F8FAFC !important;
        }

        /* 2. Surface, Cards & Tables */
        .navbar,
        .sidebar,
        .main-sidebar,
        .card,
        .modal-content,
        .info-box {
            background-color: #1E293B !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        }

        .card-header,
        .card-footer,
        .modal-header,
        .modal-footer {
            background-color: #0F172A !important;
            border-color: #334155 !important;
        }

        .table {
            color: #F8FAFC !important;
        }

        .table th,
        .table td {
            border-bottom: 1px solid #334155 !important;
            border-top: none !important;
        }

        .table thead th {
            background-color: #0B1120 !important;
            border-bottom: 2px solid #334155 !important;
        }

        /* 3. Footer Leak Fix */
        footer,
        .main-footer {
            background-color: #0F172A !important;
            color: #94A3B8 !important;
            border-top: 1px solid #334155 !important;
        }

        /* 4. Accessibility Form & Search Bar */
        input.form-control,
        select.form-control,
        .dataTables_filter input {
            background-color: #1E293B !important;
            border: 1px solid #475569 !important;
            color: #F8FAFC !important;
            border-radius: 6px !important;
        }

        input.form-control:focus,
        select.form-control:focus,
        .dataTables_filter input:focus {
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
        }

        /* 5. Fix Login Card Form */
        .login-card-body,
        .register-card-body {
            background-color: #1E293B !important;
            color: #F8FAFC !important;
        }

        /* --- FINAL POLISH --- */
        /* 1. PERBAIKAN FOOTER */
        footer,
        .main-footer,
        .footer {
            background-color: #0F172A !important;
            color: #94A3B8 !important;
            border-top: 1px solid #334155 !important;
        }

        /* 2. PERBAIKAN SIDEBAR (Brand Logo & Area Sisa) */
        .main-sidebar,
        .sidebar,
        .brand-link,
        .nav-sidebar .nav-link {
            background-color: #1E293B !important;
            color: #F8FAFC !important;
            border-color: #334155 !important;
        }

        .brand-link {
            border-bottom: 1px solid #334155 !important;
        }

        /* 3. PERBAIKAN TEKS JUDUL LOGIN & REGISTRASI */
        .login-logo,
        .register-logo,
        .login-logo a,
        .register-logo a,
        .login-box h1,
        .login-box h2,
        .login-box h3,
        .login-box h4,
        .register-box h1,
        .register-box h2,
        .register-box h3,
        .register-box h4,
        .login-card-body h1,
        .login-card-body h2,
        .login-card-body h3,
        .login-card-body h4,
        .register-card-body h1,
        .register-card-body h2,
        .register-card-body h3,
        .register-card-body h4,
        .login-form h1,
        .login-form h2,
        .login-form h3,
        .login-form h4 {
            color: #F8FAFC !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5) !important;
        }
    </style>
</head>

<body>

    <div class="login-form-bg">

        <div class="container">

            <div class="row justify-content-center align-items-center">

                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">

                    <div class="form-input-content">

                        <div class="card login-form mb-0 shadow">

                            <div class="card-body">

                                <h3 class="text-center mb-4">

                                    Registrasi Anggota Baru

                                </h3>

                                @if(session('success'))

                                <div class="alert alert-success">

                                    {{ session('success') }}

                                </div>

                                @endif

                                @if(session('error'))

                                <div class="alert alert-danger">

                                    {{ session('error') }}

                                </div>

                                @endif

                                <form action="{{ route('register.store') }}" method="POST">

                                    @csrf

                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                        @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>No HP</label>
                                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                                        @error('no_hp')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control" required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                        @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        Daftar Sekarang
                                    </button>

                                </form>

                                <hr>

                                <div class="text-center">
                                    <p class="mb-2">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                                    <small>
                                        © {{ date('Y') }} Perpustakaan Mini
                                    </small>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>