@extends('template.app')

@section('title', 'Tambah Stok Barang')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Tambah Stok Barang</h4>
    </div>
</div>

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

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Form Stok Masuk / Keluar</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Barang</label>
                <select name="id_barang" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>

                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ old('id_barang') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }} - Stok saat ini: {{ $barang->stok }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Stok</label>
                <select name="jenis" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="masuk" {{ old('jenis') == 'masuk' ? 'selected' : '' }}>Stok Masuk</option>
                    <option value="keluar" {{ old('jenis') == 'keluar' ? 'selected' : '' }}>Stok Keluar</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number"
                       name="jumlah"
                       class="form-control"
                       value="{{ old('jumlah') }}"
                       min="1"
                       placeholder="Masukkan jumlah stok"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan"
                          class="form-control"
                          rows="4"
                          placeholder="Contoh: Pembelian barang dari supplier / barang rusak / barang expired">{{ old('keterangan') }}</textarea>
            </div>

            <div class="alert alert-info">
                Pilih <strong>Stok Masuk</strong> untuk menambah stok barang.
                Pilih <strong>Stok Keluar</strong> untuk mengurangi stok barang secara manual.
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('stok.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="reset" class="btn btn-warning">
                    Reset
                </button>

                <button type="submit" class="btn btn-primary">
                    Simpan Stok
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
