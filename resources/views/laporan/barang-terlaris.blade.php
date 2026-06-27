@extends('template.app')

@section('title', 'Barang Terlaris')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Barang Terlaris</h4>
    </div>
</div>

<div class="alert alert-info">
    Halaman ini menampilkan produk yang paling banyak terjual berdasarkan data transaksi.
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Filter Barang Terlaris</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('barang.terlaris') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('barang.terlaris') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Grafik 10 Barang Terlaris</h4>
    </div>

    <div class="card-body">
        @if ($barangTerlaris->count() > 0)
            <div style="height: 350px;">
                <canvas id="chartBarangTerlaris"></canvas>
            </div>
        @else
            <div class="text-center text-muted py-4">
                Belum ada data barang terjual.
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Daftar Barang Terlaris</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Total Terjual</th>
                        <th>Total Pendapatan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($barangTerlaris as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @if ($item->barang && $item->barang->gambar)
                                    <img src="{{ asset('storage/' . $item->barang->gambar) }}" width="60" class="rounded">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $item->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $item->total_terjual }} Terjual
                                </span>
                            </td>

                            <td>
                                Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($index == 0)
                                    <span class="badge bg-success">Paling Laris</span>
                                @elseif ($index <= 4)
                                    <span class="badge bg-info">Laris</span>
                                @else
                                    <span class="badge bg-secondary">Terjual</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Data barang terlaris belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($barangTerlaris->count() > 0)
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>{{ $barangTerlaris->sum('total_terjual') }}</th>
                            <th colspan="2">
                                Rp {{ number_format($barangTerlaris->sum('total_pendapatan'), 0, ',', '.') }}
                            </th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartBarangTerlaris = document.getElementById('chartBarangTerlaris');

    if (chartBarangTerlaris) {
        new Chart(chartBarangTerlaris, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Total Terjual',
                    data: @json($chartData),
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
