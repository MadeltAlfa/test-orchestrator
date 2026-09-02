@extends('admin.layouts.app')
@section('title', 'Detail Pemain — ' . $player->name)
@section('page-title', 'Detail Pemain Binaan')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('superadmin.players.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-headline font-extrabold text-primary">{{ $player->name }}</h1>
                <p class="text-sm text-on-surface-variant mt-0.5">Detail Biodata & Riwayat Assessment Pemain</p>
            </div>
        </div>
        <form method="POST" action="{{ route('superadmin.players.destroy', $player) }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus pemain {{ $player->name }}?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition">
                <i class="fas fa-trash"></i> Hapus Pemain
            </button>
        </form>
    </div>

    <!-- Informational Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-premium p-6 flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-mono uppercase tracking-widest text-on-surface-variant block mb-1">Informasi Pemain</span>
                <h2 class="text-xl font-headline font-bold text-on-surface mb-3">{{ $player->name }}</h2>
                <div class="space-y-2 text-sm text-on-surface-variant">
                    <p><strong class="text-on-surface">Tanggal Lahir:</strong> {{ $player->dob ? $player->dob->format('d F Y') : '-' }}</p>
                    <p><strong class="text-on-surface">Usia Saat Ini:</strong> {{ $player->age }} Tahun</p>
                    <p><strong class="text-on-surface">ID Pemain:</strong> <span class="font-mono text-xs">{{ $player->id }}</span></p>
                </div>
            </div>
        </div>

        <div class="card-premium p-6 flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-mono uppercase tracking-widest text-on-surface-variant block mb-1">Pelatih Pengampu</span>
                <h2 class="text-lg font-headline font-bold text-primary mb-2">{{ $player->coach?->name ?? 'Tidak ada' }}</h2>
                <div class="space-y-1 text-sm text-on-surface-variant">
                    <p><i class="fas fa-envelope text-xs mr-1 opacity-70"></i> {{ $player->coach?->email ?? '-' }}</p>
                    <p><i class="fas fa-user-tag text-xs mr-1 opacity-70"></i> Role: {{ ucfirst($player->coach?->role ?? '-') }}</p>
                </div>
            </div>
        </div>

        <div class="card-premium p-6 flex flex-col justify-between">
            <div>
                <span class="text-[10px] font-mono uppercase tracking-widest text-on-surface-variant block mb-1">Statistik Tes</span>
                <h2 class="text-3xl font-headline font-extrabold text-primary mb-1">{{ $player->assessments->count() }}</h2>
                <p class="text-xs text-on-surface-variant">Total Assessment / Evaluasi Posisi yang pernah diikuti pemain ini.</p>
            </div>
        </div>
    </div>

    <!-- Riwayat Assessment -->
    <div class="card-premium overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30 flex items-center justify-between">
            <h2 class="text-base font-headline font-bold text-on-surface">Riwayat Assessment &amp; Hasil Posisi</h2>
            <span class="badge-premium">{{ $player->assessments->count() }} Record</span>
        </div>
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Tgl Assessment</th>
                        <th>Posisi Rekomendasi Utama</th>
                        <th class="text-center">Total Skor</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($player->assessments as $assessment)
                    <tr>
                        <td class="font-medium text-on-surface">
                            {{ $assessment->assessment_date ? $assessment->assessment_date->format('d M Y') : $assessment->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if ($assessment->finalPosition)
                            <span class="badge-premium">
                                {{ $assessment->finalPosition->code }} — {{ $assessment->finalPosition->name }}
                            </span>
                            @else
                            <span class="text-on-surface-variant/60 text-xs italic">Belum dihitung</span>
                            @endif
                        </td>
                        <td class="text-center font-mono font-bold text-primary">
                            {{ number_format($assessment->total_score, 2) }}
                        </td>
                        <td class="text-right">
                            <a href="{{ route('superadmin.assessments.show', $assessment) }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition">
                                <i class="fas fa-file-alt"></i> Lihat Hasil
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-on-surface-variant py-12">
                            <i class="fas fa-clipboard-list text-3xl mb-2 block text-on-surface-variant/40"></i>
                            <p>Pemain ini belum memiliki riwayat assessment</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
