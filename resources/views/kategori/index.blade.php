@extends('template.app')

@section('title', 'Data Kategori')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Data Kategori</h4>
    </div>

    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Data Kategori</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center border-dashed">
                <h4 class="card-title mb-0">Daftar Kategori</h4>

                <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                    <i data-lucide="plus" class="me-1"></i>
                    Tambah Kategori
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
                        <thead class="table">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($kategoris as $index => $kategori)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kategori->nama_kategori }}</td>
                                    <td>{{ $kategori->deskripsi ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">
                                            <i data-lucide="edit"></i>
                                        </a>

                                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                    <td colspan="4" class="text-center text-muted">
                                        Data kategori belum tersedia
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
