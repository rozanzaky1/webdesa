@extends('frontend.layout')

@section('title', 'Form Pengajuan Surat')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
                    <h4 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Form Pengajuan Surat</h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <form action="{{ route('layanan.store') }}" method="POST">
                        @csrf
                        
                        <!-- Pilih Pemohon Section -->
                        @if($resident && $familyMembers->count() > 0)
                        <div class="alert alert-success mb-4">
                            <h6 class="font-weight-bold mb-3">
                                <i class="fas fa-users"></i> Pilih Pemohon Surat
                            </h6>
                            <div class="form-group mb-0">
                                <div class="form-check mb-2">
                                    <input class="form-check-input applicant-radio" 
                                           type="radio" 
                                           name="applicant_type" 
                                           id="self" 
                                           value="self" 
                                           checked
                                           data-nik="{{ $resident->nik }}"
                                           data-name="{{ $resident->name }}"
                                           data-gender="{{ $resident->gender }}"
                                           data-birth-place="{{ $resident->birth_place }}"
                                           data-birth-date="{{ $resident->birth_date ? \Carbon\Carbon::parse($resident->birth_date)->format('d-m-Y') : '' }}"
                                           data-address="{{ $resident->address }}"
                                           data-occupation="{{ $resident->occupation }}"
                                           data-phone="{{ $resident->phone }}">
                                    <label class="form-check-label" for="self">
                                        <strong>Diri Sendiri</strong> - {{ $resident->name }} ({{ $resident->nik }})
                                    </label>
                                </div>
                                @foreach($familyMembers as $member)
                                <div class="form-check mb-2">
                                    <input class="form-check-input applicant-radio" 
                                           type="radio" 
                                           name="applicant_type" 
                                           id="member_{{ $member->id }}" 
                                           value="{{ $member->id }}"
                                           data-nik="{{ $member->nik }}"
                                           data-name="{{ $member->name }}"
                                           data-gender="{{ $member->gender }}"
                                           data-birth-place="{{ $member->birth_place }}"
                                           data-birth-date="{{ $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('d-m-Y') : '' }}"
                                           data-address="{{ $member->address }}"
                                           data-occupation="{{ $member->occupation }}"
                                           data-phone="{{ $member->phone }}">
                                    <label class="form-check-label" for="member_{{ $member->id }}">
                                        <strong>Anggota Keluarga</strong> - {{ $member->name }} ({{ $member->nik }})
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="resident_id" id="resident_id" value="">
                        </div>
                        @endif

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   id="applicant_name"
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $resident->name ?? auth()->user()->name) }}" 
                                   readonly
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">NIK <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nik" 
                                   id="applicant_nik"
                                   class="form-control @error('nik') is-invalid @enderror" 
                                   value="{{ old('nik', $resident->nik ?? '') }}" 
                                   placeholder="Masukkan NIK 16 digit"
                                   maxlength="16"
                                   readonly
                                   required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="gender" 
                                           id="applicant_gender"
                                           class="form-control @error('gender') is-invalid @enderror" 
                                           value="{{ old('gender', $resident->gender ?? '') }}" 
                                           readonly
                                           required>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="birth_place" 
                                           id="applicant_birth_place"
                                           class="form-control @error('birth_place') is-invalid @enderror" 
                                           value="{{ old('birth_place', $resident->birth_place ?? '') }}" 
                                           readonly
                                           required>
                                    @error('birth_place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="birth_date" 
                                   id="applicant_birth_date"
                                   class="form-control @error('birth_date') is-invalid @enderror" 
                                   value="{{ old('birth_date', $resident->birth_date ? \Carbon\Carbon::parse($resident->birth_date)->format('d-m-Y') : '') }}" 
                                   placeholder="DD-MM-YYYY"
                                   readonly
                                   required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="address" 
                                      id="applicant_address"
                                      class="form-control @error('address') is-invalid @enderror" 
                                      rows="3" 
                                      readonly
                                      required>{{ old('address', $resident->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Pekerjaan <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="occupation" 
                                           id="applicant_occupation"
                                           class="form-control @error('occupation') is-invalid @enderror" 
                                           value="{{ old('occupation', $resident->occupation ?? '') }}" 
                                           readonly
                                           required>
                                    @error('occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="phone" 
                                           id="applicant_phone"
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $resident->phone ?? '') }}" 
                                           readonly
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jenis Surat <span class="text-danger">*</span></label>
                            <select name="letter_type" class="form-control @error('letter_type') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                @foreach($letterTypes as $type)
                                    <option value="{{ $type }}" {{ old('letter_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('letter_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Keperluan <span class="text-danger">*</span></label>
                            <textarea name="purpose" 
                                      class="form-control @error('purpose') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Jelaskan keperluan pengajuan surat secara detail..." 
                                      required>{{ old('purpose') }}</textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Jelaskan dengan detail untuk mempercepat proses persetujuan
                            </small>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Catatan Tambahan</label>
                            <textarea name="notes" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                            <small class="form-text text-muted">
                                Informasi tambahan yang perlu diketahui oleh petugas
                            </small>
                        </div>
                        
                        <div class="alert alert-info mb-4">
                            <h6 class="font-weight-bold mb-2">
                                <i class="fas fa-info-circle"></i> Informasi Penting:
                            </h6>
                            <ul class="mb-0 pl-3">
                                <li>Pengajuan akan diproses dalam <strong>1-3 hari kerja</strong></li>
                                <li>Pastikan data yang diisi sudah <strong>benar dan lengkap</strong></li>
                                <li>Anda dapat mengecek status pengajuan di menu <strong>Riwayat Pengajuan</strong></li>
                                <li>Surat yang sudah disetujui dapat <strong>diunduh/dicetak</strong></li>
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('layanan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4a7c2c;
    box-shadow: 0 0 0 0.2rem rgba(74, 124, 44, 0.25);
}

.alert-info {
    background-color: #e8f5e9;
    border-color: #c8e6c9;
    color: #2d5016;
}

.alert-success {
    background-color: #e8f5e9;
    border-color: #4a7c2c;
    color: #2d5016;
}

.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

.form-check-input:checked {
    background-color: #4a7c2c;
    border-color: #4a7c2c;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const applicantRadios = document.querySelectorAll('.applicant-radio');
    const residentIdInput = document.getElementById('resident_id');
    const nameInput = document.getElementById('applicant_name');
    const nikInput = document.getElementById('applicant_nik');
    const genderInput = document.getElementById('applicant_gender');
    const birthPlaceInput = document.getElementById('applicant_birth_place');
    const birthDateInput = document.getElementById('applicant_birth_date');
    const addressInput = document.getElementById('applicant_address');
    const occupationInput = document.getElementById('applicant_occupation');
    const phoneInput = document.getElementById('applicant_phone');

    // Initialize with selected value
    const selectedRadio = document.querySelector('.applicant-radio:checked');
    if (selectedRadio) {
        updateFormFields(selectedRadio);
    }

    // Handle radio change
    applicantRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                updateFormFields(this);
            }
        });
    });

    function updateFormFields(radio) {
        const nik = radio.dataset.nik || '';
        const name = radio.dataset.name || '';
        const gender = radio.dataset.gender || '';
        const birthPlace = radio.dataset.birthPlace || '';
        const birthDate = radio.dataset.birthDate || '';
        const address = radio.dataset.address || '';
        const occupation = radio.dataset.occupation || '';
        const phone = radio.dataset.phone || '';

        // Update form fields
        if (nameInput) nameInput.value = name;
        if (nikInput) nikInput.value = nik;
        if (genderInput) genderInput.value = gender;
        if (birthPlaceInput) birthPlaceInput.value = birthPlace;
        if (birthDateInput) birthDateInput.value = birthDate;
        if (addressInput) addressInput.value = address;
        if (occupationInput) occupationInput.value = occupation;
        if (phoneInput) phoneInput.value = phone;

        // Update resident_id (for self, use empty; for family member, use member ID)
        if (residentIdInput) {
            if (radio.value === 'self') {
                residentIdInput.value = '';
            } else {
                residentIdInput.value = radio.value;
            }
        }
    }
});
</script>
@endsection
