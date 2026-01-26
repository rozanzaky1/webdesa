@extends('layouts.app')

@section('title', 'Arsip Surat Keterangan')

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

    .data-card {
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

    .badge-type {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-type-domisili {
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
        color: white;
    }

    .badge-type-usaha {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }

    .badge-type-kematian {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .badge-type-kelahiran {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: white;
    }

    .badge-type-default {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
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

    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
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
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-file-alt mr-2"></i>Arsip Surat Keterangan</h1>
                <p>Kelola arsip surat keterangan di Kampung Badran Sari</p>
            </div>
            <a href="{{ route('letter-archive.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus mr-2"></i>Tambah Arsip
            </a>
        </div>
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

    <!-- Filters -->
    <div class="filters-card">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="search-box">
                    <input type="text" 
                           id="searchInput"
                           class="form-control" 
                           placeholder="Cari No. Surat, Penerima, atau NIK...">
                    <button type="button" class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select id="typeFilter" class="form-control">
                    <option value="">Semua Jenis Surat</option>
                    @foreach($letterTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" id="dateFrom" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-2">
                <input type="date" id="dateTo" class="form-control" placeholder="Sampai Tanggal">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="table-responsive">
            <table class="table" id="archiveTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Surat</th>
                        <th>Jenis Surat</th>
                        <th>Penerima</th>
                        <th>NIK</th>
                        <th>Tanggal Surat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archives as $archive)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $archive['letter_number'] }}</strong></td>
                            <td>
                                <span class="badge-type 
                                    {{ str_contains(strtolower($archive['letter_type']), 'domisili') ? 'badge-type-domisili' : '' }}
                                    {{ str_contains(strtolower($archive['letter_type']), 'usaha') ? 'badge-type-usaha' : '' }}
                                    {{ str_contains(strtolower($archive['letter_type']), 'kematian') ? 'badge-type-kematian' : '' }}
                                    {{ str_contains(strtolower($archive['letter_type']), 'kelahiran') ? 'badge-type-kelahiran' : '' }}
                                    {{ !str_contains(strtolower($archive['letter_type']), 'domisili') && !str_contains(strtolower($archive['letter_type']), 'usaha') && !str_contains(strtolower($archive['letter_type']), 'kematian') && !str_contains(strtolower($archive['letter_type']), 'kelahiran') ? 'badge-type-default' : '' }}">
                                    {{ $archive['letter_type'] }}
                                </span>
                            </td>
                            <td>{{ $archive['recipient_name'] }}</td>
                            <td>{{ $archive['recipient_nik'] ?? '-' }}</td>
                            <td>{{ date('d M Y', strtotime($archive['letter_date'])) }}</td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 8px;">
                                    <button type="button" 
                                            class="btn btn-info btn-action"
                                            data-toggle="modal" 
                                            data-target="#detailModal{{ $archive['id'] }}"
                                            title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-danger btn-action"
                                            data-toggle="modal" 
                                            data-target="#deleteModal{{ $archive['id'] }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-file-alt"></i>
                                    <h5>Belum Ada Arsip</h5>
                                    <p>Klik tombol "Tambah Arsip" untuk menambahkan arsip surat baru</p>
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

    <!-- Detail Modals -->
    @foreach($archives as $archive)
        <div class="modal fade" id="detailModal{{ $archive['id'] }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white;">
                        <h5 class="modal-title"><i class="fas fa-file-alt mr-2"></i>Detail Data Surat</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <!-- Data Surat -->
                        <div class="mb-4">
                            <h6 class="font-weight-bold mb-3" style="color: #17a2b8; border-bottom: 2px solid #17a2b8; padding-bottom: 8px;">
                                <i class="fas fa-file-alt mr-2"></i>Data Surat
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">Nomor Surat</label>
                                    <div class="font-weight-bold">{{ $archive['letter_number'] }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">Jenis Surat</label>
                                    <div class="font-weight-bold">{{ $archive['letter_type'] }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">Tanggal Surat</label>
                                    <div>{{ date('d F Y', strtotime($archive['letter_date'])) }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">Tanggal Arsip</label>
                                    <div>{{ date('d F Y, H:i', strtotime($archive['created_at'])) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Penerima -->
                        <div class="mb-4">
                            <h6 class="font-weight-bold mb-3" style="color: #17a2b8; border-bottom: 2px solid #17a2b8; padding-bottom: 8px;">
                                <i class="fas fa-user mr-2"></i>Data Penerima
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">Nama Penerima</label>
                                    <div class="font-weight-bold">{{ $archive['recipient_name'] }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">NIK</label>
                                    <div>{{ $archive['recipient_nik'] ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="mb-3">
                            <h6 class="font-weight-bold mb-3" style="color: #17a2b8; border-bottom: 2px solid #17a2b8; padding-bottom: 8px;">
                                <i class="fas fa-info-circle mr-2"></i>Informasi Tambahan
                            </h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">Keperluan</label>
                                    <div>{{ $archive['purpose'] ?? '-' }}</div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="text-muted mb-1" style="font-size: 12px; font-weight: 600;">Catatan</label>
                                    <div>{{ $archive['notes'] ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete Modals -->
    @foreach($archives as $archive)
        <div class="modal fade" id="deleteModal{{ $archive['id'] }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <form action="{{ route('letter-archive.destroy', $archive['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Konfirmasi Hapus</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus arsip surat berikut?</p>
                            <div class="mt-3 p-3 bg-light rounded border">
                                <strong>{{ $archive['letter_number'] }}</strong><br>
                                <small class="text-muted">{{ $archive['recipient_name'] }}</small>
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

    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('#archiveTable tbody');
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const dateFrom = document.getElementById('dateFrom');
        const dateTo = document.getElementById('dateTo');
        const searchBtn = document.getElementById('searchBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        // Get all table rows (except empty state)
        allRows = Array.from(tableBody.querySelectorAll('tr')).filter(row => {
            return row.cells.length > 1; // Filter out rows with only 1 cell (empty state)
        });

        if (allRows.length === 0) {
            document.getElementById('paginationControls').style.display = 'none';
            return;
        }

        // Initial setup
        filteredRows = [...allRows];
        displayPage(currentPage);

        // Search and filter functionality
        function filterAndPaginate() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const typeValue = typeFilter.value.toLowerCase().trim();
            const fromDate = dateFrom.value;
            const toDate = dateTo.value;

            filteredRows = allRows.filter(row => {
                const cells = Array.from(row.cells);
                const rowText = cells.map(cell => cell.textContent.toLowerCase()).join(' ');
                
                // Search filter
                const matchesSearch = !searchTerm || rowText.includes(searchTerm);
                
                // Type filter
                const typeCell = cells[2]?.textContent.toLowerCase().trim() || '';
                const matchesType = !typeValue || typeCell.includes(typeValue);
                
                // Date filter
                let matchesDate = true;
                if (fromDate || toDate) {
                    const dateText = cells[5]?.textContent.trim() || '';
                    // Convert "dd Mon YYYY" to Date
                    const rowDate = new Date(dateText);
                    
                    if (fromDate) {
                        const from = new Date(fromDate);
                        matchesDate = matchesDate && rowDate >= from;
                    }
                    if (toDate) {
                        const to = new Date(toDate);
                        matchesDate = matchesDate && rowDate <= to;
                    }
                }

                return matchesSearch && matchesType && matchesDate;
            });

            currentPage = 1;
            displayPage(currentPage);
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
                    `Menampilkan <strong>${start + 1}</strong> sampai <strong>${showing}</strong> dari <strong>${filteredRows.length}</strong> data`;
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

        // Event listeners
        searchBtn.addEventListener('click', filterAndPaginate);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                filterAndPaginate();
            }
        });
        searchInput.addEventListener('input', filterAndPaginate);
        typeFilter.addEventListener('change', filterAndPaginate);
        dateFrom.addEventListener('change', filterAndPaginate);
        dateTo.addEventListener('change', filterAndPaginate);

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                displayPage(currentPage);
            }
        });

        nextBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                displayPage(currentPage);
            }
        });
    });
</script>
@endpush
@endsection
