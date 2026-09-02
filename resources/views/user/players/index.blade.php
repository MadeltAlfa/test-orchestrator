@extends('user.layouts.app')
@section('title', 'Daftar Pemain')
@section('page-title', 'Daftar Pemain')

@section('content')
<div class="space-y-6 max-w-[1200px] mx-auto w-full" x-data="{ showAddModal: false, showEditModal: false, editPlayer: {} }">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-on-background">Daftar Pemain</h1>
            <p class="text-sm text-on-surface-variant">Kelola data pemain yang berada di bawah pengawasan Anda.</p>
        </div>
        <button @click="showAddModal = true" class="btn-premium px-4 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Pemain
        </button>
    </div>

    <div class="bg-surface rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-on-surface">
                <thead class="bg-surface-container-low text-on-surface-variant text-xs uppercase tracking-wider font-label">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Pemain</th>
                        <th class="px-6 py-4 font-semibold">Umur</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Lahir</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse($players as $index => $player)
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-bold text-primary">{{ $player->name }}</td>
                        <td class="px-6 py-4">{{ $player->age }} Tahun</td>
                        <td class="px-6 py-4">{{ $player->dob->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('user.players.show', $player->id) }}" class="p-2 rounded-lg bg-info-container text-on-info-container hover:bg-info-container/80 transition shadow-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button @click="editPlayer = { id: '{{ $player->id }}', name: '{{ $player->name }}', dob: '{{ $player->dob->format('Y-m-d') }}' }; showEditModal = true" class="p-2 rounded-lg bg-tertiary-container text-on-tertiary-container hover:bg-tertiary-container/80 transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('user.players.destroy', $player->id) }}" method="POST" class="inline-block m-0" onsubmit="event.preventDefault(); confirmDelete(this, 'Seluruh riwayat tes pemain ini juga akan terhapus!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-error-container text-on-error-container hover:bg-error-container/80 transition shadow-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-on-surface-variant">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fas fa-users text-4xl opacity-20"></i>
                                <p>Belum ada pemain yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Player Modal --}}
    <div x-show="showAddModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @keydown.escape.window="showAddModal = false">
        <div @click.away="showAddModal = false" class="bg-surface rounded-2xl shadow-xl w-full max-w-md p-6 relative" x-transition>
            <h3 class="text-lg font-bold text-on-surface mb-4">Tambah Pemain Baru</h3>
            <form action="{{ route('user.players.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase">Nama Pemain</label>
                    <input type="text" name="name" required class="w-full rounded-xl border border-outline-variant/20 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase">Tanggal Lahir</label>
                    <input type="date" name="dob" required class="w-full rounded-xl border border-outline-variant/20 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-primary focus:border-primary">
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 rounded-xl text-sm font-bold text-on-surface-variant bg-surface-container hover:bg-surface-container-high transition">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-sm font-bold text-on-primary bg-primary hover:bg-primary/90 transition shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Player Modal --}}
    <div x-show="showEditModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @keydown.escape.window="showEditModal = false">
        <div @click.away="showEditModal = false" class="bg-surface rounded-2xl shadow-xl w-full max-w-md p-6 relative" x-transition>
            <h3 class="text-lg font-bold text-on-surface mb-4">Edit Data Pemain</h3>
            <form :action="`{{ url('user/players') }}/${editPlayer.id}`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase">Nama Pemain</label>
                    <input type="text" name="name" x-model="editPlayer.name" required class="w-full rounded-xl border border-outline-variant/20 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase">Tanggal Lahir</label>
                    <input type="date" name="dob" x-model="editPlayer.dob" required class="w-full rounded-xl border border-outline-variant/20 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-primary focus:border-primary">
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-xl text-sm font-bold text-on-surface-variant bg-surface-container hover:bg-surface-container-high transition">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-sm font-bold text-on-primary bg-primary hover:bg-primary/90 transition shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
