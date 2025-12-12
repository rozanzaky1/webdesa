@extends('layouts.app')

@section('title', 'Edit Profil Desa')

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .form-section h5 {
        font-size: 16px;
        font-weight: 700;
        color: #2b2b2b;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #0f7b2a;
    }

    .current-image {
        max-width: 400px;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Profil Desa</h4>
        <a href="{{ route('village-profile.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('village-profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Informasi Umum -->
        <div class="form-section">
            <h5>Informasi Umum</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="village_name" class="form-label">Nama Desa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('village_name') is-invalid @enderror" 
                           id="village_name" name="village_name" 
                           value="{{ old('village_name', $profile['village_name']) }}" required>
                    @error('village_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="district" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('district') is-invalid @enderror" 
                           id="district" name="district" 
                           value="{{ old('district', $profile['district']) }}" required>
                    @error('district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="regency" class="form-label">Kabupaten <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('regency') is-invalid @enderror" 
                           id="regency" name="regency" 
                           value="{{ old('regency', $profile['regency']) }}" required>
                    @error('regency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('province') is-invalid @enderror" 
                           id="province" name="province" 
                           value="{{ old('province', $profile['province']) }}" required>
                    @error('province')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="postal_code" class="form-label">Kode Pos</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                           id="postal_code" name="postal_code" 
                           value="{{ old('postal_code', $profile['postal_code']) }}">
                    @error('postal_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Visi -->
        <div class="form-section">
            <h5>Visi Desa</h5>
            <div class="mb-3">
                <textarea class="form-control @error('vision') is-invalid @enderror" 
                          id="vision" name="vision" rows="4" 
                          placeholder="Masukkan visi desa...">{{ old('vision', $profile['vision']) }}</textarea>
                @error('vision')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Misi -->
        <div class="form-section">
            <h5>Misi Desa</h5>
            <div class="mb-3">
                <textarea class="form-control @error('mission') is-invalid @enderror" 
                          id="mission" name="mission" rows="6" 
                          placeholder="Masukkan misi desa (pisahkan dengan enter untuk setiap poin)...">{{ old('mission', $profile['mission']) }}</textarea>
                @error('mission')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Tip: Gunakan angka atau poin untuk setiap misi, contoh: 1. Misi pertama</small>
            </div>
        </div>

        <!-- Sejarah -->
        <div class="form-section">
            <h5>Sejarah Desa</h5>
            <div class="mb-3">
                <textarea class="form-control @error('history') is-invalid @enderror" 
                          id="history" name="history" rows="8" 
                          placeholder="Masukkan sejarah desa...">{{ old('history', $profile['history']) }}</textarea>
                @error('history')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Struktur Organisasi -->
        <div class="form-section">
            <h5>Struktur Organisasi Desa</h5>
            @if(!empty($profile['structure_image']))
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini:</label>
                    <div>
                        <img src="{{ asset('storage/' . $profile['structure_image']) }}" 
                             alt="Struktur Organisasi" class="current-image">
                    </div>
                </div>
            @endif
            <div class="mb-3">
                <label for="structure_image" class="form-label">
                    {{ !empty($profile['structure_image']) ? 'Ganti Gambar Struktur' : 'Upload Gambar Struktur' }}
                </label>
                <input type="file" class="form-control @error('structure_image') is-invalid @enderror" 
                       id="structure_image" name="structure_image" accept="image/jpeg,image/png,image/jpg">
                @error('structure_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('village-profile.index') }}" class="btn btn-secondary mr-2">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
