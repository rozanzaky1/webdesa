@extends('layouts.app')

@section('title', 'Pengajuan Surat Online')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #fafdfb 100%);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 3px 15px rgba(74, 124, 44, 0.12);
        border-left: 5px solid #4a7c2c;
    }

    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #2c3e50;
    }

    .page-header p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
        color: #7f8c8d;
    }

    .stats-row {
        margin-bottom: 25px;
    }

    .stat-card {
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        color: white;
        position: relative;
        overflow: hidden;
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

    .stat-card.pending {
        background: #fd7e14;
    }

    .stat-card.approved {
        background: #4A7C2C;
    }

    .stat-card.rejected {
        background: #e74c3c;
    }

    .stat-card.completed {
        background: #20c997;
    }

    .stat-icon {
        font-size: 26px;
        opacity: 0.9;
        transition: all 0.3s ease;
        margin-bottom: 10px;
        color: white;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.15) rotate(5deg);
        opacity: 1;
    }

    .stat-value {
        font-size: 34px;
        font-weight: bold;
        color: white;
        margin: 0 0 5px 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .stat-label {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 500;
        margin: 0;
    }

    .filters-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        border-left: 4px solid #4a7c2c;
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

    .submissions-container {
        background: white;
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

    .table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f8fdf8;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(74, 124, 44, 0.1);
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        font-size: 14px;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-pending {
        background: linear-gradient(135deg, #fd7e14 0%, #e56707 100%);
        color: white;
    }

    .badge-approved {
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
        color: white;
    }

    .badge-rejected {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .badge-completed {
        background: linear-gradient(135deg, #20c997 0%, #17a589 100%);
        color: white;
    }

    .btn-action {
        padding: 8px 12px;
        border-radius: 6px;
        border: none;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
        color: #4A7C2C;
    }

    .empty-state h5 {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-pagination {
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .btn-pagination:hover:not(:disabled) {
        background: linear-gradient(135deg, #355719 0%, #2a4513 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 124, 44, 0.4);
    }

    .btn-pagination:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-info {
        color: #6c757d;
        font-weight: 600;
        padding: 0 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-paper-plane mr-2"></i>Pengajuan Surat Online</h1>
        <p>Kelola permohonan surat dari masyarakat</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="animation: slideDown 0.3s ease-out;">
            <i class="fas fa-check-circle mr-2"></i> <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="animation: slideDown 0.3s ease-out;">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row stats-row">
        <div class="col-md-3">
            <div class="stat-card pending" data-filter="pending" onclick="filterByCard(this, 'pending')">
                <i class="fas fa-clock stat-icon"></i>
                <h2 class="stat-value" id="pendingCount">0</h2>
                <p class="stat-label">Menunggu</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card approved" data-filter="approved" onclick="filterByCard(this, 'approved')">
                <i class="fas fa-check-circle stat-icon"></i>
                <h2 class="stat-value" id="approvedCount">0</h2>
                <p class="stat-label">Disetujui</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card rejected" data-filter="rejected" onclick="filterByCard(this, 'rejected')">
                <i class="fas fa-times-circle stat-icon"></i>
                <h2 class="stat-value" id="rejectedCount">0</h2>
                <p class="stat-label">Ditolak</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card completed" data-filter="completed" onclick="filterByCard(this, 'completed')">
                <i class="fas fa-check-double stat-icon"></i>
                <h2 class="stat-value" id="completedCount">0</h2>
                <p class="stat-label">Selesai</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="search-box">
                    <input type="text" 
                           id="searchInput"
                           class="form-control" 
                           placeholder="Cari nama, NIK, atau jenis surat...">
                    <button type="button" class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                    <option value="completed">Selesai</option>
                </select>
            </div>
            <div class="col-md-4">
                <select id="typeFilter" class="form-control">
                    <option value="">Semua Jenis Surat</option>
                    @foreach($letterTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="submissions-container">
        <div class="table-responsive">
            <table class="table" id="submissionTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Nama Pemohon</th>
                        <th>NIK</th>
                        <th>Keperluan</th>
                        <th>No. Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr data-status="{{ $submission['status'] }}" data-type="{{ $submission['letter_type'] }}">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $submission['letter_type'] }}</strong></td>
                            <td>{{ $submission['name'] ?? $submission['applicant_name'] ?? 'N/A' }}</td>
                            <td>{{ $submission['nik'] ?? $submission['applicant_nik'] ?? '-' }}</td>
                            <td>{{ Str::limit($submission['purpose'], 40) }}</td>
                            <td>{{ $submission['letter_number'] ?? '-' }}</td>
                            <td>{{ date('d M Y', strtotime($submission['created_at'])) }}</td>
                            <td>
                                @if($submission['status'] === 'pending')
                                    <span class="badge-status badge-pending">
                                        <i class="fas fa-clock"></i> Menunggu
                                    </span>
                                @elseif($submission['status'] === 'approved')
                                    <span class="badge-status badge-approved">
                                        <i class="fas fa-check-circle"></i> Disetujui
                                    </span>
                                @elseif($submission['status'] === 'rejected')
                                    <span class="badge-status badge-rejected">
                                        <i class="fas fa-times-circle"></i> Ditolak
                                    </span>
                                @else
                                    <span class="badge-status badge-completed">
                                        <i class="fas fa-check-double"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 8px;">
                                    <a href="{{ route('online-submission.show', $submission['id']) }}" 
                                       class="btn btn-warning btn-action"
                                       title="Edit Status">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-action"
                                            data-toggle="modal" 
                                            data-target="#deleteModal{{ $submission['id'] }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @if($submission['status'] === 'approved' || $submission['status'] === 'completed')
                                        <a href="{{ route('online-submission.print', $submission['id']) }}" 
                                           class="btn btn-success btn-action" 
                                           target="_blank"
                                           title="Cetak Surat">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h5>Belum Ada Pengajuan</h5>
                                    <p>Belum ada permohonan surat yang masuk dari masyarakat</p>
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

    <!-- Delete Modals -->
    @foreach($submissions as $submission)
        <div class="modal fade" id="deleteModal{{ $submission['id'] }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <form action="{{ route('online-submission.destroy', $submission['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Konfirmasi Hapus</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus pengajuan surat berikut?</p>
                            <div class="mt-3 p-3 bg-light rounded border">
                                <strong>{{ $submission['letter_type'] }}</strong><br>
                                <small class="text-muted">{{ $submission['name'] ?? $submission['applicant_name'] ?? 'N/A' }}</small>
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
    @endforeach
</div>

@push('scripts')
<script>
    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredRows = [];
    let allRows = [];

    // Function to filter by card click
    function filterByCard(element, filterType) {
        console.log('Card clicked:', filterType);
        
        // Remove active class from all cards
        const allCards = document.querySelectorAll('.stat-card');
        allCards.forEach(card => card.classList.remove('active'));
        
        // Get the status filter dropdown
        const statusFilter = document.getElementById('statusFilter');
        
        // Set the filter value
        statusFilter.value = filterType;
        element.classList.add('active');
        
        // Clear URL params to prevent conflicts
        window.history.replaceState({}, document.title, window.location.pathname);
        
        // Trigger the filter
        statusFilter.dispatchEvent(new Event('change'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('#submissionTable tbody');
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const typeFilter = document.getElementById('typeFilter');
        const searchBtn = document.getElementById('searchBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        // Get all table rows (except empty state)
        allRows = Array.from(tableBody.querySelectorAll('tr')).filter(row => {
            return row.cells.length > 1; // Filter out rows with only 1 cell (empty state)
        });

        if (allRows.length === 0) {
            document.getElementById('paginationControls').style.display = 'none';
            updateStats();
            return;
        }

        // Check for URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        
        // Don't set dropdown if multiple statuses - let the filter show all matching
        if (statusParam && !statusParam.includes(',')) {
            statusFilter.value = statusParam;
        }

        // Initial setup
        filteredRows = [...allRows];
        filterAndPaginate(); // Apply initial filters including URL params
        updateStats();

        // Search and filter functionality
        function filterAndPaginate() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusValue = statusFilter.value.toLowerCase().trim();
            const typeValue = typeFilter.value.toLowerCase().trim();

            // Check URL params for multiple statuses
            const urlParams = new URLSearchParams(window.location.search);
            const statusParam = urlParams.get('status');
            let allowedStatuses = [];
            
            // Priority: URL params > dropdown selection
            if (statusParam) {
                if (statusParam.includes(',')) {
                    // Multiple statuses from URL
                    allowedStatuses = statusParam.split(',').map(s => s.trim().toLowerCase());
                } else {
                    // Single status from URL
                    allowedStatuses = [statusParam.toLowerCase()];
                }
            } else if (statusValue) {
                // Dropdown selection (no URL param)
                allowedStatuses = [statusValue];
            }

            filteredRows = allRows.filter(row => {
                const cells = Array.from(row.cells);
                const rowText = cells.map(cell => cell.textContent.toLowerCase()).join(' ');
                const rowStatus = row.dataset.status.toLowerCase();
                const rowType = row.dataset.type.toLowerCase();
                
                // Search filter
                const matchesSearch = !searchTerm || rowText.includes(searchTerm);
                
                // Status filter - handle multiple statuses
                const matchesStatus = allowedStatuses.length === 0 || allowedStatuses.includes(rowStatus);
                
                // Type filter
                const matchesType = !typeValue || rowType.includes(typeValue);

                return matchesSearch && matchesStatus && matchesType;
            });

            currentPage = 1;
            displayPage(currentPage);
            updateStats();
        }

        function displayPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

            // Hide all rows first
            allRows.forEach(row => row.style.display = 'none');

            // Show only filtered rows for current page
            const pageRows = filteredRows.slice(start, end);
            pageRows.forEach((row, index) => {
                row.style.display = '';
                // Update row number
                row.cells[0].textContent = start + index + 1;
            });

            // Update pagination info
            if (filteredRows.length === 0) {
                document.getElementById('paginationInfo').innerHTML = 'Tidak ada data yang ditampilkan';
                document.getElementById('pageInfo').textContent = '0 / 0';
            } else {
                const showing = Math.min(end, filteredRows.length);
                document.getElementById('paginationInfo').innerHTML = 
                    `Menampilkan <strong>${start + 1}</strong> sampai <strong>${showing}</strong> dari <strong>${filteredRows.length}</strong> pengajuan`;
                document.getElementById('pageInfo').textContent = `${page} / ${totalPages}`;
            }

            // Update button states
            prevBtn.disabled = page === 1;
            nextBtn.disabled = page >= totalPages;

            // Show/hide pagination controls
            if (filteredRows.length <= rowsPerPage) {
                document.getElementById('paginationControls').style.display = 'none';
            } else {
                document.getElementById('paginationControls').style.display = 'flex';
            }
        }

        function updateStats() {
            const pending = allRows.filter(row => row.dataset.status === 'pending').length;
            const approved = allRows.filter(row => row.dataset.status === 'approved').length;
            const rejected = allRows.filter(row => row.dataset.status === 'rejected').length;
            const completed = allRows.filter(row => row.dataset.status === 'completed').length;

            document.getElementById('pendingCount').textContent = pending;
            document.getElementById('approvedCount').textContent = approved;
            document.getElementById('rejectedCount').textContent = rejected;
            document.getElementById('completedCount').textContent = completed;
        }

        // Event listeners
        searchBtn.addEventListener('click', filterAndPaginate);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                filterAndPaginate();
            }
        });
        searchInput.addEventListener('input', filterAndPaginate);
        statusFilter.addEventListener('change', function() {
            // Remove URL params when manually changing filter
            const newUrl = window.location.pathname;
            window.history.replaceState({}, '', newUrl);
            filterAndPaginate();
        });
        typeFilter.addEventListener('change', filterAndPaginate);

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                displayPage(currentPage);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        nextBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                displayPage(currentPage);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });
</script>
@endpush
@endsection
