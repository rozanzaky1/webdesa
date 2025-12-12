@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@push('styles')
<style>
    .detail-section {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .detail-item {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 13px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 15px;
        color: #2b2b2b;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Detail Pengajuan Surat</h4>
        <div>
            <a href="{{ route('online-submission.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if($submission['status'] === 'approved' || $submission['status'] === 'completed')
                <a href="{{ route('online-submission.print', $submission['id']) }}" 
                   class="btn btn-success btn-sm" 
                   target="_blank">
                    <i class="fas fa-print"></i> Cetak Surat
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Applicant Information -->
    <div class="detail-section">
        <h5 class="mb-3 font-weight-bold">Informasi Pemohon</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value">{{ $submission['applicant_name'] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">NIK</div>
                    <div class="detail-value">{{ $submission['applicant_nik'] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">No. Telepon</div>
                    <div class="detail-value">{{ $submission['applicant_phone'] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $submission['applicant_email'] ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Letter Information -->
    <div class="detail-section">
        <h5 class="mb-3 font-weight-bold">Informasi Surat</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Jenis Surat</div>
                    <div class="detail-value">{{ $submission['letter_type'] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        @if($submission['status'] === 'pending')
                            <span class="badge badge-warning">Menunggu</span>
                        @elseif($submission['status'] === 'approved')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($submission['status'] === 'rejected')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-info">Selesai</span>
                        @endif
                    </div>
                </div>
            </div>
            @if(!empty($submission['letter_number']))
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-label">Nomor Surat</div>
                        <div class="detail-value">{{ $submission['letter_number'] }}</div>
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Tanggal Pengajuan</div>
                    <div class="detail-value">{{ date('d F Y H:i', strtotime($submission['created_at'])) }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="detail-item">
                    <div class="detail-label">Keperluan</div>
                    <div class="detail-value">{{ $submission['purpose'] }}</div>
                </div>
            </div>
            @if(!empty($submission['admin_notes']))
                <div class="col-12">
                    <div class="detail-item">
                        <div class="detail-label">Catatan Admin</div>
                        <div class="detail-value">{{ $submission['admin_notes'] }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Update Status -->
    <div class="detail-section">
        <h5 class="mb-3 font-weight-bold">Ubah Status</h5>
        <form action="{{ route('online-submission.update-status', $submission['id']) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" {{ $submission['status'] === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ $submission['status'] === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ $submission['status'] === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="completed" {{ $submission['status'] === 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="admin_notes" class="form-label">Catatan Admin</label>
                    <textarea class="form-control" 
                              id="admin_notes" 
                              name="admin_notes" 
                              rows="3">{{ $submission['admin_notes'] ?? '' }}</textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
