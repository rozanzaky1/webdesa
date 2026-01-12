@extends('layouts.app')

@section('title', 'Profil Desa')

@push('styles')
<style>
    .profile-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        border-left: 4px solid #4A7C2C;
        transition: all 0.3s ease;
    }

    .profile-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(74, 124, 44, 0.15);
    }

    .profile-section h5 {
        font-size: 16px;
        font-weight: 700;
        color: #2b2b2b;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #4A7C2C;
    }

    .profile-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 14px;
        color: #2b2b2b;
        font-weight: 500;
    }

    .structure-image {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
        font-style: italic;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Profil Desa</h4>
        <a href="{{ route('village-profile.edit') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-edit"></i> Edit Profil
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Informasi Umum -->
    <div class="profile-section">
        <h5>Informasi Umum</h5>
        <div class="profile-info">
            <div class="info-item">
                <div class="info-label">Nama Desa</div>
                <div class="info-value">{{ $profile['village_name'] ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Kecamatan</div>
                <div class="info-value">{{ $profile['district'] ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Kabupaten</div>
                <div class="info-value">{{ $profile['regency'] ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Provinsi</div>
                <div class="info-value">{{ $profile['province'] ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Kode Pos</div>
                <div class="info-value">{{ $profile['postal_code'] ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Visi -->
    <div class="profile-section">
        <h5>Visi Desa</h5>
        @if(!empty($profile['vision']))
            <p style="line-height: 1.8; color: #444;">{{ $profile['vision'] }}</p>
        @else
            <div class="empty-state">Visi desa belum diisi</div>
        @endif
    </div>

    <!-- Misi -->
    <div class="profile-section">
        <h5>Misi Desa</h5>
        @if(!empty($profile['mission']))
            <div style="line-height: 1.8; color: #444; white-space: pre-line;">{{ $profile['mission'] }}</div>
        @else
            <div class="empty-state">Misi desa belum diisi</div>
        @endif
    </div>

    <!-- Sejarah -->
    <div class="profile-section">
        <h5>Sejarah Desa</h5>
        @if(!empty($profile['history']))
            <div style="line-height: 1.8; color: #444; white-space: pre-line;">{{ $profile['history'] }}</div>
        @else
            <div class="empty-state">Sejarah desa belum diisi</div>
        @endif
    </div>

    <!-- Struktur Organisasi -->
    <div class="profile-section">
        <h5>Struktur Organisasi Desa</h5>
        @if(!empty($profile['structure_image']))
            <img src="{{ asset('storage/' . $profile['structure_image']) }}" alt="Struktur Organisasi" class="structure-image">
        @else
            <div class="empty-state">Struktur organisasi belum diunggah</div>
        @endif
    </div>
</div>
@endsection
