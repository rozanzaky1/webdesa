@extends('layouts.app')

@push('styles')
<style>
    .hamlet-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hamlet-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }
    .stat-box {
        background: #f8f9fc;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        border: 2px solid #e3e6f0;
    }
    .stat-box h3 {
        color: #4e73df;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .stat-box p {
        color: #858796;
        font-size: 12px;
        margin: 0;
        font-weight: 600;
        text-transform: uppercase;
    }
    .badge-code {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 8px 15px;
        font-size: 13px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Dusun</h1>
        <a href="{{ route('hamlets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Tambah Dusun
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('hamlets.index') }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-0">
                            <label>Cari Nama Dusun</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Masukkan nama dusun">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('hamlets.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Cards -->
    <div class="row">
        @if(count($hamlets) > 0)
            @foreach($hamlets as $hamlet)
            <div class="col-lg-6 mb-4">
                <div class="card shadow hamlet-card h-100">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="m-0 font-weight-bold">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $hamlet['name'] }}
                                </h5>
                            </div>
                            <span class="badge badge-code">{{ $hamlet['code'] }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Statistics Row -->
                        <div class="row mb-4">
                            <div class="col-4">
                                <div class="stat-box">
                                    <h3>{{ $hamlet['total_families'] ?? 0 }}</h3>
                                    <p><i class="fas fa-home"></i> Keluarga (KK)</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box">
                                    <h3>{{ $hamlet['total_residents'] ?? 0 }}</h3>
                                    <p><i class="fas fa-users"></i> Penduduk</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box">
                                    <h3>{{ $hamlet['total_rt'] ?? 0 }}/{{ $hamlet['total_rw'] ?? 0 }}</h3>
                                    <p><i class="fas fa-layer-group"></i> RT/RW</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Info -->
                        <div class="border-top pt-3 mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fas fa-user-tie text-primary"></i> Kepala Dusun
                                    </small>
                                    <strong>{{ $hamlet['head_name'] }}</strong>
                                </div>
                                @if(isset($hamlet['head_phone']) && $hamlet['head_phone'])
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fas fa-phone text-success"></i> Telepon
                                    </small>
                                    <strong>{{ $hamlet['head_phone'] }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if(isset($hamlet['description']) && $hamlet['description'])
                        <div class="alert alert-light mb-3">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-info-circle"></i> Keterangan
                            </small>
                            <p class="mb-0 small">{{ $hamlet['description'] }}</p>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('hamlets.edit', $hamlet['id']) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit mr-1"></i>Edit Data
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $hamlet['id'] }}">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $hamlet['id'] }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $hamlet['id'] }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $hamlet['id'] }}">Konfirmasi Hapus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus data dusun <strong>{{ $hamlet['name'] }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                                <form action="{{ route('hamlets.destroy', $hamlet['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data dusun</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
