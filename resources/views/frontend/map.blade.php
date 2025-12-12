@extends('frontend.layout')

@section('title', 'Peta Desa')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%); padding: 80px 0; margin-bottom: 50px;">
    <div class="container text-center text-white">
        <h1 class="display-4 font-weight-bold mb-3">Peta Desa</h1>
        <p class="lead">Lokasi dan Wilayah Desa Badran Sari</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <!-- Peta Utama -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-map-marked-alt mr-2"></i> Peta Lokasi Desa</h5>
                </div>
                <div class="card-body p-0">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666!2d106.816!3d-6.200!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnNTcuNiJF!5e0!3m2!1sid!2sid!4v1234567890"
                            width="100%" 
                            height="500" 
                            style="border:0; border-radius: 0 0 10px 10px;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Panduan Akses -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-route mr-2"></i> Panduan Akses</h5>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Cara Menuju Desa Badran Sari:</h6>
                    <div class="access-guide">
                        <div class="guide-item mb-3">
                            <i class="fas fa-car text-primary mr-2"></i>
                            <strong>Dari Pusat Kota:</strong>
                            <p class="ml-4 mb-0 text-muted">
                                Ambil jalur utama menuju arah selatan, kemudian belok kanan di pertigaan pasar, 
                                lanjutkan sekitar 5 km hingga menemukan gerbang desa.
                            </p>
                        </div>
                        <div class="guide-item mb-3">
                            <i class="fas fa-bus text-success mr-2"></i>
                            <strong>Transportasi Umum:</strong>
                            <p class="ml-4 mb-0 text-muted">
                                Tersedia angkutan umum jurusan Terminal - Desa dengan rute melewati desa kami. 
                                Turun di halte Desa Badran Sari.
                            </p>
                        </div>
                        <div class="guide-item">
                            <i class="fas fa-motorcycle text-warning mr-2"></i>
                            <strong>Sepeda Motor/Ojek Online:</strong>
                            <p class="ml-4 mb-0 text-muted">
                                Gunakan aplikasi ojek online dan masukkan tujuan "Kantor Desa Badran Sari" 
                                atau gunakan koordinat GPS yang tersedia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Lokasi -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i> Informasi Lokasi</h5>
                </div>
                <div class="card-body">
                    <div class="location-info">
                        <div class="info-item mb-3 pb-3 border-bottom">
                            <i class="fas fa-map-pin text-danger mr-2"></i>
                            <strong>Alamat</strong>
                            <p class="mb-0 mt-1 text-muted">
                                {{ $profile['address'] ?? 'Desa Badran Sari, Kecamatan [Nama Kecamatan], Kabupaten [Nama Kabupaten]' }}
                            </p>
                        </div>
                        
                        <div class="info-item mb-3 pb-3 border-bottom">
                            <i class="fas fa-mail-bulk text-primary mr-2"></i>
                            <strong>Kode Pos</strong>
                            <p class="mb-0 mt-1 text-muted">
                                {{ $profile['postal_code'] ?? '-' }}
                            </p>
                        </div>
                        
                        <div class="info-item mb-3 pb-3 border-bottom">
                            <i class="fas fa-phone text-success mr-2"></i>
                            <strong>Telepon Kantor</strong>
                            <p class="mb-0 mt-1 text-muted">
                                {{ $profile['phone'] ?? '(021) 1234567' }}
                            </p>
                        </div>
                        
                        <div class="info-item mb-3 pb-3 border-bottom">
                            <i class="fas fa-envelope text-info mr-2"></i>
                            <strong>Email</strong>
                            <p class="mb-0 mt-1 text-muted">
                                {{ $profile['email'] ?? 'info@badransari.desa.id' }}
                            </p>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-globe text-warning mr-2"></i>
                            <strong>Koordinat GPS</strong>
                            <p class="mb-0 mt-1 text-muted">
                                {{ $profile['coordinates'] ?? '-6.200000, 106.816000' }}
                            </p>
                            <a href="https://maps.google.com/?q={{ $profile['coordinates'] ?? '-6.200000,106.816000' }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-external-link-alt mr-1"></i> Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Wilayah -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-chart-area mr-2"></i> Statistik Wilayah</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item mb-3 d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-arrows-alt text-primary mr-2"></i> Luas Wilayah</span>
                        <strong>{{ $profile['area'] ?? '250' }} Ha</strong>
                    </div>
                    <div class="stat-item mb-3 d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-mountain text-success mr-2"></i> Ketinggian</span>
                        <strong>{{ $profile['altitude'] ?? '150' }} mdpl</strong>
                    </div>
                    <div class="stat-item mb-3 d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-home text-warning mr-2"></i> Jumlah Dusun</span>
                        <strong>{{ $hamletsCount }} Dusun</strong>
                    </div>
                    <div class="stat-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-users text-info mr-2"></i> Jumlah Penduduk</span>
                        <strong>{{ number_format($residentsCount) }} Jiwa</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Batas Wilayah -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0"><i class="fas fa-border-style mr-2"></i> Batas Wilayah Desa</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="border-item p-3 bg-light rounded">
                        <i class="fas fa-arrow-up text-primary mr-2"></i>
                        <strong>Sebelah Utara:</strong>
                        <p class="mb-0 mt-2">{{ $profile['border_north'] ?? 'Desa [Nama Desa]' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="border-item p-3 bg-light rounded">
                        <i class="fas fa-arrow-right text-success mr-2"></i>
                        <strong>Sebelah Timur:</strong>
                        <p class="mb-0 mt-2">{{ $profile['border_east'] ?? 'Desa [Nama Desa]' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="border-item p-3 bg-light rounded">
                        <i class="fas fa-arrow-down text-warning mr-2"></i>
                        <strong>Sebelah Selatan:</strong>
                        <p class="mb-0 mt-2">{{ $profile['border_south'] ?? 'Desa [Nama Desa]' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="border-item p-3 bg-light rounded">
                        <i class="fas fa-arrow-left text-danger mr-2"></i>
                        <strong>Sebelah Barat:</strong>
                        <p class="mb-0 mt-2">{{ $profile['border_west'] ?? 'Desa [Nama Desa]' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.map-container {
    position: relative;
    overflow: hidden;
    border-radius: 0 0 10px 10px;
}

.location-info .info-item i {
    font-size: 1.1rem;
}

.location-info .info-item strong {
    display: block;
    color: #2d5016;
    margin-top: 5px;
}

.stat-item {
    padding: 10px;
    border-radius: 5px;
    background: #f8f9fa;
}

.border-item {
    transition: all 0.3s ease;
}

.border-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.guide-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.guide-item i {
    font-size: 1.3rem;
}

.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,122.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 50px 0 !important;
    }
    
    .hero-section h1 {
        font-size: 2rem;
    }
    
    .map-container iframe {
        height: 300px;
    }
}
</style>
@endsection
