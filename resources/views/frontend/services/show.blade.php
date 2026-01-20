@extends('frontend.layout')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <a href="{{ route('layanan.history') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
                    <h4 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Detail Pengajuan Surat</h4>
                    @if($submission['status'] === 'pending')
                        <span class="badge badge-light badge-lg px-3 py-2" style="background-color: #ffc107; border-color: #ffc107;">
                            <i class="fas fa-clock mr-1"></i> Menunggu
                        </span>
                    @elseif($submission['status'] === 'approved')
                        <span class="badge badge-light badge-lg px-3 py-2" style="background-color: #28a745; border-color: #28a745;">
                            <i class="fas fa-check-circle mr-1"></i> Disetujui
                        </span>
                    @elseif($submission['status'] === 'completed')
                        <span class="badge badge-light badge-lg px-3 py-2" style="background-color: #17a2b8; border-color: #17a2b8;">
                            <i class="fas fa-check-double mr-1"></i> Selesai
                        </span>
                    @elseif($submission['status'] === 'rejected')
                        <span class="badge badge-light badge-lg px-3 py-2" style="background-color: #dc3545; border-color: #dc3545;">
                            <i class="fas fa-times-circle mr-1"></i> Ditolak
                        </span>
                    @endif
                </div>
                <div class="card-body p-4">
                    <!-- Status Timeline -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3"><i class="fas fa-tasks mr-2"></i> Status Pengerjaan</h5>
                        <div class="timeline">
                            <!-- Step 1: Pengajuan Dikirim -->
                            <div class="timeline-item completed">
                                <div class="timeline-marker">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Pengajuan Dikirim</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($submission['created_at'])->format('d M Y, H:i') }}</small>
                                </div>
                            </div>

                            <!-- Step 2: Menunggu Persetujuan / Disetujui / Ditolak -->
                            <div class="timeline-item {{ in_array($submission['status'], ['approved', 'completed', 'rejected']) ? 'completed' : ($submission['status'] == 'pending' ? 'active' : '') }}">
                                <div class="timeline-marker">
                                    @if(in_array($submission['status'], ['approved', 'completed', 'rejected']))
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-clock"></i>
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <h6>
                                        @if($submission['status'] === 'approved' || $submission['status'] === 'completed')
                                            Disetujui
                                        @elseif($submission['status'] === 'rejected')
                                            Ditolak
                                        @else
                                            Menunggu Persetujuan
                                        @endif
                                    </h6>
                                    @if(isset($submission['updated_at']) && $submission['status'] != 'pending')
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($submission['updated_at'])->format('d M Y, H:i') }}</small>
                                    @else
                                        <small class="text-muted">Sedang diproses admin</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 3: Siap Diambil (hanya muncul jika approved atau completed) -->
                            @if($submission['status'] !== 'rejected')
                            <div class="timeline-item {{ $submission['status'] == 'completed' ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    @if($submission['status'] == 'completed')
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-hourglass-half"></i>
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <h6>Siap Diambil</h6>
                                    @if($submission['status'] == 'completed')
                                        <small class="text-muted">Surat siap diambil di kantor desa</small>
                                    @else
                                        <small class="text-muted">Menunggu proses selesai</small>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Pengajuan -->
                    <h5 class="mb-3"><i class="fas fa-info-circle mr-2"></i> Informasi Pengajuan</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%" class="bg-light">ID Pengajuan</th>
                                <td><code>{{ $submission['id'] }}</code></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Nama Lengkap</th>
                                <td>{{ $submission['name'] }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">NIK</th>
                                <td>{{ $submission['nik'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Jenis Surat</th>
                                <td><strong>{{ $submission['letter_type'] }}</strong></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Keperluan</th>
                                <td>{{ $submission['purpose'] }}</td>
                            </tr>
                            @if(!empty($submission['notes']))
                            <tr>
                                <th class="bg-light">Catatan Pemohon</th>
                                <td>{{ $submission['notes'] }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th class="bg-light">Tanggal Pengajuan</th>
                                <td>{{ \Carbon\Carbon::parse($submission['created_at'])->format('d F Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Status</th>
                                <td>
                                    @if($submission['status'] === 'pending')
                                        <span class="badge badge-warning px-3 py-2">
                                            <i class="fas fa-clock mr-1"></i> Menunggu Persetujuan
                                        </span>
                                    @elseif($submission['status'] === 'approved')
                                        <span class="badge badge-success px-3 py-2">
                                            <i class="fas fa-check-circle mr-1"></i> Disetujui - Sedang Diproses
                                        </span>
                                    @elseif($submission['status'] === 'completed')
                                        <span class="badge badge-info px-3 py-2">
                                            <i class="fas fa-check-double mr-1"></i> Selesai - Siap Diambil
                                        </span>
                                    @elseif($submission['status'] === 'rejected')
                                        <span class="badge badge-danger px-3 py-2">
                                            <i class="fas fa-times-circle mr-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Catatan Admin -->
                    @if(!empty($submission['admin_notes']) && $submission['status'] != 'pending')
                    <div class="mt-4">
                        <h5 class="mb-3">
                            <i class="fas fa-comment-dots mr-2"></i> 
                            Catatan dari Admin
                        </h5>
                        <div class="alert {{ $submission['status'] === 'approved' ? 'alert-success' : 'alert-danger' }}">
                            <i class="fas fa-{{ $submission['status'] === 'approved' ? 'check' : 'info' }}-circle mr-2"></i>
                            {{ $submission['admin_notes'] }}
                        </div>
                    </div>
                    @endif

                    <!-- Nomor Surat (jika disetujui atau selesai) -->
                    @if(in_array($submission['status'], ['approved', 'completed']) && !empty($submission['letter_number']))
                    <div class="mt-4">
                        <h5 class="mb-3"><i class="fas fa-file-signature mr-2"></i> Nomor Surat</h5>
                        <div class="alert alert-info">
                            <h6 class="mb-0">
                                <i class="fas fa-hashtag mr-2"></i>
                                <strong>{{ $submission['letter_number'] }}</strong>
                            </h6>
                        </div>
                    </div>
                    @endif

                    <!-- Info Pengambilan Surat (jika completed) -->
                    @if($submission['status'] === 'completed')
                    <div class="mt-4">
                        <div class="alert alert-success">
                            <h6 class="mb-2">
                                <i class="fas fa-check-circle mr-2"></i>
                                Surat Sudah Siap Diambil!
                            </h6>
                            <p class="mb-0">
                                <i class="fas fa-info-circle mr-2"></i>
                                Silakan datang ke kantor desa untuk mengambil surat dengan membawa:
                            </p>
                            <ul class="mb-0 mt-2">
                                <li>KTP asli dan fotokopi</li>
                                <li>Nomor pengajuan: <strong>{{ $submission['id'] }}</strong></li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-4 pt-4 border-top d-flex justify-content-between">
                        <a href="{{ route('layanan.history') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        @if(in_array($submission['status'], ['approved', 'completed']))
                        <div>
                            <button class="btn btn-success" onclick="alert('Fitur cetak dalam pengembangan')">
                                <i class="fas fa-print mr-2"></i> Cetak Surat
                            </button>
                            <button class="btn btn-primary" onclick="alert('Fitur download dalam pengembangan')">
                                <i class="fas fa-download mr-2"></i> Download PDF
                            </button>
                        </div>
                        @elseif($submission['status'] === 'pending')
                        <div class="text-muted">
                            <i class="fas fa-hourglass-half mr-2"></i> Menunggu proses persetujuan admin
                        </div>
                        @elseif($submission['status'] === 'rejected')
                        <div class="text-danger">
                            <i class="fas fa-times-circle mr-2"></i> Pengajuan ditolak oleh admin
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    display: flex;
    justify-content: space-between;
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 35px;
    left: 0;
    right: 0;
    height: 2px;
    background: #e0e0e0;
    z-index: 0;
}

.timeline-item {
    position: relative;
    flex: 1;
    text-align: center;
    z-index: 1;
}

.timeline-marker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e0e0e0;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    position: relative;
}

.timeline-item.completed .timeline-marker {
    background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
}

.timeline-item.active .timeline-marker {
    background: #ffc107;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
    }
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
    color: #2d5016;
}

.badge-lg {
    font-size: 0.9rem;
    font-weight: 600;
}

.table th {
    font-weight: 600;
}

.card {
    border: none;
    border-radius: 10px;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .timeline {
        flex-direction: column;
    }
    
    .timeline::before {
        top: 0;
        bottom: 0;
        left: 20px;
        width: 2px;
        height: auto;
    }
    
    .timeline-item {
        text-align: left;
        padding-left: 60px;
        margin-bottom: 30px;
    }
    
    .timeline-marker {
        position: absolute;
        left: 0;
        margin: 0;
    }
}
</style>
@endsection
