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

    @stack('styles')
</head>

<body>
    <div class="wrapper">

        <!-- Topbar -->
        <header class="app-topbar">
            <div class="container-fluid topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Logo -->
                    <div class="logo-topbar">
                        <a href="{{ url('/dashboard') }}" class="logo-light">
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                            </span>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                            </span>
                        </a>

                        <a href="{{ url('/dashboard') }}" class="logo-dark">
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

                    <!-- Notification -->
                    <div class="topbar-item">
                        <button class="topbar-link" type="button">
                            <i data-lucide="bell" class="topbar-link-icon"></i>
                            <span class="badge text-bg-danger badge-circle topbar-badge">3</span>
                        </button>
                    </div>

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
                                    <h5 class="my-0">{{ Auth::user()->name }}</h5>
                                    <i data-lucide="chevron-down" class="align-middle"></i>
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Selamat Datang!</h6>
                                </div>

                                <a href="#" class="dropdown-item">
                                    <i data-lucide="circle-user-round" class="me-1 fs-lg align-middle"></i>
                                    <span>Profile</span>
                                </a>

                                <a href="#" class="dropdown-item">
                                    <i data-lucide="settings" class="me-1 fs-lg align-middle"></i>
                                    <span>Pengaturan</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a href="{{ url('/login') }}" class="dropdown-item text-danger fw-semibold">
                                    <i data-lucide="log-out" class="me-1 fs-lg align-middle"></i>
                                    <span>Log Out</span>
                                </a>
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
            <a href="{{ url('/dashboard') }}" class="logo">
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
                            <a href="{{ url('/dashboard') }}" class="side-nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="layout-dashboard"></i>
                                </span>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="side-nav-title mt-2">Master Data</li>

                        <li class="side-nav-item">
                            <a href="{{ url('/barang') }}" class="side-nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="package"></i>
                                </span>
                                <span class="menu-text">Data Barang</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ url('/kategori') }}" class="side-nav-link {{ request()->is('kategori*') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="tags"></i>
                                </span>
                                <span class="menu-text">Kategori</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ url('/rak') }}" class="side-nav-link {{ request()->is('rak*') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="archive"></i>
                                </span>
                                <span class="menu-text">Rak Barang</span>
                            </a>
                        </li>

                        <li class="side-nav-title mt-2">Transaksi</li>

                        <li class="side-nav-item">
                            <a href="{{ url('/penjualan') }}" class="side-nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="shopping-cart"></i>
                                </span>
                                <span class="menu-text">Penjualan</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ url('/keranjang') }}" class="side-nav-link {{ request()->is('keranjang*') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="shopping-basket"></i>
                                </span>
                                <span class="menu-text">Keranjang</span>
                            </a>
                        </li>

                        <li class="side-nav-title mt-2">Laporan</li>

                        <li class="side-nav-item">
                            <a href="{{ url('/laporan') }}" class="side-nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                                <span class="menu-icon">
                                    <i data-lucide="file-text"></i>
                                </span>
                                <span class="menu-text">Laporan Penjualan</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="dropdown-item text-danger fw-semibold">
                                    <i data-lucide="log-out" class="me-1 fs-lg align-middle"></i>
                                    <span>Log Out</span>
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
