@extends(auth()->user()->role === 'superadmin' ? 'admin.layouts.app' : 'user.layouts.app')

@section('title', 'Edit Profil Akun')
@section('page-title', 'Edit Profil Akun')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Edit Profil Akun</h1>
            <p class="text-sm text-on-surface-variant mt-1">Kelola data profil pengguna dan keamanan kata sandi akun Anda</p>
        </div>
        <div>
            <span class="badge-premium">
                <i class="fas fa-shield-alt mr-1.5"></i> Role: {{ strtoupper(auth()->user()->role ?? 'user') }}
            </span>
        </div>
    </div>

    {{-- Status Flash Alert --}}
    @if (session('status') === 'profile-updated')
        <div class="p-4 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle text-base"></i> Profil akun berhasil diperbarui!
        </div>
    @elseif (session('status') === 'password-updated')
        <div class="p-4 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle text-base"></i> Kata sandi berhasil diubah!
        </div>
    @endif

    {{-- Card 1: Informasi Profil --}}
    <div class="card-premium p-6 sm:p-8">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Card 2: Perbarui Kata Sandi --}}
    <div class="card-premium p-6 sm:p-8">
        @include('profile.partials.update-password-form')
    </div>

    {{-- Card 3: Hapus Akun (Hanya ditampilkan jika bukan Superadmin) --}}
    @if(auth()->user()->role !== 'superadmin')
    <div class="card-premium p-6 sm:p-8 border-error/20">
        @include('profile.partials.delete-user-form')
    </div>
    @endif
</div>
@endsection
