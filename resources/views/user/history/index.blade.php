@extends('user.layouts.app')
@section('title', 'Riwayat Assessment')
@section('page-title', 'Riwayat Assessment')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Riwayat Assessment</h1>
            <p class="text-sm text-on-surface-variant mt-1">Seluruh riwayat penentuan posisi Anda</p>
        </div>
        <a href="{{ route('user.position-check.index') }}" class="btn-premium">
            <i class="fas fa-plus"></i> Tes Baru
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemain</th>
                        <th>Tanggal</th>
                        <th>Total Skor</th>
                        <th>Posisi Rekomendasi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($history as $i => $item)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $history->firstItem() + $i }}</td>
                        <td class="font-bold text-primary">{{ $item->player->name ?? 'Pemain Tidak Diketahui' }}</td>
                        <td class="font-bold text-on-surface">{{ $item->assessment_date?->format('d F Y') ?? '-' }}</td>
                        <td>
                            <span class="font-bold text-on-surface font-mono">{{ $item->total_score ?? '-' }}</span>
                        </td>
                        <td>
                            @if ($item->finalPosition)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary text-on-primary font-label tracking-wider">
                                    {{ $item->finalPosition->code }} – {{ $item->finalPosition->name }}
                                </span>
                            @else
                                <span class="text-on-surface-variant/40 text-xs font-medium">–</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('user.history.show', $item->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('user.pdf.assessment', $item->id) }}" target="_blank"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition border border-outline-variant/10" title="Unduh PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <form method="POST" action="{{ route('user.history.destroy', $item->id) }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Riwayat assessment ini akan dihapus permanen!')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-surface-container-high text-on-surface-variant hover:bg-error-container hover:text-error text-xs font-bold rounded-xl hover:shadow-sm transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-history text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p class="font-bold">Belum ada riwayat assessment</p>
                            <a href="{{ route('user.position-check.index') }}" class="mt-3 inline-flex btn-premium">Mulai Tes Pertama →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($history->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">
            {{ $history->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

