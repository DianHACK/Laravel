<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Dashboard Swalayan')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

    <!-- Theme Config JS -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App CSS -->
    <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

<body>
    <div class="wrapper">

        <!-- Topbar -->
        <header class="app-topbar">
            <div class="container-fluid topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Logo -->
                    <div class="logo-topbar">
                        <a href="{{ route('dashboard') }}" class="logo-light">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                            </span>
                        </a>

                        <a href="{{ route('dashboard') }}" class="logo-dark">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Toggle -->
                    <button class="sidenav-toggle-button btn btn-default btn-icon">
                        <i data-lucide="menu"></i>
                    </button>

                    <h5 class="mb-0 d-none d-md-block">Sistem Swalayan</h5>
                </div>

                <div class="d-flex align-items-center gap-2">

                    <!-- Search -->
                    <div class="app-search d-none d-xl-flex">
                        <input type="search" class="form-control rounded-pill topbar-search" placeholder="Cari data..." />
                        <i data-lucide="search" class="app-search-icon text-muted"></i>
                    </div>

                    <!-- Dark Mode -->
                    <div id="theme-dropdown" class="topbar-item d-none d-sm-flex">
                        <div class="dropdown">
                            <button class="topbar-link" data-bs-toggle="dropdown" type="button" aria-haspopup="false" aria-expanded="false">
                                <i data-lucide="sun" class="topbar-link-icon" id="theme-icon-light"></i>
                                <i data-lucide="moon" class="topbar-link-icon d-none" id="theme-icon-dark"></i>
                                <i data-lucide="sun-moon" class="topbar-link-icon d-none" id="theme-icon-system"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" data-thememode="dropdown">
                                <label class="dropdown-item cursor-pointer active">
                                    <input class="form-check-input" type="radio" name="data-bs-theme" value="light" style="display: none">
                                    <i data-lucide="sun" class="align-middle me-1 fs-16"></i>
                                    <span class="align-middle">Light</span>
                                </label>

                                <label class="dropdown-item cursor-pointer">
                                    <input class="form-check-input" type="radio" name="data-bs-theme" value="dark" style="display: none">
                                    <i data-lucide="moon" class="align-middle me-1 fs-16"></i>
                                    <span class="align-middle">Dark</span>
                                </label>

                                <label class="dropdown-item cursor-pointer">
                                    <input class="form-check-input" type="radio" name="data-bs-theme" value="system" style="display: none">
                                    <i data-lucide="sun-moon" class="align-middle me-1 fs-16"></i>
                                    <span class="align-middle">System</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Stok Menipis -->
                    @if (auth()->check() && auth()->user()->role == 'admin')
                        @php
                            $hariIni = \Carbon\Carbon::today();
                            $batasHampirExpired = \Carbon\Carbon::today()->addDays(30);

                            $jumlahStokMenipis = \App\Models\Barang::where('stok', '<=', 50)->count();

                            $stokMenipisNotif = \App\Models\Barang::where('stok', '<=', 50)
                                ->orderBy('stok', 'asc')
                                ->limit(5)
                                ->get();

                            $jumlahHampirExpired = \App\Models\Barang::whereNotNull('expired_date')
                                ->whereDate('expired_date', '>=', $hariIni)
                                ->whereDate('expired_date', '<=', $batasHampirExpired)
                                ->count();

                            $hampirExpiredNotif = \App\Models\Barang::whereNotNull('expired_date')
                                ->whereDate('expired_date', '>=', $hariIni)
                                ->whereDate('expired_date', '<=', $batasHampirExpired)
                                ->orderBy('expired_date', 'asc')
                                ->limit(5)
                                ->get();

                            $totalNotifikasi = $jumlahStokMenipis + $jumlahHampirExpired;
                        @endphp

                        <div id="notification-dropdown-stock" class="topbar-item">
                            <div class="dropdown">
                                <button class="topbar-link dropdown-toggle drop-arrow-none"
                                        data-bs-toggle="dropdown"
                                        type="button"
                                        data-bs-auto-close="outside"
                                        aria-haspopup="false"
                                        aria-expanded="false">

                                    <i data-lucide="bell" class="topbar-link-icon animate-ring"></i>

                                    @if ($totalNotifikasi > 0)
                                        <span class="badge text-bg-danger badge-circle topbar-badge">
                                            {{ $totalNotifikasi }}
                                        </span>
                                    @endif

                                </button>

                                <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">

                                    <div class="px-3 py-2 border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-md fw-semibold">Notifikasi Stok</h6>
                                            </div>

                                            <div class="col text-end">
                                                <span class="badge text-bg-danger">
                                                    {{ $jumlahStokMenipis }} Barang
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="max-height: 300px" data-simplebar>
                                        @forelse ($stokMenipisNotif as $barangNotif)
                                            <a href="{{ route('barang.edit', $barangNotif->id) }}"
                                               class="dropdown-item notification-item py-2 text-wrap">

                                                <span class="d-flex align-items-center gap-3">
                                                    <span class="flex-shrink-0 position-relative">
                                                        <span class="avatar-md rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center">
                                                            <i data-lucide="alert-triangle" class="text-warning"></i>
                                                        </span>
                                                    </span>

                                                    <span class="flex-grow-1 text-muted">
                                                        <span class="fw-medium text-body">
                                                            {{ $barangNotif->nama_barang }}
                                                        </span>

                                                        <br>

                                                        Stok tersisa:
                                                        <span class="fw-bold text-danger">
                                                            {{ $barangNotif->stok }}
                                                        </span>

                                                        <br>

                                                        <span class="fs-xs">
                                                            Segera tambah stok barang
                                                        </span>
                                                    </span>
                                                </span>
                                            </a>
                                        @empty
                                            <div class="dropdown-item text-center text-muted py-3">
                                                Tidak ada stok menipis
                                            </div>
                                        @endforelse
                                        <div class="border-top px-3 py-2">
                                            <h6 class="m-0 fs-md fw-semibold">Barang Hampir Expired</h6>
                                        </div>

                                        @forelse ($hampirExpiredNotif as $barangExpiredNotif)
                                            <a href="{{ route('barang.edit', $barangExpiredNotif->id) }}"
                                            class="dropdown-item notification-item py-2 text-wrap">

                                                <span class="d-flex align-items-center gap-3">
                                                    <span class="flex-shrink-0 position-relative">
                                                        <span class="avatar-md rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center">
                                                            <i data-lucide="calendar-clock" class="text-danger"></i>
                                                        </span>
                                                    </span>

                                                    <span class="flex-grow-1 text-muted">
                                                        <span class="fw-medium text-body">
                                                            {{ $barangExpiredNotif->nama_barang }}
                                                        </span>

                                                        <br>

                                                        Expired:
                                                        <span class="fw-bold text-danger">
                                                            {{ date('d-m-Y', strtotime($barangExpiredNotif->expired_date)) }}
                                                        </span>

                                                        <br>

                                                        <span class="fs-xs">
                                                            Segera cek barang ini
                                                        </span>
                                                    </span>
                                                </span>
                                            </a>
                                        @empty
                                            <div class="dropdown-item text-center text-muted py-3">
                                                Tidak ada barang hampir expired
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="border-top d-flex">
                                        <a href="{{ route('barang.stokMenipis') }}"
                                        class="dropdown-item text-center text-primary fw-bold py-2">
                                            Stok Menipis
                                        </a>

                                        <a href="{{ route('barang.expired') }}"
                                        class="dropdown-item text-center text-danger fw-bold py-2">
                                            Expired
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Fullscreen -->
                    <div class="topbar-item d-none d-md-flex">
                        <button class="topbar-link" type="button" data-toggle="fullscreen">
                            <i data-lucide="maximize" class="topbar-link-icon"></i>
                            <i data-lucide="minimize" class="topbar-link-icon d-none"></i>
                        </button>
                    </div>

                    <!-- User -->
                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" href="#">
                                <img src="{{ asset('assets/images/users/user-1.jpg') }}" width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image" />

                                <div class="d-lg-flex align-items-center gap-1 d-none">
                                    <div>
                                        <h5 class="my-0">
                                            {{ auth()->user()->name ?? 'User' }}
                                        </h5>
                                        <small class="text-muted text-capitalize">
                                            {{ auth()->user()->role ?? '-' }}
                                        </small>
                                    </div>
                                    <i data-lucide="chevron-down" class="align-middle"></i>
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Selamat Datang!</h6>
                                </div>

                                <a href="{{ route('profile.index') }}" class="dropdown-item">
                                    <i data-lucide="circle-user-round" class="me-1 fs-lg align-middle"></i>
                                    <span>Profile</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button type="submit" class="dropdown-item text-danger fw-semibold">
                                        <i data-lucide="log-out" class="me-1 fs-lg align-middle"></i>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- End Topbar -->

        <!-- Sidebar -->
        <div class="sidenav-menu">

            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="logo logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                    </span>
                </span>

                <span class="logo logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                    </span>
                </span>
            </a>

            <!-- Sidebar Close -->
            <button class="button-close-offcanvas">
                <i data-lucide="menu" class="align-middle"></i>
            </button>

            <div class="scrollbar" data-simplebar>
                <div id="sidenav-menu">
                    <ul class="side-nav">

                        <li class="side-nav-title mt-2">Menu Utama</li>

                        <li class="side-nav-item">
                            <a href="{{ route('dashboard') }}" class="side-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="layout-dashboard"></i>
                                </span>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>

                        {{-- MENU KHUSUS ADMIN --}}
                        @if (auth()->check() && auth()->user()->role == 'admin')
                            <li class="side-nav-title mt-2">Master Data</li>

                            <li class="side-nav-item">
                                <a href="{{ route('barang.index') }}" class="side-nav-link {{ request()->is('barang') || request()->is('barang/create') || request()->is('barang/*/edit') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="package"></i>
                                    </span>
                                    <span class="menu-text">Data Barang</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('barang.stokMenipis') }}" class="side-nav-link {{ request()->is('stok-menipis*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="alert-triangle"></i>
                                    </span>
                                    <span class="menu-text">Stok Menipis</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('stok.index') }}"
                                class="side-nav-link {{ request()->is('stok') || request()->is('stok/*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="arrow-left-right"></i>
                                    </span>
                                    <span class="menu-text">Stok Masuk/Keluar</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('barang.expired') }}"
                                class="side-nav-link {{ request()->is('expired-barang*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="calendar-clock"></i>
                                    </span>
                                    <span class="menu-text">Expired Barang</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('kategori.index') }}" class="side-nav-link {{ request()->is('kategori*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="tags"></i>
                                    </span>
                                    <span class="menu-text">Kategori</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('rak.index') }}" class="side-nav-link {{ request()->is('rak*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="archive"></i>
                                    </span>
                                    <span class="menu-text">Rak Barang</span>
                                </a>
                            </li>

                            <li class="side-nav-title mt-2">Pengguna</li>

                            <li class="side-nav-item">
                                <a href="{{ route('users.index') }}" class="side-nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="users"></i>
                                    </span>
                                    <span class="menu-text">User Management</span>
                                </a>
                            </li>
                        @endif

                        {{-- MENU TRANSAKSI UNTUK ADMIN DAN KASIR --}}
                        @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'kasir']))
                            <li class="side-nav-title mt-2">Transaksi</li>

                            <li class="side-nav-item">
                                <a href="{{ route('penjualan.index') }}" class="side-nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="shopping-cart"></i>
                                    </span>
                                    <span class="menu-text">Penjualan</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('keranjang.index') }}" class="side-nav-link {{ request()->is('keranjang*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="shopping-basket"></i>
                                    </span>
                                    <span class="menu-text">Keranjang</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('riwayat.index') }}" class="side-nav-link {{ request()->is('riwayat-transaksi*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="history"></i>
                                    </span>
                                    <span class="menu-text">Riwayat Transaksi</span>
                                </a>
                            </li>
                        @endif

                        {{-- LAPORAN KHUSUS ADMIN --}}
                        @if (auth()->check() && auth()->user()->role == 'admin')
                            <li class="side-nav-title mt-2">Laporan</li>

                            <li class="side-nav-item">
                                <a href="{{ route('laporan.index') }}" class="side-nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="file-text"></i>
                                    </span>
                                    <span class="menu-text">Laporan Penjualan</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('barang.terlaris') }}"
                                class="side-nav-link {{ request()->is('barang-terlaris*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="trending-up"></i>
                                    </span>
                                    <span class="menu-text">Barang Terlaris</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('laporan.keuntungan') }}"
                                class="side-nav-link {{ request()->is('laporan-keuntungan*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="line-chart"></i>
                                    </span>
                                    <span class="menu-text">Laporan Keuntungan</span>
                                </a>
                            </li>

                            <li class="side-nav-title mt-2">Pengaturan</li>

                            <li class="side-nav-item">
                                <a href="{{ route('pengaturan-toko.index') }}"
                                class="side-nav-link {{ request()->is('pengaturan-toko*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="settings"></i>
                                    </span>
                                    <span class="menu-text">Pengaturan Toko</span>
                                </a>
                            </li>

                            <li class="side-nav-item">
                                <a href="{{ route('log-aktivitas.index') }}"
                                class="side-nav-link {{ request()->is('log-aktivitas*') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i data-lucide="activity"></i>
                                    </span>
                                    <span class="menu-text">Log Aktivitas</span>
                                </a>
                            </li>
                        @endif

                        {{-- LOGOUT --}}
                        <li class="side-nav-title mt-2">Akun</li>

                        <li class="side-nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="side-nav-link w-100 border-0 bg-transparent text-start">
                                    <span class="menu-icon">
                                        <i data-lucide="log-out"></i>
                                    </span>
                                    <span class="menu-text text-danger">Log Out</span>
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="content-page">
            <div class="container-fluid">

                @yield('content')

            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            © <span data-current-year></span> Sistem Swalayan
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- End Main Content -->

    </div>

    <!-- Vendor JS -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
