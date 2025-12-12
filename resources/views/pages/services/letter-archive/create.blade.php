@extends('layouts.app')

@section('title', 'Tambah Arsip Surat')

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
        <h4 class="mb-0">Tambah Arsip Surat</h4>
        <a href="{{ route('letter-archive.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="form-section">
        <form action="{{ route('letter-archive.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="letter_number" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('letter_number') is-invalid @enderror" 
                           id="letter_number" 
                           name="letter_number" 
                           value="{{ old('letter_number') }}"
                           placeholder="Contoh: 001/SKD/01/2025" 
                           required>
                    @error('letter_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="letter_type" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                    <select class="form-control @error('letter_type') is-invalid @enderror" 
                            id="letter_type" 
                            name="letter_type" 
                            required>
                        <option value="">Pilih Jenis Surat</option>
                        @foreach($letterTypes as $type)
                            <option value="{{ $type }}" {{ old('letter_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('letter_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="recipient_name" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('recipient_name') is-invalid @enderror" 
                           id="recipient_name" 
                           name="recipient_name" 
                           value="{{ old('recipient_name') }}" 
                           required>
                    @error('recipient_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="recipient_nik" class="form-label">NIK Penerima</label>
                    <input type="text" 
                           class="form-control @error('recipient_nik') is-invalid @enderror" 
                           id="recipient_nik" 
                           name="recipient_nik" 
                           value="{{ old('recipient_nik') }}"
                           maxlength="16">
                    @error('recipient_nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="letter_date" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control @error('letter_date') is-invalid @enderror" 
                           id="letter_date" 
                           name="letter_date" 
                           value="{{ old('letter_date', date('Y-m-d')) }}" 
                           required>
                    @error('letter_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="purpose" class="form-label">Keperluan</label>
                    <input type="text" 
                           class="form-control @error('purpose') is-invalid @enderror" 
                           id="purpose" 
                           name="purpose" 
                           value="{{ old('purpose') }}"
                           placeholder="Contoh: Pembuatan SIM">
                    @error('purpose')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" 
                              name="notes" 
                              rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('letter-archive.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
