@extends('template.app')

@section('title', 'Penjualan')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Penjualan</h4>
    </div>
</div>

<div class="alert alert-success">
    Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
    Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Menu Penjualan Kasir</h4>
    </div>

    <div class="card-body">
        <p>Halaman ini nanti digunakan kasir untuk melakukan transaksi penjualan.</p>
    </div>
</div>

@endsection
