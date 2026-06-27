@extends('template.app')

@section('title', 'Detail Riwayat Transaksi')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Detail Riwayat Transaksi</h4>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Informasi Transaksi</h4>

        <div>
            <a href="{{ route('riwayat.index') }}" class="btn btn-secondary btn-sm">
                Kembali
            </a>

            <a href="{{ route('penjualan.struk', $penjualan->id) }}" class="btn btn-success btn-sm">
                Cetak Struk
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="220">Kode Transaksi</th>
                <td>{{ $penjualan->kode_transaksi }}</td>
            </tr>

            <tr>
                <th>Tanggal</th>
                <td>{{ date('d-m-Y H:i', strtotime($penjualan->tanggal)) }}</td>
            </tr>

            <tr>
                <th>Kasir</th>
                <td>{{ $penjualan->user->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Total</th>
                <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <th>Bayar</th>
                <td>Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <th>Kembalian</th>
                <td>Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-success">
                        {{ ucfirst($penjualan->status) }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Detail Barang Dibeli</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($penjualan->detail as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Detail barang tidak tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection
