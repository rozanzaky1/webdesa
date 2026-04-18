@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ubah Penduduk</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Ada kesalahan dalam pengisian form:
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col">
        <form action="{{ route('residents.update', $resident->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card shadow">
                <div class="card-body">

                    <div class="form-group mb-3">
                        <label for="family_card_number">Nomor Kartu Keluarga (KK)</label>
                        <input type="number" name="family_card_number" id="family_card_number" value="{{ old('family_card_number', $resident->family_card_number) }}" class="form-control @error('family_card_number') is-invalid @enderror" max="9999999999999999" inputmode="numeric" required style="appearance: textfield; -moz-appearance: textfield;">
                        <small class="text-muted">Harus tepat 16 digit</small>
                        @error('family_card_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nik">NIK</label>
                        <input type="number" name="nik" id="nik" value="{{ old('nik', $resident->nik) }}" class="form-control @error('nik') is-invalid @enderror" inputmode="numeric" max="9999999999999999" required style="appearance: textfield; -moz-appearance: textfield;">
                        <small class="text-muted">Harus tepat 16 digit</small>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $resident->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="gender">Jenis Kelamin</label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                            <option value="Male" {{ old('gender', $resident->gender) == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Female" {{ old('gender', $resident->gender) == 'Female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="birth_place">Tempat Lahir</label>
                        <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $resident->birth_place) }}" class="form-control @error('birth_place') is-invalid @enderror" required>
                        @error('birth_place')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="birth_date">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', optional($resident->birth_date)->format('Y-m-d')) }}" class="form-control @error('birth_date') is-invalid @enderror" required>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" cols="30" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $resident->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="hamlet">Dusun</label>
                        <select name="hamlet" id="hamlet" class="form-control @error('hamlet') is-invalid @enderror">
                            <option value="">-- Pilih Dusun --</option>
                            @foreach($hamlets ?? [] as $hamlet)
                                <option value="{{ $hamlet }}" {{ old('hamlet', $resident->hamlet) == $hamlet ? 'selected' : '' }}>{{ $hamlet }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Opsional - Pilih dusun tempat tinggal</small>
                        @error('hamlet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="form-group mb-3">                        <label for="religion">Agama</label>
                        <select name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('religion', $resident->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('religion', $resident->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('religion', $resident->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('religion', $resident->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion', $resident->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('religion', $resident->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('religion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="marital_status">Status Perkawinan</label>
                        <select name="marital_status" id="marital_status" class="form-control @error('marital_status') is-invalid @enderror" required>
                            <option value="">-- Pilih Status Perkawinan --</option>
                            <option value="Single" {{ old('marital_status', $resident->marital_status) == 'Single' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Married" {{ old('marital_status', $resident->marital_status) == 'Married' ? 'selected' : '' }}>Sudah Menikah</option>
                            <option value="Divorced" {{ old('marital_status', $resident->marital_status) == 'Divorced' ? 'selected' : '' }}>Pernah Menikah</option>
                        </select>
                        @error('marital_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="occupation">Pekerjaan</label>
                        <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $resident->occupation) }}" class="form-control @error('occupation') is-invalid @enderror" required>
                        @error('occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $resident->phone) }}" class="form-control @error('phone') is-invalid @enderror" inputmode="numeric" maxlength="15">
                        <small class="text-muted">Opsional - Nomor telepon/HP</small>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Status Penduduk</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">-- Pilih Status Penduduk --</option>
                            <option value="active" {{ old('status', $resident->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="moved" {{ old('status', $resident->status) == 'moved' ? 'selected' : '' }}>Pindah</option>
                            <option value="deceased" {{ old('status', $resident->status) == 'deceased' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-end "style="gap :10px">
                    <a href="{{ route('residents.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
