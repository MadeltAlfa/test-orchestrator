@extends('user.layouts.app')

@section('title', 'Dashboard Pelatih - GetPosition')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8 w-full">

    {{-- Welcome Header / Coach Banner --}}
    <div class="bg-primary text-on-primary rounded-2xl p-6 sm:p-8 relative overflow-hidden shadow-sm">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -translate-y-1/4 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full translate-y-1/4 -translate-x-1/4"></div>
        </div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-white/10 backdrop-blur-sm border border-white/15 text-xs font-bold font-label uppercase tracking-widest mb-3">
                <i class="fas fa-whistle text-primary-fixed-dim"></i> Portal Pelatih SSB
            </div>
            <h1 class="text-2xl sm:text-3xl font-headline font-extrabold tracking-tight">Selamat Datang, Coach {{ auth()->user()->name }}!</h1>
            <p class="text-on-primary/80 mt-1.5 text-sm max-w-2xl font-body leading-relaxed">
                Kelola data pemain binaan, pantau perkembangan indikator fisik & teknik, dan lakukan penilaian untuk menentukan posisi bermain sepak bola terbaik.
            </p>
        </div>
    </div>

    {{-- Quick Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Pemain Binaan</span>
                <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <i class="fas fa-users text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $totalPlayers }}</p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">Total pemain binaan</p>
            </div>
        </div>

        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Total Penilaian</span>
                <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <i class="fas fa-clipboard-check text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $totalAssessments }}</p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">Sesi assessment selesai</p>
            </div>
        </div>

        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Bulan Ini</span>
                <div class="w-9 h-9 bg-tertiary-container rounded-xl flex items-center justify-center text-tertiary">
                    <i class="fas fa-calendar-alt text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $thisMonthAssessments }}</p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">Penilaian di {{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="card-premium p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs text-on-surface-variant font-bold uppercase tracking-wider font-label">Rata-rata Skor</span>
                <div class="w-9 h-9 bg-secondary-container rounded-xl flex items-center justify-center text-secondary">
                    <i class="fas fa-chart-line text-sm"></i>
                </div>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface">{{ $avgScore ? number_format((float)$avgScore, 1) : '-' }}</p>
                <p class="text-[11px] text-on-surface-variant/80 mt-0.5">Skor keseluruhan pemain</p>
            </div>
        </div>
    </div>

    {{-- Main Content Grid: Pemain Binaan (7 cols) & Distribusi Posisi (5 cols) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- Kolom Kiri: Pemain Binaan Terbaru (7 cols) --}}
        <div class="lg:col-span-7 card-premium overflow-hidden">
            <div class="px-5 sm:px-6 py-4 sm:py-5 border-b border-outline-variant/10 flex items-center justify-between gap-3 bg-surface-container-low/30">
                <div class="min-w-0">
                    <h2 class="font-headline font-bold text-sm sm:text-base text-on-surface truncate">Pemain Binaan Terbaru</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5 truncate sm:whitespace-normal">Daftar pemain binaan dan status rekomendasi posisi terakhir</p>
                </div>
                <a href="{{ route('user.players.index') }}" class="text-xs font-bold text-primary uppercase tracking-widest hover:underline flex items-center gap-1 font-label flex-shrink-0">
                    <span class="hidden sm:inline">Semua Pemain</span>
                    <span class="sm:hidden">Semua</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="divide-y divide-outline-variant/10">
                @forelse ($recentPlayers as $player)
                    @php
                        $latest = $player->assessments->first();
                    @endphp
                    <div class="p-3.5 sm:p-5 flex items-center justify-between gap-3 sm:gap-4 hover:bg-surface-container-lowest/60 transition">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-xs sm:text-sm shadow-sm flex-shrink-0">
                                {{ strtoupper(substr($player->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-bold text-sm text-on-surface truncate" title="{{ $player->name }}">{{ $player->name }}</h3>
                                <p class="text-xs text-on-surface-variant mt-0.5 truncate">
                                    {{ $player->age }} tahun &bull; {{ $player->assessments_count }}x Penilaian
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if ($latest && $latest->finalPosition)
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary text-on-primary font-mono tracking-wider shadow-sm" title="{{ $latest->finalPosition->name }} ({{ $latest->finalPosition->code }})">
                                    {{ $latest->finalPosition->code }}
                                </span>
                            @else
                                <span class="text-[11px] sm:text-xs px-2 sm:px-2.5 py-1 rounded-lg bg-surface-container-high text-on-surface-variant font-medium">
                                    Belum Diuji
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-on-surface-variant space-y-3">
                        <i class="fas fa-user-friends text-3xl text-on-surface-variant/40 block"></i>
                        <p class="text-sm font-medium">Belum ada data pemain binaan</p>
                        <a href="{{ route('user.players.index') }}" class="btn-premium inline-flex text-xs py-2 px-4">
                            <i class="fas fa-plus mr-1.5"></i> Tambah Pemain Sekarang
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Kolom Kanan: Distribusi Posisi Pemain (5 cols) --}}
        <div class="lg:col-span-5 card-premium p-5 sm:p-6">
            <div class="border-b border-outline-variant/10 pb-4 mb-4">
                <h2 class="font-headline font-bold text-sm sm:text-base text-on-surface">Distribusi Posisi Pemain</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Sebaran hasil rekomendasi posisi dari seluruh penilaian</p>
            </div>

            @if ($positionDistribution->isNotEmpty())
                @php
                    $maxPosCount = $positionDistribution->max('count');
                @endphp
                <div class="space-y-4">
                    @foreach ($positionDistribution as $pos)
                        @php
                            $percentage = $totalAssessments > 0 ? round(($pos->count / $totalAssessments) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1.5">
                                <span class="font-bold text-on-surface flex items-center gap-1.5 truncate pr-2">
                                    <span class="w-2 h-2 rounded-full bg-primary flex-shrink-0"></span>
                                    <span class="truncate">{{ $pos->name }} ({{ $pos->code }})</span>
                                </span>
                                <span class="font-mono font-bold text-on-surface-variant flex-shrink-0">
                                    {{ $pos->count }} sesi ({{ $percentage }}%)
                                </span>
                            </div>
                            <div class="w-full bg-surface-container-low rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-primary to-primary-fixed-dim h-full rounded-full transition-all"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex items-center justify-center h-48 text-on-surface-variant flex-col gap-2">
                    <i class="fas fa-chart-pie text-2xl text-on-surface-variant/40"></i>
                    <p class="text-xs text-center max-w-xs">Lakukan assessment pemain untuk melihat distribusi rekomendasi posisi</p>
                </div>
            @endif
        </div>

    </div>

    {{-- Bottom Section: Riwayat Penilaian Terbaru --}}
    <div class="card-premium overflow-hidden">
        <div class="px-5 sm:px-6 py-4 sm:py-5 border-b border-outline-variant/10 flex items-center justify-between gap-3 bg-surface-container-low/30">
            <div class="min-w-0">
                <h2 class="font-headline font-bold text-sm sm:text-base text-on-surface truncate">Riwayat Assessment Terbaru</h2>
                <p class="text-xs text-on-surface-variant mt-0.5 truncate sm:whitespace-normal">Daftar sesi penilaian pemain terbaru yang telah Anda selesaikan</p>
            </div>
            <a href="{{ route('user.history.index') }}" class="text-xs font-bold text-primary uppercase tracking-widest hover:underline flex items-center gap-1 font-label flex-shrink-0">
                <span class="hidden sm:inline">Lihat Semua Riwayat</span>
                <span class="sm:hidden">Semua</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Nama Pemain</th>
                        <th>Tanggal Penilaian</th>
                        <th class="text-center">Total Skor</th>
                        <th>Posisi Rekomendasi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentAssessments as $item)
                    <tr>
                        <td class="font-bold text-on-surface">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($item->player?->name ?? 'P', 0, 1)) }}
                                </div>
                                <span>{{ $item->player?->name ?? 'Pemain' }}</span>
                            </div>
                        </td>
                        <td class="text-on-surface-variant font-mono text-xs">
                            {{ $item->assessment_date?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="text-center">
                            <span class="font-bold text-primary font-mono text-sm">{{ $item->total_score ?? '-' }}</span>
                        </td>
                        <td>
                            @if ($item->finalPosition)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary text-on-primary font-label tracking-wider">
                                    {{ $item->finalPosition->code }} &ndash; {{ $item->finalPosition->name }}
                                </span>
                            @else
                                <span class="text-on-surface-variant/40 text-xs font-medium">&ndash;</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('user.history.show', $item->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Detail Riwayat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('user.pdf.assessment', $item->id) }}" target="_blank"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-secondary-container text-secondary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Cetak PDF">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-on-surface-variant py-14">
                            <i class="fas fa-clipboard-list text-3xl mb-2 block text-on-surface-variant/40"></i>
                            Belum ada riwayat assessment pemain yang tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
