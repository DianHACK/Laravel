@extends('template.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Tambah Barang</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('/barang') }}">Data Barang</a>
            </li>
            <li class="breadcrumb-item active">Tambah Barang</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header border-dashed">
                <h4 class="card-title mb-0">Form Tambah Barang</h4>
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

                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-8">

                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text"
                                       name="nama_barang"
                                       id="nama_barang"
                                       class="form-control"
                                       placeholder="Masukkan nama barang"
                                       value="{{ old('nama_barang') }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori</label>
                                <select name="id_kategori" id="id_kategori" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>

                                    @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_rak" class="form-label">Rak Barang</label>
                                <select name="id_rak" id="id_rak" class="form-select" required>
                                    <option value="">-- Pilih Rak --</option>

                                    @foreach ($raks as $rak)
                                        <option value="{{ $rak->id }}" {{ old('id_rak') == $rak->id ? 'selected' : '' }}>
                                            {{ $rak->nama_rak }} - {{ $rak->lokasi ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="number"
                                               name="harga"
                                               id="harga"
                                               class="form-control"
                                               placeholder="Contoh: 5000"
                                               value="{{ old('harga') }}"
                                               required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Harga Modal</label>
                                    <input type="number"
                                        name="harga_modal"
                                        class="form-control"
                                        value="{{ old('harga_modal', 0) }}"
                                        min="0"
                                        placeholder="Masukkan harga modal barang"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diskon (%)</label>
                                    <input type="number"
                                        name="diskon"
                                        class="form-control"
                                        value="{{ old('diskon', 0) }}"
                                        min="0"
                                        max="100"
                                        placeholder="Masukkan diskon barang">
                                    <small class="text-muted">Isi 0 jika tidak ada diskon.</small>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number"
                                               name="stok"
                                               id="stok"
                                               class="form-control"
                                               placeholder="Contoh: 10"
                                               value="{{ old('stok') }}"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="expired_date" class="form-label">Tanggal Expired</label>
                                <input type="date"
                                       name="expired_date"
                                       id="expired_date"
                                       class="form-control"
                                       value="{{ old('expired_date') }}">
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi"
                                          id="deskripsi"
                                          rows="4"
                                          class="form-control"
                                          placeholder="Masukkan deskripsi barang">{{ old('deskripsi') }}</textarea>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Barang</label>
                                <input type="file"
                                       name="gambar"
                                       id="gambar"
                                       class="form-control"
                                       accept="image/*">
                            </div>

                            <div class="card border">
                                <div class="card-body text-center">
                                    <img id="preview-gambar"
                                         src="{{ asset('assets/images/products/1.png') }}"
                                         alt="Preview Gambar"
                                         class="img-fluid rounded mb-2"
                                         style="max-height: 220px; object-fit: cover;">

                                    <p class="text-muted mb-0">
                                        Preview gambar barang
                                    </p>
                                </div>
                            </div>

                            <div class="alert alert-info mt-3">
                                <small>
                                    Format gambar yang disarankan: JPG, PNG, JPEG.
                                    Maksimal ukuran gambar nanti bisa dibatasi di controller.
                                </small>
                            </div>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ url('/barang') }}" class="btn btn-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i>
                            Kembali
                        </a>

                        <button type="reset" class="btn btn-warning">
                            <i data-lucide="refresh-ccw" class="me-1"></i>
                            Reset
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save" class="me-1"></i>
                            Simpan Barang
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const inputGambar = document.getElementById('gambar');
    const previewGambar = document.getElementById('preview-gambar');

    inputGambar.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            previewGambar.src = URL.createObjectURL(file);
        }
    });
</script>
@endpush
