@extends('template.app')

@section('title', 'Profile User')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Profile User</h4>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Informasi Akun</h4>
            </div>

            <div class="card-body text-center">
                <img src="{{ asset('assets/images/users/user-1.jpg') }}"
                     width="100"
                     class="rounded-circle mb-3"
                     alt="User">

                <h4>{{ $user->name }}</h4>

                <p class="text-muted mb-1">
                    {{ $user->email }}
                </p>

                <span class="badge {{ $user->role == 'admin' ? 'bg-primary' : 'bg-success' }}">
                    {{ ucfirst($user->role) }}
                </span>

                <hr>

                <table class="table table-bordered text-start">
                    <tr>
                        <th width="150">Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>

                    <tr>
                        <th>Role</th>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>

                    <tr>
                        <th>Terdaftar</th>
                        <td>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Edit Profile</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}"
                               required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Ubah Password</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password"
                               name="password_lama"
                               class="form-control"
                               placeholder="Masukkan password lama"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Masukkan password baru"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="Ulangi password baru"
                               required>
                    </div>

                    <div class="alert alert-info">
                        Password minimal 6 karakter dan konfirmasi password harus sama.
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@endsection
