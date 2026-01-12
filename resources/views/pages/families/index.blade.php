@extends('layouts.app')

@section('title', 'Dashboard Keluarga')

@push('styles')
<style>
    /* Container */
    .families-container {
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
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
    }

    .stat-card.card-primary { 
        background: #4A7C2C;
    }
    .stat-card.card-success { 
        background: #17a2b8;
    }
    .stat-card.card-info { 
        background: #6c63ff;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        background: rgba(255, 255, 255, 0.2);
    }

    .stat-icon {
        font-size: 1.5rem;
        color: white;
    }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: white;
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

    .table {
        width: 100%;
        margin-bottom: 0;
    }

    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        color: #5a5c69;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        padding: 15px;
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
<div class="families-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-home text-success"></i> Data Keluarga</h1>
            <p class="text-muted mb-0">Kelola informasi keluarga dan anggota keluarga</p>
        </div>
    </div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card card-primary">
        <div class="stat-icon-wrapper">
            <i class="fas fa-home stat-icon"></i>
        </div>
        <div class="stat-label">Total Keluarga</div>
        <div class="stat-value">{{ $totalFamilies }}</div>
    </div>

    <div class="stat-card card-success">
        <div class="stat-icon-wrapper">
            <i class="fas fa-users stat-icon"></i>
        </div>
        <div class="stat-label">Total Anggota</div>
        <div class="stat-value">{{ $totalResidents }}</div>
    </div>

    <div class="stat-card card-info">
        <div class="stat-icon-wrapper">
            <i class="fas fa-calculator stat-icon"></i>
        </div>
        <div class="stat-label">Rata-rata Anggota</div>
        <div class="stat-value">{{ $averageFamilySize }}</div>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Top 10 Families -->
    <div class="card-section">
        <div class="section-header">
            <h2><i class="fas fa-users"></i> Top 10 Keluarga Terbesar</h2>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alamat Keluarga</th>
                        <th>Jumlah Anggota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($families as $index => $family)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $family->address }}</strong></td>
                        <td><span class="badge badge-primary">{{ $family->members }} Orang</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Family Size Stats -->
    <div class="card-section">
        <div class="section-header">
            <h2><i class="fas fa-chart-pie"></i> Statistik Ukuran</h2>
        </div>

        <ul class="stats-list">
            @foreach($familySizeStats as $label => $count)
            <li>
                <span class="stats-label">{{ $label }}</span>
                <span class="stats-value">{{ $count }} KK</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
</div>
@endsection
