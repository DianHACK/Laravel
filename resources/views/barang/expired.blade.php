@extends('template.app')

@section('title', 'Expired Barang')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Expired Barang</h4>
    </div>
</div>

<div class="alert alert-info">
    Barang dianggap <strong>hampir expired</strong> jika tanggal expired kurang dari atau sama dengan <strong>30 hari</strong> dari hari ini.
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Status Aman</h5>
                <h3 class="text-success">{{ $jumlahAman }}</h3>
                <p class="text-muted mb-0">Expired lebih dari 30 hari</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Hampir Expired</h5>
                <h3 class="text-warning">{{ $jumlahHampirExpired }}</h3>
                <p class="text-muted mb-0">Expired dalam 30 hari</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Sudah Expired</h5>
                <h3 class="text-danger">{{ $jumlahExpired }}</h3>
                <p class="text-muted mb-0">Tanggal expired sudah lewat</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Filter Barang Expired</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('barang.expired') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Status Expired</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                        <option value="hampir" {{ request('status') == 'hampir' ? 'selected' : '' }}>Hampir Expired</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Sudah Expired</option>
                    </select>
                </div>

                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('barang.expired') }}" class="btn btn-secondary">
                        Reset
                    </a>

                    <a href="{{ route('barang.index') }}" class="btn btn-success">
                        Data Barang
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Daftar Status Expired Barang</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Rak</th>
                        <th>Stok</th>
                        <th>Tanggal Expired</th>
                        <th>Sisa Hari</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($barangs as $index => $barang)
                        @php
                            $tanggalExpired = \Carbon\Carbon::parse($barang->expired_date)->startOfDay();
                            $hariIni = \Carbon\Carbon::today();
                            $batasHampirExpired = \Carbon\Carbon::today()->addDays(30);

                            if ($tanggalExpired->lt($hariIni)) {
                                $status = 'expired';
                                $statusText = 'Sudah Expired';
                                $badge = 'bg-danger';
                                $sisaHari = 'Lewat ' . $tanggalExpired->diffInDays($hariIni) . ' hari';
                            } elseif ($tanggalExpired->between($hariIni, $batasHampirExpired)) {
                                $status = 'hampir';
                                $statusText = 'Hampir Expired';
                                $badge = 'bg-warning text-dark';
                                $sisaHari = $hariIni->diffInDays($tanggalExpired) . ' hari lagi';
                            } else {
                                $status = 'aman';
                                $statusText = 'Aman';
                                $badge = 'bg-success';
                                $sisaHari = $hariIni->diffInDays($tanggalExpired) . ' hari lagi';
                            }
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @if ($barang->gambar)
                                    <img src="{{ asset('storage/' . $barang->gambar) }}"
                                         alt="gambar barang"
                                         width="60"
                                         class="rounded">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $barang->rak->nama_rak ?? '-' }}</td>

                            <td>
                                @if ($barang->stok <= 50)
                                    <span class="badge bg-danger">{{ $barang->stok }}</span>
                                @else
                                    <span class="badge bg-success">{{ $barang->stok }}</span>
                                @endif
                            </td>

                            <td>{{ date('d-m-Y', strtotime($barang->expired_date)) }}</td>

                            <td>{{ $sisaHari }}</td>

                            <td>
                                <span class="badge {{ $badge }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('barang.edit', $barang->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                Data barang expired belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
