@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ubah Penduduk</h1>
</div>

<div class="row">
    <div class="col">
        <form action="{{ route('residents.update', $resident->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card shadow">
                <div class="card-body">

                    <div class="form-group mb-3">
                        <label for="nik">NIK</label>
                        <input type="number" name="nik" id="nik" value="{{ old('nik', $resident->nik) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $resident->name) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="gender">Jenis Kelamin</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="Male" {{ old('gender', $resident->gender) == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Female" {{ old('gender', $resident->gender) == 'Female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="birth_place">Tempat Lahir</label>
                        <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $resident->birth_place) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="birth_date">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $resident->birth_date) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" cols="30" rows="3" class="form-control" required>{{ old('address', $resident->address) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="religion">Agama</label>
                        <input type="text" name="religion" id="religion" value="{{ old('religion', $resident->religion) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="marital_status">Status Perkawinan</label>
                        <select name="marital_status" id="marital_status" class="form-control" required>
                            <option value="Single" {{ old('marital_status', $resident->marital_status) == 'Single' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Married" {{ old('marital_status', $resident->marital_status) == 'Married' ? 'selected' : '' }}>Sudah Menikah</option>
                            <option value="Divorced" {{ old('marital_status', $resident->marital_status) == 'Divorced' ? 'selected' : '' }}>Cerai</option>
                            <option value="Widowed" {{ old('marital_status', $resident->marital_status) == 'Widowed' ? 'selected' : '' }}>Duda/Janda</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="occupation">Pekerjaan</label>
                        <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $resident->occupation) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $resident->phone) }}" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Status Penduduk</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" {{ old('status', $resident->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="moved" {{ old('status', $resident->status) == 'moved' ? 'selected' : '' }}>Pindah</option>
                            <option value="deceased" {{ old('status', $resident->status) == 'deceased' ? 'selected' : '' }}>Meninggal</option>
                        </select>
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
