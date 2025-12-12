@extends('layouts.app')

@section('title', 'Dashboard Surat')

@push('styles')
<style>
    /* Container */
    .letters-container {
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
        grid-template-columns: repeat(2, 1fr);
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

    .badge-success {
        background: #d4f4e7;
        color: #1cc88a;
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
<div class="letters-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-file-alt text-warning"></i> Surat Menyurat</h1>
            <p class="text-muted mb-0">Kelola dan cetak surat keterangan desa</p>
        </div>
    </div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card card-primary">
        <div class="stat-icon-wrapper">
            <i class="fas fa-file-alt stat-icon"></i>
        </div>
        <div class="stat-label">Total Surat Tercetak</div>
        <div class="stat-value">{{ $totalLetters }}</div>
    </div>

    <div class="stat-card card-warning">
        <div class="stat-icon-wrapper">
            <i class="fas fa-calendar-check stat-icon"></i>
        </div>
        <div class="stat-label">Surat Bulan Ini</div>
        <div class="stat-value">{{ $totalThisMonth }}</div>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Letters Table -->
    <div class="card-section">
        <div class="section-header">
            <h2><i class="fas fa-list"></i> Riwayat Surat</h2>
            <a href="#" class="btn-add">
                <i class="fas fa-plus"></i>
                <span>Cetak Surat Baru</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Nama Pemohon</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($letters as $index => $letter)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $letter['type'] }}</strong></td>
                        <td>{{ $letter['resident_name'] }}</td>
                        <td>{{ date('d/m/Y', strtotime($letter['date'])) }}</td>
                        <td><span class="badge badge-success">{{ $letter['status'] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Letter Type Stats -->
    <div class="card-section">
        <div class="section-header">
            <h2><i class="fas fa-chart-bar"></i> Statistik Jenis</h2>
        </div>

        <ul class="stats-list">
            @foreach($letterTypeStats as $type => $count)
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
