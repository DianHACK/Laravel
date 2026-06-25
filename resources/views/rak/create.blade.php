@extends('template.app')

@section('title', 'Tambah Rak')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Tambah Rak</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('rak.index') }}">Data Rak</a>
            </li>
            <li class="breadcrumb-item active">Tambah Rak</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">

            <div class="card-header border-dashed">
                <h4 class="card-title mb-0">Form Tambah Rak</h4>
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

                <form action="{{ route('rak.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_rak" class="form-label">Nama Rak</label>
                        <input type="text" name="nama_rak" id="nama_rak" class="form-control" value="{{ old('nama_rak') }}" placeholder="Contoh: Rak A1" required>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Contoh: Area Makanan">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control" placeholder="Masukkan deskripsi rak">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('rak.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="reset" class="btn btn-warning">
                            Reset
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan Rak
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection
