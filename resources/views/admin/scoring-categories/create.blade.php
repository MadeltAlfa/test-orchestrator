@extends('admin.layouts.app')
@section('title', isset($scoringCategory) ? 'Edit Kategori Skor' : 'Tambah Kategori Skor')
@section('page-title', 'Konfigurasi Penilaian')

@section('content')
<div class="max-w-xl mx-auto space-y-6 w-full">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.scoring-categories.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">{{ isset($scoringCategory) ? 'Edit Kategori Skor' : 'Tambah Kategori Skor' }}</h1>
    </div>

    <div class="card-premium p-6">
        <form action="{{ isset($scoringCategory) ? route('superadmin.scoring-categories.update', $scoringCategory) : route('superadmin.scoring-categories.store') }}" method="POST" class="space-y-5">
            @csrf
            @if (isset($scoringCategory)) @method('PUT') @endif

            {{-- Nama Kategori --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Nama Kategori <span class="text-error">*</span></label>
                <input type="text" name="name" value="{{ old('name', $scoringCategory->name ?? '') }}" placeholder="Sangat Baik, Baik, Sedang, Kurang"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('name') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all" required>
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Skor Range --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Skor Minimal <span class="text-error">*</span></label>
                    <input type="number" step="1" name="min_score" value="{{ old('min_score', $scoringCategory->min_score ?? '0') }}" placeholder="0"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('min_score') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all" required>
                    @error('min_score') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Skor Maksimal <span class="text-error">*</span></label>
                    <input type="number" step="1" name="max_score" value="{{ old('max_score', $scoringCategory->max_score ?? '10') }}" placeholder="10"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('max_score') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all" required>
                    @error('max_score') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Kode Warna Label --}}
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Kode Warna Label</label>
                <select name="color_code" class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('color_code') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @php
                        $colors = [
                            'green' => 'Hijau (Sangat Baik / Baik)',
                            'yellow' => 'Kuning (Sedang / Cukup)',
                            'red' => 'Merah (Kurang)',
                            'blue' => 'Biru',
                            'purple' => 'Ungu'
                        ];
                    @endphp
                    @foreach ($colors as $value => $label)
                        <option value="{{ $value }}" {{ old('color_code', $scoringCategory->color_code ?? 'green') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('color_code') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> {{ isset($scoringCategory) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('superadmin.scoring-categories.index') }}" class="btn-premium-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

