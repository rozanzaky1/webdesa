@extends('layouts.app')

@section('content')
     <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Penduduk</h1>
    </div>
<!-- @if ($errors->any())
        @dd ($errors->all())
        @endif  -->

    <div class="row">
        <div class="col">
            <form action="/residents" method="post">
                @csrf
                @method('POST')
                 <div class="card shadow">
                    <div class="card-body">
                      <div class="form-group mb-3">
                        <label for="nik">NIK</label>
                        <input type="number" name="nik" id="nik" class="form-control @error ('nik') is-invalid @enderror" inputmode="numeric" required style="appearance: textfield; -moz-appearance: textfield;">
                    </div>

                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control @error ('name') is-invalid @enderror" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="gender">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control @error ('gender') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Male">Laki-laki</option>
                                <option value="Female">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="birth_place">Tempat Lahir</label>
                            <input type="text" name="birth_place" id="birth_place" class="form-control @error ('birth_place') is-invalid @enderror" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="birth_date">Tanggal Lahir</label>
                            <input type="date" name="birth_date" id="birth_date" class="form-control @error ('birth_date') is-invalid @enderror" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Alamat</label>
                            <textarea name="address" id="address" cols="30" rows="3" class="form-control @error ('address') is-invalid @enderror" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="hamlet">Dusun</label>
                            <select name="hamlet" id="hamlet" class="form-control @error ('hamlet') is-invalid @enderror">
                                <option value="">-- Pilih Dusun --</option>
                                @foreach($hamlets as $hamlet)
                                    <option value="{{ $hamlet }}">{{ $hamlet }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Opsional - Pilih dusun tempat tinggal</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="family_card_number">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="family_card_number" id="family_card_number" class="form-control @error ('family_card_number') is-invalid @enderror" maxlength="20" inputmode="numeric">
                            <small class="text-muted">Opsional - Nomor KK untuk pengelompokan keluarga</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="religion">Agama</label>
                            <select name="religion" id="religion" class="form-control @error ('religion') is-invalid @enderror" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="marital_status">Status Perkawinan</label>
                            <select name="marital_status" id="marital_status" class="form-control @error ('marital_status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status Perkawinan --</option>
                                <option value="Single">Belum Menikah</option>
                                <option value="Married">Sudah Menikah</option>
                                <option value="Divorced">Cerai</option>
                                <option value="Widowed">Duda/Janda</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="occupation">Pekerjaan</label>
                            <input type="text" name="occupation" id="occupation" class="form-control @error ('occupation') is-invalid @enderror" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Telepon</label>
                            <input type="text" inputmode="numeric" name="phone" id="phone" class="form-control @error ('phone') is-invalid @enderror" maxlength="15">
                            <small class="text-muted">Opsional - Nomor telepon/HP</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status Penduduk</label>
                            <select name="status" id="status" class="form-control @error ('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status Penduduk --</option>
                                <option value="active" selected>Aktif</option>
                                <option value="moved">Pindah</option>
                                <option value="deceased">Meninggal</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer Card -->
                    <div class="card-footer d-flex justify-content-end" style="gap :10px">
                        <a href="/residents" class="btn btn-outline-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
