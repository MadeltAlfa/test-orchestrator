@extends('admin.layouts.app')

@section('title', 'Dashboard Superadmin - GetPosition')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8 w-full">

    {{-- Welcome Header Banner --}}
    <div class="bg-primary text-on-primary rounded-2xl p-6 sm:p-8 relative overflow-hidden shadow-sm">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -translate-y-1/4 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full translate-y-1/4 -translate-x-1/4"></div>
        </div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-white/10 backdrop-blur-sm border border-white/15 text-xs font-bold font-label uppercase tracking-widest mb-3">
                <i class="fas fa-shield-alt text-primary-fixed-dim"></i> Portal Superadmin SSB
            </div>
            <h1 class="text-2xl sm:text-3xl font-headline font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-on-primary/80 mt-1.5 text-sm max-w-2xl font-body leading-relaxed">
                Pantau performa sistem SSB, data seluruh pelatih dan pemain binaan, konfigurasi instrumen tes, serta hasil rekomendasi posisi pemain sepak bola.
            </p>
        </div>
    </div>

    {{-- Stat Cards Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Pelatih Terdaftar</span>
                <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <i class="fas fa-users text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $totalCoaches }}</p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">Akun pelatih aktif</p>
            </div>
        </div>

        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Pemain Binaan</span>
                <div class="w-9 h-9 bg-secondary-container rounded-xl flex items-center justify-center text-secondary">
                    <i class="fas fa-running text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $totalPlayers }}</p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">Total pemain seluruh pelatih</p>
            </div>
        </div>

        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Total Assessment</span>
                <div class="w-9 h-9 bg-tertiary-container rounded-xl flex items-center justify-center text-tertiary">
                    <i class="fas fa-clipboard-check text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $totalAssessments }}</p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">{{ $thisMonthAssessments }} sesi di bulan ini</p>
            </div>
        </div>

        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Instrumen Sistem</span>
                <div class="w-9 h-9 bg-surface-container-high rounded-xl flex items-center justify-center text-on-surface">
                    <i class="fas fa-sliders-h text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $totalPositions }} <span class="text-xs font-bold text-on-surface-variant uppercase font-label">Posisi</span></p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">{{ $totalTests }} Tes &bull; {{ $totalIndicators }} Indikator</p>
            </div>
        </div>
    </div>

    {{-- Main Content Grid: Tren Assessment (7 cols) & Distribusi Posisi (5 cols) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- Kolom Kiri: Tren Assessment (7 cols) --}}
        <div class="lg:col-span-7 card-premium p-6 flex flex-col justify-between">
            <div class="border-b border-outline-variant/10 pb-4 mb-4 flex items-center justify-between">
                <div>
                    <h2 class="font-headline font-bold text-base text-on-surface">Tren Assessment (30 Hari Terakhir)</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Grafik volume aktivitas pengujian posisi pemain di sistem</p>
                </div>
                <span class="text-xs font-bold font-mono text-primary bg-primary/10 px-2.5 py-1 rounded-lg">
                    {{ $statistics['assessments_by_date']->sum() }} Sesi
                </span>
            </div>

            <div class="h-48 flex items-end gap-1.5 pt-4">
                @php
                    $maxVal = $statistics['assessments_by_date']->max() ?: 1;
                @endphp
                @forelse ($statistics['assessments_by_date'] as $date => $count)
                    @php 
                        $h = max(8, ($count / $maxVal) * 150); 
                        $displayDate = date('d M', strtotime($date));
                    @endphp
                    <div class="group relative flex-1 flex flex-col items-center justify-end">
                        <div class="w-full bg-primary rounded-t-xl transition-all duration-300 hover:bg-primary-fixed-dim"
                             style="height: {{ $h }}px">
                        </div>
                        <div class="absolute bottom-full mb-2 hidden group-hover:block bg-primary text-on-primary text-[10px] px-2.5 py-1 rounded-lg shadow-md whitespace-nowrap z-10 font-mono font-bold">
                            {{ $displayDate }}: {{ $count }} assessment
                        </div>
                    </div>
                @empty
                    <div class="flex-1 flex items-center justify-center text-on-surface-variant text-xs py-12 flex-col gap-2">
                        <i class="fas fa-chart-bar text-2xl text-on-surface-variant/40"></i>
                        <p>Belum ada data assessment dalam 30 hari terakhir</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Kolom Kanan: Distribusi Posisi Pemain (5 cols) --}}
        <div class="lg:col-span-5 card-premium p-6">
            <div class="border-b border-outline-variant/10 pb-4 mb-4">
                <h2 class="font-headline font-bold text-base text-on-surface">Distribusi Posisi Pemain</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Rekomendasi posisi hasil penilaian dari seluruh pelatih</p>
            </div>

            <div class="space-y-4">
                @php $totalDist = $statistics['positions_distribution']->sum('count') ?: 1; @endphp
                @forelse ($statistics['positions_distribution'] as $item)
                    @php $pct = round(($item['count'] / $totalDist) * 100); @endphp
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5">
                            <span class="font-bold text-on-surface flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-primary"></span>
                                {{ $item['position_name'] }} ({{ $item['position_code'] }})
                            </span>
                            <span class="font-mono font-bold text-on-surface-variant">
                                {{ $item['count'] }} ({{ $pct }}%)
                            </span>
                        </div>
                        <div class="w-full bg-surface-container-low rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-primary to-primary-fixed-dim h-full rounded-full transition-all"
                                style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="flex items-center justify-center h-48 text-on-surface-variant flex-col gap-2">
                        <i class="fas fa-chart-pie text-2xl text-on-surface-variant/40"></i>
                        <p class="text-xs text-center">Belum ada assessment yang tersimpan</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Bottom Table: Aktivitas Assessment Terbaru --}}
    <div class="card-premium overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center justify-between bg-surface-container-low/30">
            <div>
                <h2 class="font-headline font-bold text-base text-on-surface">Assessment Terbaru Sistem</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Aktivitas penilaian pemain terkini dari seluruh pelatih</p>
            </div>
            <a href="{{ route('superadmin.assessments.index') }}" class="text-xs font-bold text-primary uppercase tracking-widest hover:underline flex items-center gap-1 font-label">
                Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Pemain & Pelatih</th>
                        <th>Tanggal Penilaian</th>
                        <th class="text-center">Total Skor</th>
                        <th>Posisi Rekomendasi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestAssessments as $assessment)
                    <tr class="group">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-xs shadow-sm flex-shrink-0">
                                     {{ strtoupper(substr($assessment->player?->name ?? $assessment->user?->name ?? 'P', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-on-surface truncate">{{ $assessment->player?->name ?? 'Pemain (Pelatih)' }}</p>
                                    <p class="text-[10px] text-on-surface-variant truncate">Pelatih: {{ $assessment->user?->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-on-surface-variant font-mono text-xs">{{ $assessment->assessment_date?->format('d M Y') ?? '-' }}</td>
                        <td class="text-center">
                            <span class="font-bold text-primary font-mono text-sm">{{ $assessment->total_score ?? '-' }}</span>
                        </td>
                        <td>
                            @if ($assessment->finalPosition)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary text-on-primary font-label tracking-wider">
                                    {{ $assessment->finalPosition->code }} &ndash; {{ $assessment->finalPosition->name }}
                                </span>
                            @else
                                <span class="text-on-surface-variant text-xs">Belum dihitung</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('superadmin.assessments.show', $assessment->id) }}"
                                class="inline-flex items-center justify-center gap-1 px-3 py-1.5 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition">
                                <i class="fas fa-eye text-xs"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-on-surface-variant py-14">
                            <i class="fas fa-inbox text-3xl mb-2 block text-on-surface-variant/40"></i>
                            Belum ada assessment yang tercatat di sistem
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
