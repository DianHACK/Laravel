@extends('template.app')

@section('title', 'Pengaturan Toko')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Pengaturan Toko</h4>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Form Pengaturan Toko</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('pengaturan-toko.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Nama Toko</label>
                        <input type="text"
                               name="nama_toko"
                               class="form-control"
                               value="{{ old('nama_toko', $pengaturan->nama_toko) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Toko</label>
                        <textarea name="alamat"
                                  class="form-control"
                                  rows="4">{{ old('alamat', $pengaturan->alamat) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text"
                               name="no_hp"
                               class="form-control"
                               value="{{ old('no_hp', $pengaturan->no_hp) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $pengaturan->email) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Bank</label>
                        <input type="text"
                               name="bank"
                               class="form-control"
                               value="{{ old('bank', $pengaturan->bank) }}"
                               placeholder="Contoh: BRI / BCA / Mandiri">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Rekening</label>
                        <input type="text"
                               name="no_rekening"
                               class="form-control"
                               value="{{ old('no_rekening', $pengaturan->no_rekening) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Atas Nama</label>
                        <input type="text"
                               name="atas_nama"
                               class="form-control"
                               value="{{ old('atas_nama', $pengaturan->atas_nama) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Logo Toko</label>
                        <input type="file" name="logo" class="form-control">

                        @if ($pengaturan->logo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $pengaturan->logo) }}"
                                     width="120"
                                     class="rounded border">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar QRIS</label>
                        <input type="file" name="qris" class="form-control">

                        @if ($pengaturan->qris)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $pengaturan->qris) }}"
                                     width="180"
                                     class="rounded border">
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-warning">
                    Reset
                </button>

                <button type="submit" class="btn btn-primary">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
