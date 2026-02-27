@extends('layouts.app')

@section('title', 'Verifikasi User Warga')

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
        margin: 0;
        font-size: 28px;
        font-weight: 600;
    }

    .page-header p {
        color: #7f8c8d;
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

    .stat-card.card-pending {
        background: #fd7e14;
    }

    .stat-card.card-approved {
        background: #4A7C2C;
    }

    .stat-card.card-total {
        background: #17a2b8;
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
        overflow-y: visible;
        position: relative;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        margin-bottom: 0;
        min-width: 1400px;
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

    .badge-approved {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .badge-approved:hover {
        background: #c3e6cb;
        transform: scale(1.05);
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .badge-pending:hover {
        background: #ffeaa7;
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

    .btn-success {
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #355719 0%, #2a4513 100%);
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

    .btn-warning {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
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

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        border: none;
        color: white;
        padding: 11px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268 0%, #4e555b 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
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
                <h1><i class="fas fa-user-check mr-2"></i>Verifikasi User Warga</h1>
                <p>Kelola verifikasi user yang mendaftar</p>
            </div>
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
        <div class="stat-card card-pending" data-filter="pending" onclick="filterByCard(this, 'pending')">
            <h3>{{ $stats['pending'] }}</h3>
            <p><i class="fas fa-clock mr-1"></i> Menunggu Verifikasi</p>
        </div>
        <div class="stat-card card-approved" data-filter="approved" onclick="filterByCard(this, 'approved')">
            <h3>{{ $stats['approved'] }}</h3>
            <p><i class="fas fa-check-circle mr-1"></i> Sudah Disetujui</p>
        </div>
        <div class="stat-card card-total" data-filter="all" onclick="filterByCard(this, 'all')">
            <h3>{{ $stats['total'] }}</h3>
            <p><i class="fas fa-users mr-1"></i> Total User Warga</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <form method="GET" action="{{ route('user-verification.index') }}" id="filterForm" class="row align-items-center">
            <div class="col-md-8">
                <div class="search-box">
                    <input type="text" 
                           name="search"
                           id="searchInput"
                           class="form-control" 
                           placeholder="Cari nama, email, atau NIK..."
                           value="{{ request('search') }}">
                    <button type="button" class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-control" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Sudah Disetujui</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="table-responsive">
            <table class="table" id="userTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIK</th>
                        <th>No. KK</th>
                        <th>Alamat</th>
                        <th>Dusun</th>
                        <th>No. Telepon</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nik ?? '-' }}</td>
                            <td>{{ $user->resident->family_card_number ?? '-' }}</td>
                            <td>{{ $user->resident->address ?? '-' }}</td>
                            <td>{{ $user->resident->hamlet ?? '-' }}</td>
                            <td>{{ $user->resident->phone ?? '-' }}</td>
                            <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span class="badge-status {{ $user->is_approved ? 'badge-approved' : 'badge-pending' }}">
                                    {{ $user->is_approved ? 'Disetujui' : 'Menunggu' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button"
                                        class="btn btn-info btn-action"
                                        data-toggle="modal"
                                        data-target="#detailModal{{ $user->id }}"
                                        title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 8px;">
                                    @if(!$user->is_approved)
                                        <button type="button"
                                                class="btn btn-success btn-action"
                                                data-toggle="modal"
                                                data-target="#approveModal{{ $user->id }}"
                                                title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-warning btn-action"
                                                data-toggle="modal"
                                                data-target="#rejectModal{{ $user->id }}"
                                                title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    <button type="button"
                                            class="btn btn-info btn-action"
                                            data-toggle="modal"
                                            data-target="#resetPasswordModal{{ $user->id }}"
                                            title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-danger btn-action"
                                            data-toggle="modal"
                                            data-target="#deleteModal{{ $user->id }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h5>Belum Ada User</h5>
                                    <p>Belum ada user yang sesuai dengan filter</p>
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
    <!-- Modal Konfirmasi - Semua Modal di Luar Tabel -->
    @foreach ($users as $user)
        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title"><i class="fas fa-user-circle mr-2"></i>Detail Data User</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Data Akun -->
                            <div class="col-12 mb-3">
                                <h6 class="font-weight-bold text-info border-bottom pb-2">
                                    <i class="fas fa-user-lock mr-2"></i>Data Akun
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Nama</label>
                                <p class="font-weight-bold">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Email</label>
                                <p class="font-weight-bold">{{ $user->email }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Password</label>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-lock mr-1"></i>Terenkripsi (Aman)
                                    </span>
                                </div>
                                <small class="text-muted">Password tersimpan dalam bentuk hash yang tidak dapat dibaca</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Role</label>
                                <p class="font-weight-bold text-capitalize">{{ $user->role }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Status Verifikasi</label>
                                <p>
                                    <span class="badge-status {{ $user->is_approved ? 'badge-approved' : 'badge-pending' }}">
                                        {{ $user->is_approved ? 'Disetujui' : 'Menunggu Verifikasi' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Tanggal Daftar</label>
                                <p class="font-weight-bold">{{ $user->created_at->format('d F Y, H:i') }}</p>
                            </div>

                            <!-- Data Penduduk -->
                            @if($user->resident)
                            <div class="col-12 mt-3 mb-3">
                                <h6 class="font-weight-bold text-info border-bottom pb-2">
                                    <i class="fas fa-id-card mr-2"></i>Data Kependudukan
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">NIK</label>
                                <p class="font-weight-bold">{{ $user->resident->nik }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Nomor KK</label>
                                <p class="font-weight-bold">{{ $user->resident->family_card_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Jenis Kelamin</label>
                                <p class="font-weight-bold">{{ $user->resident->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Tempat/Tanggal Lahir</label>
                                <p class="font-weight-bold">{{ $user->resident->birth_place }}, {{ \Carbon\Carbon::parse($user->resident->birth_date)->format('d F Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Agama</label>
                                <p class="font-weight-bold">{{ $user->resident->religion }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Status Perkawinan</label>
                                <p class="font-weight-bold">
                                    @switch($user->resident->marital_status)
                                        @case('Single') Belum Menikah @break
                                        @case('Married') Menikah @break
                                        @case('Divorced') Cerai @break
                                        @case('Widowed') Janda/Duda @break
                                    @endswitch
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Pekerjaan</label>
                                <p class="font-weight-bold">{{ $user->resident->occupation }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">No. Telepon</label>
                                <p class="font-weight-bold">{{ $user->resident->phone }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Dusun</label>
                                <p class="font-weight-bold">{{ $user->resident->hamlet }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small mb-1">Status Penduduk</label>
                                <p class="font-weight-bold text-capitalize">
                                    @switch($user->resident->status)
                                        @case('active') Aktif @break
                                        @case('moved') Pindah @break
                                        @case('deceased') Meninggal @break
                                    @endswitch
                                </p>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="text-muted small mb-1">Alamat Lengkap</label>
                                <p class="font-weight-bold">{{ $user->resident->address }}</p>
                            </div>
                            @else
                            <div class="col-12 mt-3">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Data kependudukan belum tersedia
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Approve -->
        <div class="modal fade" id="approveModal{{ $user->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0">
                    <form action="{{ route('user-verification.approve', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="fas fa-check-circle mr-2"></i>Konfirmasi Persetujuan</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menyetujui user berikut?</p>
                            <div class="mt-3 p-3 bg-light rounded border">
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check mr-2"></i>Ya, Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Reject -->
        <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0">
                    <form action="{{ route('user-verification.reject', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Pembatalan</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin membatalkan persetujuan user berikut?</p>
                            <div class="mt-3 p-3 bg-light rounded border">
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-times mr-2"></i>Ya, Batalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0">
                    <form action="{{ route('user-verification.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Konfirmasi Hapus</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus user berikut?</p>
                            <div class="mt-3 p-3 bg-light rounded border">
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <p class="text-danger mt-3 mb-0 d-flex align-items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                <small>Data yang dihapus tidak dapat dikembalikan!</small>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash mr-2"></i>Ya, Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Reset Password -->
        <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0">
                    <form action="{{ route('user-verification.reset-password', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title"><i class="fas fa-key mr-2"></i>Reset Password</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin mereset password user berikut?</p>
                            <div class="mt-3 p-3 bg-light rounded border">
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <div class="alert alert-warning mt-3 mb-0 d-flex align-items-start">
                                <i class="fas fa-info-circle mr-2 mt-1"></i>
                                <small>Password akan direset menjadi password random. Password baru akan ditampilkan setelah reset berhasil. Harap dicatat!</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-key mr-2"></i>Ya, Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
<script>
// Function to filter by card click
function filterByCard(element, filterType) {
    console.log('Card clicked:', filterType);
    
    // Remove active class from all cards
    const allCards = document.querySelectorAll('.stat-card');
    allCards.forEach(card => card.classList.remove('active'));
    
    // Get the status filter dropdown
    const statusFilter = document.getElementById('statusFilter');
    
    if (filterType === 'all') {
        // Show all users
        statusFilter.value = '';
        element.classList.add('active');
    } else if (filterType === 'pending') {
        // Show only pending users
        statusFilter.value = 'pending';
        element.classList.add('active');
    } else if (filterType === 'approved') {
        // Show only approved users
        statusFilter.value = 'approved';
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

    // Client-side search functionality with pagination
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const searchBtn = document.getElementById('searchBtn');
    const table = document.getElementById('userTable');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageInfo = document.getElementById('pageInfo');
    const paginationInfo = document.getElementById('paginationInfo');
    
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredRows = [];

    function filterAndPaginate() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const allRows = Array.from(table.querySelectorAll('tbody tr'));

        // Filter rows
        filteredRows = allRows.filter(row => {
            // Skip empty state row
            if (row.cells.length === 1) return false;

            const name = row.cells[1].textContent.toLowerCase();
            const email = row.cells[2].textContent.toLowerCase();
            const nik = row.cells[3].textContent.toLowerCase();
            const kk = row.cells[4].textContent.toLowerCase();
            const address = row.cells[5].textContent.toLowerCase();
            const status = row.cells[9].textContent.toLowerCase();

            const matchesSearch = searchTerm === '' ||
                                name.includes(searchTerm) || 
                                email.includes(searchTerm) || 
                                nik.includes(searchTerm) ||
                                kk.includes(searchTerm) ||
                                address.includes(searchTerm);
            
            let matchesStatus = true;
            if (statusValue === 'pending') {
                matchesStatus = status.includes('menunggu');
            } else if (statusValue === 'approved') {
                matchesStatus = status.includes('disetujui');
            }

            return matchesSearch && matchesStatus;
        });
        
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
    }

    // Filter on keyup
    searchInput.addEventListener('keyup', filterAndPaginate);
    
    // Filter on status change
    statusFilter.addEventListener('change', filterAndPaginate);
    
    // Filter on button click
    searchBtn.addEventListener('click', filterAndPaginate);
    
    // Filter on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
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
});
</script>
@endpush
