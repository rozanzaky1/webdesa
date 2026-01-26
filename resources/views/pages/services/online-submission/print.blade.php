<!DOCTYPE html>
<html>
<head>
    <title>Cetak Surat</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .toolbar {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            gap: 10px;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .toolbar button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #ffc107;
            color: #000;
        }

        .btn-edit:hover {
            background: #ffb300;
        }

        .btn-save {
            background: #28a745;
            color: white;
            display: none;
        }

        .btn-save:hover {
            background: #218838;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            display: none;
        }

        .btn-cancel:hover {
            background: #545b62;
        }

        .btn-print {
            background: #007bff;
            color: white;
        }

        .btn-print:hover {
            background: #0056b3;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #545b62;
        }

        .paper {
            background: white;
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            padding: 2cm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .header {
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 0;
        }
        
        .header table {
            width: 100%;
        }
        
        .header img {
            width: 80px;
            height: auto;
        }
        
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 3px 0;
            color: #000;
        }
        
        .header h3 {
            margin: 2px 0;
            font-size: 14pt;
            font-weight: normal;
            color: #000;
        }
        
        .header p {
            margin: 3px 0 8px 0;
            font-size: 9pt;
            font-style: italic;
            color: #000;
        }
        
        .header-line {
            border: none;
            border-top: 1px solid #000;
            margin: 0 0 20px 0;
        }
        
        .letter-title {
            text-align: center;
            margin: 10px 0 15px 0;
            font-weight: normal;
            font-size: 14pt;
            text-decoration: underline;
            color: #000;
        }
        
        .letter-number {
            text-align: center;
            margin: 0 0 20px 0;
            font-weight: normal;
            font-size: 12pt;
            color: #000;
        }
        
        .content {
            margin: 20px 0;
            text-align: justify;
        }

        .editable {
            background: transparent;
            border: none;
            font-family: inherit;
            font-size: inherit;
            padding: 2px 4px;
            border-radius: 3px;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .edit-mode .editable {
            background: #fff3cd;
            border: 1px dashed #ffc107;
            cursor: text;
        }

        .editable:focus {
            outline: 2px solid #ffc107;
            background: #fffbeb;
        }

        textarea.editable {
            width: 100%;
            max-width: 100%;
            resize: vertical;
            min-height: 40px;
            line-height: 1.4;
        }

        input.editable {
            display: inline-block;
            vertical-align: middle;
        }
        
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .toolbar {
                display: none !important;
            }

            .paper {
                box-shadow: none;
                margin: 0;
                width: 100%;
                min-height: 0;
            }

            .editable {
                background: transparent !important;
                border: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button class="btn-edit" id="btnEdit" onclick="toggleEditMode()">
            📝 Mode Edit
        </button>
        <button class="btn-save" id="btnSave" onclick="saveChanges()">
            💾 Simpan Perubahan
        </button>
        <button class="btn-cancel" id="btnCancel" onclick="cancelEdit()">
            ❌ Batal
        </button>
        <button class="btn-print" onclick="window.print()">
            🖨️ Cetak Surat
        </button>
        <button class="btn-back" onclick="window.location.href='{{ route('online-submission.show', $submission['id']) }}'">
            ← Kembali
        </button>
        <span id="editStatus" style="margin-left: auto; color: #666; font-size: 14px;"></span>
    </div>

    <div class="paper" id="letterContent">
        <div class="header">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td width="90px" style="vertical-align: top; padding: 5px 0;">
                        <img src="{{ asset('images/logo-lampung-tengah.png') }}" alt="Logo">
                    </td>
                    <td style="text-align: center; padding: 5px 0;">
                        <h3>PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
                        <h3>KECAMATAN PUNGGUR</h3>
                        <h1>KAMPUNG BADRAN SARI</h1>
                        <p>Alamat: Jl. Raya Punggur Km. 5, Badran Sari, Punggur, Lampung Tengah</p>
                    </td>
                    <td width="90px"></td>
                </tr>
            </table>
        </div>
        <hr class="header-line">

        <div class="letter-title">
            <input type="text" class="editable" id="letter_type" value="{{ strtoupper($submission['letter_type']) }}" readonly style="text-align: center; width: 400px; font-size: 14pt; border: none; text-decoration: underline;">
        </div>

        <div class="letter-number">
            <p style="margin: 0;">Nomor: <input type="text" class="editable" id="letter_number" value="{{ $submission['letter_number'] ?? '..../..../.../.....' }}" readonly style="width: 180px; border: none; text-align: center;"></p>
        </div>

        <div class="content">
            <p style="text-indent: 40px; line-height: 1.8;">
                Yang bertanda tangan di bawah ini Kepala Kampung Badran Sari, Kecamatan Punggur, Kabupaten Lampung Tengah, dengan ini menerangkan bahwa:
            </p>

            <table style="margin: 15px 0; line-height: 1.6; width: 100%; font-size: 12pt;">
                <tr>
                    <td width="160">Nama Lengkap</td>
                    <td width="15">:</td>
                    <td><input type="text" class="editable" id="name" value="{{ $submission['name'] ?? $submission['applicant_name'] ?? '-' }}" readonly style="width: 100%; border: none;"></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><input type="text" class="editable" id="nik" value="{{ $submission['nik'] ?? $submission['applicant_nik'] ?? '-' }}" readonly style="width: 100%; border: none;"></td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>
                        <input type="text" class="editable" id="birth_place" value="{{ $submission['birth_place'] ?? '.....................' }}" readonly style="width: 40%; border: none;">, 
                        <input type="text" class="editable" id="birth_date" value="{{ $submission['birth_date'] ?? '.../.../......' }}" readonly style="width: 45%; border: none;">
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><input type="text" class="editable" id="gender" value="{{ $submission['gender'] ?? '................' }}" readonly style="width: 100%; border: none;"></td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td><input type="text" class="editable" id="religion" value="{{ $submission['religion'] ?? '................' }}" readonly style="width: 100%; border: none;"></td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td><input type="text" class="editable" id="occupation" value="{{ $submission['occupation'] ?? '................' }}" readonly style="width: 100%; border: none;"></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Alamat</td>
                    <td style="vertical-align: top;">:</td>
                    <td><textarea class="editable" id="address" readonly style="border: none; font-family: inherit; font-size: inherit; line-height: inherit;">{{ $submission['address'] ?? 'Way Kandis, Dusun Kembang Sari, Kampung Badran Sari, Dusun Kembang Sari, Kampung Badran Sari' }}</textarea></td>
                </tr>
            </table>

            <p style="text-indent: 40px; line-height: 1.8; margin: 15px 0;">
                Surat keterangan ini dibuat untuk keperluan:
            </p>

            <p style="text-align: center; margin: 15px 0; font-size: 13pt;">
                <strong>" <input type="text" class="editable" id="purpose" readonly style="text-transform: uppercase; font-weight: bold; border: none; text-align: center; width: 300px;" value="{{ strtoupper($submission['purpose']) }}"> "</strong>
            </p>

            <p style="text-indent: 40px; line-height: 1.8; margin-top: 15px;">
                Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
            </p>
        </div>

        <div class="signature" style="margin-top: 30px;">
            <div class="signature-box" style="font-size: 12pt;">
                <p style="margin: 0;">Badran Sari, {{ date('d F Y') }}</p>
                <p style="margin: 5px 0;">Kepala Kampung Badran Sari</p>
                <div style="height: 60px;"></div>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">Wibowo, S.H.</p>
            </div>
        </div>
    </div>

    <script>
        let isEditMode = false;
        let originalData = {};

        // Save original data on page load
        document.addEventListener('DOMContentLoaded', function() {
            saveOriginalData();
        });

        function saveOriginalData() {
            const editables = document.querySelectorAll('.editable');
            editables.forEach(el => {
                originalData[el.id] = el.value;
            });
        }

        function toggleEditMode() {
            isEditMode = !isEditMode;
            const paper = document.getElementById('letterContent');
            const editables = document.querySelectorAll('.editable');
            const btnEdit = document.getElementById('btnEdit');
            const btnSave = document.getElementById('btnSave');
            const btnCancel = document.getElementById('btnCancel');
            const editStatus = document.getElementById('editStatus');

            if (isEditMode) {
                paper.classList.add('edit-mode');
                editables.forEach(el => {
                    el.removeAttribute('readonly');
                });
                btnEdit.style.display = 'none';
                btnSave.style.display = 'inline-block';
                btnCancel.style.display = 'inline-block';
                editStatus.textContent = '✏️ Mode Edit Aktif - Klik field untuk mengedit';
            } else {
                paper.classList.remove('edit-mode');
                editables.forEach(el => {
                    el.setAttribute('readonly', 'readonly');
                });
                btnEdit.style.display = 'inline-block';
                btnSave.style.display = 'none';
                btnCancel.style.display = 'none';
                editStatus.textContent = '';
            }
        }

        function cancelEdit() {
            const editables = document.querySelectorAll('.editable');
            editables.forEach(el => {
                el.value = originalData[el.id];
            });
            toggleEditMode();
        }

        async function saveChanges() {
            const data = {
                letter_number: document.getElementById('letter_number').value,
                letter_type: document.getElementById('letter_type').value,
                name: document.getElementById('name').value,
                nik: document.getElementById('nik').value,
                birth_place: document.getElementById('birth_place').value,
                birth_date: document.getElementById('birth_date').value,
                gender: document.getElementById('gender').value,
                occupation: document.getElementById('occupation').value,
                address: document.getElementById('address').value,
                purpose: document.getElementById('purpose').value,
                letter_date: document.getElementById('letter_date').value,
                signer_name: document.getElementById('signer_name').value,
                _token: '{{ csrf_token() }}'
            };

            try {
                const response = await fetch('{{ route("online-submission.update-letter", $submission["id"]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ Perubahan berhasil disimpan!');
                    saveOriginalData(); // Update original data
                    toggleEditMode();
                } else {
                    alert('❌ Gagal menyimpan: ' + (result.message || 'Terjadi kesalahan'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat menyimpan');
            }
        }
    </script>
</body>
</html>
