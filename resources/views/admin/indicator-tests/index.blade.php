@extends('admin.layouts.app')
@section('title', 'Indikator ↔ Tes')
@section('page-title', 'Relasi Indikator & Tes')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superadmin.indicators.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Indikator: {{ $indicator->name }}</h1>
            <p class="text-sm text-on-surface-variant mt-1">Hubungkan tes keahlian untuk menilai indikator ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Link Test Form --}}
        <div class="card-premium p-6">
            <h2 class="text-base font-headline font-bold text-on-surface mb-4">Hubungkan Tes Keahlian</h2>
            <form action="{{ route('superadmin.indicator-tests.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1">Tes Keahlian <span class="text-error">*</span></label>
                    <select name="test_id" class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                        <option value="">-- Pilih Tes --</option>
                        @foreach ($availableTests as $test)
                            <option value="{{ $test->id }}" {{ old('test_id') == $test->id ? 'selected' : '' }}>
                                {{ $test->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('test_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full btn-premium">
                    <i class="fas fa-link mr-2"></i> Hubungkan Tes
                </button>
            </form>
        </div>

        {{-- Current Linked Tests --}}
        <div class="lg:col-span-2 card-premium overflow-hidden">
            <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30">
                <h2 class="text-base font-headline font-bold text-on-surface">Tes Keahlian Terhubung</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table-premium">
                    <thead>
                        <tr>
                            <th>Nama Tes</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Tipe Input</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($indicator->tests ?? [] as $test)
                        <tr>
                            <td class="font-bold text-on-surface">{{ $test->name }}</td>
                            <td class="text-center text-on-surface-variant font-mono">{{ $test->unit }}</td>
                            <td class="text-center">
                                <span class="badge-premium">
                                    {{ $test->input_type_label ?? $test->input_type }}
                                </span>
                            </td>
                            <td class="text-right">
                                <form method="POST" action="{{ route('superadmin.indicator-tests.destroy', $test->pivot->id ?? $test->id) }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Tes ini akan dilepas dari indikator!')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-error-container text-error text-[10px] font-bold uppercase tracking-widest rounded-xl hover:shadow-sm transition border border-outline-variant/10"><i class="fas fa-unlink"></i> Lepas</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-on-surface-variant py-10 text-xs">
                                Belum ada tes terhubung.
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

