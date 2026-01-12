@extends('layouts.app')

@section('title', 'Edit Lembaga Desa')

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        border-left: 4px solid #4A7C2C;
        transition: all 0.3s ease;
    }

    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(74, 124, 44, 0.15);
    }

    .current-image {
        max-width: 400px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .current-image:hover {
        box-shadow: 0 6px 25px rgba(74, 124, 44, 0.2);
        transform: scale(1.02);
    }

    .btn-primary {
        background: #4A7C2C;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #355719;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 124, 44, 0.3);
    }

    .btn-secondary {
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Lembaga Desa</h4>
        <a href="{{ route('village-institutions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-section">
        <form action="{{ route('village-institutions.update', $institution['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lembaga <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $institution['name']) }}" 
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
                          placeholder="Jelaskan tentang lembaga ini, tugas, fungsi, dan perannya...">{{ old('description', $institution['description'] ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if(!empty($institution['structure_image']))
                <div class="mb-3">
                    <label class="form-label">Gambar Struktur Saat Ini:</label>
                    <div>
                        <img src="{{ asset('storage/' . $institution['structure_image']) }}" 
                             alt="Struktur {{ $institution['name'] }}" 
                             class="current-image">
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label for="structure_image" class="form-label">
                    {{ !empty($institution['structure_image']) ? 'Ganti Gambar Struktur' : 'Upload Gambar Struktur' }}
                </label>
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

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('village-institutions.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
