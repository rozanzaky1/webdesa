@extends('layouts.app')

@section('title', 'Arsip Surat Keterangan')

@push('styles')
<style>
    .filter-section {
        background: white;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        border-left: 4px solid #4A7C2C;
        transition: all 0.3s ease;
    }

    .filter-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(74, 124, 44, 0.15);
    }

    .archive-table {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        border-left: 4px solid #4A7C2C;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
        color: #4A7C2C;
    }

    .btn-primary {
        background: #4A7C2C;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #355719;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 124, 44, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Arsip Surat Keterangan</h4>
        <a href="{{ route('letter-archive.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Arsip
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('letter-archive.index') }}" class="row g-3">
            <div class="col-md-3">
                <select name="type" class="form-control form-control-sm">
                    <option value="">Semua Jenis Surat</option>
                    @foreach($letterTypes as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date_from" class="form-control form-control-sm" 
                       placeholder="Dari Tanggal" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_to" class="form-control form-control-sm" 
                       placeholder="Sampai Tanggal" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('letter-archive.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Archive Table -->
    @if(count($archives) > 0)
        <div class="archive-table">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Surat</th>
                            <th>Jenis Surat</th>
                            <th>Penerima</th>
                            <th>NIK</th>
                            <th>Tanggal Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($archives as $index => $archive)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $archive['letter_number'] }}</strong></td>
                                <td>{{ $archive['letter_type'] }}</td>
                                <td>{{ $archive['recipient_name'] }}</td>
                                <td>{{ $archive['recipient_nik'] ?? '-' }}</td>
                                <td>{{ date('d M Y', strtotime($archive['letter_date'])) }}</td>
                                <td>
                                    <a href="{{ route('letter-archive.show', $archive['id']) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            data-toggle="modal" 
                                            data-target="#deleteModal{{ $archive['id'] }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $archive['id'] }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('letter-archive.destroy', $archive['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Hapus arsip surat <strong>{{ $archive['letter_number'] }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <h5>Belum Ada Arsip</h5>
            <p>Klik "Tambah Arsip" untuk menambahkan arsip surat.</p>
        </div>
    @endif
</div>
@endsection
