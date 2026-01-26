@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Dusun</h1>
        <a href="{{ route('hamlets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Data Dusun</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('hamlets.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Nama Dusun -->
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Dusun <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Contoh: Dusun I" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kode Dusun -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Kode Dusun <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code') }}" placeholder="Contoh: D1" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Nama Kepala Dusun -->
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Kepala Dusun <span class="text-danger">*</span></label>
                            <input type="text" name="head_name" class="form-control @error('head_name') is-invalid @enderror" 
                                   value="{{ old('head_name') }}" required>
                            @error('head_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- No. Telepon -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="head_phone" class="form-control @error('head_phone') is-invalid @enderror" 
                                   value="{{ old('head_phone') }}" placeholder="08xxxxxxxxxx">
                            @error('head_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Jumlah RT -->
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah RT <span class="text-danger">*</span></label>
                            <input type="number" name="total_rt" class="form-control @error('total_rt') is-invalid @enderror" 
                                   value="{{ old('total_rt', 1) }}" min="1" required>
                            @error('total_rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jumlah RW -->
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah RW <span class="text-danger">*</span></label>
                            <input type="number" name="total_rw" class="form-control @error('total_rw') is-invalid @enderror" 
                                   value="{{ old('total_rw', 1) }}" min="1" required>
                            @error('total_rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('hamlets.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
