@extends('template.app')

@section('title', 'Penjualan')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Penjualan</h4>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Pilih Barang</h4>

        <a href="{{ route('keranjang.index') }}" class="btn btn-primary btn-sm">
            Lihat Keranjang
        </a>
    </div>

    <div class="card-body border-bottom">
        <form action="{{ route('penjualan.index') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-8">
                    <label class="form-label">Cari Barang</label>
                    <input type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari nama barang, kategori, atau rak..."
                        value="{{ request('keyword') }}">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="search" class="me-1"></i>
                        Cari
                    </button>

                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Rak</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th width="180">Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($barangs as $index => $barang)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @if ($barang->gambar)
                                    <img src="{{ asset('storage/' . $barang->gambar) }}" width="60" class="rounded">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $barang->rak->nama_rak ?? '-' }}</td>
                            <td>
                                @php
                                    $hargaAsli = $barang->harga;
                                    $diskon = $barang->diskon ?? 0;
                                    $hargaDiskon = $hargaAsli - ($hargaAsli * $diskon / 100);
                                @endphp

                                @if ($diskon > 0)
                                    <div>
                                        <small class="text-muted text-decoration-line-through">
                                            Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                                        </small>
                                    </div>

                                    <div class="fw-bold text-danger">
                                        Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                    </div>

                                    <span class="badge bg-danger">
                                        Diskon {{ $diskon }}%
                                    </span>
                                @else
                                    <div class="fw-bold">
                                        Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>
                            <td>{{ $barang->stok }}</td>

                            <td>
                                <form action="{{ route('penjualan.tambahKeranjang', $barang->id) }}" method="POST" id="form-barang-{{ $barang->id }}">
                                    @csrf

                                    <input type="number"
                                        name="jumlah"
                                        class="form-control"
                                        value="1"
                                        min="1"
                                        max="{{ $barang->stok }}">
                                </form>
                            </td>

                            <td>
                                <button type="submit" form="form-barang-{{ $barang->id }}" class="btn btn-success btn-sm">
                                    Tambah
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                Barang tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
