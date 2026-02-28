@extends('frontend.layout')

@section('title', 'Riwayat Pengajuan')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-history mr-2"></i> Riwayat Pengajuan Surat</h2>
        <a href="{{ route('layanan.create') }}" class="btn text-white" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
            <i class="fas fa-plus mr-2"></i> Pengajuan Baru
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    
    @forelse($submissions as $submission)
        <div class="card mb-3 shadow-sm submission-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="d-flex align-items-start">
                            <div class="submission-icon mr-3">
                                <i class="fas fa-file-alt fa-2x text-muted"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-2" style="color: #2d5016;">
                                    <strong>{{ $submission['letter_type'] }}</strong>
                                </h5>
                                <p class="mb-2 text-dark">
                                    <strong>Keperluan:</strong> {{ Str::limit($submission['purpose'], 100) }}
                                </p>
                                <div class="submission-meta">
                                    <small class="text-muted mr-3">
                                        <i class="far fa-calendar mr-1"></i> 
                                        {{ \Carbon\Carbon::parse($submission['created_at'])->format('d M Y, H:i') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="far fa-user mr-1"></i> {{ $submission['name'] }}
                                    </small>
                                </div>
                                
                                @if(!empty($submission['admin_notes']) && $submission['status'] != 'pending')
                                    <div class="mt-2 p-2 bg-light rounded">
                                        <small>
                                            <strong>Catatan Admin:</strong> {{ $submission['admin_notes'] }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-right d-flex flex-column justify-content-between align-items-end">
                        <div class="mb-2">
                            @if($submission['status'] === 'pending')
                                <span class="badge badge-warning badge-lg px-3 py-2">
                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                </span>
                            @elseif($submission['status'] === 'approved')
                                <span class="badge badge-success badge-lg px-3 py-2">
                                    <i class="fas fa-check-circle mr-1"></i> Disetujui
                                </span>
                            @elseif($submission['status'] === 'completed')
                                <span class="badge badge-info badge-lg px-3 py-2">
                                    <i class="fas fa-check-double mr-1"></i> Selesai
                                </span>
                            @elseif($submission['status'] === 'rejected')
                                <span class="badge badge-danger badge-lg px-3 py-2">
                                    <i class="fas fa-times-circle mr-1"></i> Ditolak
                                </span>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('layanan.show', $submission['id']) }}" 
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum Ada Pengajuan</h4>
                    <p class="text-muted mb-4">Anda belum pernah mengajukan surat administrasi</p>
                    <a href="{{ route('layanan.create') }}" class="btn text-white" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
                        <i class="fas fa-plus mr-2"></i> Buat Pengajuan Baru
                    </a>
                </div>
            </div>
        </div>
    @endforelse
    
    @if(count($submissions) > 0)
        <div class="mt-4 text-center">
            <p class="text-muted">
                <i class="fas fa-info-circle mr-1"></i> 
                Total pengajuan: <strong>{{ count($submissions) }}</strong>
            </p>
        </div>
    @endif
</div>

<style>
.submission-card {
    border: none;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.submission-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
}

.badge-lg {
    font-size: 0.9rem;
    font-weight: 600;
}

.submission-icon {
    width: 50px;
    text-align: center;
}

.submission-meta {
    margin-top: 0.5rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    margin: 2px;
}

.empty-state i {
    opacity: 0.3;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .col-md-3.text-right {
        text-align: left !important;
        margin-top: 1rem;
        flex-direction: row !important;
        justify-content: space-between !important;
    }
}
</style>
@endsection
