@extends('user.layouts.app')
@section('title', 'Panduan Tes')
@section('page-title', 'Panduan Tes')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-headline font-extrabold text-primary">Panduan Tes</h1>
        <p class="text-sm text-on-surface-variant mt-1">Pelajari cara pelaksanaan tes dan norma penilaian sebelum melakukan assessment</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse ($guides as $guide)
        <a href="{{ route('user.guides.show', $guide->id) }}"
            class="card-premium overflow-hidden group hover:border-primary/40 transition-all flex flex-col justify-between">
            <div class="bg-gradient-to-br from-primary/5 to-primary-container/20 px-5 py-6 border-b border-outline-variant/10">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary to-primary-container flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-dumbbell text-white"></i>
                </div>
                <h3 class="text-base font-headline font-bold text-on-surface group-hover:text-primary transition-colors">{{ $guide->title }}</h3>
                <p class="text-xs text-on-surface-variant mt-1">Tes: {{ $guide->test?->name ?? '-' }}</p>
            </div>
            <div class="px-5 py-4 flex items-center justify-between text-xs text-on-surface-variant border-t border-outline-variant/5 bg-surface-container-low/20">
                <span><i class="fas fa-list mr-1"></i> {{ $guide->sections_count ?? 0 }} bagian</span>
                <span class="text-primary font-bold group-hover:underline font-label">Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i></span>
            </div>
        </a>
        @empty
        <div class="col-span-3 card-premium p-16 text-center text-on-surface-variant">
            <i class="fas fa-book-open text-4xl mb-3 block text-on-surface-variant/40"></i>
            <p>Belum ada panduan tes tersedia</p>
        </div>
        @endforelse
    </div>

    @if ($guides->hasPages())
    <div class="pt-4">{{ $guides->links() }}</div>
    @endif
</div>
@endsection

