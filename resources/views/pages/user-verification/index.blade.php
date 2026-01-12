@extends('layouts.app')

@section('title', 'Verifikasi User Warga')

@push('styles')
<style>
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        border-left: 4px solid #4A7C2C;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-item {
        background: white;
        color: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    }

    .stat-item.pending {
        background: #fd7e14;
    }

    .stat-item.approved {
        background: #4A7C2C;
    }

    .stat-item.total {
        background: #17a2b8;
    }

    .stat-item h3 {
        margin: 0 0 5px 0;
        font-size: 32px;
        font-weight: bold;
        color: white;
    }

    .stat-item p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
        color: white;
    }

    .user-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        border-left: 4px solid #4A7C2C;
        transition: all 0.3s ease;
    }

    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(74, 124, 44, 0.15);
    }

    .user-card.pending {
        border-left-color: #fd7e14;
    }

    .user-card.approved {
        border-left-color: #17a2b8;
    }

    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
    }

    .user-info h5 {
        margin: 0 0 5px 0;
        color: #333;
    }

    .user-info p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pending {
        background: #fee;
        color: #c00;
    }

    .badge-approved {
        background: #efe;
        color: #060;
    }

    .user-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .detail-item {
        font-size: 14px;
    }

    .detail-item strong {
        display: block;
        color: #666;
        font-weight: 500;
        margin-bottom: 3px;
    }

    .user-actions {
        display: flex;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .filter-section {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 8px;
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
        <h4 class="mb-0">Verifikasi User Warga</h4>
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

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-item pending">
            <h3>{{ $stats['pending'] }}</h3>
            <p>Menunggu Verifikasi</p>
        </div>
        <div class="stat-item approved">
            <h3>{{ $stats['approved'] }}</h3>
            <p>Sudah Disetujui</p>
        </div>
        <div class="stat-item total">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total User Warga</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('user-verification.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau NIK..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Sudah Disetujui</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('user-verification.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- User List -->
    @forelse($users as $user)
        <div class="user-card {{ $user->is_approved ? 'approved' : 'pending' }}">
            <div class="user-header">
                <div class="user-info">
                    <h5>{{ $user->name }}</h5>
                    <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                </div>
                <span class="badge {{ $user->is_approved ? 'badge-approved' : 'badge-pending' }}">
                    {{ $user->is_approved ? 'Disetujui' : 'Menunggu Verifikasi' }}
                </span>
            </div>

            <div class="user-details">
                <div class="detail-item">
                    <strong>NIK</strong>
                    {{ $user->nik ?? '-' }}
                </div>
                <div class="detail-item">
                    <strong>Tanggal Daftar</strong>
                    {{ $user->created_at->format('d M Y H:i') }}
                </div>
                @if($user->is_approved && $user->approved_at)
                    <div class="detail-item">
                        <strong>Disetujui Pada</strong>
                        {{ $user->approved_at->format('d M Y H:i') }}
                    </div>
                @endif
            </div>

            <div class="user-actions">
                @if(!$user->is_approved)
                    <form action="{{ route('user-verification.approve', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui user {{ $user->name }}?')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>
                @else
                    <form action="{{ route('user-verification.reject', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Batalkan persetujuan user {{ $user->name }}?')">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </form>
                @endif

                <form action="{{ route('user-verification.destroy', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user {{ $user->name }}? Data tidak dapat dikembalikan!')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h5>Tidak Ada User</h5>
            <p>Belum ada user yang sesuai dengan filter Anda.</p>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
