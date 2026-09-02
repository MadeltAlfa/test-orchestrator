@extends('admin.layouts.app')
@section('title', 'Detail Profil Pemain')
@section('page-title', 'Profil Pemain')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.player-profiles.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Detail Profil Pemain</h1>
            <p class="text-sm text-on-surface-variant mt-1">Biodata lengkap atlet {{ $playerProfile->full_name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card-premium p-6 space-y-4">
            <h2 class="text-xs font-label uppercase tracking-widest text-on-surface-variant">Data Fisik</h2>
            <div class="space-y-3 text-sm">
                <p class="flex justify-between border-b border-outline-variant/10 pb-2"><span class="text-on-surface-variant">Nama Lengkap:</span> <span class="font-bold text-on-surface">{{ $playerProfile->full_name }}</span></p>
                <p class="flex justify-between border-b border-outline-variant/10 pb-2"><span class="text-on-surface-variant">Jenis Kelamin:</span> <span class="text-on-surface font-semibold">{{ $playerProfile->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span></p>
                <p class="flex justify-between border-b border-outline-variant/10 pb-2"><span class="text-on-surface-variant">Umur:</span> <span class="text-on-surface font-semibold">{{ $playerProfile->age }} tahun</span></p>
                <p class="flex justify-between border-b border-outline-variant/10 pb-2"><span class="text-on-surface-variant">Tinggi Badan:</span> <span class="text-on-surface font-label font-bold">{{ $playerProfile->height }} cm</span></p>
                <p class="flex justify-between border-b border-outline-variant/10 pb-2"><span class="text-on-surface-variant">Berat Badan:</span> <span class="text-on-surface font-label font-bold">{{ $playerProfile->weight }} kg</span></p>
            </div>
            <div class="pt-2">
                <a href="{{ route('superadmin.player-profiles.edit', $playerProfile) }}"
                    class="w-full btn-premium-outline !py-2.5">
                    <i class="fas fa-edit mr-1.5"></i> Edit Profil
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 card-premium overflow-hidden">
            <div class="px-6 py-4 border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-low/30">
                <h2 class="text-base font-headline font-bold text-on-surface">Riwayat Penilaian (Assessments)</h2>
                <span class="badge-premium">
                    Total: {{ $playerProfile->user?->assessments->count() ?? 0 }}
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="table-premium">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-center">Rekomendasi Posisi</th>
                            <th class="text-center">Skor Total</th>
                            <th class="text-right">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($playerProfile->user?->assessments ?? [] as $assessment)
                        <tr>
                            <td class="text-on-surface-variant">{{ $assessment->assessment_date?->format('d-m-Y') }}</td>
                            <td class="text-center font-bold text-on-surface">{{ $assessment->finalPosition?->name ?? '-' }} ({{ $assessment->finalPosition?->code ?? '-' }})</td>
                            <td class="text-center font-label font-bold text-primary">{{ $assessment->total_score }}</td>
                            <td class="text-right">
                                <a href="{{ route('superadmin.assessments.show', $assessment) }}" class="btn-premium-outline !py-1 !px-2.5 text-[10px] uppercase tracking-widest">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-on-surface-variant py-10 text-xs">
                                Pemain ini belum melakukan penilaian posisi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
