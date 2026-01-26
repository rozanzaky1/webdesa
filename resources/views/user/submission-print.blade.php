<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat - {{ $submission['letter_type'] }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 13pt;
            line-height: 1.8;
            color: #333;
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
            width: 90px;
        }
        
        .header h1 {
            font-size: 22pt;
            font-weight: bold;
            margin: 5px 0;
            color: #333;
        }
        
        .header h3 {
            font-size: 16pt;
            font-weight: normal;
            margin: 3px 0;
            color: #666;
        }
        
        .header p {
            font-size: 10pt;
            margin: 5px 0 10px 0;
            font-style: italic;
            color: #666;
        }
        
        .header-line {
            border: none;
            border-top: 1px solid #000;
            margin: 0;
        }
        
        .letter-title {
            text-align: center;
            font-size: 16pt;
            font-weight: normal;
            margin: 30px 0 10px 0;
            text-decoration: underline;
            color: #666;
        }
        
        .letter-number {
            text-align: center;
            margin: 0 0 20px 0;
            font-weight: normal;
            font-size: 13pt;
            color: #666;
        }
        
        .content {
            text-align: justify;
            margin: 20px 0;
            text-indent: 40px;
        }
        
        .identity-table {
            width: 100%;
            margin: 20px 0;
            font-size: 13pt;
        }
        
        .identity-table td {
            padding: 5px;
            vertical-align: top;
        }
        
        .identity-table td:first-child {
            width: 180px;
        }
        
        .identity-table td:nth-child(2) {
            width: 20px;
        }
        
        .purpose-text {
            text-align: center;
            margin: 20px 0;
            font-size: 14pt;
        }
        
        .signature {
            margin-top: 30px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
            font-size: 13pt;
        }
        
        .signature-name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="position: fixed; top: 10px; right: 10px; z-index: 1000;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #0f7b2a; color: white; border: none; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-print"></i> Cetak
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td width="100px" style="vertical-align: top; padding: 10px 0;">
                    <img src="{{ asset('images/logo-lampung-tengah.png') }}" alt="Logo">
                </td>
                <td style="text-align: center; padding: 10px 0;">
                    <h3>PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
                    <h3>KECAMATAN PUNGGUR</h3>
                    <h1>KAMPUNG BADRAN SARI</h1>
                    <p>Alamat: Jl. Raya Punggur Km. 5, Badran Sari, Punggur, Lampung Tengah</p>
                </td>
                <td width="100px"></td>
            </tr>
        </table>
    </div>
    <hr class="header-line">

    <div class="letter-title">
        {{ strtoupper($submission['letter_type']) }}
    </div>

    <div class="letter-number">
        Nomor: {{ $submission['letter_number'] }}
    </div>

    <div class="content">
        Yang bertanda tangan di bawah ini Kepala Kampung Badran Sari, Kecamatan Punggur, Kabupaten Lampung Tengah, dengan ini menerangkan bahwa:
    </div>

    <table class="identity-table">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $submission['user_name'] }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $submission['user_nik'] }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $submission['user_birth_place'] ?? 'Jakarta' }}, {{ $submission['user_birth_date'] ?? '18-06-2003' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $submission['user_gender'] ?? 'Male' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $submission['user_occupation'] ?? 'Mahasiswa' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $submission['user_address'] ?? 'Way Kandis' }}</td>
        </tr>
    </table>

    <div class="content">
        Surat keterangan ini dibuat untuk keperluan:
    </div>
    
    <div class="purpose-text">
        <strong>"{{ strtoupper($submission['purpose']) }}"</strong>
    </div>
    
    <div class="content">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    <div class="signature">
        <p>Badran Sari, {{ date('d F Y', strtotime($submission['updated_at'])) }}</p>
        <div class="signature-box">
            <p>Kepala Kampung Badran Sari</p>
            <div class="signature-name">
                Wibowo, S.H.
            </div>
        </div>
    </div>
</body>
</html>
