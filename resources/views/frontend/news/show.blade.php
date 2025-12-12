@extends('frontend.layout')

@section('title', $news['title'])

@push('styles')
<style>
    .article-header {
        background: white;
        padding: 40px 0;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .article-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2d5016;
        line-height: 1.3;
        margin-bottom: 20px;
    }
    
    .article-meta {
        color: #666;
        font-size: 0.95rem;
    }
    
    .article-meta span {
        margin-right: 20px;
    }
    
    .article-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .article-content {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        font-size: 1.05rem;
        line-height: 1.8;
        color: #333;
    }
    
    .article-content p {
        margin-bottom: 20px;
    }
    
    .article-content h3,
    .article-content h4 {
        color: #2d5016;
        margin-top: 30px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .share-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 12px;
        margin-top: 40px;
    }
    
    .share-buttons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        margin-right: 10px;
        color: white;
        transition: all 0.3s;
    }
    
    .share-buttons a:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .btn-facebook { background: #3b5998; }
    .btn-twitter { background: #1da1f2; }
    .btn-whatsapp { background: #25d366; }
    .btn-telegram { background: #0088cc; }
    
    .related-news {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
    }
    
    .related-item {
        padding: 15px 0;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .related-item:last-child {
        border-bottom: none;
    }
    
    .related-item h6 {
        font-size: 1rem;
        margin-bottom: 8px;
    }
    
    .related-item a {
        color: #2d5016;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }
    
    .related-item a:hover {
        color: #4a7c2c;
    }
    
    .badge-category {
        background: #4a7c2c;
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<!-- Article Header -->
<div class="article-header">
    <div class="container">
        <div class="mb-3">
            <span class="badge-category">{{ $news['category'] }}</span>
        </div>
        <h1 class="article-title">{{ $news['title'] }}</h1>
        <div class="article-meta">
            <span><i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($news['published_at'])->format('d F Y, H:i') }} WIB</span>
            <span><i class="far fa-user"></i> Admin</span>
            <span><i class="far fa-eye"></i> {{ $news['views'] ?? 0 }} views</span>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            @if(!empty($news['image']))
                <img src="{{ asset('storage/' . $news['image']) }}" 
                     alt="{{ $news['title'] }}" 
                     class="article-image">
            @endif
            
            <div class="article-content">
                {!! nl2br(e($news['content'])) !!}
            </div>
            
            <!-- Share Section -->
            <div class="share-section">
                <h5 class="text-green mb-3"><i class="fas fa-share-alt"></i> Bagikan Berita Ini</h5>
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="btn-facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($news['title']) }}&url={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="btn-twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news['title'] . ' ' . request()->url()) }}" 
                       target="_blank" 
                       class="btn-whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($news['title']) }}" 
                       target="_blank" 
                       class="btn-telegram">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="related-news sticky-top" style="top: 20px;">
                <h5 class="text-green mb-4"><i class="fas fa-newspaper"></i> Berita Terkait</h5>
                @forelse($relatedNews as $item)
                    <div class="related-item">
                        <small class="text-muted">
                            <i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($item['published_at'])->format('d M Y') }}
                        </small>
                        <h6 class="mt-2">
                            <a href="{{ route('berita.show', $item['slug']) }}">
                                {{ Str::limit($item['title'], 80) }}
                            </a>
                        </h6>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada berita terkait</p>
                @endforelse
                
                <div class="mt-4">
                    <a href="{{ route('berita.index') }}" class="btn btn-green btn-block">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
