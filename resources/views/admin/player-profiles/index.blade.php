@extends('admin.layouts.app')
@section('title', 'Profil Pemain')
@section('page-title', 'Profil Pemain')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Profil Pemain</h1>
            <p class="text-sm text-on-surface-variant mt-1">Daftar biodata dan ukuran fisik atlet/pemain SSB</p>
        </div>
        <form method="GET" action="{{ route('superadmin.player-profiles.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama pemain..."
                class="bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-4 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none w-64 transition-all">
            <button type="submit" class="btn-premium !py-2 !px-4">
                Cari
            </button>
        </form>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Umur</th>
                        <th class="text-center">Tinggi</th>
                        <th class="text-center">Berat</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profiles as $i => $profile)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $profiles->firstItem() + $i }}</td>
                        <td class="font-bold text-on-surface">{{ $profile->full_name }}</td>
                        <td class="text-center text-on-surface-variant">{{ $profile->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="text-center text-on-surface-variant">{{ $profile->age }} tahun</td>
                        <td class="text-center text-on-surface-variant font-label">{{ $profile->height }} cm</td>
                        <td class="text-center text-on-surface-variant font-label">{{ $profile->weight }} kg</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('superadmin.player-profiles.edit', $profile) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-tertiary-container text-tertiary text-xs font-bold rounded-xl hover:shadow-sm transition">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('superadmin.player-profiles.destroy', $profile) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-id-card text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada profil pemain</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($profiles->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">{{ $profiles->links() }}</div>
        @endif
    </div>
</div>
@endsection
