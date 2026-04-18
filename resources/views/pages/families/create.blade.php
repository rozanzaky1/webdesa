@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Keluarga</h1>
        <a href="{{ route('families.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Data Keluarga</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('families.store') }}" method="POST">
                @csrf
                
                <!-- No. KK -->
                <div class="form-group mb-3">
                    <label class="form-label">No. Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                    <input type="text" name="kk" class="form-control @error('kk') is-invalid @enderror" 
                           value="{{ old('kk') }}" maxlength="16" required>
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
                                   value="{{ old('head_name') }}" required>
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
                                   value="{{ old('head_nik') }}" maxlength="16" required>
                            @error('head_nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Dusun -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Dusun</label>
                            <select name="hamlet" class="form-control @error('hamlet') is-invalid @enderror">
                                <option value="">-- Pilih Dusun --</option>
                                @foreach($hamlets as $hamlet)
                                    <option value="{{ $hamlet }}" {{ old('hamlet') == $hamlet ? 'selected' : '' }}>{{ $hamlet }}</option>
                                @endforeach
                            </select>
                            @error('hamlet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jumlah Anggota Keluarga -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah Anggota Keluarga <span class="text-danger">*</span></label>
                            <input type="number" name="total_members" class="form-control @error('total_members') is-invalid @enderror" 
                                   value="{{ old('total_members', 1) }}" min="1" required>
                            @error('total_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('families.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
