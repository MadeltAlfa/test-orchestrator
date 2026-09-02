@extends('user.layouts.app')
@section('title', 'Detail Pemain')
@section('page-title', 'Detail Pemain')

@section('content')
<div class="space-y-6 max-w-[1200px] mx-auto w-full">
    
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('user.players.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-surface-container hover:bg-surface-container-high transition text-on-surface-variant">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">{{ $player->name }}</h1>
            <p class="text-sm text-on-surface-variant font-label uppercase tracking-widest mt-1">Umur: {{ $player->age }} Tahun | Tanggal Lahir: {{ $player->dob->format('d F Y') }}</p>
        </div>
    </div>

    <div class="border-t border-outline-variant/10 pt-6">
        <h3 class="text-lg font-bold text-on-surface mb-4">Riwayat Pengecekan Posisi</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($assessments as $index => $assessment)
            <div class="card-premium p-5 flex flex-col h-full hover:-translate-y-1 transition-transform duration-300">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-bold text-primary text-lg">Hasil #{{ str_pad(count($assessments) - $index, 2, '0', STR_PAD_LEFT) }}</h4>
                        <p class="text-[10px] text-on-surface-variant uppercase tracking-wider font-label mt-0.5"><i class="fas fa-calendar-alt mr-1"></i> {{ $assessment->assessment_date->format('d M Y') }}</p>
                    </div>
                </div>
                
                <div class="flex-grow space-y-3 mb-5">
                    <div class="bg-surface-container-lowest p-3 rounded-xl border border-outline-variant/5">
                        <p class="text-[10px] text-on-surface-variant uppercase tracking-wider font-label mb-1">Rekomendasi Posisi</p>
                        <p class="font-bold text-base text-on-surface">{{ $assessment->finalPosition->name ?? 'Belum Ditentukan' }}</p>
                    </div>
                    <div class="bg-surface-container-lowest p-3 rounded-xl border border-outline-variant/5">
                        <p class="text-[10px] text-on-surface-variant uppercase tracking-wider font-label mb-1">Skor Keseluruhan</p>
                        <p class="font-bold text-base text-on-surface">{{ $assessment->total_score ?? 0 }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-2 mt-auto">
                    <a href="{{ route('user.position-check.result', $assessment->id) }}" class="btn-premium-outline py-2 rounded-xl text-xs font-bold text-center flex items-center justify-center gap-1.5">
                        <i class="fas fa-chart-bar"></i> Detail
                    </a>
                    <a href="{{ route('user.pdf.assessment', $assessment->id) }}" target="_blank" class="py-2 rounded-xl text-xs font-bold text-center flex items-center justify-center gap-1.5 bg-error-container text-on-error-container hover:bg-error-container/80 transition">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="bg-surface-container-low rounded-2xl p-8 border border-outline-variant/10 text-center">
                    <i class="fas fa-clipboard-list text-4xl text-on-surface-variant/40 mb-3"></i>
                    <p class="text-on-surface-variant font-medium">Pemain ini belum memiliki riwayat tes atau cek posisi.</p>
                    <a href="{{ route('user.position-check.index') }}" class="inline-block mt-4 btn-premium px-6 py-2 rounded-xl text-sm">Cek Posisi Sekarang</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
