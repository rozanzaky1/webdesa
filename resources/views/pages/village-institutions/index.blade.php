@extends('layouts.app')

@section('title', 'Lembaga Desa')

@push('styles')
<style>
    .institution-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }

    .institution-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .institution-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e0e0e0;
    }

    .institution-name {
        font-size: 18px;
        font-weight: 700;
        color: #2b2b2b;
        margin: 0;
    }

    .institution-actions {
        display: flex;
        gap: 8px;
    }

    .institution-description {
        color: #444;
        line-height: 1.7;
        margin-bottom: 15px;
        white-space: pre-line;
    }

    .structure-preview {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-top: 10px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Lembaga Desa</h4>
        <a href="{{ route('village-institutions.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Lembaga
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @forelse($institutions as $institution)
        <div class="institution-card">
            <div class="institution-header">
                <h5 class="institution-name">{{ $institution['name'] }}</h5>
                <div class="institution-actions">
                    <a href="{{ route('village-institutions.edit', $institution['id']) }}" 
                       class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" 
                            data-toggle="modal" 
                            data-target="#deleteModal{{ $institution['id'] }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            @if(!empty($institution['description']))
                <div class="institution-description">
                    <strong>Pengertian:</strong><br>
                    {{ $institution['description'] }}
                </div>
            @endif

            @if(!empty($institution['structure_image']))
                <div>
                    <strong class="d-block mb-2">Struktur Organisasi:</strong>
                    <img src="{{ asset('storage/' . $institution['structure_image']) }}" 
                         alt="Struktur {{ $institution['name'] }}" 
                         class="structure-preview">
                </div>
            @endif
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $institution['id'] }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('village-institutions.destroy', $institution['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">Apakah Anda yakin ingin menghapus lembaga:</p>
                            <div class="mt-3 p-3 bg-light rounded">
                                <strong>{{ $institution['name'] }}</strong>
                            </div>
                            <p class="text-danger mt-3 mb-0">
                                <small>
                                    <i class="fas fa-info-circle me-2"></i>Data yang dihapus tidak dapat dikembalikan!
                                </small>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-building"></i>
            <h5>Belum Ada Lembaga Desa</h5>
            <p>Klik tombol "Tambah Lembaga" untuk menambahkan lembaga desa pertama.</p>
        </div>
    @endforelse
</div>
@endsection
