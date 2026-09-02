@extends('admin.layouts.app')
@section('title', 'Kelola Panduan - ' . ($testGuide->test?->name ?? 'Tes'))
@section('page-title', 'Kelola Panduan Tes')

@section('content')
<div class="space-y-6 w-full">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('superadmin.guides.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-headline font-extrabold text-primary">Kelola: {{ $testGuide->test?->name ?? $testGuide->title }}</h1>
                <p class="text-sm text-on-surface-variant mt-0.5">Kelola informasi utama dan seluruh bagian (sections) panduan tes</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('panduan-tes.show', $testGuide->id) }}" target="_blank"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-surface-container-lowest border border-outline-variant/20 rounded-xl text-xs font-bold text-on-surface hover:bg-surface-container-high transition shadow-sm">
                <i class="fas fa-external-link-alt text-primary"></i> Preview Publik
            </a>
        </div>
    </div>

    {{-- Unified Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Kolom Kiri: Form Informasi Panduan (5 cols) --}}
        <div class="lg:col-span-5 card-premium p-6 space-y-5">
            <div class="border-b border-outline-variant/10 pb-3">
                <h2 class="text-base font-headline font-bold text-on-surface">Informasi Utama Panduan</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Data ringkasan, video tutorial, dan hero background</p>
            </div>

            <form action="{{ route('superadmin.guides.update', $testGuide) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Pilih Tes --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5 font-label">
                        Tes Keahlian <span class="text-error">*</span>
                    </label>
                    <select name="test_id" class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('test_id') ? 'border-error' : 'border-outline-variant/60' }} px-3.5 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                        @foreach ($tests as $test)
                            <option value="{{ $test->id }}" {{ old('test_id', $testGuide->test_id) == $test->id ? 'selected' : '' }}>
                                {{ $test->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('test_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Judul Panduan --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5 font-label">
                        Judul Panduan <span class="text-error">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $testGuide->title) }}" placeholder="Contoh: Panduan Passing & Control Test"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('title') ? 'border-error' : 'border-outline-variant/60' }} px-3.5 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all" required>
                    @error('title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi Panduan --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5 font-label">
                        Deskripsi Ringkas <span class="text-error">*</span>
                    </label>
                    <textarea name="description" rows="3" placeholder="Masukkan ringkasan instruksi tes..."
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('description') ? 'border-error' : 'border-outline-variant/60' }} px-3.5 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all" required>{{ old('description', $testGuide->description) }}</textarea>
                    @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Video URL --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5 font-label">
                        URL Video Tutorial <span class="text-on-surface-variant/50 text-[10px] font-normal">(Opsional)</span>
                    </label>
                    <input type="text" name="video_url" value="{{ old('video_url', $testGuide->video_url) }}" placeholder="https://youtube.com/watch?v=..."
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('video_url') ? 'border-error' : 'border-outline-variant/60' }} px-3.5 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @error('video_url') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Gambar Background --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5 font-label">
                        Gambar Background Hero <span class="text-on-surface-variant/60 text-[10px] font-normal">(GIF, PNG, JPG, WEBP max 10MB)</span>
                    </label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('image') ? 'border-error' : 'border-outline-variant/60' }} px-3 py-1.5 text-xs text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @error('image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror

                    @if ($testGuide->image)
                        <div class="mt-3">
                            <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider mb-1.5">Gambar / GIF Saat Ini:</p>
                            <div class="relative w-full aspect-video rounded-xl overflow-hidden border border-outline-variant/20 bg-black/10">
                                <img src="{{ asset('storage/' . $testGuide->image) }}" class="w-full h-full object-cover" alt="Background Hero">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full btn-premium py-2.5">
                        <i class="fas fa-save mr-1.5"></i> Simpan Perubahan Panduan
                    </button>
                </div>
            </form>
        </div>

        {{-- Kolom Kanan: Daftar Bagian Panduan (Sections) (7 cols) --}}
        <div class="lg:col-span-7 card-premium overflow-hidden">
            <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30 flex justify-between items-center gap-3">
                <div>
                    <h2 class="text-base font-headline font-bold text-on-surface flex items-center gap-2">
                        Bagian Panduan (Sections)
                        <span class="px-2 py-0.5 bg-primary/10 text-primary text-xs font-bold rounded-full">
                            {{ $testGuide->sections->count() }}
                        </span>
                    </h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Langkah instruksi, peralatan, atau prosedur pelaksanaan tes</p>
                </div>
                <a href="{{ route('superadmin.guide-sections.create', ['test_guide_id' => $testGuide->id]) }}"
                    class="btn-premium text-xs py-2 px-3.5 shrink-0">
                    <i class="fas fa-plus mr-1"></i> Tambah Bagian
                </a>
            </div>

            <div class="divide-y divide-outline-variant/10">
                @forelse ($testGuide->sections->sortBy('sort_order') as $index => $section)
                <div class="p-5 hover:bg-surface-container-lowest/50 transition flex flex-col gap-2">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-lg bg-surface-container-high text-on-surface text-xs font-bold font-mono flex items-center justify-center shrink-0">
                                {{ $section->sort_order ?? ($index + 1) }}
                            </span>
                            <h3 class="text-sm font-bold text-on-surface">{{ $section->section_title }}</h3>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <a href="{{ route('superadmin.guide-sections.edit', $section) }}"
                                class="inline-flex items-center justify-center w-7 h-7 bg-tertiary-container text-tertiary text-xs font-bold rounded-lg hover:shadow-sm transition" title="Edit Bagian">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('superadmin.guide-sections.destroy', $section) }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Yakin ingin menghapus bagian panduan ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-7 h-7 bg-error-container text-error text-xs font-bold rounded-lg hover:shadow-sm transition" title="Hapus Bagian">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="pl-8">
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-3">{{ $section->content }}</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-on-surface-variant space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-surface-container-high text-on-surface-variant/60 flex items-center justify-center mx-auto text-xl">
                        <i class="fas fa-list-ol"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-surface">Belum Ada Bagian Panduan</p>
                        <p class="text-xs text-on-surface-variant mt-0.5">Tambahkan bagian instruksi seperti persiapan, langkah tes, atau peralatan.</p>
                    </div>
                    <a href="{{ route('superadmin.guide-sections.create', ['test_guide_id' => $testGuide->id]) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary text-xs font-bold rounded-xl hover:shadow-sm transition">
                        <i class="fas fa-plus"></i> Tambah Bagian Pertama
                    </a>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
