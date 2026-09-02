@extends('admin.layouts.app')
@section('title', 'Kelola Indikator')
@section('page-title', 'Indikator')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Indikator</h1>
            <p class="text-sm text-on-surface-variant mt-1">Kelola indikator penilaian kemampuan pemain</p>
        </div>
        <a href="{{ route('superadmin.indicators.create') }}" class="btn-premium">
            <i class="fas fa-plus mr-1.5"></i> Tambah Indikator
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Indikator</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Tes Terkait</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($indicators as $i => $indicator)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $indicators->firstItem() + $i }}</td>
                        <td>
                            <span class="font-bold text-on-surface">{{ $indicator->name }}</span>
                            <div class="text-[10px] text-on-surface-variant mt-0.5 font-label">{{ $indicator->code }}</div>
                        </td>
                        <td class="text-on-surface-variant max-w-md">
                            <div class="font-normal text-xs mb-1.5">{{ $indicator->description ?? '-' }}</div>
                            @if($indicator->tests->isNotEmpty())
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($indicator->tests as $t)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-xl bg-surface-container-low text-on-surface-variant text-[10px] font-bold border border-outline-variant/30">
                                            <i class="fas fa-running mr-1 text-on-surface-variant/55 text-[9px]"></i>{{ $t->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-[10px] text-on-surface-variant/60 font-medium italic">Belum ada tes yang ditautkan</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge-premium">
                                {{ $indicator->tests_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('superadmin.indicator-tests.index', $indicator->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Atur Tes">
                                    <i class="fas fa-link"></i>
                                </a>
                                <a href="{{ route('superadmin.indicators.edit', $indicator) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-tertiary-container text-tertiary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('superadmin.indicators.destroy', $indicator) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
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
                            <i class="fas fa-layer-group text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada indikator</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($indicators->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">{{ $indicators->links() }}</div>
        @endif
    </div>
</div>
@endsection
