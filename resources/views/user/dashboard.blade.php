@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">Dashboard User</h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Pengajuan</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Menunggu</h6>
                            <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Disetujui</h6>
                            <h3 class="mb-0">{{ $stats['approved'] }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Ditolak</h6>
                            <h3 class="mb-0">{{ $stats['rejected'] }}</h3>
                        </div>
                        <div class="text-danger">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('user.submission.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle me-2"></i>Ajukan Surat Baru
            </a>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">Riwayat Pengajuan Surat</h5>
        </div>
        <div class="card-body">
            @if(count($submissions) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Jenis Surat</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>No. Surat</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $index => $submission)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $submission['letter_type'] }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($submission['created_at'])) }}</td>
                                <td>
                                    @if($submission['status'] == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($submission['status'] == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($submission['status'] == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-info">Selesai</span>
                                    @endif
                                </td>
                                <td>{{ $submission['letter_number'] ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('user.submission.show', $submission['id']) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(in_array($submission['status'], ['approved', 'completed']))
                                        <a href="{{ route('user.submission.print', $submission['id']) }}" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada pengajuan surat</p>
                    <a href="{{ route('user.submission.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Ajukan Surat Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
