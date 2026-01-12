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
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .header h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .header p {
            font-size: 11pt;
            margin: 3px 0;
        }
        
        .letter-number {
            text-align: center;
            margin: 20px 0;
            text-decoration: underline;
            font-weight: bold;
        }
        
        .letter-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        
        .identity-table {
            width: 100%;
            margin: 20px 0;
        }
        
        .identity-table td {
            padding: 5px;
            vertical-align: top;
        }
        
        .identity-table td:first-child {
            width: 200px;
        }
        
        .identity-table td:nth-child(2) {
            width: 20px;
        }
        
        .signature {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-name {
            margin-top: 60px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding: 0 20px;
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
        <h1>PEMERINTAH KABUPATEN LAMPUNG TENGAH</h1>
        <h2>KECAMATAN PUNGGUR</h2>
        <h2>DESA BADRAN SARI</h2>
        <p>Alamat: Jl. Raya Punggur - Badran Sari, Kode Pos 34155</p>
    </div>

    <div class="letter-number">
        Nomor: {{ $submission['letter_number'] }}
    </div>

    <div class="letter-title">
        {{ strtoupper($submission['letter_type']) }}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Badran Sari, Kecamatan Punggur, Kabupaten Lampung Tengah, dengan ini menerangkan bahwa:</p>
    </div>

    <table class="identity-table">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><strong>{{ $submission['user_name'] }}</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td><strong>{{ $submission['user_nik'] }}</strong></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $submission['user_email'] }}</td>
        </tr>
    </table>

    <div class="content">
        <p><strong>Keperluan:</strong></p>
        <p>{{ $submission['purpose'] }}</p>
        
        @if($submission['notes'])
        <p><strong>Catatan:</strong></p>
        <p>{{ $submission['notes'] }}</p>
        @endif
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <p>Badran Sari, {{ date('d F Y', strtotime($submission['updated_at'])) }}</p>
        <div class="signature-box">
            <p>Kepala Desa Badran Sari</p>
            <div class="signature-name">
                Pak Suronto
            </div>
        </div>
    </div>
</body>
</html>
