@extends('admin.layouts.app')
@section('title', 'Kelola Posisi')
@section('page-title', 'Posisi Pemain')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Posisi Pemain</h1>
            <p class="text-sm text-on-surface-variant mt-1">Kelola daftar posisi dalam sistem SSB</p>
        </div>
        <a href="{{ route('superadmin.positions.create') }}" class="btn-premium">
            <i class="fas fa-plus mr-1.5"></i> Tambah Posisi
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Posisi</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Indikator</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($positions as $i => $position)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $positions->firstItem() + $i }}</td>
                        <td>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary text-on-primary tracking-wider font-label">
                                {{ $position->code }}
                            </span>
                        </td>
                        <td class="font-bold text-on-surface">{{ $position->name }}</td>
                        <td class="text-on-surface-variant max-w-xs truncate">{{ $position->description ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge-premium">
                                {{ $position->indicators_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('superadmin.position-indicators.index', $position->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Atur Indikator">
                                    <i class="fas fa-link"></i>
                                </a>
                                <a href="{{ route('superadmin.positions.edit', $position) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-tertiary-container text-tertiary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('superadmin.positions.destroy', $position) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
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
                            <i class="fas fa-map-marker-alt text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada posisi terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($positions->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">{{ $positions->links() }}</div>
        @endif
    </div>
</div>
@endsection
