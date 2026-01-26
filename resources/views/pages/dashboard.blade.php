
@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* Dashboard Container */
    .dashboard-container {
        background: transparent;
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
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        color: white;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
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

    /* Card Colors - Subtle & Elegant */
    .icon-primary {
        background: #f0f5ed;
        color: #556b2f;
    }

    .icon-info {
        background: #ebf5fb;
        color: #3498db;
    }

    .icon-success {
        background: #eafaf1;
        color: #27ae60;
    }

    .icon-warning {
        background: #fef5e7;
        color: #f39c12;
    }

    .icon-danger {
        background: #fadbd8;
        color: #e74c3c;
    }

    /* Colorful Card Variations - Harmonious with Olive Green Theme */
    .stat-card.card-purple {
        background: #6c63ff;
    }
    
    .stat-card.card-cyan {
        background: #17a2b8;
    }
    
    .stat-card.card-green {
        background: #4A7C2C;
    }
    
    .stat-card.card-orange {
        background: #fd7e14;
    }
    
    .stat-card.card-teal {
        background: #20c997;
    }
    
    .stat-card.card-warning {
        background: #f39c12;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-value {
            font-size: 24px;
        }

        .stat-icon-wrapper {
            width: 42px;
            height: 42px;
        }

        .stat-icon {
            font-size: 18px;
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
        <!-- Wilayah Kampung Card -->
        <div class="stat-card card-purple">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $hamletCount ?? 0 }}</div>
                        <div class="stat-label">Dusun</div>
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
                        <div class="stat-value">{{ $totalResidents ?? 0 }}</div>
                        <div class="stat-label">Penduduk</div>
                    </div>
                    <i class="fas fa-users stat-icon"></i>
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
                        <div class="stat-value">{{ $familyCount ?? 0 }}</div>
                        <div class="stat-label">Keluarga</div>
                    </div>
                    <i class="fas fa-home stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ Route::has('families.index') ? route('families.index') : '#' }}">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Lembaga Card -->
        <div class="stat-card card-orange">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $institutionsCount ?? 0 }}</div>
                        <div class="stat-label">Lembaga</div>
                    </div>
                    <i class="fas fa-building stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ route('village-institutions.index') }}">
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
                <a href="{{ route('online-submission.index') }}">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Verifikasi User Card -->
        <div class="stat-card card-warning">
            <div class="stat-card-body">
                <div class="stat-content">
                    <div class="stat-text">
                        <div class="stat-value">{{ $pendingUsers ?? 0 }}</div>
                        <div class="stat-label">Verifikasi User Warga</div>
                    </div>
                    <i class="fas fa-user-check stat-icon"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <a href="{{ route('user-verification.index') }}">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('chart-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset ('template/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset ('template/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset ('template/js/demo/chart-pie-demo.js') }}"></script>
@endpush