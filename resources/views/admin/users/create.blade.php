@extends('admin.layouts.app')
@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('page-title', 'Pengguna')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.users.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="text-2xl font-headline font-extrabold text-primary">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h1>
    </div>
    <div class="card-premium p-6">
        <form action="{{ isset($user) ? route('superadmin.users.update', $user) : route('superadmin.users.store') }}" method="POST" class="space-y-5">
            @csrf
            @if (isset($user)) @method('PUT') @endif

            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Nama <span class="text-error">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('name') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Email <span class="text-error">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('email') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">Role <span class="text-error">*</span></label>
                <select name="role" class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('role') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                    <option value="user" {{ old('role', $user->role ?? 'user') === 'user' ? 'selected' : '' }}>User (Pemain)</option>
                    <option value="superadmin" {{ old('role', $user->role ?? '') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
                @error('role') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-on-surface mb-1.5">
                    Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }} <span class="text-error">{{ isset($user) ? '' : '*' }}</span>
                </label>
                <input type="password" name="password"
                    class="w-full bg-surface-container-lowest rounded-xl border {{ $errors->has('password') ? 'border-error' : 'border-outline-variant/60' }} px-4 py-2.5 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                    placeholder="{{ isset($user) ? '••••••••' : 'Masukkan password' }}">
                @error('password') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 btn-premium">
                    <i class="fas fa-save mr-2"></i> {{ isset($user) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('superadmin.users.index') }}" class="btn-premium-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
