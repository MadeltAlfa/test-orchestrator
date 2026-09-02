@extends('user.layouts.app')
@section('title', $guide->title)
@section('page-title', 'Panduan Tes')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    <div class="flex items-center gap-4">
        <a href="{{ route('user.guides.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">{{ $guide->title }}</h1>
            <p class="text-sm text-on-surface-variant mt-1">Tes: {{ $guide->test?->name ?? '-' }}</p>
        </div>
    </div>

    {{-- Ringkasan & Video --}}
    <div class="card-premium p-6 space-y-4">
        <h2 class="text-sm font-headline font-bold text-on-surface">Ringkasan Panduan</h2>
        <p class="text-sm text-on-surface-variant leading-relaxed whitespace-pre-line">{{ $guide->description }}</p>
        @if ($guide->video_url)
        <div class="pt-2">
            <a href="{{ $guide->video_url }}" target="_blank"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-error-container text-error text-sm font-bold rounded-xl hover:shadow-sm transition border border-outline-variant/10">
                <i class="fab fa-youtube text-lg"></i> Tonton Video Tutorial
            </a>
        </div>
        @endif
    </div>

    {{-- Guide Sections --}}
    @forelse ($guide->sections as $section)
    <div class="card-premium p-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 rounded-xl bg-primary-container text-primary flex items-center justify-center text-sm font-bold">
                {{ $section->sort_order }}
            </div>
            <h2 class="text-base font-headline font-bold text-on-surface">{{ $section->section_title }}</h2>
        </div>
        <div class="text-sm text-on-surface-variant leading-relaxed whitespace-pre-line">{{ $section->content }}</div>
    </div>
    @empty
    <div class="card-premium p-12 text-center text-on-surface-variant">
        <i class="fas fa-file-alt text-3xl mb-2 block text-on-surface-variant/40"></i>
        <p>Belum ada isi panduan</p>
    </div>
    @endforelse

    {{-- Scoring Norms --}}
    @if ($guide->test?->norms?->count() > 0)
    <div class="card-premium overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30">
            <h2 class="text-base font-headline font-bold text-on-surface">Tabel Norma Penilaian</h2>
            <p class="text-xs text-on-surface-variant mt-0.5">Referensi konversi nilai mentah ke skor</p>
        </div>
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Rentang Nilai</th>
                        <th class="text-center">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guide->test->norms as $norm)
                    <tr>
                        <td>
                            @if (in_array($norm->category, ['Sangat Baik', 'Baik']))
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-primary/10 text-primary">
                                    {{ $norm->category }}
                                </span>
                            @elseif (in_array($norm->category, ['Sedang', 'Cukup']))
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-tertiary-container text-tertiary">
                                    {{ $norm->category }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-error-container text-error">
                                    {{ $norm->category }}
                                </span>
                            @endif
                        </td>
                        <td class="text-on-surface-variant font-mono text-xs">
                            @switch($norm->operator)
                                @case('between')      {{ $norm->min_value }} – {{ $norm->max_value }} @break
                                @case('less_than')    < {{ $norm->max_value }} @break
                                @case('greater_than') > {{ $norm->min_value }} @break
                                @case('less_equal')   ≤ {{ $norm->max_value }} @break
                                @case('greater_equal')≥ {{ $norm->min_value }} @break
                            @endswitch
                        </td>
                        <td class="text-center font-bold text-primary font-mono">{{ $norm->score }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

