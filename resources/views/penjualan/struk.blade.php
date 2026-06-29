@extends('template.app')

@section('title', 'Struk Transaksi')

@section('content')
@php
    $metodePembayaran = [
        'cash' => 'Cash',
        'qris' => 'QRIS',
        'transfer' => 'Transfer',
        'debit' => 'Debit',
    ];
@endphp
<style>
    @media print {
        .app-topbar,
        .sidenav-menu,
        .footer,
        .btn-print,
        .btn-back {
            display: none !important;
        }

        .content-page {
            margin-left: 0 !important;
            padding: 0 !important;
        }

        .container-fluid {
            padding: 0 !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        body {
            background: #fff !important;
        }

        .struk-area {
            width: 80mm;
            margin: 0 auto;
            font-size: 12px;
        }
    }

    .struk-area {
        max-width: 420px;
        margin: auto;
    }

    .struk-title {
        text-align: center;
        font-weight: bold;
        font-size: 18px;
    }

    .struk-subtitle {
        text-align: center;
        font-size: 13px;
        color: #666;
    }

    .struk-line {
        border-top: 1px dashed #999;
        margin: 10px 0;
    }

    .struk-table {
        width: 100%;
        font-size: 13px;
    }

    .struk-table td {
        padding: 3px 0;
        vertical-align: top;
    }

    .text-right {
        text-align: right;
    }
</style>

<div class="page-title-head d-flex align-items-center btn-back">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Struk Transaksi</h4>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success btn-back">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">

        <div class="struk-area">

            <div class="struk-title">
                <h3>{{ $pengaturan->nama_toko ?? 'Sistem Swalayan' }}</h3>

                <p>
                    {{ $pengaturan->alamat ?? '-' }} <br>
                    {{ $pengaturan->no_hp ?? '-' }} <br>
                    {{ $pengaturan->email ?? '-' }}
                </p>
            </div>

            <div class="struk-subtitle">
                Nota Transaksi Penjualan
            </div>

            <div class="struk-line"></div>

            <table class="struk-table">
                <tr>
                    <td>Kode</td>
                    <td>:</td>
                    <td>{{ $penjualan->kode_transaksi }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ date('d-m-Y H:i', strtotime($penjualan->tanggal)) }}</td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>:</td>
                    <td>{{ $penjualan->user->name ?? '-' }}</td>
                </tr>
                <p>
                    <strong>Metode Pembayaran:</strong>
                    {{ $metodePembayaran[$penjualan->metode_pembayaran] ?? '-' }}
                </p>
            </table>

            <div class="struk-line"></div>

            <table class="struk-table">
                @foreach ($penjualan->detail as $item)
                    <tr>
                        <td colspan="3">
                            {{ $item->barang->nama_barang ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            {{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>
                        <td></td>
                        <td class="text-right">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="struk-line"></div>

            <table class="struk-table">
                <tr>
                    <td>Total</td>
                    <td class="text-right">
                        Rp {{ number_format($penjualan->total, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td>Bayar</td>
                    <td class="text-right">
                        Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td>Kembalian</td>
                    <td class="text-right">
                        Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <div class="struk-line"></div>

            <div class="text-center">
                <p class="mb-1">Terima kasih sudah berbelanja</p>
                <p class="mb-0">Barang yang sudah dibeli tidak dapat dikembalikan</p>
            </div>

        </div>

        <div class="text-center mt-4 btn-print">
            <button onclick="window.print()" class="btn btn-primary">
                Cetak Struk
            </button>

            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                Kembali ke Penjualan
            </a>
        </div>

    </div>
</div>

@endsection
