@extends('admin.layouts.app')
@section('title', 'Data Pemain')
@section('page-title', 'Data Pemain Binaan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Data Pemain Binaan</h1>
            <p class="text-sm text-on-surface-variant mt-1">Daftar seluruh atlet/pemain yang terdaftar di bawah pengampuan Pelatih</p>
        </div>
        <form method="GET" action="{{ route('superadmin.players.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama pemain / pelatih..."
                class="bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-4 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none w-64 transition-all">
            <button type="submit" class="btn-premium !py-2 !px-4">
                <i class="fas fa-search mr-1"></i> Cari
            </button>
        </form>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemain</th>
                        <th class="text-center">Tgl Lahir / Usia</th>
                        <th>Pelatih Pengampu</th>
                        <th class="text-center">Total Assessment</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($players as $i => $player)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $players->firstItem() + $i }}</td>
                        <td>
                            <div class="font-bold text-on-surface">{{ $player->name }}</div>
                        </td>
                        <td class="text-center text-on-surface-variant">
                            {{ $player->dob ? $player->dob->format('d M Y') : '-' }}
                            <span class="block text-xs text-on-surface-variant/70 font-mono">({{ $player->age }} tahun)</span>
                        </td>
                        <td>
                            <div class="font-semibold text-primary">{{ $player->coach?->name ?? 'Belum ada' }}</div>
                            <div class="text-xs text-on-surface-variant/70 font-mono">{{ $player->coach?->email }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge-premium">
                                {{ $player->assessments_count }} Tes
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('superadmin.players.show', $player) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <form method="POST" action="{{ route('superadmin.players.destroy', $player) }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus pemain {{ $player->name }}?')">
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
                        <td colspan="6" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-users-slash text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada data pemain binaan terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($players->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">{{ $players->links() }}</div>
        @endif
    </div>
</div>
@endsection
