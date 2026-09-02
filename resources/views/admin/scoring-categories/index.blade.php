@extends('admin.layouts.app')
@section('title', 'Kategori Skor')
@section('page-title', 'Konfigurasi Penilaian')

@section('content')
<div class="space-y-6 w-full">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Kategori Skor</h1>
            <p class="text-sm text-on-surface-variant mt-1">Definisikan klasifikasi hasil skor (misal: Sangat Baik, Baik, Cukup, Kurang)</p>
        </div>
        <a href="{{ route('superadmin.scoring-categories.create') }}" class="btn-premium">
            <i class="fas fa-plus mr-1.5"></i> Tambah Kategori
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th class="text-center">Skor Min</th>
                        <th class="text-center">Skor Max</th>
                        <th class="text-center">Warna Label</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td class="font-bold text-on-surface">
                            {{ $category->name }}
                        </td>
                        <td class="text-center font-mono font-bold text-on-surface-variant">{{ $category->min_score }}</td>
                        <td class="text-center font-mono font-bold text-on-surface-variant">{{ $category->max_score }}</td>
                        <td class="text-center">
                            @php
                                $badgeColor = match(strtolower($category->color_code ?? '')) {
                                    'green', 'hijau' => 'bg-primary/10 text-primary',
                                    'yellow', 'kuning' => 'bg-tertiary-container text-tertiary',
                                    'red', 'merah' => 'bg-error-container text-error',
                                    'blue', 'biru' => 'bg-primary-container text-primary',
                                    default => 'bg-surface-container-high text-on-surface-variant'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider {{ $badgeColor }}">
                                {{ $category->color_code ?? 'Default' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('superadmin.scoring-categories.edit', $category) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-tertiary-container text-tertiary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('superadmin.scoring-categories.destroy', $category) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
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
                        <td colspan="5" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-star-half-alt text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada kategori skor</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

