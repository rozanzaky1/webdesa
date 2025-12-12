@extends('frontend.layout')

@section('title', 'Layanan Administrasi')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
        padding: 60px 0;
        color: white;
        margin-bottom: 40px;
    }
    
    .service-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        height: 100%;
        text-align: center;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .service-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: white;
    }
    
    .service-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d5016;
        margin-bottom: 10px;
    }
    
    .service-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="display-4 font-weight-bold">Layanan Administrasi Desa</h1>
        <p class="mb-0">Ajukan permohonan surat secara online dengan mudah dan cepat</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row mb-4">
        @foreach($services as $service)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas {{ $service['icon'] }}"></i>
                    </div>
                    <h4 class="service-title">{{ $service['name'] }}</h4>
                    <p class="service-description">{{ $service['description'] }}</p>
                    <a href="{{ route('layanan.create') }}" class="btn btn-green">
                        <i class="fas fa-paper-plane mr-2"></i> Ajukan Sekarang
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="alert alert-info">
        <h5><i class="fas fa-info-circle"></i> Informasi Penting</h5>
        <ul class="mb-0">
            <li>Pastikan data yang Anda masukkan sudah benar dan sesuai</li>
            <li>Pengajuan akan diproses oleh admin dalam 1-3 hari kerja</li>
            <li>Anda akan menerima notifikasi melalui email jika pengajuan disetujui</li>
            <li>Surat yang sudah disetujui dapat dicetak langsung dari website</li>
        </ul>
    </div>
</div>
@endsection
