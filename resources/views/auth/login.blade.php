<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | Sistem Swalayan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg">

<div class="account-pages py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Login Sistem Swalayan</h4>
                            <p class="text-muted mb-0">Masuk untuk mengakses dashboard</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                Email atau password salah
                            </div>
                        @endif

                        <form action="{{ route('login.process') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email') }}"
                                       placeholder="Masukkan email"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Masukkan password"
                                       required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p class="mb-0">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-primary fw-semibold">
                                    Daftar
                                </a>
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/vendors.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
