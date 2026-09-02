@extends('admin.layouts.app')
@section('title', isset($test) ? 'Edit Tes' : 'Tambah Tes')
@section('page-title', 'Tes Keahlian')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.tests.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">{{ isset($test) ? 'Edit Tes' : 'Tambah Tes' }}</h1>
    </div>

    <div class="card-premium p-6">
        <form action="{{ isset($test) ? route('superadmin.tests.update', $test) : route('superadmin.tests.store') }}" method="POST" class="space-y-5">
            @csrf
            @if (isset($test)) @method('PUT') @endif

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Nama Tes <span class="text-error">*</span></label>
                <input type="text" name="name" value="{{ old('name', $test->name ?? '') }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('name') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                    placeholder="Contoh: Sprint 30 Meter">
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Tipe Input <span class="text-error">*</span></label>
                    <select name="input_type" class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('input_type') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                        <option value="">Pilih Tipe</option>
                        <option value="time" {{ old('input_type', $test->input_type ?? '') === 'time' ? 'selected' : '' }}>Waktu (detik)</option>
                        <option value="count" {{ old('input_type', $test->input_type ?? '') === 'count' ? 'selected' : '' }}>Hitungan</option>
                        <option value="distance" {{ old('input_type', $test->input_type ?? '') === 'distance' ? 'selected' : '' }}>Jarak (meter)</option>
                        <option value="number" {{ old('input_type', $test->input_type ?? '') === 'number' ? 'selected' : '' }}>Angka</option>
                    </select>
                    @error('input_type') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Satuan</label>
                    <input type="text" name="unit" value="{{ old('unit', $test->unit ?? '') }}"
                        class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                        placeholder="detik, kali, meter...">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div class="flex items-center gap-3 p-4 bg-surface-container-low/50 border border-outline-variant/10 rounded-xl">
                    <input type="checkbox" name="use_stopwatch" value="1" id="use_stopwatch"
                        {{ old('use_stopwatch', ($test->use_stopwatch ?? false) ? '1' : '') == '1' ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-outline-variant/60 bg-surface-container-lowest text-primary focus:ring-primary/30 cursor-pointer">
                    <label for="use_stopwatch" class="text-sm font-semibold text-on-surface cursor-pointer">
                        <i class="fas fa-stopwatch text-primary mr-1"></i> Gunakan Stopwatch
                    </label>
                </div>
                <div class="flex items-center gap-3 p-4 bg-surface-container-low/50 border border-outline-variant/10 rounded-xl">
                    <input type="checkbox" name="use_increment" value="1" id="use_increment"
                        {{ old('use_increment', ($test->use_increment ?? false) ? '1' : '') == '1' ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-outline-variant/60 bg-surface-container-lowest text-primary focus:ring-primary/30 cursor-pointer">
                    <label for="use_increment" class="text-sm font-semibold text-on-surface cursor-pointer">
                        <i class="fas fa-plus-circle text-primary mr-1"></i> Gunakan Increment
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> {{ isset($test) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('superadmin.tests.index') }}" class="btn-premium-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

