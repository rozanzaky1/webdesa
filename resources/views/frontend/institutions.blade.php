@extends('frontend.layout')

@section('title', 'Lembaga Kampung')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%); padding: 50px 0 40px; margin-bottom: 40px;">
    <div class="container text-center text-white">
        <h1 class="font-weight-bold mb-2" style="font-size: 2rem;">Lembaga Kampung</h1>
        <p class="mb-0" style="font-size: 0.95rem;">Organisasi dan Lembaga yang Berperan dalam Pembangunan Kampung</p>
    </div>
</div>

<div class="container pb-5">

    <!-- Daftar Lembaga -->
    <h3 class="mb-3" style="font-size: 1.5rem;"><i class="fas fa-building mr-2"></i> Daftar Lembaga Kampung</h3>
    
    @if(count($institutions) > 0)
    <div class="row">
        @foreach($institutions as $institution)
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm institution-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start mb-3">
                        <div class="institution-icon mr-3">
                            <i class="fas fa-{{ $institution['icon'] ?? 'building' }} fa-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-2" style="color: #2d5016; font-size: 1.15rem;">
                                <strong>{{ $institution['name'] }}</strong>
                            </h5>
                            
                            @if(!empty($institution['description']))
                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.5;">{{ $institution['description'] }}</p>
                            @endif
                        </div>
                    </div>
                    
                    @if(!empty($institution['structure_image']))
                    <div class="mt-3 mb-3">
                        <h6 class="mb-2" style="font-size: 0.95rem;"><i class="fas fa-sitemap mr-1"></i> Struktur Organisasi</h6>
                        <div class="structure-image-wrapper" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <img src="{{ asset('storage/' . $institution['structure_image']) }}" 
                                 alt="Struktur {{ $institution['name'] }}" 
                                 class="img-fluid rounded zoom-image"
                                 style="width: 100%; height: auto; cursor: pointer;"
                                 onclick="openImageModal(this.src, '{{ $institution['name'] }}')">
                            <small class="text-muted d-block mt-2 text-center"><i class="fas fa-search-plus"></i> Klik gambar untuk memperbesar</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-building fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Data Lembaga Kampung Belum Tersedia</h5>
            <p class="text-muted mb-0">Informasi lembaga Kampung akan segera ditambahkan</p>
        </div>
    </div>
    @endif
</div>

<!-- Modal Zoom Image -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="imageModalTitle">Struktur Organisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-4">
                <img id="modalImage" src="" alt="Struktur Organisasi" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalTitle').textContent = 'Struktur Organisasi ' + title;
    $('#imageModal').modal('show');
}
</script>

<style>
.institution-card {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.institution-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12) !important;
    border-color: #c8e6c9;
}

.institution-icon {
    width: 55px;
    height: 55px;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2d5016;
    flex-shrink: 0;
}

.structure-image-wrapper {
    border: 2px solid #e0e0e0;
    transition: all 0.2s ease;
}

.structure-image-wrapper:hover {
    border-color: #2d5016;
}

.zoom-image {
    transition: all 0.2s ease;
}

.zoom-image:hover {
    opacity: 0.9;
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
        padding: 35px 0 30px !important;
    }
    
    .hero-section h1 {
        font-size: 1.5rem !important;
    }
    
    .hero-section p {
        font-size: 0.85rem !important;
    }
    
    .institution-icon {
        width: 45px;
        height: 45px;
    }
    
    .institution-icon i {
        font-size: 1.3rem !important;
    }
}
</style>
</style>
@endsection
