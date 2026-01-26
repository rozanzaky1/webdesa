@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-edit text-primary"></i> Form Buat Surat
            </h1>
            <p class="text-muted mt-2">Jenis Surat: <strong>{{ ucwords(str_replace('_', ' ', $type)) }}</strong></p>
        </div>
        <a href="{{ route('letters.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Data Surat
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('letters.store') }}" method="POST" id="letterForm">
                        @csrf
                        <input type="hidden" name="letter_type" value="{{ $type }}">
                        
                        <!-- Pilih Penduduk -->
                        <div class="form-group">
                            <label for="resident_search">Cari Penduduk <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('resident_id') is-invalid @enderror" 
                                   id="resident_search" 
                                   placeholder="Ketik NIK atau Nama penduduk..."
                                   autocomplete="off">
                            <input type="hidden" id="resident_id" name="resident_id" required>
                            <div id="resident_results" class="search-results"></div>
                            @error('resident_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Ketik minimal 2 karakter untuk mencari. Data akan otomatis terisi setelah memilih penduduk.
                            </small>
                        </div>

                        <!-- Data Penduduk (Auto-fill) -->
                        <div id="resident-data" style="display: none;">
                            <hr>
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-user"></i> Data Penduduk
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" class="form-control" id="display_nik" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" id="display_name" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat, Tanggal Lahir</label>
                                        <input type="text" class="form-control" id="display_birth" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <input type="text" class="form-control" id="display_gender" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <input type="text" class="form-control" id="display_religion" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <input type="text" class="form-control" id="display_occupation" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" id="display_address" rows="2" readonly></textarea>
                            </div>

                            <hr>
                        </div>

                        <!-- Keperluan Surat -->
                        <div class="form-group">
                            <label for="purpose">Keperluan/Tujuan Surat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('purpose') is-invalid @enderror" 
                                      id="purpose" 
                                      name="purpose" 
                                      rows="3" 
                                      required 
                                      placeholder="Contoh: Untuk keperluan melamar pekerjaan di PT. ABC"></textarea>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Data Tambahan sesuai jenis surat -->
                        <div id="additional-fields"></div>

                        <!-- Tanggal Surat -->
                        <div class="form-group">
                            <label for="letter_date">Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('letter_date') is-invalid @enderror" 
                                   id="letter_date" 
                                   name="letter_date" 
                                   value="{{ date('Y-m-d') }}" 
                                   required>
                            @error('letter_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Kepala Kampung -->
                        <div class="form-group">
                            <label for="village_head_name">Nama Kepala Kampung</label>
                            <input type="text" 
                                   class="form-control @error('village_head_name') is-invalid @enderror" 
                                   id="village_head_name" 
                                   name="village_head_name" 
                                   value="Wibowo, S.H."
                                   placeholder="Nama Kepala Kampung">
                            @error('village_head_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Nama akan muncul di tanda tangan surat</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Buat Surat
                            </button>
                            <a href="{{ route('letters.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Panduan:</strong></p>
                    <ol class="pl-3">
                        <li class="mb-2">Pilih penduduk yang akan dibuatkan surat</li>
                        <li class="mb-2">Data penduduk akan otomatis terisi</li>
                        <li class="mb-2">Isi keperluan/tujuan surat</li>
                        <li class="mb-2">Klik tombol "Buat Surat" untuk menyimpan</li>
                        <li class="mb-2">Surat dapat langsung di-preview dan dicetak</li>
                    </ol>
                </div>
            </div>

            <div class="card shadow border-left-info">
                <div class="card-body">
                    <div class="text-info font-weight-bold mb-2">
                        <i class="fas fa-lightbulb"></i> Tips
                    </div>
                    <small class="text-muted">
                        Pastikan data penduduk sudah lengkap dan benar sebelum membuat surat. 
                        Anda dapat mengedit data penduduk terlebih dahulu jika diperlukan.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.search-results {
    position: absolute;
    background: white;
    border: 1px solid #ddd;
    border-top: none;
    max-height: 300px;
    overflow-y: auto;
    width: calc(100% - 30px);
    z-index: 1000;
    display: none;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.search-result-item {
    padding: 12px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s;
}

.search-result-item:hover {
    background: #f8f9fa;
}

.search-result-item:last-child {
    border-bottom: none;
}

.result-nik {
    font-weight: 600;
    color: #4e73df;
    font-size: 0.9rem;
}

.result-name {
    font-weight: 500;
    color: #333;
    font-size: 1rem;
    margin-top: 2px;
}

.result-address {
    font-size: 0.85rem;
    color: #858796;
    margin-top: 4px;
}

.no-results {
    padding: 15px;
    text-align: center;
    color: #858796;
}

.search-loading {
    padding: 15px;
    text-align: center;
    color: #4e73df;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let searchTimeout;
    const residents = @json($residents);
    
    // Search functionality
    $('#resident_search').on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim().toLowerCase();
        
        if (query.length < 2) {
            $('#resident_results').hide().empty();
            $('#resident_id').val('');
            $('#resident-data').slideUp();
            return;
        }
        
        searchTimeout = setTimeout(function() {
            searchResidents(query);
        }, 300);
    });
    
    // Search residents function
    function searchResidents(query) {
        const results = residents.filter(resident => {
            const nik = resident.nik.toLowerCase();
            const name = resident.name.toLowerCase();
            return nik.includes(query) || name.includes(query);
        });
        
        displayResults(results);
    }
    
    // Display search results
    function displayResults(results) {
        const $resultsDiv = $('#resident_results');
        $resultsDiv.empty();
        
        if (results.length === 0) {
            $resultsDiv.html('<div class="no-results"><i class="fas fa-search"></i> Tidak ada data ditemukan</div>');
            $resultsDiv.show();
            return;
        }
        
        results.forEach(resident => {
            const resultHtml = `
                <div class="search-result-item" data-resident-id="${resident.id}">
                    <div class="result-nik">${resident.nik}</div>
                    <div class="result-name">${resident.name}</div>
                    <div class="result-address">${resident.address}, Dusun ${resident.hamlet}</div>
                </div>
            `;
            $resultsDiv.append(resultHtml);
        });
        
        $resultsDiv.show();
    }
    
    // Select resident from results
    $(document).on('click', '.search-result-item', function() {
        const residentId = $(this).data('resident-id');
        const resident = residents.find(r => r.id === residentId);
        
        if (resident) {
            $('#resident_search').val(resident.nik + ' - ' + resident.name);
            $('#resident_id').val(resident.id);
            $('#resident_results').hide();
            
            // Fill resident data
            fillResidentData(resident);
        }
    });
    
    // Close results when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#resident_search, #resident_results').length) {
            $('#resident_results').hide();
        }
    });
    
    // Fill resident data
    function fillResidentData(resident) {
        $('#resident-data').slideDown();
        
        $('#display_nik').val(resident.nik);
        $('#display_name').val(resident.name);
        $('#display_birth').val(resident.birth_place + ', ' + formatDate(resident.birth_date));
        $('#display_gender').val(resident.gender);
        $('#display_religion').val(resident.religion);
        $('#display_occupation').val(resident.occupation);
        $('#display_address').val(resident.address + ', Dusun ' + resident.hamlet);
    }
    
    // Format date function
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
    }
    
    // Add additional fields based on letter type
    const letterType = '{{ $type }}';
    let additionalHTML = '';
    
    if (letterType === 'usaha') {
        additionalHTML = `
            <div class="form-group">
                <label>Nama Usaha</label>
                <input type="text" class="form-control" name="additional_data[business_name]" placeholder="Contoh: Toko Sembako Makmur">
            </div>
            <div class="form-group">
                <label>Jenis Usaha</label>
                <input type="text" class="form-control" name="additional_data[business_type]" placeholder="Contoh: Perdagangan">
            </div>
        `;
    } else if (letterType === 'kematian') {
        additionalHTML = `
            <div class="form-group">
                <label>Tanggal Meninggal</label>
                <input type="date" class="form-control" name="additional_data[death_date]">
            </div>
            <div class="form-group">
                <label>Tempat Meninggal</label>
                <input type="text" class="form-control" name="additional_data[death_place]" placeholder="Contoh: RS. Umum Daerah">
            </div>
            <div class="form-group">
                <label>Penyebab Kematian</label>
                <input type="text" class="form-control" name="additional_data[death_cause]" placeholder="Contoh: Sakit">
            </div>
        `;
    } else if (letterType === 'nikah') {
        additionalHTML = `
            <div class="form-group">
                <label>Nama Calon Pasangan</label>
                <input type="text" class="form-control" name="additional_data[partner_name]" placeholder="Nama lengkap calon pasangan">
            </div>
        `;
    } else if (letterType === 'kelahiran') {
        additionalHTML = `
            <div class="form-group">
                <label>Nama Bayi</label>
                <input type="text" class="form-control" name="additional_data[baby_name]" placeholder="Nama bayi">
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" class="form-control" name="additional_data[birth_date]">
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" class="form-control" name="additional_data[birth_place]" placeholder="Contoh: RS. Bersalin">
            </div>
        `;
    }
    
    if (additionalHTML) {
        $('#additional-fields').html(`
            <hr>
            <h5 class="text-primary mb-3">
                <i class="fas fa-plus-circle"></i> Data Tambahan
            </h5>
            ${additionalHTML}
        `);
    }
});
</script>
@endpush
@endsection
