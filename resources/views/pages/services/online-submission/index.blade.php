@extends('layouts.app')

@section('title', 'Pengajuan Surat Online')

@push('styles')
<style>
    .filter-section {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .submission-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }

    .submission-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .submission-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e0e0e0;
    }

    .submission-title {
        font-size: 18px;
        font-weight: 700;
        color: #2b2b2b;
        margin: 0;
    }

    .submission-meta {
        display: flex;
        gap: 20px;
        font-size: 13px;
        color: #666;
        margin-bottom: 10px;
    }

    .badge-pending {
        background: #ffc107;
        color: #000;
    }

    .badge-approved {
        background: #28a745;
        color: #fff;
    }

    .badge-rejected {
        background: #dc3545;
        color: #fff;
    }

    .badge-completed {
        background: #17a2b8;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Pengajuan Surat Online</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('online-submission.index') }}" class="row g-3">
            <div class="col-md-4">
                <select name="status" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="type" class="form-control form-control-sm">
                    <option value="">Semua Jenis Surat</option>
                    @foreach($letterTypes as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('online-submission.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Submissions List -->
    @forelse($submissions as $submission)
        <div class="submission-card">
            <div class="submission-header">
                <div>
                    <h5 class="submission-title">{{ $submission['letter_type'] }}</h5>
                    <div class="submission-meta">
                        <span><i class="far fa-user"></i> {{ $submission['applicant_name'] }}</span>
                        <span><i class="far fa-calendar"></i> {{ date('d M Y', strtotime($submission['created_at'])) }}</span>
                        <span><i class="far fa-id-card"></i> {{ $submission['applicant_nik'] }}</span>
                    </div>
                    @if($submission['status'] === 'pending')
                        <span class="badge badge-pending">Menunggu</span>
                    @elseif($submission['status'] === 'approved')
                        <span class="badge badge-approved">Disetujui</span>
                    @elseif($submission['status'] === 'rejected')
                        <span class="badge badge-rejected">Ditolak</span>
                    @else
                        <span class="badge badge-completed">Selesai</span>
                    @endif
                </div>
                <div class="d-flex">
                    <a href="{{ route('online-submission.show', $submission['id']) }}" 
                       class="btn btn-sm btn-info mr-2">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    @if($submission['status'] === 'approved' || $submission['status'] === 'completed')
                        <a href="{{ route('online-submission.print', $submission['id']) }}" 
                           class="btn btn-sm btn-success" 
                           target="_blank">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <strong>Keperluan:</strong> {{ $submission['purpose'] }}
            </div>
            @if(!empty($submission['letter_number']))
                <div class="mt-2">
                    <strong>No. Surat:</strong> {{ $submission['letter_number'] }}
                </div>
            @endif
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h5>Belum Ada Pengajuan</h5>
            <p>Belum ada permohonan surat yang masuk.</p>
        </div>
    @endforelse
</div>
@endsection
