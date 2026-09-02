@extends('admin.layouts.app')
@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-headline font-extrabold text-primary">Pengaturan Sistem</h1>
        <p class="text-sm text-on-surface-variant mt-1">Kelola konfigurasi parameter sistem SSB</p>
    </div>

    <div class="card-premium p-6">
        <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <h2 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-2 border-b border-outline-variant/10 pb-2">Konfigurasi Penilaian</h2>
            
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Nama Institusi / SSB <span class="text-error">*</span></label>
                <input type="text" name="institution_name" value="{{ old('institution_name', $settings['institution_name'] ?? '') }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('institution_name') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('institution_name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Email Kontak <span class="text-error">*</span></label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('contact_email') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('contact_email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between p-4 bg-surface-container-low/50 rounded-xl border border-outline-variant/10">
                <div>
                    <label class="block text-sm font-bold text-on-surface">Registrasi Pemain Baru</label>
                    <p class="text-xs text-on-surface-variant">Aktifkan registrasi mandiri untuk pemain baru</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="registration_enabled" value="1" class="sr-only peer"
                        {{ old('registration_enabled', $settings['registration_enabled'] ?? false) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-surface-container-high peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-outline-variant/60 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                </label>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Paginasi Default <span class="text-error">*</span></label>
                    <input type="number" name="default_pagination" value="{{ old('default_pagination', $settings['default_pagination'] ?? 10) }}"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('default_pagination') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @error('default_pagination') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-1.5">Minimal Skor Posisi Sesuai <span class="text-error">*</span></label>
                    <input type="number" step="0.01" name="min_suitable_score" value="{{ old('min_suitable_score', $settings['min_suitable_score'] ?? 60.00) }}"
                        class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('min_suitable_score') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    @error('min_suitable_score') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full btn-premium">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

