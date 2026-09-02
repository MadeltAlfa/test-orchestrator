@extends('admin.layouts.app')
@section('title', 'Panduan Tes')
@section('page-title', 'Panduan Tes')

@section('content')
<div class="space-y-6 w-full">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Panduan Tes</h1>
            <p class="text-sm text-on-surface-variant mt-1">Kelola instruksi, video/gambar demo, dan panduan untuk tiap Tes Keahlian</p>
        </div>
        <a href="{{ route('superadmin.guides.create') }}" class="btn-premium">
            <i class="fas fa-plus mr-1.5"></i> Tambah Panduan
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Nama Panduan (Tes)</th>
                        <th>Deskripsi Singkat</th>
                        <th class="text-center">Sections</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guides as $guide)
                    <tr>
                        <td class="font-bold text-on-surface">
                            {{ $guide->title ?? $guide->test?->name ?? 'Tes Terhapus' }}
                        </td>
                        <td class="text-on-surface-variant truncate max-w-xs">{{ $guide->description }}</td>
                        <td class="text-center font-bold text-on-surface">{{ $guide->sections_count ?? $guide->sections->count() }}</td>
                        <td>
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('superadmin.guides.edit', $guide) }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Kelola Panduan & Sections">
                                    <i class="fas fa-sliders-h"></i> Kelola
                                </a>
                                <form method="POST" action="{{ route('superadmin.guides.destroy', $guide) }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Apakah Anda yakin ingin menghapus panduan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition" title="Hapus Panduan">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-book text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada panduan tes</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

