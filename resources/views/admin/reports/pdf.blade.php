<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Penilaian Posisi Pemain</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
            width: 120px;
            font-weight: 600;
        }
        .metadata-table td.value {
            color: #2C3E28;
            font-weight: 700;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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
        .badge-success {
            background-color: rgba(44, 62, 40, 0.1);
            color: #2C3E28;
        }
        .footer-note {
            margin-top: 60px;
            text-align: center;
            font-size: 11px;
            color: #4A6741;
            border-top: 1px solid rgba(44, 62, 40, 0.15);
            padding-top: 20px;
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
            <i class="fas fa-file-invoice mr-1 text-primary"></i> Preview Cetak Laporan
        </span>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('superadmin.reports.index', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <div class="content-container">
        <div class="header">
            <h1>Sistem Penentuan Posisi Pemain</h1>
            <p>Laporan Rekapitulasi Hasil Penilaian Posisi Pemain</p>
        </div>

        <div class="metadata-section">
            <div class="metadata-col">
                <div class="metadata-title">Filter Pencarian</div>
                <table class="metadata-table">
                    <tr>
                        <td class="label">Periode</td>
                        <td class="value">
                            : 
                            @if($startDate && $endDate)
                                {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
                            @elseif($startDate)
                                Mulai dari {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }}
                            @elseif($endDate)
                                Sampai dengan {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
                            @else
                                Semua Periode
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Total Data</td>
                        <td class="value">: {{ $assessments->count() }} Penilaian</td>
                    </tr>
                </table>
            </div>
            <div class="metadata-col" style="padding-left: 20px;">
                <div class="metadata-title">Informasi Dokumen</div>
                <table class="metadata-table">
                    <tr>
                        <td class="label">Tanggal Cetak</td>
                        <td class="value">: {{ now()->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Waktu Cetak</td>
                        <td class="value">: {{ now()->format('H:i') }} WIB</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 6%;" class="text-center">No</th>
                    <th style="width: 26%;">Nama Pemain</th>
                    <th style="width: 24%;">Pelatih Pengampu</th>
                    <th style="width: 18%;" class="text-center">Tgl Penilaian</th>
                    <th style="width: 16%;" class="text-center">Rekomendasi</th>
                    <th style="width: 10%;" class="text-center">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assessments as $index => $assessment)
                <tr>
                    <td class="text-center" style="font-weight: bold; color: #2C3E28;">{{ $index + 1 }}</td>
                    <td style="font-weight: 700;">
                        {{ $assessment->player?->name ?? 'Pemain' }}
                    </td>
                    <td style="color: #2C3E28;">
                        {{ $assessment->user?->name ?? '-' }}
                    </td>
                    <td class="text-center" style="color: #4A6741;">
                        {{ $assessment->assessment_date?->format('d F Y') ?? '-' }}
                    </td>
                    <td class="text-center">
                        <span class="badge badge-purple">
                            {{ $assessment->finalPosition?->code ?? '-' }}
                        </span>
                    </td>
                    <td class="text-center" style="font-weight: 800; font-family: 'DM Mono', monospace; color: #2C3E28; font-size: 13px;">
                        {{ number_format($assessment->total_score, 2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="color: #4A6741; padding: 40px;">
                        Tidak ada data penilaian yang ditemukan untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-note">
            Laporan rekapitulasi ini dihasilkan secara otomatis oleh Sistem Penentuan Posisi Pemain.<br>
            © {{ date('Y') }} All Rights Reserved.
        </div>
    </div>

    <!-- Automatically open the print dialog when loading -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Delay slightly to ensure page rendering is complete before printing
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
