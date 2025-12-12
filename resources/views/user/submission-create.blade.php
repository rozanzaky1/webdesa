@extends('layouts.user')

@section('title', 'Ajukan Surat')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <h2 class="mb-1">Ajukan Surat Baru</h2>
            <p class="text-muted">Isi form di bawah ini untuk mengajukan surat</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('user.submission.store') }}" method="POST">
                @csrf

                <!-- User Info (Read Only) -->
                <div class="mb-4">
                    <h5 class="mb-3">Data Pemohon</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->nik ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->email }}" readonly>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Letter Request Form -->
                <div class="mb-4">
                    <h5 class="mb-3">Data Surat</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                        <select name="letter_type" class="form-control @error('letter_type') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Surat</option>
                            @foreach($letterTypes as $type)
                                <option value="{{ $type }}" {{ old('letter_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('letter_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keperluan/Tujuan Surat <span class="text-danger">*</span></label>
                        <textarea name="purpose" 
                                  class="form-control @error('purpose') is-invalid @enderror" 
                                  rows="4" 
                                  placeholder="Jelaskan keperluan atau tujuan pembuatan surat..."
                                  required>{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="notes" 
                                  class="form-control @error('notes') is-invalid @enderror" 
                                  rows="3"
                                  placeholder="Catatan atau informasi tambahan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Pastikan data yang Anda masukkan sudah benar. Pengajuan akan diproses oleh admin dan Anda akan menerima notifikasi melalui email.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                    </button>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
