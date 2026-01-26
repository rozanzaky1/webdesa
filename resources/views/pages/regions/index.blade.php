@extends('layouts.app')

@section('title', 'Dashboard Wilayah Kampung')

@push('styles')
<style>
    /* Container */
    .regions-container {
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
    .stat-card.card-success { 
        --card-color: #1cc88a;
        --card-color-light: #36d6a0;
    }
    .stat-card.card-info { 
        --card-color: #36b9cc;
        --card-color-light: #4dd4e8;
    }
    .stat-card.card-warning { 
        --card-color: #f6c23e;
        --card-color-light: #f8d162;
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

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid #e3e6f0;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e3e6f0;
    }

    .table-header h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #5a5c69;
        margin: 0;
    }

    .btn-add {
        background: #4e73df;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .btn-add:hover {
        background: #2e59d9;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
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

    .badge-primary {
        background: #e7f1ff;
        color: #4e73df;
    }

    .badge-success {
        background: #d4f4e7;
        color: #1cc88a;
    }

    /* Action Buttons */
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

    .btn-edit {
        background: #fff3cd;
        color: #856404;
    }

    .btn-edit:hover {
        background: #f6c23e;
        color: #5a5c69;
    }

    .btn-delete {
        background: #f8d7da;
        color: #842029;
    }

    .btn-delete:hover {
        background: #e74a3b;
        color: white;
    }

    /* Responsive */
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

        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .table {
            font-size: 0.85rem;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="regions-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-map-marker-alt text-primary"></i> Wilayah Kampung</h1>
            <p class="text-muted mb-0">Kelola data wilayah dan pembagian RT/RW</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card card-primary">
            <div class="stat-icon-wrapper">
                <i class="fas fa-map-marked-alt stat-icon"></i>
            </div>
            <div class="stat-label">Total Wilayah</div>
            <div class="stat-value">{{ $totalRegions }}</div>
        </div>

        <div class="stat-card card-success">
            <div class="stat-icon-wrapper">
                <i class="fas fa-users stat-icon"></i>
            </div>
            <div class="stat-label">Total Penduduk</div>
            <div class="stat-value">{{ $totalResidents }}</div>
        </div>

        <div class="stat-card card-info">
            <div class="stat-icon-wrapper">
                <i class="fas fa-home stat-icon"></i>
            </div>
            <div class="stat-label">Total Keluarga</div>
            <div class="stat-value">{{ $totalFamilies }}</div>
        </div>

        <div class="stat-card card-warning">
            <div class="stat-icon-wrapper">
                <i class="fas fa-chart-line stat-icon"></i>
            </div>
            <div class="stat-label">Rata-rata / Wilayah</div>
            <div class="stat-value">{{ $averageResidentsPerRegion }}</div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-header">
            <h2><i class="fas fa-list"></i> Daftar Wilayah</h2>
            <a href="#" class="btn-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Wilayah</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama Wilayah</th>
                        <th width="20%">Jumlah Penduduk</th>
                        <th width="20%">Jumlah Keluarga</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($regions as $index => $region)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $region['name'] }}</strong></td>
                        <td><span class="badge badge-primary">{{ $region['total_residents'] }} Orang</span></td>
                        <td><span class="badge badge-success">{{ $region['total_families'] }} KK</span></td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" class="btn-action btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
