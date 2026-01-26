@extends('frontend.layout')

@section('title', 'Lembaga Kampung')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%); padding: 80px 0; margin-bottom: 50px;">
    <div class="container text-center text-white">
        <h1 class="display-4 font-weight-bold mb-3">Lembaga Kampung</h1>
        <p class="lead">Organisasi dan Lembaga yang Berperan dalam Pembangunan Kampung</p>
    </div>
</div>

<div class="container pb-5">
    <!-- Struktur Organisasi -->
    @if(!empty($profile['organizational_structure']))
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0"><i class="fas fa-sitemap mr-2"></i> Struktur Organisasi Pemerintah Kampung</h4>
        </div>
        <div class="card-body text-center p-4">
            <img src="{{ asset($profile['organizational_structure']) }}" 
                 alt="Struktur Organisasi" 
                 class="img-fluid rounded shadow"
                 style="max-width: 100%; height: auto;">
        </div>
    </div>
    @endif

    <!-- Daftar Lembaga -->
    <h3 class="mb-4"><i class="fas fa-building mr-2"></i> Daftar Lembaga Kampung</h3>
    
    @if(count($institutions) > 0)
    <div class="row">
        @foreach($institutions as $institution)
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm institution-card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="institution-icon mr-3">
                            <i class="fas fa-{{ $institution['icon'] ?? 'building' }} fa-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-2" style="color: #2d5016;">
                                <strong>{{ $institution['name'] }}</strong>
                            </h5>
                            
                            @if(!empty($institution['description']))
                            <p class="text-muted mb-3">{{ $institution['description'] }}</p>
                            @endif
                            
                            <div class="institution-details">
                                @if(!empty($institution['chairman']))
                                <div class="mb-2">
                                    <i class="fas fa-user-tie mr-2 text-primary"></i>
                                    <strong>Ketua:</strong> {{ $institution['chairman'] }}
                                </div>
                                @endif
                                
                                @if(!empty($institution['secretary']))
                                <div class="mb-2">
                                    <i class="fas fa-user mr-2 text-success"></i>
                                    <strong>Sekretaris:</strong> {{ $institution['secretary'] }}
                                </div>
                                @endif
                                
                                @if(!empty($institution['treasurer']))
                                <div class="mb-2">
                                    <i class="fas fa-wallet mr-2 text-warning"></i>
                                    <strong>Bendahara:</strong> {{ $institution['treasurer'] }}
                                </div>
                                @endif
                                
                                @if(!empty($institution['members_count']))
                                <div class="mb-2">
                                    <i class="fas fa-users mr-2 text-info"></i>
                                    <strong>Jumlah Anggota:</strong> {{ $institution['members_count'] }} orang
                                </div>
                                @endif
                                
                                @if(!empty($institution['established_date']))
                                <div class="mb-2">
                                    <i class="far fa-calendar mr-2 text-secondary"></i>
                                    <strong>Dibentuk:</strong> {{ \Carbon\Carbon::parse($institution['established_date'])->format('d F Y') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($institution['programs']) && is_array($institution['programs']))
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="fas fa-tasks mr-1"></i> 
                        <strong>Program:</strong>
                    </small>
                    <ul class="mb-0 mt-2 pl-3">
                        @foreach($institution['programs'] as $program)
                        <li><small>{{ $program }}</small></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-building fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Data Lembaga Kampung Belum Tersedia</h5>
            <p class="text-muted">Informasi lembaga Kampung akan segera ditambahkan</p>
        </div>
    </div>
    @endif

    <!-- Info Tambahan -->
    <div class="alert alert-info mt-5">
        <h5 class="mb-3"><i class="fas fa-info-circle mr-2"></i> Tentang Lembaga Kampung</h5>
        <p class="mb-2">
            Lembaga Kampung adalah organisasi atau kelembagaan yang dibentuk atas prakarsa masyarakat 
            sesuai dengan kebutuhan dan merupakan mitra pemerintah Kampung dalam memberdayakan masyarakat.
        </p>
        <p class="mb-0">
            Lembaga-lembaga ini memiliki peran penting dalam pembangunan Kampung dan peningkatan 
            kesejahteraan masyarakat melalui berbagai program dan kegiatan.
        </p>
    </div>
</div>

<style>
.institution-card {
    border: none;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.institution-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.institution-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2d5016;
}

.institution-details {
    font-size: 0.95rem;
}

.institution-details i {
    width: 20px;
}

.card-footer {
    border-top: 1px solid #dee2e6;
}

.card-footer ul {
    list-style-type: disc;
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
}
</style>
@endsection
