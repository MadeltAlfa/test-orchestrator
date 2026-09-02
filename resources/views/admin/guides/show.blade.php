@extends('admin.layouts.app')
@section('title', 'Detail Panduan Tes')
@section('page-title', 'Panduan Tes')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.guides.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-headline font-extrabold text-primary">Panduan: {{ $testGuide->test?->name }}</h1>
            <p class="text-sm text-on-surface-variant mt-1">Lihat dan kelola detail panduan tes</p>
        </div>
        <a href="{{ route('superadmin.guides.edit', $testGuide) }}"
            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-tertiary-container text-tertiary text-xs font-bold rounded-xl hover:shadow-sm transition">
            <i class="fas fa-edit"></i> Edit Panduan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card-premium p-6 space-y-4">
            <h2 class="text-sm font-headline font-bold text-on-surface">Ringkasan</h2>
            <p class="text-sm text-on-surface-variant leading-relaxed">{{ $testGuide->description }}</p>
            @if ($testGuide->video_url)
            <div class="pt-2">
                <a href="{{ $testGuide->video_url }}" target="_blank"
                    class="w-full inline-flex items-center justify-center gap-2 py-2.5 bg-error-container text-error text-sm font-bold rounded-xl hover:shadow-sm transition border border-outline-variant/10">
                    <i class="fab fa-youtube"></i> Tonton Video Tutorial
                </a>
            </div>
            @endif

            @if ($testGuide->image)
            <div class="pt-2">
                <p class="text-xs font-semibold text-on-surface mb-2">Gambar Background Hero</p>
                <div class="relative w-full aspect-video rounded-xl overflow-hidden border border-outline-variant/20">
                    <img src="{{ asset('storage/' . $testGuide->image) }}" class="w-full h-full object-cover" alt="Background Hero">
                </div>
            </div>
            @endif
        </div>

        <div class="lg:col-span-2 card-premium overflow-hidden">
            <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30 flex justify-between items-center">
                <h2 class="text-base font-headline font-bold text-on-surface">Bagian Panduan (Sections)</h2>
                <a href="{{ route('superadmin.guide-sections.create', ['test_guide_id' => $testGuide->id]) }}"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition">
                    <i class="fas fa-plus"></i> Tambah Bagian
                </a>
            </div>
            <div class="divide-y divide-outline-variant/10">
                @forelse ($testGuide->sections ?? [] as $section)
                <div class="p-6 space-y-2">
                    <div class="flex justify-between items-start gap-4">
                        <h3 class="text-sm font-bold text-on-surface">{{ $section->section_title }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('superadmin.guide-sections.edit', $section) }}"
                                class="inline-flex items-center justify-center w-7 h-7 bg-tertiary-container text-tertiary text-xs font-bold rounded-lg hover:shadow-sm transition" title="Edit Bagian">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('superadmin.guide-sections.destroy', $section) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-7 h-7 bg-error-container text-error text-xs font-bold rounded-lg hover:shadow-sm transition" title="Hapus Bagian">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="text-sm text-on-surface-variant leading-relaxed">{{ $section->content }}</p>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-on-surface-variant text-sm">Belum ada bagian panduan. Tambahkan bagian menggunakan tombol di atas.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

