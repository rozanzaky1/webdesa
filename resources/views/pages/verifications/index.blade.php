@extends('layouts.app')

@section('title', 'Dashboard Verifikasi')

@push('styles')
<style>
    /* Container */
    .verifications-container {
        padding: 20px 0;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .page-header h1 {
        color: #5a5c69;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    /* Stats Cards Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--card-color) 0%, var(--card-color-light) 100%);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        border-color: var(--card-color);
    }

    .stat-card.card-primary { 
        --card-color: #4e73df;
        --card-color-light: #6c8aec;
    }
    .stat-card.card-warning { 
        --card-color: #f6c23e;
        --card-color-light: #f8d162;
    }
    .stat-card.card-success { 
        --card-color: #1cc88a;
        --card-color-light: #36d6a0;
    }
    .stat-card.card-danger { 
        --card-color: #e74a3b;
        --card-color-light: #ec5e50;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        background: linear-gradient(135deg, var(--card-color) 0%, var(--card-color-light) 100%);
    }

    .stat-icon {
        font-size: 1.5rem;
        color: white;
    }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #858796;
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #2e3338;
        line-height: 1;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
    }

    .card-section {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid #e3e6f0;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e3e6f0;
    }

    .section-header h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #5a5c69;
        margin: 0;
    }

    /* Table Styling */
    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }

    .table thead th {
        background: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
        color: #5a5c69;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        padding: 15px;
        text-align: left;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e3e6f0;
        color: #5a5c69;
        font-size: 0.9rem;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f8f9fc;
    }

    /* Badges */
    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-success {
        background: #d4f4e7;
        color: #1cc88a;
    }

    .badge-danger {
        background: #f8d7da;
        color: #842029;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 0.8rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        cursor: pointer;
    }

    .btn-approve {
        background: #1cc88a;
        color: white;
    }

    .btn-approve:hover {
        background: #17a673;
        color: white;
    }

    .btn-reject {
        background: #e74a3b;
        color: white;
    }

    .btn-reject:hover {
        background: #c9302c;
        color: white;
    }

    .stats-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .stats-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #e3e6f0;
    }

    .stats-list li:last-child {
        border-bottom: none;
    }

    .stats-list li:hover {
        background-color: #f8f9fc;
    }

    .stats-label {
        font-weight: 600;
        color: #5a5c69;
        font-size: 0.9rem;
    }

    .stats-value {
        font-weight: 700;
        color: #4e73df;
        font-size: 1.1rem;
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-value {
            font-size: 1.75rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="verifications-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-check-circle text-danger"></i> Verifikasi Pengajuan</h1>
            <p class="text-muted mb-0">Kelola dan verifikasi pengajuan dokumen kependudukan</p>
        </div>
    </div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card card-primary">
        <div class="stat-icon-wrapper">
            <i class="fas fa-clipboard-list stat-icon"></i>
        </div>
        <div class="stat-label">Total Pengajuan</div>
        <div class="stat-value">{{ $totalVerifications }}</div>
    </div>

    <div class="stat-card card-warning">
        <div class="stat-icon-wrapper">
            <i class="fas fa-clock stat-icon"></i>
        </div>
        <div class="stat-label">Menunggu Verifikasi</div>
        <div class="stat-value">{{ $statusStats['Menunggu'] }}</div>
    </div>

    <div class="stat-card card-success">
        <div class="stat-icon-wrapper">
            <i class="fas fa-check-circle stat-icon"></i>
        </div>
        <div class="stat-label">Disetujui</div>
        <div class="stat-value">{{ $statusStats['Disetujui'] }}</div>
    </div>

    <div class="stat-card card-danger">
        <div class="stat-icon-wrapper">
            <i class="fas fa-times-circle stat-icon"></i>
        </div>
        <div class="stat-label">Ditolak</div>
        <div class="stat-value">{{ $statusStats['Ditolak'] }}</div>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Verifications Table -->
    <div class="card-section">
        <div class="section-header">
            <h2><i class="fas fa-list"></i> Daftar Pengajuan</h2>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemohon</th>
                        <th>Jenis Pengajuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($verifications as $index => $verification)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $verification['applicant_name'] }}</strong></td>
                        <td>{{ $verification['request_type'] }}</td>
                        <td>{{ date('d/m/Y', strtotime($verification['date'])) }}</td>
                        <td>
                            @if($verification['status'] === 'Menunggu')
                                <span class="badge badge-warning">{{ $verification['status'] }}</span>
                            @elseif($verification['status'] === 'Disetujui')
                                <span class="badge badge-success">{{ $verification['status'] }}</span>
                            @else
                                <span class="badge badge-danger">{{ $verification['status'] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($verification['status'] === 'Menunggu')
                            <div class="action-buttons">
                                <button class="btn-action btn-approve">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                                <button class="btn-action btn-reject">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </div>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Request Type Stats -->
    <div class="card-section">
        <div class="section-header">
            <h2><i class="fas fa-chart-pie"></i> Statistik Jenis</h2>
        </div>

        <ul class="stats-list">
            @foreach($requestTypeStats as $type => $count)
            <li>
                <span class="stats-label">{{ $type }}</span>
                <span class="stats-value">{{ $count }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
</div>
@endsection
