@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Dusun</h1>
        <a href="{{ route('hamlets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Dusun</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('hamlets.update', $hamlet['id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Nama Dusun -->
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Dusun <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $hamlet['name']) }}" required>
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
                                   value="{{ old('code', $hamlet['code']) }}" required>
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
                                   value="{{ old('head_name', $hamlet['head_name']) }}" required>
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
                                   value="{{ old('head_phone', $hamlet['head_phone'] ?? '') }}">
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
                                   value="{{ old('total_rt', $hamlet['total_rt']) }}" min="1" required>
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
                                   value="{{ old('total_rw', $hamlet['total_rw']) }}" min="1" required>
                            @error('total_rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jumlah KK -->
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah KK</label>
                            <input type="number" name="total_families" class="form-control @error('total_families') is-invalid @enderror" 
                                   value="{{ old('total_families', $hamlet['total_families'] ?? 0) }}" min="0">
                            @error('total_families')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jumlah Penduduk -->
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah Penduduk</label>
                            <input type="number" name="total_residents" class="form-control @error('total_residents') is-invalid @enderror" 
                                   value="{{ old('total_residents', $hamlet['total_residents'] ?? 0) }}" min="0">
                            @error('total_residents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3">{{ old('description', $hamlet['description'] ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                    <a href="{{ route('hamlets.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
