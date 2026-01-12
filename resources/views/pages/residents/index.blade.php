@extends('layouts.app')

@section('title', 'Data Penduduk')

@push('styles')
<style>
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
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
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
        overflow: hidden;
        position: relative;
    }

    .table {
        margin-bottom: 0;
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
    }

    .search-box input {
        padding-left: 40px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
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
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-users mr-2"></i>Data Penduduk</h1>
                <p>Kelola data penduduk Desa Badran Sari</p>
            </div>
            <a href="{{ route('residents.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus mr-2"></i> Tambah Penduduk
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card card-primary">
            <h3>{{ $residents->count() }}</h3>
            <p><i class="fas fa-users mr-1"></i> Total Penduduk</p>
        </div>
        <div class="stat-card card-info">
            <h3>{{ $residents->where('status', 'active')->count() }}</h3>
            <p><i class="fas fa-check-circle mr-1"></i> Status Aktif</p>
        </div>
        <div class="stat-card card-danger">
            <h3>{{ $residents->where('status', 'inactive')->count() }}</h3>
            <p><i class="fas fa-times-circle mr-1"></i> Status Tidak Aktif</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" 
                           id="searchInput" 
                           class="form-control" 
                           placeholder="Cari berdasarkan NIK, nama, alamat, atau pekerjaan...">
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
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>TTL</th>
                        <th>Alamat</th>
                        <th>Agama</th>
                        <th>Status Perkawinan</th>
                        <th>Pekerjaan</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($residents as $item)
                        <tr>
                            <td><strong>{{ $item->nik }}</strong></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->birth_place }}, {{ \Carbon\Carbon::parse($item->birth_date)->format('d-m-Y') }}</td>
                            <td>{{ Str::limit($item->address, 30) }}</td>
                            <td>{{ $item->religion }}</td>
                            <td>{{ $item->marital_status }}</td>
                            <td>{{ $item->occupation }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                <span class="badge-status {{ $item->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $item->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
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

                                        <!-- Modal Konfirmasi Hapus Component -->
                                        @include('components.confirmation-delete', [
                                            'id' => $item->id,
                                            'name' => $item->name,
                                            'nik' => $item->nik,
                                            'route' => route('residents.destroy', $item->id)
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5">
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
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('residentsTable');
    const rows = table.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();

        rows.forEach(row => {
            // Skip empty state row
            if (row.cells.length === 1) return;

            const nik = row.cells[0].textContent.toLowerCase();
            const name = row.cells[1].textContent.toLowerCase();
            const address = row.cells[4].textContent.toLowerCase();
            const occupation = row.cells[7].textContent.toLowerCase();
            const status = row.cells[9].textContent.toLowerCase();

            const matchesSearch = nik.includes(searchTerm) || 
                                name.includes(searchTerm) || 
                                address.includes(searchTerm) || 
                                occupation.includes(searchTerm);
            
            const matchesStatus = statusValue === '' || status.includes(statusValue);

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('keyup', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>
@endpush
