@extends('admin.layouts.app')
@section('title', 'Edit Profil Pemain')
@section('page-title', 'Profil Pemain')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.player-profiles.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">Edit Profil Pemain</h1>
    </div>
    <div class="card-premium p-6">
        <form action="{{ route('superadmin.player-profiles.update', $playerProfile) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Nama Lengkap <span class="text-error">*</span></label>
                <input type="text" name="full_name" value="{{ old('full_name', $playerProfile->full_name) }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('full_name') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('full_name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Jenis Kelamin <span class="text-error">*</span></label>
                <select name="gender" class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('gender') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    <option value="L" {{ old('gender', $playerProfile->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $playerProfile->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Umur <span class="text-error">*</span></label>
                    <input type="number" name="age" value="{{ old('age', $playerProfile->age) }}"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('age') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @error('age') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Tinggi (cm) <span class="text-error">*</span></label>
                    <input type="number" step="0.01" name="height" value="{{ old('height', $playerProfile->height) }}"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('height') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @error('height') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Berat (kg) <span class="text-error">*</span></label>
                    <input type="number" step="0.01" name="weight" value="{{ old('weight', $playerProfile->weight) }}"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('weight') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @error('weight') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('superadmin.player-profiles.index') }}" class="btn-premium-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
