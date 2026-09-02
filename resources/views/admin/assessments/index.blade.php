@extends('admin.layouts.app')
@section('title', 'Kelola Assessment')
@section('page-title', 'Assessment Pemain')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-headline font-extrabold text-primary">Assessment Pemain</h1>
        <p class="text-sm text-on-surface-variant mt-1">Pantau seluruh hasil assessment pemain SSB</p>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemain</th>
                        <th>Tanggal</th>
                        <th class="text-center">Total Skor</th>
                        <th>Posisi Rekomendasi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assessments as $i => $assessment)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $assessments->firstItem() + $i }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary text-on-primary text-xs font-bold flex items-center justify-center">
                                    {{ strtoupper(substr($assessment->player?->name ?? $assessment->user?->name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ $assessment->player?->name ?? 'Pemain (Pelatih)' }}</p>
                                    <p class="text-xs text-on-surface-variant">Pelatih: {{ $assessment->user?->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-on-surface-variant font-mono">{{ $assessment->assessment_date?->format('d M Y') }}</td>
                        <td class="text-center font-bold text-on-surface">{{ $assessment->total_score ?? '-' }}</td>
                        <td>
                            @if ($assessment->finalPosition)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary text-on-primary tracking-wider font-label">
                                    {{ $assessment->finalPosition->code }}
                                </span>
                            @else
                                <span class="text-on-surface-variant/40 text-xs font-medium">–</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-end">
                                <a href="{{ route('superadmin.assessments.show', $assessment->id) }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-primary-container text-primary text-xs font-bold rounded-xl hover:shadow-sm transition border border-outline-variant/10">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-clipboard-list text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada assessment</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($assessments->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">{{ $assessments->links() }}</div>
        @endif
    </div>
</div>
@endsection

