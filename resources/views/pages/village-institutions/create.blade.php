@extends('layouts.app')

@section('title', 'Tambah Lembaga Kampung')

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Tambah Lembaga Kampung</h4>
        <a href="{{ route('village-institutions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-section">
        <form action="{{ route('village-institutions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lembaga <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Contoh: PKK, Karang Taruna, BPD" 
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Pengertian / Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" 
                          name="description" 
                          rows="6" 
                          placeholder="Jelaskan tentang lembaga ini, tugas, fungsi, dan perannya...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="structure_image" class="form-label">Gambar Struktur Organisasi</label>
                <input type="file" 
                       class="form-control @error('structure_image') is-invalid @enderror" 
                       id="structure_image" 
                       name="structure_image" 
                       accept="image/jpeg,image/png,image/jpg">
                @error('structure_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('village-institutions.index') }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
