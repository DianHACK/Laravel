@extends('template.app')

@section('title', 'Stok Barang')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Stok Barang Masuk / Keluar</h4>
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

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Total Stok Masuk</h5>
                <h3 class="text-success">{{ $totalMasuk }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Total Stok Keluar</h5>
                <h3 class="text-danger">{{ $totalKeluar }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Filter Riwayat Stok</h4>

        <a href="{{ route('stok.create') }}" class="btn btn-primary btn-sm">
            Tambah Stok Masuk / Keluar
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('stok.index') }}" method="GET">
            <div class="row align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Barang</label>
                    <select name="id_barang" class="form-select">
                        <option value="">Semua Barang</option>

                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ request('id_barang') == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-select">
                        <option value="">Semua</option>
                        <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date"
                           name="tanggal_awal"
                           class="form-control"
                           value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date"
                           name="tanggal_akhir"
                           class="form-control"
                           value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('stok.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Riwayat Stok Barang</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Admin</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($stokBarangs as $index => $stok)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ date('d-m-Y H:i', strtotime($stok->tanggal)) }}</td>

                            <td>{{ $stok->barang->nama_barang ?? '-' }}</td>

                            <td>
                                @if ($stok->jenis == 'masuk')
                                    <span class="badge bg-success">Masuk</span>
                                @else
                                    <span class="badge bg-danger">Keluar</span>
                                @endif
                            </td>

                            <td>{{ $stok->jumlah }}</td>

                            <td>{{ $stok->stok_sebelum }}</td>

                            <td>{{ $stok->stok_sesudah }}</td>

                            <td>{{ $stok->user->name ?? '-' }}</td>

                            <td>{{ $stok->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                Riwayat stok barang belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
