@extends('frontend.layout')

@section('title', 'Berita Desa')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
        padding: 60px 0;
        color: white;
        margin-bottom: 40px;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .news-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        margin-bottom: 30px;
    }
    
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .news-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }
    
    .news-content {
        padding: 25px;
    }
    
    .news-meta {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 12px;
    }
    
    .news-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2d5016;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    
    .news-title a {
        color: #2d5016;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .news-title a:hover {
        color: #4a7c2c;
    }
    
    .news-excerpt {
        color: #555;
        line-height: 1.7;
        margin-bottom: 15px;
    }
    
    .badge-category {
        background: #4a7c2c;
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .filter-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .search-box {
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        padding: 10px 20px;
        transition: all 0.3s;
    }
    
    .search-box:focus {
        border-color: #4a7c2c;
        box-shadow: 0 0 0 0.2rem rgba(74, 124, 44, 0.25);
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title">Berita Desa</h1>
        <p class="mb-0">Informasi dan kegiatan terkini di Desa Badran Sari</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('berita.index') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="font-weight-bold mb-2">Cari Berita</label>
                    <input type="text" 
                           name="search" 
                           class="form-control search-box" 
                           placeholder="Masukkan kata kunci..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="font-weight-bold mb-2">Kategori</label>
                    <select name="category" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-green btn-block">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- News List -->
    <div class="row">
        @forelse($news as $item)
            <div class="col-lg-4 col-md-6">
                <div class="news-card">
                    <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/400x220/2d5016/ffffff?text=Berita+Desa' }}" 
                         alt="{{ $item['title'] }}" 
                         class="news-image">
                    <div class="news-content">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge-category">{{ $item['category'] }}</span>
                        </div>
                        <div class="news-meta">
                            <i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($item['published_at'])->format('d F Y') }}
                            <span class="mx-2">•</span>
                            <i class="far fa-user"></i> Admin
                        </div>
                        <h5 class="news-title">
                            <a href="{{ route('berita.show', $item['slug']) }}">
                                {{ $item['title'] }}
                            </a>
                        </h5>
                        <p class="news-excerpt">
                            {{ Str::limit(strip_tags($item['content']), 120) }}
                        </p>
                        <a href="{{ route('berita.show', $item['slug']) }}" class="btn btn-sm btn-green">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Tidak Ada Berita</h4>
                    <p class="text-muted">Belum ada berita yang sesuai dengan pencarian Anda</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($news->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $news->links() }}
        </div>
    @endif
</div>
@endsection
