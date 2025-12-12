@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Keluarga</h1>
        <a href="{{ route('families.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Keluarga</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('families.update', $family['id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- No. KK -->
                <div class="form-group mb-3">
                    <label class="form-label">No. Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                    <input type="text" name="kk" class="form-control @error('kk') is-invalid @enderror" 
                           value="{{ old('kk', $family['kk']) }}" maxlength="16" required>
                    @error('kk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Nama Kepala Keluarga -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Kepala Keluarga <span class="text-danger">*</span></label>
                            <input type="text" name="head_name" class="form-control @error('head_name') is-invalid @enderror" 
                                   value="{{ old('head_name', $family['head_name']) }}" required>
                            @error('head_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- NIK Kepala Keluarga -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">NIK Kepala Keluarga <span class="text-danger">*</span></label>
                            <input type="text" name="head_nik" class="form-control @error('head_nik') is-invalid @enderror" 
                                   value="{{ old('head_nik', $family['head_nik']) }}" maxlength="16" required>
                            @error('head_nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Dusun -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Dusun <span class="text-danger">*</span></label>
                            <select name="hamlet" class="form-control @error('hamlet') is-invalid @enderror" required>
                                <option value="">Pilih Dusun</option>
                                @foreach($hamlets as $hamlet)
                                    <option value="{{ $hamlet }}" {{ old('hamlet', $family['hamlet']) == $hamlet ? 'selected' : '' }}>{{ $hamlet }}</option>
                                @endforeach
                            </select>
                            @error('hamlet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- RT -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label">RT <span class="text-danger">*</span></label>
                            <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" 
                                   value="{{ old('rt', $family['rt']) }}" required>
                            @error('rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- RW -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label">RW <span class="text-danger">*</span></label>
                            <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" 
                                   value="{{ old('rw', $family['rw']) }}" required>
                            @error('rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="form-group mb-3">
                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                              rows="3" required>{{ old('address', $family['address']) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Kode Pos -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                   value="{{ old('postal_code', $family['postal_code'] ?? '') }}">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jumlah Anggota Keluarga -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah Anggota Keluarga <span class="text-danger">*</span></label>
                            <input type="number" name="total_members" class="form-control @error('total_members') is-invalid @enderror" 
                                   value="{{ old('total_members', $family['total_members']) }}" min="1" required>
                            @error('total_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                    <a href="{{ route('families.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
