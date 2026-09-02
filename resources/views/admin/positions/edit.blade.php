@extends('admin.layouts.app')
@section('title', 'Edit Posisi')
@section('page-title', 'Posisi Pemain')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.positions.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">Edit Posisi: {{ $position->code }}</h1>
    </div>

    <div class="card-premium p-6">
        <form action="{{ route('superadmin.positions.update', $position) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Kode Posisi <span class="text-error">*</span></label>
                <input type="text" name="code" value="{{ old('code', $position->code) }}" maxlength="10"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('code') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none uppercase transition-all">
                @error('code') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Nama Posisi <span class="text-error">*</span></label>
                <input type="text" name="name" value="{{ old('name', $position->name) }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('name') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('description') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none resize-none transition-all">{{ old('description', $position->description) }}</textarea>
                @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> Perbarui Posisi
                </button>
                <a href="{{ route('superadmin.positions.index') }}" class="btn-premium-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

