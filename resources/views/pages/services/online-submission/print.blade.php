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
            padding: 0;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .header h3 {
            margin: 5px 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        
        .header p {
            margin: 2px 0;
            font-size: 11pt;
        }
        
        .letter-number {
            text-align: center;
            margin: 30px 0;
            font-weight: bold;
            text-decoration: underline;
        }
        
        .content {
            margin: 20px 0;
            text-align: justify;
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
            button {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">
        🖨️ Cetak Surat
    </button>

    <div class="header">
        <h3>PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
        <h3>KECAMATAN PUNGGUR</h3>
        <h3>KANTOR DESA BADRAN SARI</h3>
        <p>Jl. Raya Punggur KM. 5, Badran Sari, Kec. Punggur</p>
        <p>Email: desabadransari@gmail.com | Telp: (0725) 123456</p>
    </div>

    <div class="letter-number">
        <p>NOMOR: {{ $submission['letter_number'] ?? '..../..../.../.....' }}</p>
        <h4>{{ strtoupper($submission['letter_type']) }}</h4>
    </div>

    <div class="content">
        <p style="text-indent: 50px;">
            Yang bertanda tangan di bawah ini Kepala Desa Badran Sari, Kecamatan Punggur, 
            Kabupaten Lampung Tengah, dengan ini menerangkan bahwa:
        </p>

        <table style="margin: 20px 0 20px 80px; line-height: 2;">
            <tr>
                <td width="150">Nama</td>
                <td width="20">:</td>
                <td><strong>{{ $submission['name'] ?? $submission['applicant_name'] ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $submission['nik'] ?? $submission['applicant_nik'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tempat/Tgl. Lahir</td>
                <td>:</td>
                <td>{{ $submission['birth_place'] ?? '.....................' }}, {{ $submission['birth_date'] ?? '.../.../......' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $submission['gender'] ?? '................' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $submission['occupation'] ?? '................' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $submission['address'] ?? 'Desa Badran Sari, Kec. Punggur, Kab. Lampung Tengah' }}</td>
            </tr>
        </table>

        <p style="text-indent: 50px;">
            Adalah benar warga Desa Badran Sari dan surat keterangan ini dibuat untuk keperluan:
        </p>

        <p style="margin: 20px 0 20px 80px; font-weight: bold;">
            {{ strtoupper($submission['purpose']) }}
        </p>

        <p style="text-indent: 50px;">
            Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan 
            sebagaimana mestinya.
        </p>
    </div>

    <div class="signature">
        <div class="signature-box">
            <p>Badran Sari, {{ date('d F Y') }}</p>
            <p style="font-weight: bold;">Kepala Desa Badran Sari</p>
            <div class="signature-line">
                <p style="font-weight: bold;">Pak Suronto</p>
            </div>
        </div>
    </div>
</body>
</html>
