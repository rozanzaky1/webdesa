
@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* Dashboard Container */
    .dashboard-container {
        background: #f4f6f9;
        min-height: 100vh;
        padding: 20px;
    }

    /* Dashboard Header */
    .dashboard-title {
        font-size: 13px;
        font-weight: 700;
        color: #2b2b2b;
        letter-spacing: 1px;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e0e0e0;
    }

    /* Stats Cards Grid */
    .stats-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 30px;
    }

    /* Stat Card Styling */
    .stat-card {
        width: 260px;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        color: white;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.18);
    }

    /* Card Body */
    .stat-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
        position: relative;
    }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-text {
        flex: 1;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 500;
        opacity: 0.95;
        line-height: 1.3;
    }

    .stat-icon {
        font-size: 42px;
        opacity: 0.5;
        line-height: 1;
        margin-left: 15px;
    }

    /* Card Footer */
    .stat-card-footer {
        background: rgba(0, 0, 0, 0.15);
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .stat-card-footer a {
        color: white;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: opacity 0.2s;
    }

    .stat-card-footer a:hover {
        opacity: 0.8;
    }

    .stat-card-footer i {
        font-size: 11px;
    }

    /* Card Colors */
    .card-purple { background: #685bc7; }
    .card-cyan { background: #00b5f2; }
    .card-green { background: #009f52; }
    .card-orange { background: #f1a52a; }
    .card-teal { background: #15b1b8; }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            gap: 15px;
        }
        .stat-card {
            width: calc(50% - 8px);
        }
    }

    @media (max-width: 768px) {
        .stat-card {
            width: 100%;
        }
        
        .stat-value {
            font-size: 32px;
        }

        .stat-icon {
            font-size: 36px;
        }
    }

    @media (min-width: 1400px) {
        .stat-card {
            width: 280px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-title">BERANDA</div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Wilayah Desa Card -->
        <div class="stat-card card-purple">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $hamletCount ?? 0 }}</div>
                        <div class="stat-label">Wilayah Desa (Dusun)</div>
                    </div>
                    <i class="fas fa-map-marker-alt stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ route('hamlets.index') }}">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Penduduk Card -->
        <div class="stat-card card-cyan">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $totalResidents ?? 201 }}</div>
                        <div class="stat-label">Penduduk</div>
                    </div>
                    <i class="fas fa-user stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ Route::has('residents.index') ? route('residents.index') : '#' }}">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Keluarga Card -->
        <div class="stat-card card-green">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $familyCount ?? 50 }}</div>
                        <div class="stat-label">Keluarga</div>
                    </div>
                    <i class="fas fa-users stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ Route::has('families.index') ? route('families.index') : '#' }}">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Surat Tercetak Card -->
        <div class="stat-card card-orange">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $printedLetters ?? 0 }}</div>
                        <div class="stat-label">Surat Tercetak</div>
                    </div>
                    <i class="fas fa-file-alt stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ route('online-submission.index') }}?status=approved">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Verifikasi Pengajuan Card -->
        <div class="stat-card card-teal">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $pendingVerifications ?? 0 }}</div>
                        <div class="stat-label">Verifikasi Pengajuan</div>
                    </div>
                    <i class="fas fa-id-card stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ route('online-submission.index') }}?status=pending">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection