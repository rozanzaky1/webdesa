@extends('frontend.layout')

@section('title', 'Beranda')

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, rgba(45, 80, 22, 0.9), rgba(74, 124, 44, 0.9)), 
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920') center/cover;
        min-height: 500px;
        display: flex;
        align-items: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        animation: fadeInUp 1s ease;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 30px;
        opacity: 0.95;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Section Styling */
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2d5016;
        margin-bottom: 10px;
        position: relative;
        display: inline-block;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: #4a7c2c;
        border-radius: 2px;
    }
    
    /* Sambutan Kepala Desa */
    .sambutan-section {
        padding: 60px 0;
        background: #f8f9fa;
    }
    
    .sambutan-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .sambutan-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    
    .sambutan-content {
        padding: 40px;
    }
    
    /* Berita Card */
    .news-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .news-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .news-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .news-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d5016;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    
    .news-meta {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 10px;
    }
    
    .news-excerpt {
        color: #555;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 15px;
        flex: 1;
    }
    
    .badge-category {
        background: #4a7c2c;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Statistik Desa */
    .stats-section {
        background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
        padding: 60px 0;
        color: white;
    }
    
    .stat-card {
        text-align: center;
        padding: 30px 20px;
    }
    
    .stat-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    /* Peta Section */
    .map-section {
        padding: 60px 0;
    }
    
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        .hero-subtitle {
            font-size: 1rem;
        }
        .section-title {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Success Alert -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 10px;">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 hero-content">
                <h1 class="hero-title">Selamat Datang di Website<br>Desa Badran Sari</h1>
                <p class="hero-subtitle">Portal Informasi & Layanan Digital untuk Masyarakat Desa</p>
                <div class="d-flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('layanan.index') }}" class="btn btn-light btn-lg mr-3">
                            <i class="fas fa-file-alt"></i> Layanan Online
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg mr-3">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @endauth
                    <a href="{{ route('profil-desa') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle"></i> Profil Desa
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Desa -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-number">{{ $stats['total_residents'] ?? 0 }}</div>
                    <div class="stat-label">Penduduk</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-home stat-icon"></i>
                    <div class="stat-number">{{ $stats['total_families'] ?? 0 }}</div>
                    <div class="stat-label">Keluarga</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-map-marker-alt stat-icon"></i>
                    <div class="stat-number">{{ $stats['total_hamlets'] ?? 0 }}</div>
                    <div class="stat-label">Dusun</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stat-card">
                    <i class="fas fa-building stat-icon"></i>
                    <div class="stat-number">{{ $stats['total_institutions'] ?? 0 }}</div>
                    <div class="stat-label">Lembaga</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sambutan Kepala Desa -->
@if(!empty($greeting))
<section class="sambutan-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Sambutan Kepala Desa</h2>
        </div>
        <div class="sambutan-card">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-4">
                    <img src="{{ asset('storage/' . $greeting['image']) }}" 
                         alt="Kepala Desa" 
                         class="sambutan-image"
                         onerror="this.src='https://via.placeholder.com/400x400/2d5016/ffffff?text=Kepala+Desa'">
                </div>
                <div class="col-lg-8">
                    <div class="sambutan-content">
                        <h3 class="text-green mb-3">{{ $greeting['name'] }}</h3>
                        <p class="text-muted mb-4"><em>Kepala Desa Badran Sari</em></p>
                        <div class="text-justify" style="line-height: 1.8;">
                            {{ Str::limit($greeting['message'], 500) }}
                        </div>
                        @if(strlen($greeting['message']) > 500)
                            <a href="{{ route('profil-desa') }}" class="btn btn-green mt-3">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Berita Terbaru -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title">Berita Terbaru</h2>
                <p class="text-muted">Informasi dan kegiatan terkini di Desa Badran Sari</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-outline-success">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="row">
            @forelse($latestNews as $news)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card">
                        <img src="{{ !empty($news['image']) ? asset('storage/' . $news['image']) : 'https://via.placeholder.com/400x200/2d5016/ffffff?text=Berita+Desa' }}" 
                             alt="{{ $news['title'] }}" 
                             class="news-image">
                        <div class="news-content">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge-category">{{ $news['category'] }}</span>
                                <span class="news-meta">
                                    <i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($news['published_at'])->format('d M Y') }}
                                </span>
                            </div>
                            <h5 class="news-title">{{ Str::limit($news['title'], 60) }}</h5>
                            <p class="news-excerpt">{{ Str::limit(strip_tags($news['content']), 100) }}</p>
                            <a href="{{ route('berita.show', $news['slug']) }}" class="btn btn-sm btn-green">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada berita yang dipublikasikan</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Peta Desa -->
<section class="map-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Peta Wilayah Desa</h2>
            <p class="text-muted">Lokasi dan batas wilayah Desa Badran Sari</p>
        </div>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862248!2d107.57311709999999!3d-6.903444399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container text-center">
        <h3 class="text-green mb-3">Butuh Layanan Administrasi Desa?</h3>
        <p class="text-muted mb-4">Ajukan permohonan surat secara online dengan mudah dan cepat</p>
        @auth
            <a href="{{ route('layanan.index') }}" class="btn btn-green btn-lg">
                <i class="fas fa-file-alt mr-2"></i> Ajukan Surat Sekarang
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-green btn-lg">
                <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Mengajukan Surat
            </a>
        @endauth
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Auto hide alert after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush
