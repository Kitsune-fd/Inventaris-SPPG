<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SPPG Admin Portal</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =============================================
           CSS VARIABLES — SPPG Color System
        ============================================= */
        :root {
            --sppg-primary:     #1a7a4a;   /* Hijau tua utama */
            --sppg-primary-dk:  #145e38;   /* Hijau lebih gelap */
            --sppg-primary-lt:  #e8f5ee;   /* Hijau sangat terang */
            --sppg-accent:      #f97316;   /* Oranye aksen */
            --sppg-accent-lt:   #fff4ec;   /* Oranye sangat terang */
            --sppg-sidebar-bg:  #0f3d24;   /* Sidebar gelap */
            --sppg-sidebar-w:   265px;     /* Lebar sidebar */
            --sppg-navbar-h:    62px;      /* Tinggi navbar */
            --sppg-text:        #1e293b;
            --sppg-text-muted:  #64748b;
            --sppg-border:      #e2e8f0;
            --sppg-bg:          #f1f5f0;
            --sppg-card:        #ffffff;
            --sppg-shadow:      0 1px 3px rgba(0,0,0,.07), 0 4px 16px rgba(0,0,0,.06);
            --sppg-shadow-md:   0 4px 24px rgba(15,61,36,.13);
            --transition:       all .22s cubic-bezier(.4,0,.2,1);
        }

        /* =============================================
           BASE RESET & TYPOGRAPHY
        ============================================= */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--sppg-bg);
            color: var(--sppg-text);
            font-size: 0.9rem;
            overflow-x: hidden;
        }

        /* =============================================
           SCROLLBAR STYLING
        ============================================= */
        ::-webkit-scrollbar          { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track    { background: transparent; }
        ::-webkit-scrollbar-thumb    { background: rgba(0,0,0,.18); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--sppg-primary); }

        /* =============================================
           SIDEBAR
        ============================================= */
        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sppg-sidebar-w);
            background: var(--sppg-sidebar-bg);
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        /* Brand / Logo area */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 20px;
            height: var(--sppg-navbar-h);
            border-bottom: 1px solid rgba(255,255,255,.07);
            text-decoration: none;
            flex-shrink: 0;
        }
        .sidebar-brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--sppg-accent), #fb923c);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            box-shadow: 0 4px 12px rgba(249,115,22,.35);
            flex-shrink: 0;
        }
        .sidebar-brand-text { flex: 1; }
        .sidebar-brand-text .brand-title {
            font-size: .85rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .5px;
            line-height: 1.2;
        }
        .sidebar-brand-text .brand-sub {
            font-size: .65rem;
            color: rgba(255,255,255,.45);
            font-weight: 400;
            letter-spacing: .3px;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 12px 0 20px;
        }

        /* Section label */
        .nav-section-label {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: 1.4px;
            color: rgba(255,255,255,.28);
            text-transform: uppercase;
            padding: 16px 22px 5px;
            margin-top: 4px;
        }

        /* Nav item */
        .sidebar-nav .nav-item { padding: 1px 10px; }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,.65);
            font-size: .82rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }
        .sidebar-nav .nav-link i {
            font-size: 1rem;
            width: 20px;
            flex-shrink: 0;
            text-align: center;
        }
        .sidebar-nav .nav-link span { flex: 1; }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,.08);
            color: #fff;
            transform: translateX(2px);
        }
        .sidebar-nav .nav-link.active {
            background: linear-gradient(90deg, var(--sppg-primary), #22a05a);
            color: #fff;
            box-shadow: 0 3px 10px rgba(26,122,74,.4);
        }
        .sidebar-nav .nav-link.active i { color: var(--sppg-accent); }

        /* Collapse chevron */
        .sidebar-nav .nav-link .chev {
            font-size: .72rem;
            transition: transform .25s;
            margin-left: auto;
        }
        .sidebar-nav .nav-link[aria-expanded="true"] .chev {
            transform: rotate(90deg);
        }

        /* Sub-menu */
        .sidebar-submenu {
            list-style: none;
            padding: 2px 0 4px 32px;
            margin: 0;
        }
        .sidebar-submenu .nav-link {
            font-size: .78rem;
            padding: 7px 10px;
            color: rgba(255,255,255,.50);
        }
        .sidebar-submenu .nav-link::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
            background: rgba(255,255,255,.25);
            flex-shrink: 0;
            margin-right: -2px;
        }
        .sidebar-submenu .nav-link:hover,
        .sidebar-submenu .nav-link.active {
            color: #fff;
        }
        .sidebar-submenu .nav-link.active::before {
            background: var(--sppg-accent);
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 12px 10px;
            border-top: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,.06);
        }
        .sidebar-user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sppg-accent), #ef4444);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .8rem;
            flex-shrink: 0;
        }
        .sidebar-user-info .user-name {
            font-size: .78rem; font-weight: 600; color: #fff; line-height: 1.2;
        }
        .sidebar-user-info .user-role {
            font-size: .65rem; color: rgba(255,255,255,.4);
        }

        /* =============================================
           TOP NAVBAR
        ============================================= */
        #topNavbar {
            position: fixed;
            top: 0; right: 0;
            left: var(--sppg-sidebar-w);
            height: var(--sppg-navbar-h);
            background: var(--sppg-card);
            border-bottom: 1px solid var(--sppg-border);
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
            transition: var(--transition);
            box-shadow: 0 1px 0 rgba(0,0,0,.04);
        }

        .navbar-toggle-btn {
            width: 34px; height: 34px;
            border: none; background: transparent;
            border-radius: 7px;
            color: var(--sppg-text-muted);
            font-size: 1.1rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        .navbar-toggle-btn:hover {
            background: var(--sppg-primary-lt);
            color: var(--sppg-primary);
        }

        .navbar-breadcrumb {
            font-size: .78rem;
            color: var(--sppg-text-muted);
        }
        .navbar-breadcrumb .bc-current {
            color: var(--sppg-text);
            font-weight: 600;
        }

        .navbar-actions { margin-left: auto; display: flex; align-items: center; gap: 6px; }

        .nav-icon-btn {
            width: 36px; height: 36px;
            border: none; background: transparent;
            border-radius: 8px;
            color: var(--sppg-text-muted);
            font-size: 1.05rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }
        .nav-icon-btn:hover {
            background: var(--sppg-primary-lt);
            color: var(--sppg-primary);
        }
        .nav-icon-btn .badge-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: var(--sppg-accent);
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .navbar-divider {
            width: 1px; height: 22px;
            background: var(--sppg-border);
            margin: 0 4px;
        }

        .navbar-user-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 10px 5px 5px;
            border-radius: 8px;
            border: none; background: transparent;
            cursor: pointer;
            transition: var(--transition);
        }
        .navbar-user-btn:hover { background: var(--sppg-primary-lt); }
        .navbar-user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sppg-primary), var(--sppg-accent));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .75rem;
        }
        .navbar-user-name {
            font-size: .8rem; font-weight: 600;
            color: var(--sppg-text);
        }

        /* =============================================
           MAIN CONTENT WRAPPER
        ============================================= */
        #mainContent {
            margin-left: var(--sppg-sidebar-w);
            padding-top: var(--sppg-navbar-h);
            min-height: 100vh;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .content-area {
            flex: 1;
            padding: 28px 28px 0;
        }

        /* =============================================
           FOOTER
        ============================================= */
        .main-footer {
            padding: 18px 28px;
            font-size: .75rem;
            color: var(--sppg-text-muted);
            border-top: 1px solid var(--sppg-border);
            margin-top: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .main-footer a { color: var(--sppg-primary); text-decoration: none; }
        .main-footer a:hover { text-decoration: underline; }

        /* =============================================
           SIDEBAR COLLAPSED STATE
        ============================================= */
        body.sidebar-collapsed #sidebar {
            width: 66px;
        }
        body.sidebar-collapsed #topNavbar,
        body.sidebar-collapsed #mainContent {
            left: 66px;
            margin-left: 66px;
        }
        body.sidebar-collapsed .sidebar-brand-text,
        body.sidebar-collapsed .nav-section-label,
        body.sidebar-collapsed .sidebar-nav .nav-link span,
        body.sidebar-collapsed .sidebar-nav .nav-link .chev,
        body.sidebar-collapsed .sidebar-user-info,
        body.sidebar-collapsed .sidebar-submenu {
            display: none !important;
        }
        body.sidebar-collapsed .sidebar-brand { justify-content: center; padding: 0; }
        body.sidebar-collapsed .sidebar-nav .nav-item { padding: 2px 8px; }
        body.sidebar-collapsed .sidebar-nav .nav-link { justify-content: center; padding: 10px; }
        body.sidebar-collapsed .sidebar-nav .nav-link i { width: auto; }
        body.sidebar-collapsed .sidebar-user { justify-content: center; }
        body.sidebar-collapsed .sidebar-user-avatar { margin: 0; }

        /* =============================================
           MOBILE RESPONSIVE
        ============================================= */
        @media (max-width: 991.98px) {
            #sidebar {
                left: calc(-1 * var(--sppg-sidebar-w));
            }
            #topNavbar, #mainContent {
                left: 0;
                margin-left: 0;
            }
            body.sidebar-open #sidebar {
                left: 0;
            }
            .sidebar-backdrop {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,.45);
                z-index: 1039;
            }
            body.sidebar-open .sidebar-backdrop { display: block; }
        }

        /* =============================================
           UTILITY HELPERS
        ============================================= */
        .text-primary-sppg { color: var(--sppg-primary) !important; }
        .text-accent-sppg  { color: var(--sppg-accent) !important; }
        .bg-primary-sppg   { background: var(--sppg-primary) !important; }
        .bg-accent-sppg    { background: var(--sppg-accent) !important; }

        /* Page header */
        .page-header {
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--sppg-text);
            margin: 0;
        }
        .page-header p {
            font-size: .8rem;
            color: var(--sppg-text-muted);
            margin: 3px 0 0;
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ===================================================
     SIDEBAR BACKDROP (mobile)
==================================================== --}}
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

{{-- ===================================================
     SIDEBAR
==================================================== --}}
<nav id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="bi bi-egg-fried"></i>
        </div>
        <div class="sidebar-brand-text">
            <div class="brand-title">SPPG</div>
            <div class="brand-sub">Satuan Pelayanan Pemenuhan Gizi</div>
        </div>
    </a>

    {{-- Navigation --}}
    <div class="sidebar-nav">
        <ul class="nav flex-column">

            {{-- DASHBOARD --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('/') || Request::routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- MASTER DATA --}}
            <div class="nav-section-label">Master Data</div>

            <li class="nav-item">
                <a href="#menuMasterData" class="nav-link {{ Request::routeIs('bahan-baku.*', 'kategori.*', 'sekolah.*') ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse" aria-expanded="{{ Request::routeIs('bahan-baku.*', 'kategori.*', 'sekolah.*') ? 'true' : 'false' }}">
                    <i class="bi bi-boxes"></i>
                    <span>Master Data</span>
                    <i class="bi bi-chevron-right chev"></i>
                </a>
                <div class="collapse {{ Request::routeIs('bahan-baku.*', 'kategori.*', 'sekolah.*') ? 'show' : '' }}" id="menuMasterData">
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('bahan-baku.index')}}" class="nav-link {{ Request::routeIs('bahan-baku.*') ? 'active' : '' }}">
                            <span>Data Bahan Baku</span>
                        </a></li>
                        <li><a href="{{route('kategori.index')}}" class="nav-link {{ Request::routeIs('kategori.*') ? 'active' : '' }}">
                            <span>Kategori Bahan</span>
                        </a></li>
                        <li><a href="{{route('sekolah.index')}}" class="nav-link {{ Request::routeIs('sekolah.*') ? 'active' : '' }}">
                            <span>Sekolah Penerima</span>
                        </a></li>
                    </ul>
                </div>
            </li>

            {{-- MANAJEMEN STOK --}}
            <div class="nav-section-label">Manajemen Stok</div>

            <li class="nav-item">
                <a href="#menuStok" class="nav-link {{ Request::routeIs('stok-bahan.*', 'bahan-masuk.*', 'penggunaan-bahan.*') ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse" aria-expanded="{{ Request::routeIs('stok-bahan.*', 'bahan-masuk.*', 'penggunaan-bahan.*') ? 'true' : 'false' }}">
                    <i class="bi bi-archive"></i>
                    <span>Manajemen Stok</span>
                    <i class="bi bi-chevron-right chev"></i>
                </a>
                <div class="collapse {{ Request::routeIs('stok-bahan.*', 'bahan-masuk.*', 'penggunaan-bahan.*') ? 'show' : '' }}" id="menuStok">
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('stok-bahan.index') }}" class="nav-link {{ Request::routeIs('stok-bahan.*') ? 'active' : '' }}">
                            <span>Stok Bahan</span>
                        </a></li>
                        <li><a href="{{ route('bahan-masuk.index') }}" class="nav-link {{ Request::routeIs('bahan-masuk.*') ? 'active' : '' }}">
                            <span>Bahan Masuk</span>
                        </a></li>
                        <li><a href="{{ route('penggunaan-bahan.index') }}" class="nav-link {{ Request::routeIs('penggunaan-bahan.*') ? 'active' : '' }}">
                            <span>Penggunaan Bahan</span>
                        </a></li>
                    </ul>
                </div>
            </li>

            
            <div class="nav-section-label">Laporan</div>

            <li class="nav-item">
                <a href="#menuLaporan" class="nav-link {{ Request::routeIs('laporan.*') ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse" aria-expanded="{{ Request::routeIs('laporan.*') ? 'true' : 'false' }}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Laporan</span>
                    <i class="bi bi-chevron-right chev"></i>
                </a>
                <div class="collapse {{ Request::routeIs('laporan.*') ? 'show' : '' }}" id="menuLaporan">
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('laporan.index') }}" class="nav-link {{ Request::routeIs('laporan.*') ? 'active' : '' }}">
                            <span>Laporan Stok</span>
                        </a></li>
                        
                    </ul>
                </div>
            </li>


            {{-- PENGATURAN --}}
            <div class="nav-section-label">Pengaturan</div>

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <a href="#" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>

        </ul>
    </div>

    {{-- Sidebar Footer / User Info --}}
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="user-name">{{ Auth::user()->name ?? 'Administrator' }}</div>
                <div class="user-role">{{ Auth::user()->role ?? 'Super Admin' }}</div>
            </div>
        </div>
    </div>

</nav>

{{-- ===================================================
     TOP NAVBAR
==================================================== --}}
<header id="topNavbar">
    {{-- Toggle Sidebar --}}
    <button class="navbar-toggle-btn" id="sidebarToggle" title="Toggle Sidebar">
        <i class="bi bi-list"></i>
    </button>

    {{-- Breadcrumb --}}
    <nav class="navbar-breadcrumb d-none d-md-flex align-items-center gap-1">
        <i class="bi bi-house-door text-primary-sppg" style="font-size:.8rem"></i>
        <span>/</span>
        @yield('breadcrumb', '<span class="bc-current">Dashboard</span>')
    </nav>

    {{-- Right Actions --}}
    <div class="navbar-actions">

        {{-- Search --}}
        <button class="nav-icon-btn d-none d-md-flex" title="Cari">
            <i class="bi bi-search"></i>
        </button>

        {{-- Notifikasi --}}
        <button class="nav-icon-btn" title="Notifikasi">
            <i class="bi bi-bell"></i>
            <span class="badge-dot"></span>
        </button>

        {{-- Pesan --}}
        <button class="nav-icon-btn" title="Pesan">
            <i class="bi bi-chat-dots"></i>
        </button>

        <div class="navbar-divider d-none d-sm-block"></div>

        {{-- User dropdown --}}
        <div class="dropdown">
            <button class="navbar-user-btn" data-bs-toggle="dropdown">
                <div class="navbar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                </div>
                <span class="navbar-user-name d-none d-sm-block">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </span>
                <i class="bi bi-chevron-down" style="font-size:.65rem; color: var(--sppg-text-muted)"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size:.82rem; min-width:180px">
                <li>
                    <div class="px-3 py-2 border-bottom">
                        <div style="font-weight:600; color:var(--sppg-text)">{{ Auth::user()->name ?? 'Administrator' }}</div>
                        <div style="font-size:.72rem; color:var(--sppg-text-muted)">{{ Auth::user()->email ?? 'admin@sppg.go.id' }}</div>
                    </div>
                </li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="#"
                       onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>
</header>

{{-- ===================================================
     MAIN CONTENT
==================================================== --}}
<main id="mainContent">

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="main-footer">
        <span>
            &copy; {{ date('Y') }} <a href="#">SPPG — Satuan Pelayanan Pemenuhan Gizi</a>.
            All rights reserved.
        </span>
        <span class="d-none d-sm-block">
            v1.0.0 &nbsp;·&nbsp; Dibuat oleh Tim IT Dinas Kesehatan
        </span>
    </footer>

</main>

{{-- Bootstrap 5 JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar       = document.getElementById('sidebar');
    const topNavbar     = document.getElementById('topNavbar');
    const mainContent   = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const backdrop      = document.getElementById('sidebarBackdrop');
    const body          = document.body;

    const isMobile = () => window.innerWidth < 992;

    /* ---- Toggle sidebar ---- */
    sidebarToggle.addEventListener('click', function () {
        if (isMobile()) {
            body.classList.toggle('sidebar-open');
        } else {
            body.classList.toggle('sidebar-collapsed');
            // Persist preference
            localStorage.setItem('sidebarCollapsed', body.classList.contains('sidebar-collapsed') ? '1' : '0');
        }
    });

    /* ---- Close on backdrop click (mobile) ---- */
    backdrop.addEventListener('click', function () {
        body.classList.remove('sidebar-open');
    });

    /* ---- Restore preference on load (desktop) ---- */
    if (!isMobile() && localStorage.getItem('sidebarCollapsed') === '1') {
        body.classList.add('sidebar-collapsed');
    }

    /* ---- Responsive: close sidebar when resizing to desktop ---- */
    window.addEventListener('resize', function () {
        if (!isMobile()) {
            body.classList.remove('sidebar-open');
        }
    });

    /* ---- Tooltip init for collapsed sidebar icons ---- */
    const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(el => new bootstrap.Tooltip(el, { placement: 'right' }));

});
</script>

@stack('scripts')
</body>
</html>