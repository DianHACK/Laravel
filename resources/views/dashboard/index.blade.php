@extends('template.app')

@section('title', 'Dashboard Swalayan')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Dashboard</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Swalayan</a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<div class="alert alert-primary">
    Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
    Anda login sebagai <strong class="text-capitalize">{{ auth()->user()->role }}</strong>.
</div>

<div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">

    @if (auth()->user()->role == 'admin')
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                                <i data-lucide="package"></i>
                            </span>
                        </div>

                        <div class="text-end">
                            <h3 class="mb-2 fw-normal">{{ $totalBarang }}</h3>
                            <p class="mb-0 text-muted">Total Barang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                                <i data-lucide="tags"></i>
                            </span>
                        </div>

                        <div class="text-end">
                            <h3 class="mb-2 fw-normal">{{ $totalKategori }}</h3>
                            <p class="mb-0 text-muted">Total Kategori</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                            <span class="avatar-title bg-secondary-subtle text-secondary rounded-circle fs-24">
                                <i data-lucide="archive"></i>
                            </span>
                        </div>

                        <div class="text-end">
                            <h3 class="mb-2 fw-normal">{{ $totalRak }}</h3>
                            <p class="mb-0 text-muted">Total Rak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                            <i data-lucide="shopping-cart"></i>
                        </span>
                    </div>

                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">{{ $transaksiHariIni }}</h3>
                        <p class="mb-0 text-muted">Transaksi Hari Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-24">
                            <i data-lucide="wallet"></i>
                        </span>
                    </div>

                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">
                            Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                        </h3>
                        <p class="mb-0 text-muted">Pendapatan Hari Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->role == 'admin')
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar fs-60 avatar-img-size flex-shrink-0">
                            <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-24">
                                <i data-lucide="alert-triangle"></i>
                            </span>
                        </div>

                        <div class="text-end">
                            <h3 class="mb-2 fw-normal">{{ $stokMenipis }}</h3>
                            <p class="mb-0 text-muted">Stok Menipis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Transaksi Terbaru</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-custom table-bordered table-hover align-middle">
                        <thead class="table align-middle">
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($transaksiTerbaru as $index => $transaksi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaksi->kode_transaksi }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($transaksi->tanggal)) }}</td>
                                    <td>{{ $transaksi->user->name ?? '-' }}</td>
                                    <td>
                                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($transaksi->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('laporan.index') }}" class="btn btn-primary btn-sm">
                        Lihat Laporan
                    </a>
                @endif
            </div>
        </div>
    </div>


    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Menu Cepat</h4>
            </div>

            <div class="card-body">
                <div class="d-grid gap-2">

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('barang.index') }}" class="btn btn-primary">
                            <i data-lucide="package" class="me-1"></i>
                            Data Barang
                        </a>

                        <a href="{{ route('kategori.index') }}" class="btn btn-info">
                            <i data-lucide="tags" class="me-1"></i>
                            Kategori
                        </a>

                        <a href="{{ route('rak.index') }}" class="btn btn-secondary">
                            <i data-lucide="archive" class="me-1"></i>
                            Rak Barang
                        </a>
                    @endif

                    <a href="{{ route('penjualan.index') }}" class="btn btn-success">
                        <i data-lucide="shopping-cart" class="me-1"></i>
                        Penjualan
                    </a>

                    <a href="{{ route('keranjang.index') }}" class="btn btn-warning">
                        <i data-lucide="shopping-basket" class="me-1"></i>
                        Keranjang
                    </a>

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('laporan.index') }}" class="btn btn-dark">
                            <i data-lucide="file-text" class="me-1"></i>
                            Laporan Penjualan
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Grafik Penjualan Harian</h4>
                    </div>

                    <div class="card-body">
                        <div style="height: 350px;">
                            <canvas id="chartHarian"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Grafik Penjualan Mingguan</h4>
                    </div>

                    <div class="card-body">
                        <div style="height: 300px;">
                            <canvas id="chartMingguan"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Grafik Penjualan Bulanan</h4>
                    </div>

                    <div class="card-body">
                        <div style="height: 300px;">
                            <canvas id="chartBulanan"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: ' + formatRupiah(context.raw);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return formatRupiah(value);
                    }
                }
            }
        }
    };

    // Grafik Harian
    new Chart(document.getElementById('chartHarian'), {
        type: 'line',
        data: {
            labels: @json($grafikHarianLabels),
            datasets: [{
                label: 'Pendapatan Harian',
                data: @json($grafikHarianData),
                tension: 0.4,
                fill: false
            }]
        },
        options: chartOptions
    });

    // Grafik Mingguan
    new Chart(document.getElementById('chartMingguan'), {
        type: 'bar',
        data: {
            labels: @json($grafikMingguanLabels),
            datasets: [{
                label: 'Pendapatan Mingguan',
                data: @json($grafikMingguanData)
            }]
        },
        options: chartOptions
    });

    // Grafik Bulanan
    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: @json($grafikBulananLabels),
            datasets: [{
                label: 'Pendapatan Bulanan',
                data: @json($grafikBulananData)
            }]
        },
        options: chartOptions
    });
</script>
@endpush
@endsection
