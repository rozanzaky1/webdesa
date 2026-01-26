@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-edit text-warning"></i> Edit Surat
            </h1>
            <p class="text-muted mt-2">No. Surat: <strong>{{ $letter->letter_number }}</strong></p>
        </div>
        <a href="{{ route('letters.show', $letter->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-edit"></i> Edit Data Surat
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('letters.update', $letter->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Data Penduduk (Read-only) -->
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-user"></i> Data Penduduk
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control bg-light" value="{{ $letter->resident->nik }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control bg-light" value="{{ $letter->resident->name }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat, Tanggal Lahir</label>
                                    <input type="text" class="form-control bg-light" value="{{ $letter->resident->birth_place }}, {{ $letter->resident->birth_date->format('d F Y') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <input type="text" class="form-control bg-light" value="{{ $letter->resident->gender }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" class="form-control bg-light" value="{{ $letter->resident->religion }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" class="form-control bg-light" value="{{ $letter->resident->occupation }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control bg-light" rows="2" readonly>{{ $letter->resident->address }}, Dusun {{ $letter->resident->hamlet }}</textarea>
                        </div>

                        <hr>

                        <!-- Keperluan Surat (Editable) -->
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-file-alt"></i> Data Surat
                        </h5>

                        <div class="form-group">
                            <label for="purpose">Keperluan/Tujuan Surat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('purpose') is-invalid @enderror" 
                                      id="purpose" 
                                      name="purpose" 
                                      rows="3" 
                                      required>{{ old('purpose', $letter->purpose) }}</textarea>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Data Tambahan sesuai jenis surat -->
                        @if($letter->letter_type == 'usaha')
                        <div class="form-group">
                            <label>Nama Usaha</label>
                            <input type="text" class="form-control" name="additional_data[business_name]" value="{{ $letter->additional_data['business_name'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Jenis Usaha</label>
                            <input type="text" class="form-control" name="additional_data[business_type]" value="{{ $letter->additional_data['business_type'] ?? '' }}">
                        </div>
                        @elseif($letter->letter_type == 'kematian')
                        <div class="form-group">
                            <label>Tanggal Meninggal</label>
                            <input type="date" class="form-control" name="additional_data[death_date]" value="{{ $letter->additional_data['death_date'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Tempat Meninggal</label>
                            <input type="text" class="form-control" name="additional_data[death_place]" value="{{ $letter->additional_data['death_place'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Penyebab Kematian</label>
                            <input type="text" class="form-control" name="additional_data[death_cause]" value="{{ $letter->additional_data['death_cause'] ?? '' }}">
                        </div>
                        @elseif($letter->letter_type == 'nikah')
                        <div class="form-group">
                            <label>Nama Calon Pasangan</label>
                            <input type="text" class="form-control" name="additional_data[partner_name]" value="{{ $letter->additional_data['partner_name'] ?? '' }}">
                        </div>
                        @elseif($letter->letter_type == 'kelahiran')
                        <div class="form-group">
                            <label>Nama Bayi</label>
                            <input type="text" class="form-control" name="additional_data[baby_name]" value="{{ $letter->additional_data['baby_name'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control" name="additional_data[birth_date]" value="{{ $letter->additional_data['birth_date'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" class="form-control" name="additional_data[birth_place]" value="{{ $letter->additional_data['birth_place'] ?? '' }}">
                        </div>
                        @endif

                        <!-- Tanggal Surat -->
                        <div class="form-group">
                            <label for="letter_date">Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('letter_date') is-invalid @enderror" 
                                   id="letter_date" 
                                   name="letter_date" 
                                   value="{{ old('letter_date', $letter->letter_date->format('Y-m-d')) }}" 
                                   required>
                            @error('letter_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Kepala Kampung -->
                        <div class="form-group">
                            <label for="village_head_name">Nama Kepala Kampung</label>
                            <input type="text" 
                                   class="form-control @error('village_head_name') is-invalid @enderror" 
                                   id="village_head_name" 
                                   name="village_head_name" 
                                   value="{{ old('village_head_name', $letter->village_head_name ?? 'Wibowo, S.H.') }}"
                                   placeholder="Nama Kepala Kampung">
                            @error('village_head_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Nama akan muncul di tanda tangan surat</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('letters.show', $letter->id) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-info-circle"></i> Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Yang Dapat Diedit:</strong></p>
                    <ul class="pl-3">
                        <li class="mb-2">Keperluan/tujuan surat</li>
                        <li class="mb-2">Data tambahan sesuai jenis surat</li>
                        <li class="mb-2">Tanggal surat</li>
                        <li class="mb-2">Nama kepala kampung</li>
                    </ul>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Tidak Dapat Diedit:</strong></p>
                    <ul class="pl-3">
                        <li class="mb-2">Nomor surat</li>
                        <li class="mb-2">Jenis surat</li>
                        <li class="mb-2">Data penduduk</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow border-left-info">
                <div class="card-body">
                    <div class="text-info font-weight-bold mb-2">
                        <i class="fas fa-lightbulb"></i> Catatan
                    </div>
                    <small class="text-muted">
                        Perubahan akan langsung tersimpan dan terlihat di preview surat.
                        Jika perlu mengubah data penduduk, silakan edit dari menu Data Penduduk.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
