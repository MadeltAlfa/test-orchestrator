@extends('admin.layouts.app')
@section('title', isset($indicator) ? 'Edit Indikator' : 'Tambah Indikator')
@section('page-title', 'Indikator')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.indicators.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">{{ isset($indicator) ? 'Edit Indikator' : 'Tambah Indikator' }}</h1>
    </div>

    <div class="card-premium p-6">
        <form action="{{ isset($indicator) ? route('superadmin.indicators.update', $indicator) : route('superadmin.indicators.store') }}" method="POST" class="space-y-5">
            @csrf
            @if (isset($indicator)) @method('PUT') @endif

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Nama Indikator <span class="text-error">*</span></label>
                <input type="text" name="name" value="{{ old('name', $indicator->name ?? '') }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('name') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                    placeholder="Contoh: Kecepatan, Kelincahan">
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('description') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none resize-none transition-all"
                    placeholder="Deskripsi indikator...">{{ old('description', $indicator->description ?? '') }}</textarea>
                @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> {{ isset($indicator) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('superadmin.indicators.index') }}" class="btn-premium-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
