@extends('template.app')

@section('title', 'Tambah User')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Tambah User</h4>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Form Tambah User</h4>
    </div>

    <div class="card-body">

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

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama user"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email') }}"
                       placeholder="Masukkan email user"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan password"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi password"
                       required>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="reset" class="btn btn-warning">
                    Reset
                </button>

                <button type="submit" class="btn btn-primary">
                    Simpan User
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
