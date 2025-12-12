@extends('frontend.layout')

@section('title', 'Form Pengajuan Surat')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
                    <h4 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Form Pengajuan Surat</h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <form action="{{ route('layanan.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', auth()->user()->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">NIK <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nik" 
                                   class="form-control @error('nik') is-invalid @enderror" 
                                   value="{{ old('nik') }}" 
                                   placeholder="Masukkan NIK 16 digit"
                                   maxlength="16"
                                   required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jenis Surat <span class="text-danger">*</span></label>
                            <select name="letter_type" class="form-control @error('letter_type') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($letterTypes as $type)
                                    <option value="{{ $type }}" {{ old('letter_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('letter_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Keperluan <span class="text-danger">*</span></label>
                            <textarea name="purpose" 
                                      class="form-control @error('purpose') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Jelaskan keperluan pengajuan surat secara detail..." 
                                      required>{{ old('purpose') }}</textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Jelaskan dengan detail untuk mempercepat proses persetujuan
                            </small>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Catatan Tambahan</label>
                            <textarea name="notes" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                            <small class="form-text text-muted">
                                Informasi tambahan yang perlu diketahui oleh petugas
                            </small>
                        </div>
                        
                        <div class="alert alert-info mb-4">
                            <h6 class="font-weight-bold mb-2">
                                <i class="fas fa-info-circle"></i> Informasi Penting:
                            </h6>
                            <ul class="mb-0 pl-3">
                                <li>Pengajuan akan diproses dalam <strong>1-3 hari kerja</strong></li>
                                <li>Pastikan data yang diisi sudah <strong>benar dan lengkap</strong></li>
                                <li>Anda dapat mengecek status pengajuan di menu <strong>Riwayat Pengajuan</strong></li>
                                <li>Surat yang sudah disetujui dapat <strong>diunduh/dicetak</strong></li>
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('layanan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4a7c2c;
    box-shadow: 0 0 0 0.2rem rgba(74, 124, 44, 0.25);
}

.alert-info {
    background-color: #e8f5e9;
    border-color: #c8e6c9;
    color: #2d5016;
}

.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}
</style>
@endsection
