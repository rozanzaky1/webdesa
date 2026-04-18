@extends('layouts.app')

@section('title', 'Data Keluarga')

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

    .page-header .btn-light {
        background: #4a7c2c;
        color: white;
        border: none;
    }

    .page-header .btn-light:hover {
        background: #3d6622;
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

    .stat-card.card-purple {
        background: #6c63ff;
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
        background: linear-gradient(135deg, #4a7c2c 0%, #5d9b3a 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        padding: 15px;
        border: none;
    }

    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table tbody tr:hover {
        background: #f8fef8;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(74, 124, 44, 0.1);
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        color: #2c3e50;
        font-size: 14px;
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

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
        color: #4a7c2c;
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
                <h1><i class="fas fa-home mr-2"></i>Data Keluarga</h1>
                <p>Kelola informasi keluarga dan anggota keluarga</p>
            </div>
            <a href="{{ route('families.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus mr-2"></i> Tambah Keluarga
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
            <h3>{{ $totalFamilies }}</h3>
            <p><i class="fas fa-home mr-1"></i> Total Keluarga</p>
        </div>
        <div class="stat-card card-info">
            <h3>{{ $totalMembers }}</h3>
            <p><i class="fas fa-users mr-1"></i> Total Penduduk</p>
        </div>
        <div class="stat-card card-purple">
            <h3>{{ $averageFamilySize }}</h3>
            <p><i class="fas fa-calculator mr-1"></i> Rata-rata Anggota</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="search-box">
                    <input type="text" 
                           id="searchInput" 
                           class="form-control" 
                           placeholder="Cari berdasarkan No. KK, Nama Kepala Keluarga, atau Alamat...">
                    <button type="button" class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="table-responsive">
            <table class="table" id="familiesTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. KK</th>
                        <th>Kepala Keluarga</th>
                        <th>NIK Kepala</th>
                        <th>Dusun</th>
                        <th>Jumlah Anggota</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($families as $family)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $family->kk }}</strong></td>
                            <td>{{ $family->head_name }}</td>
                            <td>{{ $family->head_nik ?? '-' }}</td>
                            <td>{{ $family->hamlet ?? '-' }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $family->total_members }} Orang</span>
                            </td>
                            <td class="text-center">
                                <button type="button"
                                        class="btn btn-info btn-sm btn-action"
                                        data-toggle="modal"
                                        data-target="#detailModal{{ $family->id }}"
                                        title="Lihat Anggota">
                                    <i class="fas fa-users"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('families.edit', $family->id) }}" 
                                   class="btn btn-warning btn-sm btn-action"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('families.destroy', $family->id) }}" 
                                      method="POST" 
                                      style="display: inline-block;"
                                      onsubmit="return confirm('Yakin ingin menghapus data keluarga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm btn-action"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <i class="fas fa-home"></i>
                                    <h5>Belum Ada Data Keluarga</h5>
                                    <p>Klik tombol "Tambah Keluarga" untuk menambahkan data baru</p>
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
    <!-- Modal Detail Anggota Keluarga -->
    @foreach ($families as $family)
        <div class="modal fade" id="detailModal{{ $family->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-users mr-2"></i>Anggota Keluarga - KK: {{ $family->kk }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Kepala Keluarga:</strong> {{ $family->head_name }}<br>
                                    <strong>NIK:</strong> {{ $family->head_nik ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Dusun:</strong> {{ $family->hamlet ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <h6 class="font-weight-bold mb-3">
                            <i class="fas fa-list mr-2"></i>Daftar Anggota ({{ $family->members->count() }} Orang)
                        </h6>

                        @if($family->members->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($family->members as $index => $member)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $member->nik }}</td>
                                                <td>
                                                    <strong>{{ $member->name }}</strong>
                                                    @if($member->nik == $family->head_nik)
                                                        <span class="badge badge-success badge-sm ml-1">Kepala Keluarga</span>
                                                    @endif
                                                </td>
                                                <td>{{ $member->gender == 'Male' ? 'L' : 'P' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($member->birth_date)->age }} tahun</td>
                                                <td>
                                                    <span class="badge badge-{{ $member->status == 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($member->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Belum ada anggota keluarga yang terdaftar dengan No. KK ini.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
<script>
console.log('Loading families search script...');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing families search...');
    
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const table = document.getElementById('familiesTable');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageInfo = document.getElementById('pageInfo');
    const paginationInfo = document.getElementById('paginationInfo');
    
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredRows = [];
    
    console.log('searchInput:', searchInput);
    console.log('searchBtn:', searchBtn);
    console.log('table:', table);
    
    if (!searchInput || !searchBtn || !table) {
        console.error('Element tidak ditemukan!');
        return;
    }

    function filterAndPaginate() {
        console.log('Filtering and paginating families...');
        const searchTerm = searchInput.value.toLowerCase();
        const allRows = Array.from(table.querySelectorAll('tbody tr'));
        
        console.log('Search term:', searchTerm);
        console.log('Total rows:', allRows.length);
        
        // Filter rows
        filteredRows = allRows.filter(row => {
            if (row.cells.length <= 1) return false;
            const rowText = row.textContent.toLowerCase();
            return searchTerm === '' || rowText.includes(searchTerm);
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

    // Search on keyup
    searchInput.addEventListener('keyup', function() {
        console.log('Keyup event triggered');
        filterAndPaginate();
    });

    // Search button click
    searchBtn.addEventListener('click', function() {
        console.log('Search button clicked');
        filterAndPaginate();
    });

    // Search on Enter key
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
    console.log('Families search initialized successfully!');
});
</script>
@endpush

