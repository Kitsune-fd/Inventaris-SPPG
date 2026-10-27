@extends('layouts.layouts_app')

    @section('title', 'Dashboard')

    @section('breadcrumb')
        <span class="bc-current">Dashboard</span>
    @endsection

    @push('styles')
    <style>
        /* =============================================
        DASHBOARD — Welcome Banner
        ============================================= */
        .welcome-banner {
            background: linear-gradient(120deg, var(--sppg-primary) 0%, #1d9a57 55%, #2ec97a 100%);
            border-radius: 16px;
            padding: 28px 32px;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,.06);
            border-radius: 50%;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -60px; right: 80px;
            width: 150px; height: 150px;
            background: rgba(255,255,255,.05);
            border-radius: 50%;
        }
        .welcome-banner .wb-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0 0 4px;
        }
        .welcome-banner .wb-sub {
            font-size: .82rem;
            opacity: .8;
            margin: 0;
        }
        .welcome-banner .wb-icon {
            position: absolute;
            right: 32px; top: 50%;
            transform: translateY(-50%);
            font-size: 5rem;
            opacity: .12;
        }
        .wb-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: .72rem;
            font-weight: 600;
            margin-top: 14px;
        }

        /* =============================================
        STAT CARDS
        ============================================= */
        .stat-card {
            background: var(--sppg-card);
            border-radius: 14px;
            padding: 22px;
            border: 1px solid var(--sppg-border);
            box-shadow: var(--sppg-shadow);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--sppg-shadow-md);
        }
        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 0 0 14px 14px;
        }
        .stat-card.sc-green::after  { background: var(--sppg-primary); }
        .stat-card.sc-orange::after { background: var(--sppg-accent); }
        .stat-card.sc-blue::after   { background: #3b82f6; }
        .stat-card.sc-purple::after { background: #8b5cf6; }

        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .stat-icon.si-green  { background: var(--sppg-primary-lt); color: var(--sppg-primary); }
        .stat-icon.si-orange { background: var(--sppg-accent-lt);  color: var(--sppg-accent); }
        .stat-icon.si-blue   { background: #eff6ff; color: #3b82f6; }
        .stat-icon.si-purple { background: #f5f3ff; color: #8b5cf6; }

        .stat-body { flex: 1; }
        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--sppg-text);
        }
        .stat-label {
            font-size: .76rem;
            color: var(--sppg-text-muted);
            font-weight: 500;
            margin-top: 3px;
        }
        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: .68rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            margin-top: 8px;
        }
        .stat-badge.up   { background: #dcfce7; color: #16a34a; }
        .stat-badge.down { background: #fee2e2; color: #dc2626; }
        .stat-badge.neu  { background: #f1f5f9; color: #64748b; }

        /* =============================================
        SECTION CARD (panel)
        ============================================= */
        .panel-card {
            background: var(--sppg-card);
            border: 1px solid var(--sppg-border);
            border-radius: 14px;
            box-shadow: var(--sppg-shadow);
            overflow: hidden;
        }
        .panel-card .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px 14px;
            border-bottom: 1px solid var(--sppg-border);
        }
        .panel-card .panel-title {
            font-size: .9rem;
            font-weight: 700;
            color: var(--sppg-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .panel-card .panel-title i {
            color: var(--sppg-primary);
            font-size: 1rem;
        }
        .panel-card .panel-body { padding: 18px 22px; }

        /* =============================================
        STOCK TABLE
        ============================================= */
        .stock-table { font-size: .8rem; }
        .stock-table thead th {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--sppg-text-muted);
            border-bottom: 1px solid var(--sppg-border);
            padding: 10px 14px;
            background: #fafafa;
            white-space: nowrap;
        }
        .stock-table tbody td {
            padding: 11px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--sppg-border);
            color: var(--sppg-text);
        }
        .stock-table tbody tr:last-child td { border-bottom: 0; }
        .stock-table tbody tr:hover td { background: var(--sppg-primary-lt); }

        .stock-badge {
            font-size: .7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }
        .stock-badge.kritis  { background: #fee2e2; color: #b91c1c; }
        .stock-badge.rendah  { background: #fef3c7; color: #b45309; }
        .stock-badge.normal  { background: #dcfce7; color: #15803d; }

        .stock-progress-wrap { min-width: 90px; }
        .stock-progress {
            height: 6px;
            border-radius: 10px;
            background: #e2e8f0;
            overflow: hidden;
        }
        .stock-progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width .6s ease;
        }

        /* =============================================
        CHART PLACEHOLDER
        ============================================= */
        .chart-placeholder {
            position: relative;
            background: linear-gradient(135deg, var(--sppg-primary-lt), #fff);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            color: var(--sppg-text-muted);
        }
        .chart-bar-demo {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            height: 100px;
            padding: 10px 0 0;
        }
        .chart-bar-demo .bar {
            width: 22px;
            border-radius: 4px 4px 0 0;
            background: var(--sppg-primary);
            opacity: .7;
            transition: opacity .3s;
        }
        .chart-bar-demo .bar:hover { opacity: 1; }
        .chart-bar-demo .bar.accent { background: var(--sppg-accent); }

        /* =============================================
        ACTIVITY FEED
        ============================================= */
        .activity-feed { list-style: none; padding: 0; margin: 0; }
        .activity-feed li {
            display: flex;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--sppg-border);
            font-size: .8rem;
        }
        .activity-feed li:last-child { border-bottom: 0; }
        .activity-dot {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .activity-dot.green  { background: var(--sppg-primary-lt); color: var(--sppg-primary); }
        .activity-dot.orange { background: var(--sppg-accent-lt);  color: var(--sppg-accent); }
        .activity-dot.blue   { background: #eff6ff; color: #3b82f6; }
        .activity-dot.red    { background: #fee2e2; color: #ef4444; }

        .activity-content .ac-title {
            font-weight: 600; color: var(--sppg-text);
            line-height: 1.3;
        }
        .activity-content .ac-meta {
            color: var(--sppg-text-muted);
            font-size: .72rem;
            margin-top: 2px;
        }

        /* =============================================
        QUICK ACTIONS
        ============================================= */
        .quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px 8px;
            border-radius: 10px;
            border: 1.5px solid var(--sppg-border);
            background: #fff;
            text-decoration: none;
            color: var(--sppg-text);
            font-size: .73rem;
            font-weight: 600;
            text-align: center;
            transition: var(--transition);
            height: 90px;
        }
        .quick-action-btn i {
            font-size: 1.3rem;
            color: var(--sppg-primary);
        }
        .quick-action-btn:hover {
            border-color: var(--sppg-primary);
            background: var(--sppg-primary-lt);
            color: var(--sppg-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26,122,74,.12);
        }
        .quick-action-btn.accent i    { color: var(--sppg-accent); }
        .quick-action-btn.accent:hover {
            border-color: var(--sppg-accent);
            background: var(--sppg-accent-lt);
            color: var(--sppg-accent);
        }

        /* =============================================
        DISTRIBUSI SEKOLAH LIST
        ============================================= */
        .sekolah-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--sppg-border);
            font-size: .8rem;
        }
        .sekolah-item:last-child { border-bottom: 0; }
        .sekolah-avatar {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: var(--sppg-primary-lt);
            color: var(--sppg-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .sekolah-name { font-weight: 600; color: var(--sppg-text); }
        .sekolah-detail { font-size: .7rem; color: var(--sppg-text-muted); }
    </style>
    @endpush

    @section('content')

    {{-- =============================================
        WELCOME BANNER
    ============================================= --}}
    <div class="welcome-banner">
        <p class="wb-title">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }} 👋</p>
        <p class="wb-sub">Portal Admin SPPG — Satuan Pelayanan Pemenuhan Gizi</p>
        <span class="wb-badge">
            <i class="bi bi-calendar3"></i>
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </span>
        <i class="bi bi-egg-fried wb-icon"></i>
    </div>

    {{-- =============================================
        STAT CARDS
    ============================================= --}}
    <div class="row g-3 mb-4">

        <div class="col-6 col-xl-3">
            <div class="stat-card sc-green">
                <div class="stat-icon si-green"><i class="bi bi-boxes"></i></div>
                <div class="stat-body">
                    <div class="stat-value">{{ number_format($totalBahanBaku) }}</div>
                    <div class="stat-label">Total Bahan Baku</div>
                    @if($bahanBakuBulanIni > 0)
                        <span class="stat-badge up"><i class="bi bi-arrow-up-short"></i>+{{ $bahanBakuBulanIni }} baru bulan ini</span>
                    @else
                        <span class="stat-badge neu"><i class="bi bi-check2"></i>{{ $totalBahanTersedia }} item tersedia</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card sc-orange">
                <div class="stat-icon si-orange"><i class="bi bi-building"></i></div>
                <div class="stat-body">
                    <div class="stat-value">{{ number_format($totalSekolah) }}</div>
                    <div class="stat-label">Total Sekolah</div>
                    <span class="stat-badge neu"><i class="bi bi-building-check"></i>{{ $totalSekolahAktif }} aktif terdaftar</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card sc-blue">
                <div class="stat-icon si-blue"><i class="bi bi-fire"></i></div>
                <div class="stat-body">
                    <div class="stat-value">{{ number_format($totalPorsiTarget) }}</div>
                    <div class="stat-label">Target Porsi Hari Ini</div>
                    <span class="stat-badge up"><i class="bi bi-truck"></i>{{ $persenPorsiTerkirim }}% terkirim ({{ number_format($porsiTerkirim) }})</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card {{ $totalBahanKritis > 0 ? 'sc-purple' : 'sc-green' }}">
                <div class="stat-icon {{ $totalBahanKritis > 0 ? 'si-purple' : 'si-green' }}"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="stat-body">
                    <div class="stat-value" style="{{ $totalBahanKritis > 0 ? 'color:#dc2626' : '' }}">{{ number_format($totalBahanKritis) }}</div>
                    <div class="stat-label">Bahan Kritis / Menipis</div>
                    @if($totalBahanKritis > 0)
                        <span class="stat-badge down"><i class="bi bi-exclamation-circle"></i>Perlu Restock</span>
                    @else
                        <span class="stat-badge up"><i class="bi bi-check-circle"></i>Semua Stok Aman</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- =============================================
        ROW: STOK HAMPIR HABIS + GRAFIK
    ============================================= --}}
    <div class="row g-3 mb-4">

        {{-- Stok Hampir Habis --}}
        <div class="col-12 col-xl-7">
            <div class="panel-card h-100">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                        Stok Bahan Hampir Habis
                    </div>
                    <a href="{{ route('bahan-baku.index') }}" class="btn btn-sm"
                    style="background:var(--sppg-primary-lt); color:var(--sppg-primary); font-size:.73rem; font-weight:600; border:none; border-radius:7px; padding:5px 12px;">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="p-0">
                    <table class="table stock-table mb-0">
                        <thead>
                            <tr>
                                <th>Nama Bahan</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Min. Stok</th>
                                <th>Kondisi</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokHampirHabis as $item)
                            <tr>
                                <td>
                                    <div style="font-weight:600">{{ $item->nama }}</div>
                                </td>
                                <td>
                                    <span style="font-size:.7rem; color:var(--sppg-text-muted)">{{ $item->kategori }}</span>
                                </td>
                                <td>
                                    <span style="font-weight:600; color:{{ $item->kondisi === 'kritis' ? '#b91c1c' : ($item->kondisi === 'rendah' ? '#b45309' : '#15803d') }}">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td style="color:var(--sppg-text-muted)">{{ $item->min_stok }}</td>
                                <td>
                                    <span class="stock-badge {{ $item->kondisi }}">
                                        {{ ucfirst($item->kondisi) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="stock-progress-wrap">
                                        <div class="stock-progress">
                                            <div class="stock-progress-bar"
                                                style="width:{{ $item->progress }}%; background:{{ $item->kondisi === 'kritis' ? '#ef4444' : ($item->kondisi === 'rendah' ? '#f97316' : '#22c55e') }}">
                                            </div>
                                        </div>
                                        <div style="font-size:.65rem; color:var(--sppg-text-muted); margin-top:2px">{{ $item->progress }}%</div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-check-circle text-success me-1"></i> Tidak ada bahan dengan stok kritis saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Grafik Produksi --}}
        <div class="col-12 col-xl-5">
            <div class="panel-card h-100">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="bi bi-bar-chart-line"></i>
                        Grafik Produksi (7 Hari)
                    </div>
                    <span style="font-size:.7rem; color:var(--sppg-text-muted)">Porsi / Hari</span>
                </div>
                <div class="panel-body d-flex flex-column align-items-center">

                    <div class="w-100">
                        <div class="d-flex align-items-flex-end gap-2 justify-content-between" style="height:160px; padding: 0 4px;">
                            @foreach($chartVals as $i => $val)
                            @php $pct = $chartMax > 0 ? round($val / $chartMax * 100) : 0; @endphp
                            <div class="d-flex flex-column align-items-center gap-1" style="flex:1">
                                <div style="font-size:.62rem; color:var(--sppg-text-muted); font-weight:600">{{ number_format($val) }}</div>
                                <div style="flex:1; display:flex; align-items:flex-end; width:100%">
                                    <div style="
                                        width:100%;
                                        height:{{ max(8, $pct) }}%;
                                        min-height:8px;
                                        background: {{ $i === (count($chartVals) - 1) ? 'var(--sppg-primary)' : 'linear-gradient(180deg, #22a05a, var(--sppg-primary))' }};
                                        border-radius:5px 5px 0 0;
                                        opacity: {{ $i === (count($chartVals) - 1) ? '1' : '.75' }};
                                        transition: opacity .3s;
                                    " title="{{ $chartDays[$i] }}: {{ number_format($val) }} porsi"></div>
                                </div>
                                <div style="font-size:.68rem; color:var(--sppg-text-muted); font-weight:600">{{ $chartDays[$i] }}</div>
                            </div>
                            @endforeach
                        </div>

                        <hr style="border-color:var(--sppg-border); margin: 14px 0 10px">
                    </div>

                    {{-- Legend / stats --}}
                    <div class="row g-2 w-100">
                        <div class="col-4 text-center">
                            <div style="font-size:1.05rem; font-weight:800; color:var(--sppg-primary)">
                                {{ number_format($chartTotal7Hari) }}
                            </div>
                            <div style="font-size:.68rem; color:var(--sppg-text-muted)">Total 7 Hari</div>
                        </div>
                        <div class="col-4 text-center">
                            <div style="font-size:1.05rem; font-weight:800; color:var(--sppg-accent)">
                                {{ number_format($chartRataRata) }}
                            </div>
                            <div style="font-size:.68rem; color:var(--sppg-text-muted)">Rata-rata</div>
                        </div>
                        <div class="col-4 text-center">
                            <div style="font-size:1.05rem; font-weight:800; color:#3b82f6">
                                {{ number_format($chartTertinggi) }}
                            </div>
                            <div style="font-size:.68rem; color:var(--sppg-text-muted)">Tertinggi</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- =============================================
        ROW: QUICK ACTIONS + ACTIVITY + SEKOLAH
    ============================================= --}}
    <div class="row g-3 mb-4">

        {{-- Quick Actions --}}
        <div class="col-12 col-lg-4">
            <div class="panel-card h-100">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="bi bi-lightning-charge"></i>
                        Aksi Cepat
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('bahan-masuk.index') }}" class="quick-action-btn">
                                <i class="bi bi-box-arrow-in-down"></i>
                                Bahan Masuk
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('penggunaan-bahan.index') }}" class="quick-action-btn accent">
                                <i class="bi bi-fire" style="color:var(--sppg-accent)"></i>
                                Penggunaan
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('sekolah.index') }}" class="quick-action-btn">
                                <i class="bi bi-truck"></i>
                                Distribusi
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('supplier.index') }}" class="quick-action-btn">
                                <i class="bi bi-shop"></i>
                                Supplier
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('bahan-baku.create') }}" class="quick-action-btn">
                                <i class="bi bi-plus-circle"></i>
                                Tambah Bahan
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('laporan.index') }}" class="quick-action-btn accent">
                                <i class="bi bi-file-earmark-bar-graph" style="color:var(--sppg-accent)"></i>
                                Laporan Stok
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity Feed --}}
        <div class="col-12 col-lg-4">
            <div class="panel-card h-100">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="bi bi-clock-history"></i>
                        Aktivitas Terbaru
                    </div>
                    <a href="{{ route('bahan-baku.index') }}" style="font-size:.72rem; color:var(--sppg-primary); text-decoration:none; font-weight:600">
                        Semua
                    </a>
                </div>
                <div class="panel-body p-0 px-3">
                    <ul class="activity-feed">
                        @forelse($activityFeed as $act)
                        <li>
                            <div class="activity-dot {{ $act['dot'] }}"><i class="bi {{ $act['icon'] }}"></i></div>
                            <div class="activity-content">
                                <div class="ac-title">{{ $act['title'] }}</div>
                                <div class="ac-meta"><i class="bi bi-info-circle me-1"></i>{{ $act['meta'] }}</div>
                            </div>
                        </li>
                        @empty
                        <li class="py-4 text-center text-muted">
                            Belum ada riwayat aktivitas terbaru.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- Sekolah Penerima Hari Ini --}}
        <div class="col-12 col-lg-4">
            <div class="panel-card h-100">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="bi bi-building"></i>
                        Sekolah Penerima Hari Ini
                    </div>
                    <span class="badge" style="background:var(--sppg-primary-lt); color:var(--sppg-primary); font-size:.7rem; font-weight:600; padding:4px 10px; border-radius:20px">
                        {{ $totalSekolah }} Sekolah
                    </span>
                </div>
                <div class="panel-body p-0 px-3">
                    @forelse($sekolahList as $s)
                    <div class="sekolah-item">
                        <div class="sekolah-avatar">{{ strtoupper(substr($s->nama_sekolah, 0, 2)) }}</div>
                        <div style="flex:1; min-width:0">
                            <div class="sekolah-name text-truncate">{{ $s->nama_sekolah }}</div>
                            <div class="sekolah-detail">{{ $s->kecamatan ?? $s->jenjang }} · {{ number_format($s->porsi) }} porsi</div>
                        </div>
                        @if($s->status_distribusi === 'terkirim')
                            <span style="font-size:.65rem; font-weight:600; background:#dcfce7; color:#15803d; padding:2px 8px; border-radius:20px; white-space:nowrap">
                                <i class="bi bi-check2"></i> Terkirim
                            </span>
                        @elseif($s->status_distribusi === 'proses')
                            <span style="font-size:.65rem; font-weight:600; background:#fef3c7; color:#b45309; padding:2px 8px; border-radius:20px; white-space:nowrap">
                                <i class="bi bi-clock"></i> Proses
                            </span>
                        @else
                            <span style="font-size:.65rem; font-weight:600; background:#f1f5f9; color:#64748b; padding:2px 8px; border-radius:20px; white-space:nowrap">
                                <i class="bi bi-hourglass-split"></i> Menunggu
                            </span>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        Belum ada data sekolah penerima.
                    </div>
                    @endforelse

                    <div class="text-center pt-3 pb-1">
                        <a href="{{ route('sekolah.index') }}"
                        style="font-size:.75rem; color:var(--sppg-primary); font-weight:600; text-decoration:none">
                            Lihat Jadwal Lengkap <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @endsection