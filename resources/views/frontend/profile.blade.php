@extends('frontend.layout')

@section('title', 'Profil Desa')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
        padding: 60px 0;
        color: white;
        margin-bottom: 40px;
    }
    
    .profile-section {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d5016;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 3px solid #4a7c2c;
    }
    
    .info-row {
        padding: 15px 0;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #2d5016;
    }
    
    .structure-image {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="display-4 font-weight-bold">Profil Desa Badran Sari</h1>
        <p class="mb-0">Informasi lengkap tentang Desa Badran Sari</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Informasi Umum -->
    <div class="profile-section">
        <h2 class="section-title"><i class="fas fa-info-circle"></i> Informasi Umum</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Nama Desa</div>
                    <div>{{ $profile['village_name'] ?? 'Badran Sari' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kecamatan</div>
                    <div>{{ $profile['district'] ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kabupaten</div>
                    <div>{{ $profile['regency'] ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Provinsi</div>
                    <div>{{ $profile['province'] ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kode Pos</div>
                    <div>{{ $profile['postal_code'] ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Website</div>
                    <div>www.badransari.desa.id</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visi -->
    @if(!empty($profile['vision']))
    <div class="profile-section">
        <h2 class="section-title"><i class="fas fa-eye"></i> Visi Desa</h2>
        <p class="lead text-justify">{{ $profile['vision'] }}</p>
    </div>
    @endif

    <!-- Misi -->
    @if(!empty($profile['mission']))
    <div class="profile-section">
        <h2 class="section-title"><i class="fas fa-bullseye"></i> Misi Desa</h2>
        <div style="white-space: pre-line; line-height: 2;">{{ $profile['mission'] }}</div>
    </div>
    @endif

    <!-- Sejarah -->
    @if(!empty($profile['history']))
    <div class="profile-section">
        <h2 class="section-title"><i class="fas fa-book"></i> Sejarah Desa</h2>
        <p class="text-justify" style="line-height: 1.8;">{{ $profile['history'] }}</p>
    </div>
    @endif

    <!-- Struktur Organisasi -->
    @if(!empty($profile['structure_image']))
    <div class="profile-section">
        <h2 class="section-title"><i class="fas fa-sitemap"></i> Struktur Organisasi</h2>
        <img src="{{ asset('storage/' . $profile['structure_image']) }}" 
             alt="Struktur Organisasi" 
             class="structure-image">
    </div>
    @endif
</div>
@endsection
