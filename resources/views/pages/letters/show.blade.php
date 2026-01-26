@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-pdf text-danger"></i> Preview Surat
            </h1>
            <p class="text-muted mt-2">No. Surat: <strong>{{ $letter->letter_number }}</strong></p>
        </div>
        <div>
            <button type="button" id="toggleEditMode" class="btn btn-warning mr-2">
                <i class="fas fa-edit"></i> <span id="editModeText">Mode Edit Aktif</span>
            </button>
            <button type="button" id="saveChanges" class="btn btn-success mr-2" style="display: none;">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <button type="button" id="cancelEdit" class="btn btn-secondary mr-2" style="display: none;">
                <i class="fas fa-times"></i> Batal
            </button>
            <button onclick="printLetter()" class="btn btn-info mr-2">
                <i class="fas fa-print"></i> Cetak Surat
            </button>
            <a href="{{ route('letters.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Edit Mode Info -->
    <div id="editModeInfo" class="alert alert-warning" style="display: none;">
        <i class="fas fa-pencil-alt"></i> <strong>Mode Edit Aktif</strong> - Klik field untuk mengedit
    </div>

    <!-- Letter Preview -->
    <div class="card shadow">
        <div class="card-body p-5" id="letter-content">
            @include('pages.letters.templates.' . $letter->letter_type)
        </div>
    </div>
</div>

@push('styles')
<style>
#letter-content {
    background: white;
    min-height: 297mm; /* A4 height */
    max-width: 210mm; /* A4 width */
    margin: 0 auto;
    padding: 2cm;
}

.editable {
    transition: background-color 0.3s;
    padding: 2px 4px;
    border-radius: 3px;
    cursor: text;
}

.editable:hover {
    background-color: #fff3cd !important;
}

.editable.editing {
    background-color: #fff3cd !important;
    outline: 2px solid #ffc107;
    outline-offset: 2px;
}

.edit-mode .editable {
    background-color: #fffbea !important;
}

@media print {
    body {
        margin: 0;
        padding: 0;
    }
    
    /* Hide everything except letter content */
    .sidebar,
    .topbar,
    .navbar,
    .breadcrumb,
    .btn,
    .card-header,
    .alert,
    #editModeInfo,
    .d-sm-flex,
    h1.h3,
    .text-muted {
        display: none !important;
    }
    
    .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .card {
        box-shadow: none !important;
        border: none !important;
        margin: 0 !important;
    }
    
    .card-body {
        padding: 1cm !important;
    }
    
    #letter-content {
        padding: 1cm !important;
        margin: 0 !important;
        max-width: 100% !important;
        min-height: auto !important;
    }
    
    .editable {
        background: transparent !important;
        border: none !important;
        outline: none !important;
    }
    
    .edit-mode .editable {
        background: transparent !important;
    }
}

.letter-header {
    text-align: center;
    border-bottom: 3px solid #000;
    padding-bottom: 15px;
    margin-bottom: 30px;
}

.letter-header img {
    width: 80px;
    height: auto;
}

.letter-header h2 {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0 5px 0;
}

.letter-header p {
    font-size: 12px;
    margin: 2px 0;
}

.letter-title {
    text-align: center;
    margin: 30px 0;
}

.letter-title h3 {
    font-size: 16px;
    font-weight: bold;
    text-decoration: underline;
    margin-bottom: 5px;
}

.letter-title p {
    font-size: 12px;
}

.letter-body {
    font-size: 12px;
    line-height: 1.8;
    text-align: justify;
}

.letter-body p {
    margin-bottom: 15px;
}

.letter-footer {
    margin-top: 50px;
}

.signature-section {
    text-align: center;
    margin-top: 80px;
}

.signature-name {
    font-weight: bold;
    text-decoration: underline;
}
</style>
@endpush

@push('scripts')
<script>
let editMode = false;
let originalData = {};

function printLetter() {
    window.print();
}

$(document).ready(function() {
    // Toggle edit mode
    $('#toggleEditMode').on('click', function() {
        editMode = !editMode;
        
        if (editMode) {
            enableEditMode();
        } else {
            disableEditMode();
        }
    });
    
    // Enable edit mode
    function enableEditMode() {
        $('#letter-content').addClass('edit-mode');
        $('#editModeInfo').slideDown();
        $('#saveChanges, #cancelEdit').show();
        $('#editModeText').text('Mode Edit Aktif');
        
        // Store original data
        originalData = {
            letter_number: $('.editable[data-field="letter_number"]').text(),
            resident_name: $('.editable[data-field="resident_name"]').text(),
            resident_nik: $('.editable[data-field="resident_nik"]').text(),
            resident_birth_place: $('.editable[data-field="resident_birth_place"]').text(),
            resident_birth_date: $('.editable[data-field="resident_birth_date"]').text(),
            resident_gender: $('.editable[data-field="resident_gender"]').text(),
            resident_religion: $('.editable[data-field="resident_religion"]').text(),
            resident_occupation: $('.editable[data-field="resident_occupation"]').text(),
            resident_marital_status: $('.editable[data-field="resident_marital_status"]').text(),
            resident_address: $('.editable[data-field="resident_address"]').text(),
            purpose: $('.editable[data-field="purpose"]').text(),
            village_head_name: $('.editable[data-field="village_head_name"]').text(),
        };
        
        // Make fields editable
        $('.editable').attr('contenteditable', 'true');
    }
    
    // Disable edit mode
    function disableEditMode() {
        $('#letter-content').removeClass('edit-mode');
        $('#editModeInfo').slideUp();
        $('#saveChanges, #cancelEdit').hide();
        $('#editModeText').text('Mode Edit');
        
        $('.editable').attr('contenteditable', 'false').removeClass('editing');
    }
    
    // Save changes
    $('#saveChanges').on('click', function() {
        const data = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            letter_number: $('.editable[data-field="letter_number"]').text().trim(),
            resident_data: {
                name: $('.editable[data-field="resident_name"]').text().trim(),
                nik: $('.editable[data-field="resident_nik"]').text().trim(),
                birth_place: $('.editable[data-field="resident_birth_place"]').text().trim(),
                birth_date: $('.editable[data-field="resident_birth_date"]').attr('data-value'),
                gender: $('.editable[data-field="resident_gender"]').text().trim(),
                religion: $('.editable[data-field="resident_religion"]').text().trim(),
                occupation: $('.editable[data-field="resident_occupation"]').text().trim(),
                marital_status: $('.editable[data-field="resident_marital_status"]').text().trim(),
                address: $('.editable[data-field="resident_address"]').text().trim(),
            },
            purpose: $('.editable[data-field="purpose"]').text().trim(),
            letter_date: '{{ $letter->letter_date->format("Y-m-d") }}',
            village_head_name: $('.editable[data-field="village_head_name"]').text().trim(),
        };
        
        $.ajax({
            url: '{{ route("letters.update", $letter->id) }}',
            type: 'POST',
            data: data,
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat menyimpan data');
            }
        });
    });
    
    // Cancel edit
    $('#cancelEdit').on('click', function() {
        // Restore original data
        $('.editable[data-field="letter_number"]').text(originalData.letter_number);
        $('.editable[data-field="resident_name"]').text(originalData.resident_name);
        $('.editable[data-field="resident_nik"]').text(originalData.resident_nik);
        $('.editable[data-field="resident_birth_place"]').text(originalData.resident_birth_place);
        $('.editable[data-field="resident_birth_date"]').text(originalData.resident_birth_date);
        $('.editable[data-field="resident_gender"]').text(originalData.resident_gender);
        $('.editable[data-field="resident_religion"]').text(originalData.resident_religion);
        $('.editable[data-field="resident_occupation"]').text(originalData.resident_occupation);
        $('.editable[data-field="resident_marital_status"]').text(originalData.resident_marital_status);
        $('.editable[data-field="resident_address"]').text(originalData.resident_address);
        $('.editable[data-field="purpose"]').text(originalData.purpose);
        $('.editable[data-field="village_head_name"]').text(originalData.village_head_name);
        
        disableEditMode();
    });
    
    // Add editing class on focus
    $('.editable').on('focus', function() {
        $(this).addClass('editing');
    }).on('blur', function() {
        $(this).removeClass('editing');
    });
});
</script>
@endpush
@endsection
