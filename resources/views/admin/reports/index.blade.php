@extends('admin.layouts.app')
@section('title', 'Laporan & Ekspor')
@section('page-title', 'Laporan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Laporan & Ekspor</h1>
            <p class="text-sm text-on-surface-variant mt-1">Filter dan unduh data hasil penilaian pemain SSB</p>
        </div>
    </div>

    <div class="card-premium p-6">
        <h2 class="text-sm font-headline font-bold text-on-surface mb-4">Filter Data Laporan</h2>
        <form method="GET" action="{{ route('superadmin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate ?? '' }}"
                    class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate ?? '' }}"
                    class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 btn-premium py-2 text-xs font-bold uppercase tracking-widest">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('superadmin.reports.index') }}" class="btn-premium-outline py-2 text-xs font-bold uppercase tracking-widest text-center px-4 flex items-center justify-center">Reset</a>
            </div>
        </form>
    </div>

    @if (isset($assessments) && $assessments->count() > 0)
    <div class="flex gap-3 justify-end">
        <a href="{{ route('superadmin.reports.export-pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
            class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-error-container text-error text-xs font-bold uppercase tracking-widest rounded-xl hover:shadow-sm transition border border-outline-variant/10 shadow-sm">
            <i class="fas fa-file-pdf"></i> Ekspor PDF
        </a>
        <a href="{{ route('superadmin.reports.export-excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
            class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-primary-container text-primary text-xs font-bold uppercase tracking-widest rounded-xl hover:shadow-sm transition border border-outline-variant/10 shadow-sm">
            <i class="fas fa-file-excel"></i> Ekspor Excel
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Nama Pemain</th>
                        <th>Pelatih Pengampu</th>
                        <th class="text-center">Tanggal Penilaian</th>
                        <th class="text-center">Rekomendasi Posisi</th>
                        <th class="text-center">Skor Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assessments as $assessment)
                    <tr>
                        <td class="font-bold text-on-surface">{{ $assessment->player?->name ?? 'Pemain' }}</td>
                        <td class="text-on-surface-variant font-medium">{{ $assessment->user?->name ?? '-' }}</td>
                        <td class="text-center text-on-surface-variant font-mono">{{ $assessment->assessment_date?->format('d-m-Y') }}</td>
                        <td class="text-center font-bold text-on-surface">{{ $assessment->finalPosition?->name }} <span class="text-xs font-label text-primary font-semibold">({{ $assessment->finalPosition?->code }})</span></td>
                        <td class="text-center font-mono font-bold text-primary">{{ $assessment->total_score }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="card-premium p-16 text-center">
        <i class="fas fa-file-invoice text-5xl mb-4 block text-on-surface-variant/40"></i>
        <p class="text-base font-headline font-bold text-on-surface">Tidak ada data untuk filter tanggal ini</p>
        <p class="text-sm text-on-surface-variant mt-1">Silakan tentukan range tanggal penilaian di atas.</p>
    </div>
    @endif
</div>
@endsection

