<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Penentuan Posisi - {{ $assessment->player?->name ?? 'Pemain' }}</title>
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
        .banner {
            background: linear-gradient(135deg, #2C3E28 0%, #4A6741 100%);
            color: #fff;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }
        .banner p {
            margin: 0;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0.85;
            font-weight: 700;
        }
        .banner h2 {
            margin: 5px 0;
            font-family: 'Source Serif 4', serif;
            font-size: 42px;
            font-weight: 900;
            letter-spacing: 1px;
        }
        .banner h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            opacity: 0.95;
        }
        .banner .score-badge {
            display: inline-block;
            margin-top: 15px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            font-family: 'DM Mono', monospace;
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
            padding: 10px 12px;
            border-bottom: 2px solid rgba(44, 62, 40, 0.15);
            text-align: left;
        }
        .data-table td {
            padding: 10px 12px;
            font-size: 13px;
            border-bottom: 1px solid rgba(44, 62, 40, 0.08);
            color: #1A1614;
        }
        .data-table tr:last-child td {
            border-bottom: none;
        }
        .text-center {
            text-align: center !important;
        }
        .text-right {
            text-align: right !important;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success {
            background-color: rgba(44, 62, 40, 0.1);
            color: #2C3E28;
        }
        .badge-warning {
            background-color: rgba(143, 106, 59, 0.1);
            color: #8F6A3B;
        }
        .badge-danger {
            background-color: rgba(179, 38, 30, 0.1);
            color: #B3261E;
        }
        .badge-purple {
            background-color: rgba(44, 62, 40, 0.1);
            color: #2C3E28;
        }
        .progress-bar-bg {
            background: #EDE7D8;
            width: 100%;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            display: inline-block;
        }
        .progress-bar-fill {
            background: #2C3E28;
            height: 100%;
            border-radius: 4px;
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
    @php
        $resultsData = $assessment->results()->with('position')->get();
        $getScoreForCode = function($code) use ($resultsData) {
            $res = $resultsData->first(function($r) use ($code) {
                return $r->position && $r->position->code === $code;
            });
            return $res ? round($res->score) : 0;
        };
        
        $scores = [
            'GK' => $getScoreForCode('GK'),
            'LD' => $getScoreForCode('DL/DR'),
            'RD' => $getScoreForCode('CB'),
            'LM' => $getScoreForCode('WR/WL'),
            'CM' => $getScoreForCode('MC'),
            'RM' => $getScoreForCode('ML/MR'),
            'ST' => $getScoreForCode('ST'),
        ];

        $getColor = function($pct) {
            if ($pct >= 80) return '#2C3E28'; // Brand green
            if ($pct >= 60) return '#8F6A3B'; // Brand gold
            return '#B3261E'; // Brand error
        };
    @endphp

    <!-- Floating Action Toolbar for Screen View -->
    <div class="toolbar no-print">
        <span class="toolbar-title">
            <i class="fas fa-file-invoice mr-1 text-primary"></i> Preview Cetak Detail Hasil
        </span>
        <div style="display: flex; gap: 10px;">
            <a href="{{ auth()->user() && auth()->user()->role === 'superadmin' ? route('superadmin.assessments.show', $assessment->id) : route('user.history.show', $assessment->id) }}" class="btn btn-secondary">
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
            <p>Laporan Hasil Analisis Rekomendasi Posisi Terbaik</p>
        </div>

        <div class="metadata-section">
            <div class="metadata-col">
                <div class="metadata-title">Info Pemain &amp; Pelatih</div>
                <table class="metadata-table">
                    <tr>
                        <td class="label">Nama Pemain</td>
                        <td class="value">: {{ $assessment->player?->name ?? 'Pemain' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Usia / Tgl Lahir</td>
                        <td class="value">: {{ $assessment->player?->dob ? $assessment->player->dob->format('d M Y') . ' (' . $assessment->player->age . ' thn)' : ($assessment->player?->age ? $assessment->player->age . ' Tahun' : '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pelatih Pengampu</td>
                        <td class="value">: {{ $assessment->user?->name ?? 'Pelatih' }}</td>
                    </tr>
                </table>
            </div>
            <div class="metadata-col" style="padding-left: 20px;">
                <div class="metadata-title">Informasi Assessment</div>
                <table class="metadata-table">
                    <tr>
                        <td class="label">Tanggal Penilaian</td>
                        <td class="value">: {{ $assessment->assessment_date?->format('d F Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Cetak</td>
                        <td class="value">: {{ now()->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Platform Sistem</td>
                        <td class="value" style="font-weight: 800; color: #2C3E28; font-family: 'DM Mono', monospace;">: soccergetposition.com</td>
                    </tr>
                </table>
            </div>
        </div>

        @if ($assessment->finalPosition)
        <div class="banner">
            <p>Posisi Rekomendasi Terbaik</p>
            <h2>{{ $assessment->finalPosition->code }}</h2>
            <h3>{{ $assessment->finalPosition->name }}</h3>
            <div class="score-badge">
                Skor Kecocokan: {{ number_format($assessment->total_score, 2) }}
            </div>
        </div>
        @endif

        <div class="layout-container" style="width: 100%; display: table; margin-bottom: 20px;">
            <div class="layout-row" style="display: table-row;">
                {{-- Left Column: Soccer Field --}}
                <div class="layout-col" style="display: table-cell; width: 44%; vertical-align: top; text-align: center;">
                    <div class="section-title" style="margin-top: 0; margin-bottom: 15px;">Visualisasi Formasi</div>
                    
                    <div class="field" style="background: #23371f; border-radius: 12px; position: relative; width: 230px; height: 430px; border: 3px solid #1a2917; overflow: hidden; margin: 0 auto;">
                        {{-- Field Lines --}}
                        <div style="position: absolute; top: 0; left: 0; width: 224px; height: 424px; border: 1.5px solid rgba(255,255,255,0.4); border-radius: 8px; margin: 1px;">
                            <div style="position: absolute; top: 211px; left: 0; width: 100%; height: 1px; background: rgba(255,255,255,0.4);"></div>
                            <div style="position: absolute; top: 179px; left: 80px; width: 64px; height: 64px; border: 1.2px solid rgba(255,255,255,0.4); border-radius: 50%;"></div>
                            <div style="position: absolute; top: 210px; left: 111px; width: 2px; height: 2px; background: rgba(255,255,255,0.4); border-radius: 50%;"></div>
                            <div style="position: absolute; top: 0; left: 52px; width: 120px; height: 40px; border: 1.2px solid rgba(255,255,255,0.4); border-top: none;"></div>
                            <div style="position: absolute; top: 0; left: 82px; width: 60px; height: 15px; border: 1.2px solid rgba(255,255,255,0.4); border-top: none;"></div>
                            <div style="position: absolute; top: 40px; left: 110px; width: 20px; height: 20px; border-radius: 50%; border: 1.2px solid rgba(255,255,255,0.4); clip-path: inset(0 0 10px 0);"></div>
                            <div style="position: absolute; bottom: 0; left: 52px; width: 120px; height: 40px; border: 1.2px solid rgba(255,255,255,0.4); border-bottom: none;"></div>
                            <div style="position: absolute; bottom: 0; left: 82px; width: 60px; height: 15px; border: 1.2px solid rgba(255,255,255,0.4); border-bottom: none;"></div>
                        </div>

                        {{-- Players --}}
                        <div class="players" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            <!-- ST -->
                            <div style="position: absolute; top: 25px; left: 0; width: 100%; text-align: center;">
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #F5F0E8; border: 2.5px solid {{ $getColor($scores['ST']) }}; margin: 0 auto 3px auto; padding-top: 4px; box-sizing: border-box;">
                                        <div style="font-size: 8px; font-weight: 800; color: #2C3E28; line-height: 1;">ST</div>
                                        <div style="font-size: 7px; font-weight: 700; color: #4A6741; margin-top: 1px; font-family: 'DM Mono', monospace;">{{ $scores['ST'] }}%</div>
                                    </div>
                                    <span style="font-size: 7px; font-weight: 700; color: #fff; background: {{ $getColor($scores['ST']) }}; border-radius: 4px; padding: 1px 4px; font-family: 'DM Mono', monospace;">{{ $scores['ST'] }}%</span>
                                </div>
                            </div>

                            <!-- RM, CM, LM -->
                            <!-- LM -->
                            <div style="position: absolute; top: 115px; left: 10px; width: 60px; text-align: center;">
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #F5F0E8; border: 2.5px solid {{ $getColor($scores['LM']) }}; margin: 0 auto 3px auto; padding-top: 4px; box-sizing: border-box;">
                                        <div style="font-size: 7px; font-weight: 800; color: #2C3E28; line-height: 1; letter-spacing: -0.5px;">WR/WL</div>
                                        <div style="font-size: 7px; font-weight: 700; color: #4A6741; margin-top: 1px; font-family: 'DM Mono', monospace;">{{ $scores['LM'] }}%</div>
                                    </div>
                                    <span style="font-size: 7px; font-weight: 700; color: #fff; background: {{ $getColor($scores['LM']) }}; border-radius: 4px; padding: 1px 4px; font-family: 'DM Mono', monospace;">{{ $scores['LM'] }}%</span>
                                </div>
                            </div>
                            <!-- CM -->
                            <div style="position: absolute; top: 120px; left: 85px; width: 60px; text-align: center;">
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #F5F0E8; border: 2.5px solid {{ $getColor($scores['CM']) }}; margin: 0 auto 3px auto; padding-top: 4px; box-sizing: border-box;">
                                        <div style="font-size: 8px; font-weight: 800; color: #2C3E28; line-height: 1;">MC</div>
                                        <div style="font-size: 7px; font-weight: 700; color: #4A6741; margin-top: 1px; font-family: 'DM Mono', monospace;">{{ $scores['CM'] }}%</div>
                                    </div>
                                    <span style="font-size: 7px; font-weight: 700; color: #fff; background: {{ $getColor($scores['CM']) }}; border-radius: 4px; padding: 1px 4px; font-family: 'DM Mono', monospace;">{{ $scores['CM'] }}%</span>
                                </div>
                            </div>
                            <!-- RM -->
                            <div style="position: absolute; top: 115px; right: 10px; width: 60px; text-align: center;">
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #F5F0E8; border: 2.5px solid {{ $getColor($scores['RM']) }}; margin: 0 auto 3px auto; padding-top: 4px; box-sizing: border-box;">
                                        <div style="font-size: 7px; font-weight: 800; color: #2C3E28; line-height: 1; letter-spacing: -0.5px;">ML/MR</div>
                                        <div style="font-size: 7px; font-weight: 700; color: #4A6741; margin-top: 1px; font-family: 'DM Mono', monospace;">{{ $scores['RM'] }}%</div>
                                    </div>
                                    <span style="font-size: 7px; font-weight: 700; color: #fff; background: {{ $getColor($scores['RM']) }}; border-radius: 4px; padding: 1px 4px; font-family: 'DM Mono', monospace;">{{ $scores['RM'] }}%</span>
                                </div>
                            </div>

                            <!-- RD & LD -->
                            <!-- LD -->
                            <div style="position: absolute; top: 225px; left: 25px; width: 60px; text-align: center;">
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #F5F0E8; border: 2.5px solid {{ $getColor($scores['LD']) }}; margin: 0 auto 3px auto; padding-top: 4px; box-sizing: border-box;">
                                        <div style="font-size: 7px; font-weight: 800; color: #2C3E28; line-height: 1; letter-spacing: -0.5px;">DL/DR</div>
                                        <div style="font-size: 7px; font-weight: 700; color: #4A6741; margin-top: 1px; font-family: 'DM Mono', monospace;">{{ $scores['LD'] }}%</div>
                                    </div>
                                    <span style="font-size: 7px; font-weight: 700; color: #fff; background: {{ $getColor($scores['LD']) }}; border-radius: 4px; padding: 1px 4px; font-family: 'DM Mono', monospace;">{{ $scores['LD'] }}%</span>
                                </div>
                            </div>
                            <!-- RD -->
                            <div style="position: absolute; top: 225px; right: 25px; width: 60px; text-align: center;">
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #F5F0E8; border: 2.5px solid {{ $getColor($scores['RD']) }}; margin: 0 auto 3px auto; padding-top: 4px; box-sizing: border-box;">
                                        <div style="font-size: 8px; font-weight: 800; color: #2C3E28; line-height: 1;">CB</div>
                                        <div style="font-size: 7px; font-weight: 700; color: #4A6741; margin-top: 1px; font-family: 'DM Mono', monospace;">{{ $scores['RD'] }}%</div>
                                    </div>
                                    <span style="font-size: 7px; font-weight: 700; color: #fff; background: {{ $getColor($scores['RD']) }}; border-radius: 4px; padding: 1px 4px; font-family: 'DM Mono', monospace;">{{ $scores['RD'] }}%</span>
                                </div>
                            </div>

                            <!-- GK -->
                            <div style="position: absolute; bottom: 20px; left: 0; width: 100%; text-align: center;">
                                <div style="display: inline-block; text-align: center;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #F5F0E8; border: 2.5px solid {{ $getColor($scores['GK']) }}; margin: 0 auto 3px auto; padding-top: 4px; box-sizing: border-box;">
                                        <div style="font-size: 8px; font-weight: 800; color: #2C3E28; line-height: 1;">GK</div>
                                        <div style="font-size: 7px; font-weight: 700; color: #4A6741; margin-top: 1px; font-family: 'DM Mono', monospace;">{{ $scores['GK'] }}%</div>
                                    </div>
                                    <span style="font-size: 7px; font-weight: 700; color: #fff; background: {{ $getColor($scores['GK']) }}; border-radius: 4px; padding: 1px 4px; font-family: 'DM Mono', monospace;">{{ $scores['GK'] }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Rankings Table --}}
                <div class="layout-col" style="display: table-cell; width: 56%; vertical-align: top; padding-left: 20px;">
                    <div class="section-title" style="margin-top: 0; margin-bottom: 15px;">Ranking Kecocokan Posisi</div>
                    <table class="data-table" style="margin-bottom: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 15%; padding: 8px 10px;">Rank</th>
                                <th style="width: 25%; padding: 8px 10px;">Kode</th>
                                <th style="width: 40%; padding: 8px 10px;">Nama Posisi</th>
                                <th style="width: 20%; padding: 8px 10px; text-align: center;">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessment->results()->with('position')->orderBy('ranking', 'asc')->get() as $result)
                            @if ($result->ranking === 1 || ($result->ranking === 2 && $result->score > 80))
                            <tr>
                                <td class="text-center" style="font-weight: bold; color: #2C3E28; padding: 8px 10px; font-size: 11px;">{{ $result->ranking }}</td>
                                <td style="padding: 8px 10px;"><span class="badge badge-purple" style="font-size: 9px; padding: 2px 6px;">{{ $result->position?->code ?? '-' }}</span></td>
                                <td style="font-weight: 600; padding: 8px 10px; font-size: 11px;">{{ $result->position?->name ?? 'Unknown' }}</td>
                                <td class="text-center" style="font-weight: bold; padding: 8px 10px; font-size: 11px; font-family: 'DM Mono', monospace;">{{ number_format($result->score, 2) }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($assessment->scores->count() > 0)
        <div class="section-title">Skor Per Indikator Kesiapan</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60%;">Nama Indikator</th>
                    <th style="width: 20%; text-align: center;">Skor (Skala 1 - 10)</th>
                    <th style="width: 20%;">Tingkat Kesiapan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assessment->scores as $score)
                <tr>
                    <td style="font-weight: 600;">{{ $score->indicator_name }}</td>
                    <td class="text-center" style="font-weight: bold; color: #2C3E28; font-family: 'DM Mono', monospace;">{{ $score->score }} / 10</td>
                    <td>
                        @if ($score->score >= 8)
                            <span class="badge badge-success">Sangat Baik</span>
                        @elseif ($score->score >= 6)
                            <span class="badge badge-warning">Baik</span>
                        @elseif ($score->score >= 4)
                            <span class="badge badge-warning">Cukup</span>
                        @else
                            <span class="badge badge-danger">Kurang</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if ($assessment->testResults->count() > 0)
        <div class="section-title">Detail Hasil Tes Keahlian</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Nama Tes</th>
                    <th style="width: 25%; text-align: center;">Nilai Mentah</th>
                    <th style="width: 15%; text-align: center;">Skor Konversi</th>
                    <th style="width: 15%; text-align: center;">Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assessment->testResults as $res)
                <tr>
                    <td style="font-weight: 600;">{{ $res->test?->name ?? '-' }}</td>
                    <td class="text-center" style="font-family: 'DM Mono', monospace;">{{ $res->raw_value }} {{ $res->test?->unit }}</td>
                    <td class="text-center" style="font-weight: bold; color: #2C3E28; font-family: 'DM Mono', monospace;">{{ $res->score }}</td>
                    <td class="text-center">
                        <span class="badge {{ in_array($res->category, ['Sangat Baik', 'Baik']) ? 'badge-success' : (in_array($res->category, ['Sedang', 'Cukup']) ? 'badge-warning' : 'badge-danger') }}">
                            {{ $res->category ?? '-' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div class="footer-note">
            <div style="font-weight: 800; font-family: 'DM Mono', monospace; font-size: 13px; color: #2C3E28; letter-spacing: 0.5px;">
                soccergetposition.com
            </div>
            <div style="font-size: 10px; color: #4A6741; margin-top: 3px;">
                Sistem Penentuan Posisi Pemain Sepakbola &bull; Dokumen Resmi Hasil Penilaian &bull; &copy; {{ date('Y') }}
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
