@extends('admin.layouts.app')
@section('title', isset($testGuide) ? 'Edit Panduan Tes' : 'Tambah Panduan Tes')
@section('page-title', 'Panduan Tes')

@section('content')
<div class="max-w-xl mx-auto space-y-6 w-full">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.guides.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">{{ isset($testGuide) ? 'Edit Panduan Tes' : 'Tambah Panduan Tes' }}</h1>
    </div>

    <div class="card-premium p-6">
        <form action="{{ isset($testGuide) ? route('superadmin.guides.update', $testGuide) : route('superadmin.guides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if (isset($testGuide)) @method('PUT') @endif

            {{-- Pilih Tes --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Pilih Tes Keahlian <span class="text-error">*</span></label>
                <select name="test_id" class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('test_id') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    <option value="">-- Pilih Tes --</option>
                    @foreach ($tests as $test)
                        <option value="{{ $test->id }}" {{ old('test_id', $testGuide->test_id ?? '') == $test->id ? 'selected' : '' }}>
                            {{ $test->name }}
                        </option>
                    @endforeach
                </select>
                @error('test_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Judul Panduan --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Judul Panduan <span class="text-error">*</span></label>
                <input type="text" name="title" value="{{ old('title', $testGuide->title ?? '') }}" placeholder="Masukkan judul panduan (contoh: Panduan Juggling Test)"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('title') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all" required>
                @error('title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi Panduan --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Deskripsi Singkat <span class="text-error">*</span></label>
                <textarea name="description" rows="4" placeholder="Masukkan ringkasan panduan tes secara mendetail..."
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('description') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all" required>{{ old('description', $testGuide->description ?? '') }}</textarea>
                @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Video URL --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">URL Video Tutorial <span class="text-on-surface-variant/50 text-xs">(Opsional)</span></label>
                <input type="text" name="video_url" value="{{ old('video_url', $testGuide->video_url ?? '') }}" placeholder="https://youtube.com/watch?v=..."
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('video_url') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('video_url') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Gambar Background --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Gambar Background Hero <span class="text-on-surface-variant/70 text-xs">(Opsional, JPEG, PNG, WEBP, GIF Gerak max 10MB)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('image') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror

                @if (isset($testGuide) && $testGuide->image)
                    <div class="mt-3">
                        <p class="text-xs font-semibold text-on-surface mb-1.5">Gambar Saat Ini:</p>
                        <div class="relative w-40 aspect-video rounded-xl overflow-hidden border border-outline-variant/20">
                            <img src="{{ asset('storage/' . $testGuide->image) }}" class="w-full h-full object-cover" alt="Gambar Background">
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> {{ isset($testGuide) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('superadmin.guides.index') }}" class="btn-premium-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

