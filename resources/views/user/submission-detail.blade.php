@extends('layouts.user')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <h2 class="mb-1">Detail Pengajuan Surat</h2>
            <p class="text-muted">ID Pengajuan: {{ $submission['id'] }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Informasi Pemohon</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Nama Lengkap</small>
                            <strong>{{ $submission['user_name'] }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">NIK</small>
                            <strong>{{ $submission['user_nik'] ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $submission['user_email'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Informasi Surat</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Jenis Surat</small>
                        <strong>{{ $submission['letter_type'] }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Keperluan/Tujuan</small>
                        <p class="mb-0">{{ $submission['purpose'] }}</p>
                    </div>
                    @if($submission['notes'])
                    <div class="mb-3">
                        <small class="text-muted d-block">Catatan Tambahan</small>
                        <p class="mb-0">{{ $submission['notes'] }}</p>
                    </div>
                    @endif
                    <div class="mb-3">
                        <small class="text-muted d-block">Tanggal Pengajuan</small>
                        <strong>{{ date('d F Y, H:i', strtotime($submission['created_at'])) }} WIB</strong>
                    </div>
                </div>
            </div>

            @if($submission['admin_notes'])
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Catatan Admin</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $submission['admin_notes'] }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Status Pengajuan</h5>
                </div>
                <div class="card-body text-center">
                    @if($submission['status'] == 'pending')
                        <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                        <h5 class="text-warning">Menunggu Persetujuan</h5>
                        <p class="text-muted small">Pengajuan Anda sedang diproses oleh admin</p>
                    @elseif($submission['status'] == 'approved')
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">Disetujui</h5>
                        <p class="text-muted small">Pengajuan Anda telah disetujui</p>
                    @elseif($submission['status'] == 'rejected')
                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                        <h5 class="text-danger">Ditolak</h5>
                        <p class="text-muted small">Pengajuan Anda ditolak oleh admin</p>
                    @else
                        <i class="fas fa-flag-checkered fa-3x text-info mb-3"></i>
                        <h5 class="text-info">Selesai</h5>
                        <p class="text-muted small">Surat telah selesai diproses</p>
                    @endif
                </div>
            </div>

            @if($submission['letter_number'])
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Nomor Surat</h5>
                </div>
                <div class="card-body text-center">
                    <h4 class="text-primary">{{ $submission['letter_number'] }}</h4>
                </div>
            </div>
            @endif

            @if(in_array($submission['status'], ['approved', 'completed']))
            <div class="d-grid">
                <a href="{{ route('user.submission.print', $submission['id']) }}" class="btn btn-primary btn-lg" target="_blank">
                    <i class="fas fa-print me-2"></i>Cetak Surat
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
