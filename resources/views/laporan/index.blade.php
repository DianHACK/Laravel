@extends('template.app')

@section('title', 'Laporan Penjualan')

@section('content')

<style>
    @media print {
        .app-topbar,
        .sidenav-menu,
        .footer,
        .btn-print,
        .btn-filter,
        .btn-aksi {
            display: none !important;
        }

        .content-page {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .container-fluid {
            padding: 0 !important;
        }

        body {
            background: #fff !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Laporan Penjualan</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1">Total Transaksi</p>
                <h3 class="mb-0">{{ $totalTransaksi }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1">Total Pendapatan</p>
                <h3 class="mb-0">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card btn-filter">
    <div class="card-header">
        <h4 class="card-title mb-0">Filter Laporan</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date"
                           name="tanggal_awal"
                           class="form-control"
                           value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date"
                           name="tanggal_akhir"
                           class="form-control"
                           value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                        Reset
                    </a>

                    <button type="button" onclick="window.print()" class="btn btn-success btn-print">
                        Print
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Daftar Transaksi Penjualan</h4>
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
                        <th width="50">No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Status</th>
                        <th class="btn-aksi" width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($laporans as $index => $laporan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $laporan->kode_transaksi }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($laporan->tanggal)) }}</td>
                            <td>{{ $laporan->user->name ?? '-' }}</td>
                            <td>{{ $metodePembayaran[$laporan->metode_pembayaran] ?? '-' }}</td>
                            <td>Rp {{ number_format($laporan->total, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($laporan->bayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($laporan->kembalian, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </td>
                            <td class="btn-aksi">
                                <a href="{{ route('laporan.detail', $laporan->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('penjualan.struk', $laporan->id) }}" class="btn btn-primary btn-sm">
                                    Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                Data laporan belum tersedia
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
