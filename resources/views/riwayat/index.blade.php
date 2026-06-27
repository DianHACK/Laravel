@extends('template.app')

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Riwayat Transaksi</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Total Transaksi</h5>
                <h3>{{ $totalTransaksi }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Total Pendapatan</h5>
                <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Filter Riwayat Transaksi</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('riwayat.index') }}" method="GET">
            <div class="row align-items-end">

                @if (auth()->user()->role == 'admin')
                    <div class="col-md-3">
                        <label class="form-label">Kasir</label>
                        <select name="id_user" class="form-select">
                            <option value="">Semua Kasir</option>

                            @foreach ($kasirs as $kasir)
                                <option value="{{ $kasir->id }}" {{ request('id_user') == $kasir->id ? 'selected' : '' }}>
                                    {{ $kasir->name }} - {{ ucfirst($kasir->role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-md-3">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">Reset</a>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Daftar Riwayat Transaksi</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            @php
                $metodePembayaran = [
                    'cash' => 'Cash',
                    'qris' => 'QRIS',
                    'transfer' => 'Transfer',
                    'debit' => 'Debit',
                ];
            @endphp
            <table class="table table-bordered table-hover align-middle">
                <thead class="table">
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($riwayats as $index => $riwayat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $riwayat->kode_transaksi }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($riwayat->tanggal)) }}</td>
                            <td>{{ $riwayat->user->name ?? '-' }}</td>
                            <td>{{ $metodePembayaran[$riwayat->metode_pembayaran] ?? '-' }}</td>
                            <td>Rp {{ number_format($riwayat->total, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($riwayat->bayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($riwayat->kembalian, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($riwayat->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('riwayat.detail', $riwayat->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('penjualan.struk', $riwayat->id) }}" class="btn btn-success btn-sm">
                                    Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                Riwayat transaksi belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total Pendapatan</th>
                        <th colspan="5">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection
