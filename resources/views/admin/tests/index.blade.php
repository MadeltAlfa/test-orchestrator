@extends('admin.layouts.app')
@section('title', 'Kelola Tes Keahlian')
@section('page-title', 'Tes Keahlian')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Tes Keahlian</h1>
            <p class="text-sm text-on-surface-variant mt-1">Kelola jenis tes kemampuan fisik dan teknis pemain</p>
        </div>
        <a href="{{ route('superadmin.tests.create') }}" class="btn-premium">
            <i class="fas fa-plus mr-1.5"></i> Tambah Tes
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tes</th>
                        <th>Tipe Input</th>
                        <th>Satuan</th>
                        <th class="text-center">Stopwatch</th>
                        <th class="text-center">Increment</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tests as $i => $test)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $tests->firstItem() + $i }}</td>
                        <td class="font-bold text-on-surface">{{ $test->name }}</td>
                        <td>
                            <span class="badge-premium">{{ $test->input_type }}</span>
                        </td>
                        <td class="text-on-surface-variant font-mono">{{ $test->unit ?? '-' }}</td>
                        <td class="text-center">
                            @if ($test->use_stopwatch)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-primary/10 text-primary">
                                    <i class="fas fa-check-circle text-[10px]"></i> Ya
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-surface-container-high text-on-surface-variant/60">
                                    <i class="fas fa-times-circle text-[10px]"></i> Tidak
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($test->use_increment)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-primary/10 text-primary">
                                    <i class="fas fa-check-circle text-[10px]"></i> Ya
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-surface-container-high text-on-surface-variant/60">
                                    <i class="fas fa-times-circle text-[10px]"></i> Tidak
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('superadmin.norms.index', ['test_id' => $test->id]) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition"
                                    title="Kelola Norma Penilaian">
                                    <i class="fas fa-ruler-combined"></i>
                                </a>
                                <a href="{{ route('superadmin.tests.edit', $test) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-tertiary-container text-tertiary text-xs font-bold rounded-xl hover:shadow-sm transition"
                                    title="Edit Tes">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('superadmin.tests.destroy', $test) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition" title="Hapus Tes">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-dumbbell text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada tes terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($tests->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">{{ $tests->links() }}</div>
        @endif
    </div>
</div>
@endsection

