@extends('template.app')

@section('title', 'Edit User')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Edit User</h4>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Form Edit User</h4>
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

        <form action="{{ route('users.update', $user->id) }}" method="POST">
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

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>

            <div class="alert alert-info">
                Kosongkan password jika tidak ingin mengganti password.
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan password baru">
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi password baru">
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Update User
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
