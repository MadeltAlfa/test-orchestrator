@extends('admin.layouts.app')
@section('title', 'Detail Assessment')
@section('page-title', 'Assessment Pemain')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.assessments.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Detail Assessment</h1>
            <p class="text-sm text-on-surface-variant mt-1">{{ $assessment->assessment_date?->format('d F Y') }}</p>
        </div>
    </div>

    {{-- Player & Coach Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card-premium p-6">
            <h2 class="text-sm font-headline font-bold text-on-surface mb-4">Data Pemain &amp; Pelatih</h2>
            @php $player = $assessment->player; @endphp
            <div class="space-y-2 text-sm">
                <p><span class="text-on-surface-variant/60">Nama Pemain:</span> <span class="font-bold text-on-surface">{{ $player?->name ?? 'Pemain' }}</span></p>
                <p><span class="text-on-surface-variant/60">Tgl Lahir / Usia:</span> <span class="text-on-surface font-medium">{{ $player?->dob ? $player->dob->format('d M Y') . ' ('.$player->age.' thn)' : '-' }}</span></p>
                <p><span class="text-on-surface-variant/60">Pelatih Pengampu:</span> <span class="text-primary font-bold">{{ $assessment->user?->name ?? '-' }}</span></p>
                <p><span class="text-on-surface-variant/60">Email Pelatih:</span> <span class="text-on-surface-variant font-mono">{{ $assessment->user?->email }}</span></p>
            </div>
        </div>
        <div class="lg:col-span-2 bg-gradient-to-br from-primary to-primary-container rounded-2xl p-6 text-white shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-cream/80 text-xs uppercase font-bold tracking-widest font-label">Posisi Terbaik</p>
                <h2 class="text-4xl font-headline font-black mt-1">{{ $assessment->finalPosition?->code ?? '-' }}</h2>
                <p class="text-xl font-semibold text-cream/90 mt-0.5">{{ $assessment->finalPosition?->name ?? 'Belum dihitung' }}</p>
            </div>
            <div class="mt-6 flex gap-4 text-sm font-label">
                <div class="bg-white/10 rounded-xl px-4 py-2 border border-white/10">Total Skor: <strong>{{ $assessment->total_score ?? '-' }}</strong></div>
                <div class="bg-white/10 rounded-xl px-4 py-2 border border-white/10">Jumlah Tes: <strong>{{ $assessment->testResults->count() }}</strong></div>
            </div>
        </div>
    </div>

    {{-- Rankings --}}
    <div class="card-premium p-6 space-y-4">
        <div class="pb-4 border-b border-outline-variant/10">
            <h2 class="text-base font-headline font-bold text-on-surface">Ranking Posisi</h2>
        </div>
        <div class="space-y-4 pt-2">
            @foreach ($assessment->results()->with('position')->orderBy('ranking', 'asc')->get() as $result)
            <div class="flex items-center gap-4">
                <div class="w-9 h-9 rounded-xl flex-shrink-0 flex items-center justify-center font-bold tracking-wider font-label {{ $result->ranking === 1 ? 'bg-tertiary-container text-tertiary' : 'bg-surface-container-high text-on-surface-variant' }}">{{ $result->ranking }}</div>
                <div class="flex-1">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-bold text-on-surface">{{ $result->position?->name }} <span class="text-xs font-label text-primary font-semibold">({{ $result->position?->code }})</span></span>
                        <span class="font-bold text-on-surface font-mono">{{ number_format($result->score, 2) }}</span>
                    </div>
                    @php $pct = min(100, max(2, ($result->score/10)*100)); @endphp
                    <div class="w-full bg-surface-container-low rounded-full h-2">
                        <div class="{{ $result->ranking===1 ? 'bg-gradient-to-r from-tertiary to-tertiary/70' : 'bg-gradient-to-r from-primary to-primary/70' }} h-2 rounded-full" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Test Results --}}
    <div class="card-premium overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30">
            <h2 class="text-base font-headline font-bold text-on-surface">Hasil Tes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Tes</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Skor</th>
                        <th class="text-center">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assessment->testResults as $tr)
                    <tr>
                        <td class="font-bold text-on-surface">{{ $tr->test?->name }}</td>
                        <td class="text-center text-on-surface-variant font-mono">{{ $tr->raw_value }} {{ $tr->test?->unit }}</td>
                        <td class="text-center font-bold text-primary font-mono">{{ $tr->score }}</td>
                        <td class="text-center">
                            @if (in_array($tr->category, ['Sangat Baik', 'Baik']))
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-primary/10 text-primary">
                                    <i class="fas fa-arrow-up text-[10px]"></i> {{ $tr->category }}
                                </span>
                            @elseif (in_array($tr->category, ['Sedang', 'Cukup']))
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-tertiary-container text-tertiary">
                                    <i class="fas fa-minus text-[10px]"></i> {{ $tr->category }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-error-container text-error">
                                    <i class="fas fa-arrow-down text-[10px]"></i> {{ $tr->category }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

