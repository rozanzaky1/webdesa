@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt text-primary"></i> Buat Surat
        </h1>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Pilih Template Surat</strong> - Silakan pilih jenis surat yang ingin dibuat. Data penduduk akan otomatis terisi setelah memilih penduduk.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <!-- Template Cards Grid -->
    <div class="template-grid">
        @foreach($templates as $template)
        <div class="template-card">
            <div class="template-icon">
                <i class="fas {{ $template['icon'] }}"></i>
            </div>
            <h3 class="template-title">{{ $template['name'] }}</h3>
            <p class="template-description">{{ $template['description'] }}</p>
            <a href="{{ route('letters.create', ['type' => $template['type']]) }}" class="btn btn-primary btn-block">
                <i class="fas fa-plus me-1"></i> Buat Surat
            </a>
        </div>
        @endforeach
    </div>
</div>

<style>
.template-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.template-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 2px solid #e3e6f0;
    transition: all 0.3s ease;
    text-align: center;
}

.template-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    border-color: #4e73df;
}

.template-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
}

.template-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #5a5c69;
    margin-bottom: 10px;
}

.template-description {
    font-size: 0.9rem;
    color: #858796;
    margin-bottom: 20px;
    min-height: 40px;
}

@media (max-width: 768px) {
    .template-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
