@extends('frontend.layout')

@section('title', 'Beranda')

@push('styles')
<style>
    /* Hero Carousel Section */
    .hero-carousel {
        position: relative;
        height: 600px;
        overflow: hidden;
    }
    
    .hero-carousel .carousel-item {
        height: 600px;
        position: relative;
    }
    
    .hero-carousel .carousel-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(45, 80, 22, 0.85), rgba(74, 124, 44, 0.85));
        z-index: 1;
    }
    
    .hero-carousel .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        animation: kenburns 10s ease-out infinite;
    }
    
    @keyframes kenburns {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    .hero-carousel .carousel-caption {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        width: 90%;
        max-width: 900px;
        text-align: center;
        padding: 0 15px;
    }
    
    .hero-section {
        min-height: 600px;
        display: flex;
        align-items: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        animation: fadeInUp 1.2s ease;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        line-height: 1.2;
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 30px;
        opacity: 0.95;
        line-height: 1.5;
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
    
    /* Hero Responsive */
    @media (max-width: 992px) {
        .hero-carousel,
        .hero-carousel .carousel-item {
            height: 500px;
        }
        .hero-title {
            font-size: 2.5rem;
        }
        .hero-subtitle {
            font-size: 1.15rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-carousel,
        .hero-carousel .carousel-item {
            height: 450px;
        }
        .hero-title {
            font-size: 2rem;
        }
        .hero-subtitle {
            font-size: 1rem;
            margin-bottom: 25px;
        }
        .hero-carousel .carousel-caption {
            width: 95%;
        }
        .btn-lg {
            padding: 10px 20px;
            font-size: 1rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-carousel,
        .hero-carousel .carousel-item {
            height: 400px;
        }
        .hero-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .hero-subtitle {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        .btn-lg {
            padding: 8px 16px;
            font-size: 0.9rem;
            margin: 5px !important;
        }
    }
    
    @media (max-width: 360px) {
        .hero-carousel,
        .hero-carousel .carousel-item {
            height: 350px;
        }
        .hero-title {
            font-size: 1.25rem;
        }
        .hero-subtitle {
            font-size: 0.85rem;
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
    
    /* Section Responsive */
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.6rem;
        }
    }
    
    @media (max-width: 576px) {
        .section-title {
            font-size: 1.4rem;
        }
        .section-title::after {
            width: 50px;
            height: 3px;
        }
    }
    
    /* Sambutan Kepala Kampung */
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
    
    /* Sambutan Responsive */
    @media (max-width: 992px) {
        .sambutan-image {
            height: 350px;
        }
        .sambutan-content {
            padding: 30px;
        }
    }
    
    @media (max-width: 768px) {
        .sambutan-section {
            padding: 40px 0;
        }
        .sambutan-image {
            height: 300px;
        }
        .sambutan-content {
            padding: 25px;
        }
    }
    
    @media (max-width: 576px) {
        .sambutan-section {
            padding: 30px 0;
        }
        .sambutan-image {
            height: 250px;
        }
        .sambutan-content {
            padding: 20px;
            font-size: 0.9rem;
        }
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
    
    /* News Card Responsive */
    @media (max-width: 992px) {
        .news-image {
            height: 180px;
        }
        .news-content {
            padding: 18px;
        }
    }
    
    @media (max-width: 768px) {
        .news-card {
            margin-bottom: 20px;
        }
        .news-image {
            height: 200px;
        }
        .news-title {
            font-size: 1.05rem;
        }
        .news-content {
            padding: 16px;
        }
    }
    
    @media (max-width: 576px) {
        .news-card {
            margin-bottom: 15px;
        }
        .news-image {
            height: 180px;
        }
        .news-title {
            font-size: 1rem;
        }
        .news-meta {
            font-size: 0.8rem;
        }
        .news-excerpt {
            font-size: 0.85rem;
        }
        .news-content {
            padding: 15px;
        }
    }
    
    /* Statistik Kampung */
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
        line-height: 1;
    }
    
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    /* Stats Responsive */
    @media (max-width: 992px) {
        .stats-section {
            padding: 50px 0;
        }
        .stat-icon {
            font-size: 2.5rem;
        }
        .stat-number {
            font-size: 2.2rem;
        }
        .stat-label {
            font-size: 0.95rem;
        }
    }
    
    @media (max-width: 768px) {
        .stats-section {
            padding: 40px 0;
        }
        .stat-card {
            padding: 25px 15px;
            margin-bottom: 20px;
        }
        .stat-icon {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        .stat-number {
            font-size: 2rem;
        }
        .stat-label {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 576px) {
        .stats-section {
            padding: 30px 0;
        }
        .stat-card {
            padding: 20px 10px;
        }
        .stat-icon {
            font-size: 2rem;
        }
        .stat-number {
            font-size: 1.8rem;
        }
        .stat-label {
            font-size: 0.85rem;
        }
    }
    
    /* Peta Section */
    .map-section {
        padding: 60px 0;
    }
    
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        height: 500px;
    }
    
    /* Map Responsive */
    @media (max-width: 768px) {
        .map-section {
            padding: 40px 0;
        }
        .map-container {
            height: 400px;
        }
    }
    
    @media (max-width: 576px) {
        .map-section {
            padding: 30px 0;
        }
        .map-container {
            height: 350px;
            border-radius: 10px;
        }
    }
    
    /* General Section Padding Responsive */
    @media (max-width: 768px) {
        section {
            padding: 40px 0 !important;
        }
    }
    
    @media (max-width: 576px) {
        section {
            padding: 30px 0 !important;
        }
    }
    
    /* Utility Spacing Responsive */
    @media (max-width: 768px) {
        .mb-4, .my-4 {
            margin-bottom: 1.25rem !important;
        }
        .mb-5, .my-5 {
            margin-bottom: 2rem !important;
        }
        .pt-5, .py-5 {
            padding-top: 2rem !important;
        }
        .pb-5, .py-5 {
            padding-bottom: 2rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .mb-4, .my-4 {
            margin-bottom: 1rem !important;
        }
        .mb-5, .my-5 {
            margin-bottom: 1.5rem !important;
        }
        .pt-5, .py-5 {
            padding-top: 1.5rem !important;
        }
        .pb-5, .py-5 {
            padding-bottom: 1.5rem !important;
        }
    }
    
    /* Alert Responsive */
    @media (max-width: 768px) {
        .alert {
            min-width: 250px;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 576px) {
        .alert {
            min-width: 200px;
            font-size: 0.85rem;
            top: 70px !important;
            right: 10px !important;
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

<!-- Hero Carousel Section -->
<div id="heroCarousel" class="carousel slide hero-carousel" data-ride="carousel" data-interval="5000">
    <ol class="carousel-indicators">
        <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#heroCarousel" data-slide-to="1"></li>
        <li data-target="#heroCarousel" data-slide-to="2"></li>
        <li data-target="#heroCarousel" data-slide-to="3"></li>
    </ol>
    
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&h=600&fit=crop" alt="Pemandangan Kampung" class="d-block w-100">
            <div class="carousel-caption">
                <div class="hero-content">
                    <h1 class="hero-title">Selamat Datang di Website<br>Kampung Kedaton Sari</h1>
                    <p class="hero-subtitle">Portal Informasi & Layanan Digital untuk Masyarakat Kampung</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
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
                            <i class="fas fa-info-circle"></i> Profil Kampung
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 2 -->
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=1920&h=600&fit=crop" alt="Pertanian Kampung" class="d-block w-100">
            <div class="carousel-caption">
                <div class="hero-content">
                    <h1 class="hero-title">Kampung Maju, Masyarakat Sejahtera</h1>
                    <p class="hero-subtitle">Membangun Kampung Bersama untuk Masa Depan yang Lebih Baik</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('profil-desa') }}" class="btn btn-light btn-lg mr-3">
                            <i class="fas fa-info-circle"></i> Tentang Kami
                        </a>
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-newspaper"></i> Berita Kampung
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 3 -->
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=1920&h=600&fit=crop" alt="Alam Kampung" class="d-block w-100">
            <div class="carousel-caption">
                <div class="hero-content">
                    <h1 class="hero-title">Pelayanan Digital Terpadu</h1>
                    <p class="hero-subtitle">Kemudahan Akses Layanan Administrasi Secara Online</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @auth
                            <a href="{{ route('layanan.index') }}" class="btn btn-light btn-lg mr-3">
                                <i class="fas fa-laptop"></i> Layanan Digital
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg mr-3">
                                <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                            </a>
                        @endauth
                        <a href="{{ route('lembaga-desa') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-building"></i> Lembaga Kampung
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 4 -->
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1920&h=600&fit=crop" alt="Gotong Royong" class="d-block w-100">
            <div class="carousel-caption">
                <div class="hero-content">
                    <h1 class="hero-title">Transparansi & Akuntabilitas</h1>
                    <p class="hero-subtitle">Informasi Publik yang Terbuka dan Dapat Dipertanggungjawabkan</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('berita.index') }}" class="btn btn-light btn-lg mr-3">
                            <i class="fas fa-newspaper"></i> Info Terkini
                        </a>
                        <a href="{{ route('profil-desa') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-chart-bar"></i> Data Kampung
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- Statistik Kampung -->
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

<!-- Sambutan Kepala Kampung -->
@if(!empty($greeting))
<section class="sambutan-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Sambutan Kepala Kampung</h2>
        </div>
        <div class="sambutan-card">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-4">
                    <img src="{{ asset('storage/' . $greeting['image']) }}" 
                         alt="Kepala Kampung" 
                         class="sambutan-image"
                         onerror="this.src='https://via.placeholder.com/400x400/2d5016/ffffff?text=Kepala+Kampung'">
                </div>
                <div class="col-lg-8">
                    <div class="sambutan-content">
                        <h3 class="text-green mb-3">{{ $greeting['name'] }}</h3>
                        <p class="text-muted mb-4"><em>Kepala Kampung Kedaton Sari</em></p>
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
                <p class="text-muted">Informasi dan kegiatan terkini di Kampung Kedaton Sari</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-outline-success">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="row">
            @forelse($latestNews as $news)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card">
                        <img src="{{ !empty($news['image']) ? asset('storage/' . $news['image']) : 'https://via.placeholder.com/400x200/2d5016/ffffff?text=Berita+Kampung' }}" 
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

<!-- Peta Kampung -->
<section class="map-section bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Peta Wilayah Kampung</h2>
            <p class="text-muted">Lokasi Kampung Kedaton Sari, Kecamatan Punggur, Kabupaten Lampung Tengah</p>
        </div>
        <div class="map-container" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div id="villageMap" style="height: 500px; width: 100%;"></div>
        </div>
        <div class="mt-3 text-center">
            <small class="text-muted">
                <i class="fas fa-info-circle mr-1"></i>
                Klik dan drag untuk menjelajahi peta | Scroll untuk zoom in/out
            </small>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container text-center">
        <h3 class="text-green mb-3">Butuh Layanan Administrasi Kampung?</h3>
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

    // Initialize Leaflet Map for Kampung Badran Sari
    document.addEventListener('DOMContentLoaded', function() {
        // Create map centered on Kampung Badran Sari, Kecamatan Punggur
        var map = L.map('villageMap', {
            center: [-4.9526, 105.1526],
            zoom: 14,
            zoomControl: true,
            scrollWheelZoom: true
        });

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Define village boundary polygon (approximate coordinates for Kampung Badran Sari)
        // These coordinates create a polygon around the village area
        var villageBoundary = [
            [-4.9420, 105.1420],  // North-West
            [-4.9420, 105.1630],  // North-East
            [-4.9630, 105.1630],  // South-East
            [-4.9630, 105.1420],  // South-West
            [-4.9420, 105.1420]   // Close polygon
        ];

        // Add village boundary polygon to map
        var polygon = L.polygon(villageBoundary, {
            color: '#4A7C2C',           // Olive green border
            fillColor: '#4A7C2C',       // Olive green fill
            fillOpacity: 0.2,           // Semi-transparent
            weight: 3,                  // Border width
            dashArray: '10, 5'          // Dashed border
        }).addTo(map);

        // Add popup to polygon
        polygon.bindPopup('<div style="text-align: center;"><strong>Kampung Badran Sari</strong><br>Kecamatan Punggur<br>Kabupaten Lampung Tengah</div>');

        // Add marker for village center
        var villageCenter = L.marker([-4.9526, 105.1526], {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(map);

        // Add popup to marker
        villageCenter.bindPopup('<div style="text-align: center;"><strong>📍 Kantor Kampung Badran Sari</strong><br>Kecamatan Punggur<br>Kabupaten Lampung Tengah</div>');

        // Fit map to polygon bounds
        map.fitBounds(polygon.getBounds(), {
            padding: [50, 50]
        });

        // Add scale control
        L.control.scale({
            imperial: false,
            metric: true
        }).addTo(map);
    });
</script>
@endpush
