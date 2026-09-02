@extends('admin.layouts.app')
@section('title', isset($testGuideSection) ? 'Edit Bagian Panduan' : 'Tambah Bagian Panduan')
@section('page-title', 'Panduan Tes')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.guides.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">{{ isset($testGuideSection) ? 'Edit Bagian Panduan' : 'Tambah Bagian Panduan' }}</h1>
    </div>
    <div class="card-premium p-6">
        <form action="{{ isset($testGuideSection) ? route('superadmin.guide-sections.update', $testGuideSection) : route('superadmin.guide-sections.store') }}" method="POST" class="space-y-5">
            @csrf
            @if (isset($testGuideSection)) @method('PUT') @endif

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Pilih Panduan Induk <span class="text-error">*</span></label>
                <select name="test_guide_id" class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('test_guide_id') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    <option value="">-- Pilih Panduan --</option>
                    @foreach ($guides as $guide)
                        <option value="{{ $guide->id }}" {{ old('test_guide_id', $testGuideSection->test_guide_id ?? $guideId ?? '') == $guide->id ? 'selected' : '' }}>
                            {{ $guide->test?->name }}
                        </option>
                    @endforeach
                </select>
                @error('test_guide_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Judul Bagian <span class="text-error">*</span></label>
                <input type="text" name="section_title" value="{{ old('section_title', $testGuideSection->section_title ?? '') }}" placeholder="Persiapan, Prosedur Tes, Penilaian, dll"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('section_title') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('section_title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Isi Konten <span class="text-error">*</span></label>
                <textarea name="content" rows="6" placeholder="Masukkan langkah-langkah atau detail instruksi..."
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('content') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">{{ old('content', $testGuideSection->content ?? '') }}</textarea>
                @error('content') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Urutan Tampil (Sort Order) <span class="text-error">*</span></label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $testGuideSection->sort_order ?? $nextSortOrder ?? '1') }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('sort_order') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('sort_order') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> {{ isset($testGuideSection) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('superadmin.guides.index') }}" class="btn-premium-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

