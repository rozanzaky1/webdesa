@extends('layouts.app')

@section('title', 'Berita Desa')

@push('styles')
<style>
    .filter-section {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .news-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        display: flex;
        gap: 20px;
        transition: transform 0.2s;
    }

    .news-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .news-image {
        width: 180px;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
    }

    .news-image-placeholder {
        width: 180px;
        height: 120px;
        background: #e9ecef;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 48px;
        flex-shrink: 0;
    }

    .news-content {
        flex: 1;
        min-width: 0;
    }

    .news-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 15px;
        margin-bottom: 10px;
    }

    .news-title {
        font-size: 18px;
        font-weight: 700;
        color: #2b2b2b;
        margin: 0 0 8px 0;
    }

    .news-meta {
        display: flex;
        gap: 15px;
        font-size: 13px;
        color: #666;
        margin-bottom: 10px;
    }

    .news-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .news-excerpt {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .news-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .badge-featured {
        background: #ffc107;
        color: #000;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-draft {
        background: #6c757d;
        color: #fff;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-published {
        background: #28a745;
        color: #fff;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
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
        <h4 class="mb-0">Berita Desa</h4>
        <a href="{{ route('news.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tulis Berita
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

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('news.index') }}" class="row g-3">
            <div class="col-md-4">
                <select name="category" class="form-control form-control-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Dipublikasi</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('news.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- News List -->
    @forelse($news as $article)
        <div class="news-card">
            @if(!empty($article['image']))
                <img src="{{ asset('storage/' . $article['image']) }}" alt="{{ $article['title'] }}" class="news-image">
            @else
                <div class="news-image-placeholder">
                    <i class="far fa-image"></i>
                </div>
            @endif

            <div class="news-content">
                <div class="news-header">
                    <div>
                        <h5 class="news-title">{{ $article['title'] }}</h5>
                        <div class="news-meta">
                            <span><i class="far fa-calendar"></i> {{ date('d M Y', strtotime($article['created_at'])) }}</span>
                            <span><i class="fas fa-tag"></i> {{ $article['category'] }}</span>
                            <span><i class="far fa-eye"></i> {{ $article['views'] ?? 0 }} views</span>
                        </div>
                        <div class="mb-2">
                            @if($article['status'] === 'published')
                                <span class="badge-published">Dipublikasi</span>
                            @else
                                <span class="badge-draft">Draft</span>
                            @endif
                            @if($article['is_featured'] ?? false)
                                <span class="badge-featured"><i class="fas fa-star"></i> Favorit</span>
                            @endif
                        </div>
                    </div>
                    <div class="news-actions">
                        <form action="{{ route('news.toggle-featured', $article['id']) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ ($article['is_featured'] ?? false) ? 'btn-warning' : 'btn-outline-warning' }}" title="Toggle Favorit">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>
                        <a href="{{ route('news.edit', $article['id']) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" 
                                data-toggle="modal" 
                                data-target="#deleteModal{{ $article['id'] }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <p class="news-excerpt">{{ $article['excerpt'] }}</p>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $article['id'] }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('news.destroy', $article['id']) }}" method="POST">
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
                            <p class="mb-0">Apakah Anda yakin ingin menghapus berita:</p>
                            <div class="mt-3 p-3 bg-light rounded">
                                <strong>{{ $article['title'] }}</strong>
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
            <i class="far fa-newspaper"></i>
            <h5>Belum Ada Berita</h5>
            <p>Klik tombol "Tulis Berita" untuk membuat berita pertama.</p>
        </div>
    @endforelse
</div>
@endsection
