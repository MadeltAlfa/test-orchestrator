@extends('admin.layouts.app')
@section('title', 'Posisi ↔ Indikator')
@section('page-title', 'Relasi Posisi & Indikator')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.positions.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Posisi: {{ $position->code }} – {{ $position->name }}</h1>
            <p class="text-sm text-on-surface-variant mt-1">Atur indikator dan bobot untuk posisi ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Add Indicator Form --}}
        <div class="card-premium p-6">
            <h2 class="text-base font-headline font-bold text-on-surface mb-4">Tambah Indikator</h2>
            <form action="{{ route('superadmin.position-indicators.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="position_id" value="{{ $position->id }}">
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1">Indikator <span class="text-error">*</span></label>
                    <select name="indicator_id" class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                        <option value="">-- Pilih Indikator --</option>
                        @foreach ($availableIndicators as $indicator)
                            <option value="{{ $indicator->id }}" {{ old('indicator_id') == $indicator->id ? 'selected' : '' }}>
                                {{ $indicator->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('indicator_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1">Bobot (0.01 – 100.00) <span class="text-error">*</span></label>
                    <input type="number" step="0.01" min="0.01" max="100.00" name="weight" value="{{ old('weight', '20.00') }}"
                        class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                        placeholder="20.00">
                    @error('weight') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full btn-premium">
                    <i class="fas fa-link mr-2"></i> Tambahkan
                </button>
            </form>
        </div>

        {{-- Current Indicators --}}
        <div class="lg:col-span-2 card-premium overflow-hidden">
            <div class="px-6 py-4 border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-low/30">
                <h2 class="text-base font-headline font-bold text-on-surface">Indikator Terkait</h2>
                @php $totalWeight = $positionIndicators->sum('weight'); @endphp
                <span class="text-sm {{ $totalWeight > 100 ? 'text-error font-bold' : 'text-on-surface-variant font-medium' }}">
                    Total Bobot: <strong>{{ number_format($totalWeight, 2) }}</strong>
                    @if ($totalWeight > 100)
                        <span class="inline-flex items-center gap-1 text-error ml-1">
                            <i class="fas fa-exclamation-triangle text-error"></i> Melebihi 100.00
                        </span>
                    @endif
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="table-premium">
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th class="text-center">Bobot</th>
                            <th class="text-center">% Bobot</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($positionIndicators as $pi)
                        <tr>
                            <td class="font-bold text-on-surface">{{ $pi->indicator?->name ?? '-' }}</td>
                            <td class="text-center font-label font-bold text-primary">{{ $pi->weight }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    @php $pct = $totalWeight > 0 ? round(($pi->weight / $totalWeight) * 100) : 0; @endphp
                                    <div class="flex-1 bg-surface-container-low rounded-full h-2 min-w-[60px]">
                                        <div class="bg-primary h-2 rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="text-xs text-on-surface-variant font-label">{{ $pct }}%</span>
                                </div>
                            </td>
                            <td class="text-right">
                                <form method="POST" action="{{ route('superadmin.position-indicators.destroy', $pi->id) }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Indikator ini akan dilepas dari posisi!')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-error-container text-error text-[10px] font-bold uppercase tracking-widest rounded-xl hover:shadow-sm transition border border-outline-variant/10"><i class="fas fa-unlink"></i> Lepas</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-on-surface-variant py-10 text-xs">
                                Belum ada indikator terhubung.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
