@extends('user.layouts.app')
@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('user.profile.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Edit Profil</h1>
            <p class="text-sm text-on-surface-variant mt-1 font-body">Perbarui data biodata pemain Anda</p>
        </div>
    </div>

    <div class="card-premium p-6">
        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">
                        Nama Lengkap <span class="text-error">*</span>
                    </label>
                    <input type="text" name="full_name" value="{{ old('full_name', $profile?->full_name) }}"
                        class="w-full rounded-xl border {{ $errors->has('full_name') ? 'border-error/40 bg-error-container/10 text-error' : 'border-outline-variant/20' }} px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary transition outline-none"
                        placeholder="Masukkan nama lengkap">
                    @error('full_name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="flex gap-3 pt-2 font-label">
                <button type="submit" class="flex-1 py-2.5 btn-premium">
                    <i class="fas fa-save mr-2 text-sm"></i> Simpan Perubahan
                </button>
                <a href="{{ route('user.profile.index') }}" class="px-5 py-2.5 btn-premium-outline flex items-center justify-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
