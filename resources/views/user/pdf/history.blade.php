<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Penilaian Pemain - {{ $user->name }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/ball.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/ball.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body {
            font-family: 'DM Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1A1614;
            line-height: 1.5;
            margin: 0;
            padding: 40px;
            background-color: #fff;
        }
        .toolbar {
            background-color: #F5F0E8;
            border-bottom: 1px solid rgba(44, 62, 40, 0.15);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(44, 62, 40, 0.05);
        }
        .toolbar-title {
            font-family: 'Source Serif 4', serif;
            font-weight: 800;
            color: #2C3E28;
            font-size: 15px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        .btn-primary {
            background-color: #2C3E28;
            color: #F5F0E8;
        }
        .btn-primary:hover {
            background-color: #4A6741;
        }
        .btn-secondary {
            background-color: rgba(44, 62, 40, 0.08);
            color: #2C3E28;
        }
        .btn-secondary:hover {
            background-color: rgba(44, 62, 40, 0.15);
        }
        .content-container {
            margin-top: 50px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #2C3E28;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-family: 'Source Serif 4', serif;
            font-size: 24px;
            color: #2C3E28;
            text-transform: uppercase;
            font-weight: 900;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #4A6741;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .metadata-section {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            background: #F5F0E8;
            border: 1px solid rgba(44, 62, 40, 0.15);
            padding: 15px;
            border-radius: 12px;
            box-sizing: border-box;
        }
        .metadata-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .metadata-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #4A6741;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .metadata-table {
            width: 100%;
            border-collapse: collapse;
        }
        .metadata-table td {
            padding: 4px 0;
            font-size: 13px;
        }
        .metadata-table td.label {
            color: #1A1614;
            width: 130px;
            font-weight: 600;
        }
        .metadata-table td.value {
            color: #2C3E28;
            font-weight: 700;
        }
        .section-title {
            font-family: 'Source Serif 4', serif;
            font-size: 15px;
            font-weight: bold;
            color: #2C3E28;
            border-left: 4px solid #2C3E28;
            padding-left: 10px;
            margin: 25px 0 15px 0;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .data-table th {
            background-color: rgba(44, 62, 40, 0.05);
            color: #2C3E28;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 800;
            padding: 12px 14px;
            border-bottom: 2px solid rgba(44, 62, 40, 0.15);
            text-align: left;
        }
        .data-table td {
            padding: 12px 14px;
            font-size: 13px;
            border-bottom: 1px solid rgba(44, 62, 40, 0.08);
            color: #1A1614;
        }
        .data-table tr:hover td {
            background-color: #F5F0E8;
        }
        .data-table tr:last-child td {
            border-bottom: none;
        }
        .text-center {
            text-align: center !important;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-purple {
            background-color: rgba(44, 62, 40, 0.1);
            color: #2C3E28;
        }
        .summary-box {
            background-color: rgba(44, 62, 40, 0.04);
            border-left: 4px solid #2C3E28;
            padding: 12px 16px;
            font-size: 12.5px;
            color: #2C3E28;
            border-radius: 0 8px 8px 0;
            line-height: 1.6;
            font-weight: 500;
            margin-bottom: 25px;
        }
        .footer-note {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #4A6741;
            border-top: 1px solid rgba(44, 62, 40, 0.15);
            padding-top: 15px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .content-container {
                margin-top: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Action Toolbar for Screen View -->
    <div class="toolbar no-print">
        <span class="toolbar-title">
            <i class="fas fa-file-invoice mr-1 text-primary"></i> Preview Cetak Riwayat
        </span>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('user.history.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak Dokumen
            </button>
        </div>
    </div>

    <div class="content-container">
        <div class="header">
            <h1>Sistem Penentuan Posisi Pemain</h1>
            <p>Laporan Riwayat Hasil Analisis Penentuan Posisi Pemain</p>
        </div>

        <div class="metadata-section">
            <div class="metadata-col">
                <div class="metadata-title">Informasi Pelatih</div>
                <table class="metadata-table">
                    <tr>
                        <td class="label">Nama Pelatih</td>
                        <td class="value">: {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email Pelatih</td>
                        <td class="value">: {{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Peran Sistem</td>
                        <td class="value">: Pelatih Pengampu SSB</td>
                    </tr>
                </table>
            </div>
            <div class="metadata-col" style="padding-left: 20px;">
                <div class="metadata-title">Informasi Dokumen</div>
                <table class="metadata-table">
                    <tr>
                        <td class="label">Tanggal Cetak</td>
                        <td class="value">: {{ now()->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Total Assessment</td>
                        <td class="value">: {{ $assessments->count() }} Sesi</td>
                    </tr>
                    <tr>
                        <td class="label">Platform Sistem</td>
                        <td class="value" style="font-weight: 800; color: #2C3E28; font-family: 'DM Mono', monospace;">: soccergetposition.com</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="summary-box">
            Laporan ini menyajikan ringkasan riwayat hasil penentuan rekomendasi posisi terbaik seluruh pemain binaan yang telah diuji secara berkala untuk mengevaluasi konsistensi kesiapan fisik dan teknik.
        </div>

        <div class="section-title">Log Riwayat Assessment Pemain</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 26%;">Nama Pemain</th>
                    <th style="width: 20%;">Tanggal Tes</th>
                    <th style="width: 14%; text-align: center;">Kode</th>
                    <th style="width: 22%;">Rekomendasi</th>
                    <th style="width: 12%; text-align: center;">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assessments as $index => $assessment)
                <tr>
                    <td style="font-weight: bold; color: #2C3E28;">{{ $index + 1 }}</td>
                    <td style="font-weight: 700;">{{ $assessment->player?->name ?? 'Pemain' }}</td>
                    <td style="font-weight: 500; color: #4A6741;">{{ $assessment->assessment_date?->format('d F Y') ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge badge-purple">{{ $assessment->finalPosition?->code ?? '-' }}</span>
                    </td>
                    <td style="font-weight: 600;">{{ $assessment->finalPosition?->name ?? 'Belum Ditentukan' }}</td>
                    <td class="text-center" style="font-weight: bold; color: #2C3E28; font-family: 'DM Mono', monospace;">
                        {{ number_format((float)$assessment->total_score, 2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="color: #4A6741; padding: 30px;">Belum ada riwayat assessment yang tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-note">
            <div style="font-weight: 800; font-family: 'DM Mono', monospace; font-size: 13px; color: #2C3E28; letter-spacing: 0.5px;">
                soccergetposition.com
            </div>
            <div style="font-size: 10.5px; color: #4A6741; margin-top: 3px;">
                Sistem Penentuan Posisi Pemain Sepakbola &bull; Dokumen Resmi Riwayat Penilaian &bull; &copy; {{ date('Y') }}
            </div>
        </div>
    </div>

    <!-- Automatically open the print dialog when loading -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
