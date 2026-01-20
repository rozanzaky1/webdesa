@extends('layouts.app')

@section('title', 'Data Dusun')

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

    .page-header .btn-light {
        background: #4a7c2c;
        color: white;
        border: none;
    }

    .page-header .btn-light:hover {
        background: #3d6622;
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

    .stats-summary {
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

    .hamlet-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
    }
    
    .hamlet-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(74, 124, 44, 0.18) !important;
    }

    .hamlet-card:nth-child(6n+1) .card-header {
        background: linear-gradient(135deg, #4A7C2C 0%, #355719 100%);
    }

    .hamlet-card:nth-child(6n+2) .card-header {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    }

    .hamlet-card:nth-child(6n+3) .card-header {
        background: linear-gradient(135deg, #6c63ff 0%, #5848c9 100%);
    }

    .hamlet-card:nth-child(6n+4) .card-header {
        background: linear-gradient(135deg, #fd7e14 0%, #dc6502 100%);
    }

    .hamlet-card:nth-child(6n+5) .card-header {
        background: linear-gradient(135deg, #20c997 0%, #1aa179 100%);
    }

    .hamlet-card:nth-child(6n+6) .card-header {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .hamlet-card .card-header {
        border-bottom: none;
        padding: 20px;
        position: relative;
        color: white;
    }

    .hamlet-card .card-header h5 {
        color: white;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .hamlet-card .card-header i {
        color: white;
        font-size: 16px;
    }

    .badge-code {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stat-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }

    .stat-box:hover {
        background: #ffffff;
        border-color: #4a7c2c;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .stat-box h3 {
        color: #2c3e50;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-box i {
        color: #4a7c2c;
        font-size: 14px;
    }
    
    .stat-box p {
        color: #666;
        font-size: 10px;
        margin: 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .badge-code {
        background: #e8f5e9;
        color: #2d5016;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #4a7c2c;
        border-radius: 4px;
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

    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
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

    .btn-success {
        background: #4A7C2C;
        border: none;
    }

    .btn-success:hover {
        background: #355719;
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .detail-row {
        border-top: 2px solid #f0f0f0;
        padding-top: 15px;
        margin-bottom: 15px;
    }

    .detail-item {
        margin-bottom: 15px;
    }

    .detail-item small {
        display: block;
        color: #6c757d;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .detail-item strong {
        color: #2c3e50;
        font-size: 14px;
    }

    .info-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-left: 3px solid #4a7c2c;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .info-box small {
        color: #495057;
        font-weight: 600;
        display: block;
        margin-bottom: 8px;
        font-size: 11px;
    }

    .info-box p {
        color: #6c757d;
        margin: 0;
        font-size: 13px;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-map-marked-alt mr-2"></i>Data Dusun</h1>
                <p>Kelola data dusun di Desa Badran Sari</p>
            </div>
            <a href="{{ route('hamlets.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus mr-2"></i>Tambah Dusun
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Summary -->
    <div class="stats-summary">
        <div class="stat-card card-primary">
            <h3>{{ count($hamlets) }}</h3>
            <p><i class="fas fa-map-marked-alt mr-1"></i> Total Dusun</p>
        </div>
        <div class="stat-card card-info">
            <h3>{{ collect($hamlets)->sum('total_families') }}</h3>
            <p><i class="fas fa-home mr-1"></i> Total Keluarga</p>
        </div>
        <div class="stat-card card-purple">
            <h3>{{ collect($hamlets)->sum('total_residents') }}</h3>
            <p><i class="fas fa-users mr-1"></i> Total Penduduk</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filters-card">
        <div class="row align-items-end">
            <div class="col-md-12">
                <div class="search-box">
                    <input type="text" 
                           id="searchInput"
                           class="form-control" 
                           placeholder="Cari nama dusun, kode, kepala dusun...">
                    <button type="button" class="search-btn" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Cards -->
    <div class="row">
        @if(count($hamlets) > 0)
            @foreach($hamlets as $hamlet)
            <div class="col-lg-6 mb-4">
                <div class="card shadow hamlet-card h-100">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="m-0 font-weight-bold">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $hamlet['name'] }}
                                </h5>
                            </div>
                            <span class="badge badge-code">{{ $hamlet['code'] }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Statistics Row -->
                        <div class="row mb-4">
                            <div class="col-4">
                                <div class="stat-box">
                                    <h3>{{ $hamlet['total_families'] ?? 0 }}</h3>
                                    <p><i class="fas fa-home"></i> Keluarga (KK)</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box">
                                    <h3>{{ $hamlet['total_residents'] ?? 0 }}</h3>
                                    <p><i class="fas fa-users"></i> Penduduk</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box">
                                    <h3>{{ $hamlet['total_rt'] ?? 0 }}/{{ $hamlet['total_rw'] ?? 0 }}</h3>
                                    <p><i class="fas fa-layer-group"></i> RT/RW</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Info -->
                        <div class="detail-row">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <small>
                                            <i class="fas fa-user-tie"></i> Kepala Dusun
                                        </small>
                                        <strong>{{ $hamlet['head_name'] }}</strong>
                                    </div>
                                </div>
                                @if(isset($hamlet['head_phone']) && $hamlet['head_phone'])
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <small>
                                            <i class="fas fa-phone"></i> Telepon
                                        </small>
                                        <strong>{{ $hamlet['head_phone'] }}</strong>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if(isset($hamlet['description']) && $hamlet['description'])
                        <div class="info-box">
                            <small>
                                <i class="fas fa-info-circle mr-1"></i> Keterangan
                            </small>
                            <p>{{ $hamlet['description'] }}</p>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('hamlets.edit', $hamlet['id']) }}" class="btn btn-warning btn-action">
                                <i class="fas fa-edit mr-1"></i>Edit Data
                            </a>
                            <button type="button" class="btn btn-danger btn-action" data-toggle="modal" data-target="#deleteModal{{ $hamlet['id'] }}">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $hamlet['id'] }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $hamlet['id'] }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $hamlet['id'] }}">Konfirmasi Hapus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus data dusun <strong>{{ $hamlet['name'] }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                                <form action="{{ route('hamlets.destroy', $hamlet['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card shadow" style="border: none; border-radius: 10px;">
                    <div class="card-body">
                        <div class="empty-state">
                            <i class="fas fa-map-marked-alt"></i>
                            <h5>Belum Ada Data Dusun</h5>
                            <p>Klik tombol "Tambah Dusun" untuk menambahkan data baru</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
console.log('Loading hamlets search script...');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing hamlets search...');
    
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    
    console.log('searchInput:', searchInput);
    console.log('searchBtn:', searchBtn);
    
    if (!searchInput || !searchBtn) {
        console.error('Element tidak ditemukan!');
        return;
    }

    function performSearch() {
        console.log('Searching hamlets...');
        const searchTerm = searchInput.value.toLowerCase();
        const hamletCards = document.querySelectorAll('.hamlet-card');
        
        console.log('Search term:', searchTerm);
        console.log('Total cards:', hamletCards.length);
        
        let visibleCount = 0;

        hamletCards.forEach(card => {
            const cardParent = card.closest('.col-lg-6');
            const cardText = card.textContent.toLowerCase();

            if (searchTerm === '' || cardText.includes(searchTerm)) {
                cardParent.style.display = '';
                visibleCount++;
            } else {
                cardParent.style.display = 'none';
            }
        });
        
        console.log('Visible cards:', visibleCount);
    }

    // Search on keyup
    searchInput.addEventListener('keyup', function() {
        console.log('Keyup event triggered');
        performSearch();
    });
    
    // Search on button click
    searchBtn.addEventListener('click', function() {
        console.log('Search button clicked');
        performSearch();
    });
    
    // Search on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            console.log('Enter key pressed');
            performSearch();
        }
    });
    
    console.log('Hamlets search initialized successfully!');
});
</script>
@endpush
