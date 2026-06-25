@extends('template.app')

@section('title', 'Data Barang')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Data Barang</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Data Barang</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">Daftar Barang</h4>


                <a href="{{ url('/barang/create') }}" class="btn btn-primary btn-sm">
                    <i data-lucide="plus" class="me-1"></i>
                    Tambah Barang
                </a>
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchBarang" class="form-control" placeholder="Cari barang...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-hover table-bordered align-middle" id="tableBarang">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Gambar</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Rak</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Expired</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($barang ?? [] as $index => $barang)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        @php
                                            $gambar = data_get($barang, 'gambar');
                                        @endphp

                                        @if ($gambar)
                                            <img src="{{ asset('storage/' . $gambar) }}" alt="gambar barang" width="55" height="55" class="rounded">
                                        @else
                                            <img src="{{ asset('assets/images/products/1.png') }}" alt="gambar barang" width="55" height="55" class="rounded">
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ data_get($barang, 'nama_barang', '-') }}</strong>
                                    </td>

                                    <td>
                                        {{ data_get($barang, 'kategori.nama_kategori', data_get($barang, 'nama_kategori', '-')) }}
                                    </td>

                                    <td>
                                        {{ data_get($barang, 'rak.nama_rak', data_get($barang, 'nama_rak', '-')) }}
                                    </td>

                                    <td>
                                        Rp {{ number_format(data_get($barang, 'harga', 0), 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ data_get($barang, 'stok', 0) }}
                                    </td>

                                    <td>
                                        {{ data_get($barang, 'expired_date', '-') }}
                                    </td>

                                    <td>
                                        @if (data_get($barang, 'stok', 0) <= 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @elseif (data_get($barang, 'stok', 0) <= 5)
                                            <span class="badge bg-warning">Menipis</span>
                                        @else
                                            <span class="badge bg-success">Tersedia</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">
                                            <i data-lucide="edit"></i>
                                        </a>

                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i data-lucide="trash-2"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        Data barang belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchBarang').addEventListener('keyup', function () {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBarang tbody tr');

        rows.forEach(function (row) {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>
@endpush
