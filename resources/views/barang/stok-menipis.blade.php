@extends('template.app')

@section('title', 'Stok Menipis')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Stok Menipis</h4>
    </div>
</div>

<div class="alert alert-warning">
    Berikut daftar barang dengan stok kurang dari atau sama dengan <strong>50</strong>.
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Barang Stok Menipis</h4>

        <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">
            Kembali ke Data Barang
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table">
                    <tr>
                        <th width="50">No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Rak</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($barangs as $index => $barang)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @if ($barang->gambar)
                                    <img src="{{ asset('storage/' . $barang->gambar) }}"
                                         alt="gambar barang"
                                         width="60"
                                         class="rounded">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>

                            <td>{{ $barang->nama_barang }}</td>

                            <td>
                                {{ $barang->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td>
                                {{ $barang->rak->nama_rak ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($barang->harga, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($barang->stok == 0)
                                    <span class="badge bg-dark">
                                        {{ $barang->stok }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        {{ $barang->stok }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if ($barang->stok == 0)
                                    <span class="badge bg-dark">
                                        Stok Habis
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Stok Menipis
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('barang.edit', $barang->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                Tidak ada barang stok menipis
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
