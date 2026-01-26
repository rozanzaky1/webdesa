<!-- Template Surat Pengantar Nikah -->
<div class="letter-header">
    <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom: 3px solid #000;">
        <tr>
            <td width="100px" style="vertical-align: top; padding: 10px 0;">
                <img src="{{ asset('images/logo-lampung-tengah.png') }}" alt="Logo" style="width: 90px;">
            </td>
            <td style="text-align: center; padding: 10px 0;">
                <h3 style="margin: 0; font-size: 16px; font-weight: normal; color: #666;">PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
                <h3 style="margin: 3px 0; font-size: 16px; font-weight: normal; color: #666;">KECAMATAN PUNGGUR</h3>
                <h2 style="margin: 5px 0; font-size: 22px; font-weight: bold; color: #333;">KAMPUNG BADRAN SARI</h2>
                <p style="margin: 5px 0 10px 0; font-size: 10px; color: #666; font-style: italic;">Alamat: Jl. Raya Punggur Km. 5, Badran Sari, Punggur, Lampung Tengah</p>
            </td>
            <td width="100px"></td>
        </tr>
    </table>
    <hr style="border: none; border-top: 1px solid #000; margin: 0;">
</div>

<div class="letter-title" style="text-align: center; margin: 30px 0 20px 0;">
    <h3 style="text-decoration: underline; margin-bottom: 10px; font-size: 16px; color: #666;">SURAT PENGANTAR NIKAH</h3>
    <p style="margin: 0; font-size: 13px; color: #666;">Nomor: <span class="editable" data-field="letter_number">{{ $letter->letter_number }}</span></p>
</div>

<div class="letter-body" style="font-size: 13px; line-height: 1.8; color: #333;">
    <p style="text-indent: 40px; text-align: justify; margin-bottom: 20px;">
        Yang bertanda tangan di bawah ini Kepala Kampung Badran Sari, Kecamatan Punggur, Kabupaten Lampung Tengah, dengan ini menerangkan bahwa:
    </p>

    <table style="width: 100%; margin: 20px 0;" cellpadding="5">
        <tr>
            <td width="180px">Nama Lengkap</td>
            <td width="20px">:</td>
            <td><span class="editable" data-field="resident_name">{{ $letter->resident->name }}</span></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td><span class="editable" data-field="resident_nik">{{ $letter->resident->nik }}</span></td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td><span class="editable" data-field="resident_birth_place">{{ $letter->resident->birth_place }}</span>, <span class="editable" data-field="resident_birth_date" data-value="{{ $letter->resident->birth_date->format('Y-m-d') }}">{{ $letter->resident->birth_date->format('d F Y') }}</span></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><span class="editable" data-field="resident_gender">{{ $letter->resident->gender }}</span></td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td><span class="editable" data-field="resident_religion">{{ $letter->resident->religion }}</span></td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td><span class="editable" data-field="resident_occupation">{{ $letter->resident->occupation }}</span></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><span class="editable" data-field="resident_address">{{ $letter->resident->address }}, Dusun {{ $letter->resident->hamlet }}, Kampung Badran Sari</span></td>
        </tr>
        @if($letter->additional_data && isset($letter->additional_data['spouse_name']))
        <tr>
            <td>Akan Menikah Dengan</td>
            <td>:</td>
            <td><span class="editable" data-field="spouse_name">{{ $letter->additional_data['spouse_name'] }}</span></td>
        </tr>
        @endif
    </table>

    <p style="text-indent: 40px; text-align: justify; margin: 20px 0 10px 0;">
        Adalah benar penduduk Kampung Badran Sari dan berdasarkan laporan yang ada tidak terdapat larangan menurut hukum agama maupun peraturan perundang-undangan untuk melangsungkan pernikahan. Surat pengantar ini dibuat untuk keperluan:
    </p>

    <p style="text-align: center; margin: 20px 0; font-size: 14px;">
        <strong>"<span class="editable" data-field="purpose">{{ strtoupper($letter->purpose) }}</span>"</strong>
    </p>

    <p style="text-indent: 40px; text-align: justify; margin-top: 20px;">
        Demikian surat pengantar ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagai persyaratan administrasi pernikahan di KUA yang berwenang.
    </p>
</div>

<div class="letter-footer">
    <table width="100%" style="margin-top: 30px;">
        <tr>
            <td width="50%"></td>
            <td width="50%" style="text-align: center; font-size: 13px;">
                <p style="margin: 0;">Badran Sari, {{ $letter->letter_date->format('d F Y') }}</p>
                <p style="margin: 5px 0;">Kepala Kampung Badran Sari</p>
                <div style="height: 70px;"></div>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;"><span class="editable" data-field="village_head_name">{{ $letter->village_head_name ?? 'Wibowo, S.H.' }}</span></p>
            </td>
        </tr>
    </table>
</div>
