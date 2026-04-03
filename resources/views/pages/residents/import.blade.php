@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Import Data Penduduk</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> 
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title mb-4">Petunjuk Format Excel</h5>
                    <div class="alert alert-info">
                        <p>File Excel harus memiliki kolom dengan nama berikut:</p>
                        <ul class="mb-0">
                            <li><strong>no_kk</strong> atau <strong>family_card_number</strong> - Nomor Kartu Keluarga (16 digit)</li>
                            <li><strong>nik</strong> - Nomor Induk Kependudukan (16 digit) *Wajib</li>
                            <li><strong>nama</strong> atau <strong>name</strong> - Nama Lengkap</li>
                            <li><strong>jenis_kelamin</strong> atau <strong>gender</strong> - Male/Female atau Laki-laki/Perempuan</li>
                            <li><strong>tanggal_lahir</strong> atau <strong>birth_date</strong> - Format: DD/MM/YYYY atau YYYY-MM-DD</li>
                            <li><strong>tempat_lahir</strong> atau <strong>birth_place</strong> - Tempat Lahir</li>
                            <li><strong>alamat</strong> atau <strong>address</strong> - Alamat Lengkap</li>
                            <li><strong>dusun</strong> atau <strong>hamlet</strong> - Dusun (Opsional)</li>
                            <li><strong>agama</strong> atau <strong>religion</strong> - Agama (Islam, Kristen, dll)</li>
                            <li><strong>status_perkawinan</strong> atau <strong>marital_status</strong> - Single/Married/Divorced/Widowed</li>
                            <li><strong>pekerjaan</strong> atau <strong>occupation</strong> - Pekerjaan</li>
                            <li><strong>telepon</strong> atau <strong>phone</strong> - Nomor Telepon (Opsional)</li>
                        </ul>
                    </div>

                    <form action="{{ route('residents.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="file">Pilih File Excel</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                            <small class="text-muted">Format: Excel (.xlsx, .xls) atau CSV</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <small>
                                <strong>⚠️ Perhatian:</strong> Data yang diimport akan ditambahkan ke database yang sudah ada. 
                                Pastikan tidak ada duplikasi NIK atau No. KK.
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload mr-2"></i>Import Data
                            </button>
                            <a href="{{ route('residents.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
