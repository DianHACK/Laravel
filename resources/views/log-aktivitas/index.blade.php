@extends('template.app')

@section('title', 'Log Aktivitas User')

@section('content')

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">Log Aktivitas User</h4>
    </div>
</div>

<div class="alert alert-info">
    Halaman ini menampilkan riwayat aktivitas admin dan kasir di dalam sistem.
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Filter Log Aktivitas</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('log-aktivitas.index') }}" method="GET">
            <div class="row align-items-end">

                <div class="col-md-3">
                    <label class="form-label">User</label>
                    <select name="id_user" class="form-select">
                        <option value="">Semua User</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('id_user') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ ucfirst($user->role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Modul</label>
                    <select name="modul" class="form-select">
                        <option value="">Semua Modul</option>

                        @foreach ($moduls as $modul)
                            <option value="{{ $modul }}" {{ request('modul') == $modul ? 'selected' : '' }}>
                                {{ $modul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date"
                           name="tanggal_awal"
                           class="form-control"
                           value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date"
                           name="tanggal_akhir"
                           class="form-control"
                           value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">Cari Aktivitas</label>
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           value="{{ request('keyword') }}"
                           placeholder="Cari aktivitas, deskripsi, atau nama user">
                </div>

                <div class="col-md-6 mt-3">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('log-aktivitas.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Daftar Log Aktivitas</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table">
                    <tr>
                        <th width="50">No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Modul</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($logs as $index => $log)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                {{ $log->created_at ? $log->created_at->format('d-m-Y H:i:s') : '-' }}
                            </td>

                            <td>{{ $log->nama_user ?? '-' }}</td>

                            <td>
                                @if ($log->role == 'admin')
                                    <span class="badge bg-primary">Admin</span>
                                @elseif ($log->role == 'kasir')
                                    <span class="badge bg-success">Kasir</span>
                                @else
                                    <span class="badge bg-secondary">{{ $log->role ?? '-' }}</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $log->modul ?? '-' }}
                                </span>
                            </td>

                            <td>{{ $log->aktivitas }}</td>

                            <td>{{ $log->deskripsi ?? '-' }}</td>

                            <td>{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Data log aktivitas belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
