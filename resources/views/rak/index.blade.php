@extends('template.app')

@section('title', 'Data Rak')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Data Rak</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Data Rak</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">Daftar Rak Barang</h4>

                <a href="{{ route('rak.create') }}" class="btn btn-primary btn-sm">
                    <i data-lucide="plus" class="me-1"></i>
                    Tambah Rak
                </a>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Rak</th>
                                <th>Lokasi</th>
                                <th>Deskripsi</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($raks as $index => $rak)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rak->nama_rak }}</td>
                                    <td>{{ $rak->lokasi ?? '-' }}</td>
                                    <td>{{ $rak->deskripsi ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('rak.edit', $rak->id) }}" class="btn btn-warning btn-sm">
                                            <i data-lucide="edit"></i>
                                        </a>

                                        <form action="{{ route('rak.destroy', $rak->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus rak ini?')">
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
                                    <td colspan="5" class="text-center text-muted">
                                        Data rak belum tersedia
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
