@extends('layouts.app')

@section('title', 'Data Penduduk')

@push('styles')
<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #fafdfb 100%);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 3px 15px rgba(74, 124, 44, 0.12);
        border-left: 5px solid #4a7c2c;
        position: relative;
        overflow: hidden;
    }

    .page-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(74, 124, 44, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header h1 {
        color: #2c3e50;
    }

    .page-header p {
        color: #7f8c8d;
    }

    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
    }

    .page-header p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: white;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
        text-decoration: none;
        color: white;
    }

    .stat-card.active {
        border: 3px solid white;
        box-shadow: 0 8px 30px rgba(0,0,0,0.35);
    }

    .stat-card.card-primary {
        background: #4A7C2C;
    }

    .stat-card.card-info {
        background: #17a2b8;
    }

    .stat-card.card-danger {
        background: #e74c3c;
    }

    .stat-card h3 {
        margin: 0 0 5px 0;
        font-size: 34px;
        font-weight: bold;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .stat-card i {
        color: white;
        font-size: 26px;
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    .stat-card:hover i {
        transform: scale(1.15) rotate(5deg);
        opacity: 1;
    }

    .stat-card p {
        margin: 0;
        color: rgba(255, 255, 255, 0.95);
        font-size: 14px;
        font-weight: 500;
    }

    .filters-card {
        background: linear-gradient(135deg, #ffffff 0%, #fcfefd 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(74, 124, 44, 0.1);
        border: 1px solid #e8f5e9;
        position: relative;
        overflow: hidden;
    }

    .filters-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #4a7c2c 0%, #6ab04c 50%, #4a7c2c 100%);
    }

    .data-card {
        background: linear-gradient(135deg, #ffffff 0%, #fefffe 100%);
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        border-top: 3px solid #4a7c2c;
    }

    .table-responsive {
        border-radius: 8px;
        overflow-x: auto;
        overflow-y: hidden;
        position: relative;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .table {
        margin-bottom: 0;
        min-width: 1200px;
    }

    .table thead th {
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
        color: white;
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.8px;
        padding: 18px 15px;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(74, 124, 44, 0.2);
    }

    .table tbody td {
        vertical-align: middle;
        padding: 15px;
        font-size: 14px;
        border-bottom: 1px solid #e8f5e9;
        transition: all 0.3s ease;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #fafdfb;
    }

    .table tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    .table tbody tr:hover {
        background: linear-gradient(90deg, rgba(74, 124, 44, 0.08) 0%, rgba(74, 124, 44, 0.03) 100%);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(74, 124, 44, 0.15);
        position: relative;
        z-index: 1;
    }

    .table tbody tr:hover td {
        color: #2c3e50;
        font-weight: 500;
    }

    .badge-status {
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .badge-status::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }

    .badge-active {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .badge-active:hover {
        background: #c3e6cb;
        transform: scale(1.05);
    }

    .badge-inactive {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .badge-inactive:hover {
        background: #f5c6cb;
        transform: scale(1.05);
    }

    .btn-action {
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 13px;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .btn-action:hover::before {
        width: 200px;
        height: 200px;
    }

    .btn-action:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    }

    .btn-action:active {
        transform: translateY(-1px) scale(1.02);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
        color: white;
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #138496 0%, #117a8b 100%);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
        color: white;
    }

    .btn-light {
        background: #4A7C2C;
        color: white;
        border: none;
    }

    .btn-light:hover {
        background: #355719;
        color: white;
    }

    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-box input {
        flex: 1;
        padding-left: 15px;
        padding-right: 60px;
        border: 1px solid #ddd;
        border-radius: 8px;
        height: 45px;
    }

    .search-box .search-btn {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 50px;
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
        border: none;
        border-radius: 0 8px 8px 0;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-box .search-btn:hover {
        background: linear-gradient(135deg, #355719 0%, #2a4513 100%);
        transform: scale(1.05);
    }

    .search-box .search-btn i {
        font-size: 16px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
        border: none;
        color: white;
        padding: 11px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #355719 0%, #2a4513 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 124, 44, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state h5 {
        margin-bottom: 10px;
        color: #666;
    }

    /* Pagination Styles */
    .pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-pagination {
        background: white;
        border: 2px solid #4A7C2C;
        color: #4A7C2C;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-pagination:hover:not(:disabled) {
        background: #4A7C2C;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 124, 44, 0.3);
    }

    .btn-pagination:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        border-color: #ddd;
        color: #999;
    }

    .pagination-info {
        font-weight: 600;
        color: #2c3e50;
        padding: 10px 20px;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-users mr-2"></i>Data Penduduk</h1>
                <p>Kelola data penduduk Kampung Badran Sari</p>
            </div>
            <a href="{{ route('residents.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus mr-2"></i> Tambah Penduduk
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="animation: slideDown 0.3s ease-out;">
            <i class="fas fa-check-circle mr-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="animation: slideDown 0.3s ease-out;">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card card-primary" data-filter="all" onclick="filterByCard(this, 'all')">
            <h3>{{ $stats['total'] }}</h3>
            <p><i class="fas fa-users mr-1"></i> Total Penduduk</p>
        </div>
        <div class="stat-card card-info" data-filter="active" onclick="filterByCard(this, 'active')">
            <h3>{{ $stats['active'] }}</h3>
            <p><i class="fas fa-check-circle mr-1"></i> Status Aktif</p>
        </div>
        <div class="stat-card card-danger" data-filter="inactive" onclick="filterByCard(this, 'inactive')">
            <h3>{{ $stats['inactive'] }}</h3>
            <p><i class="fas fa-times-circle mr-1"></i> Status Tidak Aktif</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="search-box">
                    <input type="text" 
                           id="searchInput" 
                           class="form-control" 
                           placeholder="Cari berdasarkan NIK, nama, alamat, atau pekerjaan...">
                    <button type="button" class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <select id="statusFilter" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="table-responsive">
            <table class="table" id="residentsTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>No. KK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Dusun</th>
                        <th>No. Telepon</th>
                        <th>Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($residents as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->nik }}</strong></td>
                            <td>{{ $item->family_card_number ?? '-' }}</td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>{{ Str::limit($item->address, 40) }}</td>
                            <td>{{ $item->hamlet ?? '-' }}</td>
                            <td>{{ $item->phone ?? '-' }}</td>
                            <td>
                                <span class="badge-status {{ $item->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $item->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button"
                                        class="btn btn-info btn-action"
                                        data-toggle="modal"
                                        data-target="#detailModal{{ $item->id }}"
                                        title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 8px;">
                                    <a href="{{ route('residents.edit', $item->id) }}" 
                                       class="btn btn-warning btn-action"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-danger btn-action"
                                            data-toggle="modal"
                                            data-target="#confirmationDelete{{ $item->id }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-users"></i>
                                            <h5>Belum Ada Data Penduduk</h5>
                                            <p>Klik tombol "Tambah Penduduk" untuk menambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
            </table>
        </div>
        
        <!-- Client-side Pagination -->
        <div id="paginationControls" class="d-flex justify-content-between align-items-center mt-4 px-3">
            <div id="paginationInfo" class="text-muted"></div>
            <div class="pagination-wrapper">
                <button class="btn-pagination" id="prevBtn">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <span class="pagination-info" id="pageInfo"></span>
                <button class="btn-pagination" id="nextBtn">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus - Semua Modal di Luar Tabel -->
    @foreach ($residents as $item)
        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title"><i class="fas fa-id-card mr-2"></i>Detail Data Penduduk</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Data Identitas -->
                            <div class="col-12 mb-3">
                                <h6 class="font-weight-bold text-info border-bottom pb-2">
                                    <i class="fas fa-id-card mr-2"></i>Data Identitas
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">NIK</label>
                                <p class="font-weight-bold">{{ $item->nik }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Nomor KK</label>
                                <p class="font-weight-bold">{{ $item->family_card_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Nama Lengkap</label>
                                <p class="font-weight-bold">{{ $item->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Jenis Kelamin</label>
                                <p class="font-weight-bold">{{ $item->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Tempat Lahir</label>
                                <p class="font-weight-bold">{{ $item->birth_place }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Tanggal Lahir</label>
                                <p class="font-weight-bold">{{ \Carbon\Carbon::parse($item->birth_date)->format('d F Y') }}</p>
                            </div>
                            
                            <!-- Data Kontak & Lokasi -->
                            <div class="col-12 mt-3 mb-3">
                                <h6 class="font-weight-bold text-info border-bottom pb-2">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Data Kontak & Lokasi
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">No. Telepon</label>
                                <p class="font-weight-bold">{{ $item->phone ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Dusun</label>
                                <p class="font-weight-bold">{{ $item->hamlet ?? '-' }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="text-muted small mb-1">Alamat Lengkap</label>
                                <p class="font-weight-bold">{{ $item->address }}</p>
                            </div>
                            
                            <!-- Data Lainnya -->
                            <div class="col-12 mt-3 mb-3">
                                <h6 class="font-weight-bold text-info border-bottom pb-2">
                                    <i class="fas fa-info-circle mr-2"></i>Data Lainnya
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Agama</label>
                                <p class="font-weight-bold">{{ $item->religion }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Status Perkawinan</label>
                                <p class="font-weight-bold">
                                    @switch($item->marital_status)
                                        @case('Single') Belum Menikah @break
                                        @case('Married') Menikah @break
                                        @case('Divorced') Cerai @break
                                        @case('Widowed') Janda/Duda @break
                                        @default {{ $item->marital_status }}
                                    @endswitch
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Pekerjaan</label>
                                <p class="font-weight-bold">{{ $item->occupation }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Status Penduduk</label>
                                <p>
                                    <span class="badge-status {{ $item->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                                        @switch($item->status)
                                            @case('active') Aktif @break
                                            @case('moved') Pindah @break
                                            @case('deceased') Meninggal @break
                                            @default {{ $item->status }}
                                        @endswitch
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('residents.edit', $item->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-2"></i>Edit Data
                        </a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Delete -->
        @include('components.confirmation-delete', [
            'id' => $item->id,
            'name' => $item->name,
            'nik' => $item->nik,
            'route' => route('residents.destroy', $item->id)
        ])
    @endforeach

@endsection

@push('scripts')
<script>
console.log('Loading residents search script...');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing search...');
    
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const searchBtn = document.getElementById('searchBtn');
    const table = document.getElementById('residentsTable');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageInfo = document.getElementById('pageInfo');
    const paginationInfo = document.getElementById('paginationInfo');
    
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredRows = [];
    
    console.log('searchInput:', searchInput);
    console.log('statusFilter:', statusFilter);
    console.log('searchBtn:', searchBtn);
    console.log('table:', table);
    
    if (!searchInput || !statusFilter || !searchBtn || !table) {
        console.error('Element tidak ditemukan!');
        return;
    }

    function filterAndPaginate() {
        console.log('Filtering and paginating...');
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const allRows = Array.from(table.querySelectorAll('tbody tr'));
        
        console.log('Search term:', searchTerm);
        console.log('Status value:', statusValue);
        console.log('Total rows:', allRows.length);
        
        // Filter rows
        filteredRows = allRows.filter(row => {
            if (row.cells.length <= 1) return false;

            const nik = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
            const kk = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
            const name = row.cells[3] ? row.cells[3].textContent.toLowerCase() : '';
            const address = row.cells[4] ? row.cells[4].textContent.toLowerCase() : '';
            const hamlet = row.cells[5] ? row.cells[5].textContent.toLowerCase() : '';
            const phone = row.cells[6] ? row.cells[6].textContent.toLowerCase() : '';
            const status = row.cells[7] ? row.cells[7].textContent.toLowerCase().trim() : '';

            // Debug log untuk beberapa row pertama
            if (filteredRows.length < 3) {
                console.log('Row status text:', status, '| statusValue:', statusValue);
            }

            const matchesSearch = searchTerm === '' || 
                                nik.includes(searchTerm) || 
                                kk.includes(searchTerm) ||
                                name.includes(searchTerm) || 
                                address.includes(searchTerm) ||
                                hamlet.includes(searchTerm) ||
                                phone.includes(searchTerm);
            
            let matchesStatus = true;
            if (statusValue === 'active') {
                matchesStatus = status === 'aktif';
            } else if (statusValue === 'inactive') {
                matchesStatus = status === 'tidak aktif';
            }
            // If statusValue is empty (''), matchesStatus stays true (show all)

            return matchesSearch && matchesStatus;
        });
        
        console.log('Filtered rows:', filteredRows.length);
        
        // Reset to first page when filtering
        currentPage = 1;
        displayPage();
    }
    
    function displayPage() {
        const allRows = Array.from(table.querySelectorAll('tbody tr'));
        
        // Hide all rows first
        allRows.forEach(row => row.style.display = 'none');
        
        // Calculate pagination
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        
        // Show rows for current page and update row numbers
        filteredRows.slice(start, end).forEach((row, index) => {
            row.style.display = '';
            // Update row number
            if (row.cells[0]) {
                row.cells[0].textContent = start + index + 1;
            }
        });
        
        // Update pagination info
        const showing = filteredRows.length > 0 ? start + 1 : 0;
        const showingEnd = Math.min(end, filteredRows.length);
        paginationInfo.textContent = `Menampilkan ${showing} - ${showingEnd} dari ${filteredRows.length} data`;
        pageInfo.textContent = `Halaman ${currentPage} dari ${totalPages || 1}`;
        
        // Update button states
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage >= totalPages;
        
        if (prevBtn.disabled) {
            prevBtn.style.opacity = '0.5';
            prevBtn.style.cursor = 'not-allowed';
        } else {
            prevBtn.style.opacity = '1';
            prevBtn.style.cursor = 'pointer';
        }
        
        if (nextBtn.disabled) {
            nextBtn.style.opacity = '0.5';
            nextBtn.style.cursor = 'not-allowed';
        } else {
            nextBtn.style.opacity = '1';
            nextBtn.style.cursor = 'pointer';
        }
        
        console.log('Displaying page', currentPage, 'of', totalPages);
    }

    // Filter on keyup
    searchInput.addEventListener('keyup', function() {
        console.log('Keyup event triggered');
        filterAndPaginate();
    });
    
    // Filter on status change
    statusFilter.addEventListener('change', function() {
        console.log('Status change event triggered');
        filterAndPaginate();
    });
    
    // Filter on button click
    searchBtn.addEventListener('click', function() {
        console.log('Search button clicked');
        filterAndPaginate();
    });
    
    // Filter on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            console.log('Enter key pressed');
            filterAndPaginate();
        }
    });
    
    // Pagination controls
    prevBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            displayPage();
        }
    });
    
    nextBtn.addEventListener('click', function() {
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayPage();
        }
    });
    
    // Initialize
    filterAndPaginate();
    console.log('Search initialized successfully!');
});

// Function to filter by card click
function filterByCard(element, filterType) {
    console.log('Card clicked:', filterType);
    
    // Remove active class from all cards
    const allCards = document.querySelectorAll('.stat-card');
    allCards.forEach(card => card.classList.remove('active'));
    
    // Get the status filter dropdown
    const statusFilter = document.getElementById('statusFilter');
    
    if (filterType === 'all') {
        // Show all residents
        statusFilter.value = '';
        element.classList.add('active');
    } else if (filterType === 'active') {
        // Show only active residents
        statusFilter.value = 'active';
        element.classList.add('active');
    } else if (filterType === 'inactive') {
        // Show only inactive residents
        statusFilter.value = 'inactive';
        element.classList.add('active');
    }
    
    // Trigger the filter
    statusFilter.dispatchEvent(new Event('change'));
}

// Auto-dismiss alert setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush
