@extends('template.app')

@section('title', 'Keranjang')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Keranjang</h4>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Daftar Keranjang</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table ">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th width="160">Jumlah</th>
                                <th>Subtotal</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($keranjangs as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>

                                    <td>
                                        <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex gap-1">
                                            @csrf
                                            @method('PUT')

                                            <input type="number"
                                                   name="jumlah"
                                                   class="form-control"
                                                   value="{{ $item->jumlah }}"
                                                   min="1"
                                                   max="{{ $item->barang->stok ?? 1 }}">

                                            <button type="submit" class="btn btn-warning btn-sm">
                                                Update
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang dari keranjang?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Keranjang masih kosong
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th colspan="2">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                    Kembali ke Penjualan
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Checkout</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('keranjang.checkout') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Total Belanja</label>
                        <input type="text"
                               class="form-control"
                               value="Rp {{ number_format($total, 0, ',', '.') }}"
                               readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="cash">Cash</option>
                            <option value="qris">QRIS</option>
                            <option value="transfer">Transfer</option>
                            <option value="debit">Debit</option>
                        </select>
                    </div>

                    {{-- Tampilan QRIS --}}
                    <div id="box-qris" class="mb-3 d-none">
                        <div class="alert alert-info">
                            <strong>Silakan scan QRIS di bawah ini untuk pembayaran.</strong>
                        </div>

                        <div class="text-center border rounded p-3">
                            @if ($pengaturan && $pengaturan->qris)
                                <img src="{{ asset('storage/' . $pengaturan->qris) }}"
                                    alt="QRIS Pembayaran"
                                    width="250"
                                    class="img-fluid rounded">
                            @else
                                <div class="alert alert-warning">
                                    QRIS belum diatur oleh admin.
                                </div>
                            @endif
                            <p class="mt-2 mb-0 text-muted">
                                Setelah melakukan pembayaran QRIS, masukkan nominal bayar lalu klik Checkout.
                            </p>
                        </div>
                    </div>

                    {{-- Tampilan Transfer --}}
                    <div id="box-transfer" class="mb-3 d-none">
                        <div class="alert alert-warning">
                            <strong>Silakan transfer ke rekening berikut:</strong>
                        </div>

                        <div class="border rounded p-3">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="160">Bank</th>
                                    <td>{{ $pengaturan->bank ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>No. Rekening</th>
                                    <td>
                                        <strong>{{ $pengaturan->no_rekening ?? '-' }}</strong>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Atas Nama</th>
                                    <td>{{ $pengaturan->atas_nama ?? '-' }}</td>
                                </tr>
                            </table>

                            <p class="mt-2 mb-0 text-muted">
                                Setelah transfer, masukkan nominal bayar lalu klik Checkout.
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bayar</label>
                        <input type="number"
                            name="bayar"
                            class="form-control"
                            min="{{ $total }}"
                            placeholder="Masukkan jumlah bayar"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" {{ $keranjangs->isEmpty() ? 'disabled' : '' }}>
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const metodePembayaran = document.getElementById('metode_pembayaran');
        const boxQris = document.getElementById('box-qris');
        const boxTransfer = document.getElementById('box-transfer');

        metodePembayaran.addEventListener('change', function () {
            const metode = this.value;

            boxQris.classList.add('d-none');
            boxTransfer.classList.add('d-none');

            if (metode === 'qris') {
                boxQris.classList.remove('d-none');
            }

            if (metode === 'transfer') {
                boxTransfer.classList.remove('d-none');
            }
        });
    });
</script>
@endpush

@endsection
