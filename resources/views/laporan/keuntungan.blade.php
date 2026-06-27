@extends('template.app')

@section('title', 'Laporan Keuntungan')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Laporan Keuntungan</h4>
    </div>
</div>

<div class="alert alert-info">
    Laporan ini menghitung omzet, modal, dan laba dari transaksi penjualan.
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Total Omzet</h5>
                <h3>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Total Modal</h5>
                <h3>Rp {{ number_format($totalModal, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Total Laba</h5>
                <h3 class="{{ $totalLaba >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($totalLaba, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Filter Laporan Keuntungan</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('laporan.keuntungan') }}" method="GET">
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
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('laporan.keuntungan') }}" class="btn btn-secondary">
                        Reset
                    </a>

                    <a href="{{ route('laporan.index') }}" class="btn btn-success">
                        Laporan Penjualan
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Grafik 10 Barang dengan Laba Tertinggi</h4>
    </div>

    <div class="card-body">
        @if ($laporanKeuntungan->count() > 0)
            <div style="height: 350px;">
                <canvas id="chartLaba"></canvas>
            </div>
        @else
            <div class="text-center text-muted py-4">
                Belum ada data keuntungan.
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Detail Keuntungan Per Barang</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Total Terjual</th>
                        <th>Omzet</th>
                        <th>Modal</th>
                        <th>Laba</th>
                        <th>Margin</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($laporanKeuntungan as $index => $item)
                        @php
                            $margin = $item->total_omzet > 0
                                ? ($item->total_laba / $item->total_omzet) * 100
                                : 0;
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                            <td>{{ $item->total_terjual }}</td>
                            <td>Rp {{ number_format($item->total_omzet, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->total_modal, 0, ',', '.') }}</td>
                            <td>
                                <span class="{{ $item->total_laba >= 0 ? 'text-success' : 'text-danger' }}">
                                    Rp {{ number_format($item->total_laba, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>{{ number_format($margin, 2, ',', '.') }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Data keuntungan belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($laporanKeuntungan->count() > 0)
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</th>
                            <th>Rp {{ number_format($totalModal, 0, ',', '.') }}</th>
                            <th colspan="2">
                                Rp {{ number_format($totalLaba, 0, ',', '.') }}
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
    const chartLaba = document.getElementById('chartLaba');

    if (chartLaba) {
        new Chart(chartLaba, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Total Laba',
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
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
@endpush
