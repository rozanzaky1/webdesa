@extends('layouts.app')

@section('title', 'Detail Arsip Surat')

@push('styles')
<style>
    .detail-section {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
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
        <h4 class="mb-0">Detail Arsip Surat</h4>
        <div>
            <a href="{{ route('letter-archive.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>

    <div class="detail-section">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Nomor Surat</div>
                    <div class="detail-value">{{ $archive['letter_number'] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Jenis Surat</div>
                    <div class="detail-value">{{ $archive['letter_type'] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Nama Penerima</div>
                    <div class="detail-value">{{ $archive['recipient_name'] }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">NIK Penerima</div>
                    <div class="detail-value">{{ $archive['recipient_nik'] ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Tanggal Surat</div>
                    <div class="detail-value">{{ date('d F Y', strtotime($archive['letter_date'])) }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <div class="detail-label">Keperluan</div>
                    <div class="detail-value">{{ $archive['purpose'] ?? '-' }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="detail-item">
                    <div class="detail-label">Catatan</div>
                    <div class="detail-value">{{ $archive['notes'] ?? '-' }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="detail-item">
                    <div class="detail-label">Dibuat Pada</div>
                    <div class="detail-value">{{ date('d F Y H:i', strtotime($archive['created_at'])) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
