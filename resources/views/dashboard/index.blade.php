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
                <a href="{{ url('/dashboard') }}">Swalayan</a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">

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
                        <h3 class="mb-2 fw-normal">120</h3>
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
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                            <i data-lucide="shopping-cart"></i>
                        </span>
                    </div>

                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">35</h3>
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
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                            <i data-lucide="wallet"></i>
                        </span>
                    </div>

                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">Rp 2.500.000</h3>
                        <p class="mb-0 text-muted">Pendapatan Hari Ini</p>
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
                            <i data-lucide="alert-triangle"></i>
                        </span>
                    </div>

                    <div class="text-end">
                        <h3 class="mb-2 fw-normal">8</h3>
                        <p class="mb-0 text-muted">Stok Menipis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Ringkasan Penjualan</h4>
            </div>

            <div class="card-body">
                <p class="mb-0">
                    Ini halaman dashboard sistem swalayan. Nanti bagian ini bisa diisi grafik penjualan, data transaksi terbaru, dan laporan stok barang.
                </p>
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
                    <a href="{{ url('/barang') }}" class="btn btn-primary">
                        <i data-lucide="package" class="me-1"></i> Data Barang
                    </a>

                    <a href="{{ url('/penjualan') }}" class="btn btn-success">
                        <i data-lucide="shopping-cart" class="me-1"></i> Penjualan
                    </a>

                    <a href="{{ url('/laporan') }}" class="btn btn-warning">
                        <i data-lucide="file-text" class="me-1"></i> Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
