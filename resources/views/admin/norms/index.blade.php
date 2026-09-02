@extends('admin.layouts.app')
@section('title', 'Norma Penilaian' . ($test ? ' - ' . $test->name : ''))
@section('page-title', 'Norma Penilaian')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Norma: {{ $test->name ?? 'Belum Ada Tes' }}</h1>
            <p class="text-sm text-on-surface-variant mt-1">Atur tabel konversi nilai mentah ke skor</p>
        </div>

        @if($tests->isNotEmpty())
        <div class="flex items-center gap-2 bg-surface-container-lowest px-4 py-2 rounded-xl border border-outline-variant/20 shadow-sm">
            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Pilih Tes:</label>
            <select onchange="window.location.href = '{{ route('superadmin.norms.index') }}?test_id=' + this.value" 
                class="rounded-lg border border-outline-variant/60 px-3 py-1.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none font-semibold transition-all">
                @foreach($tests as $t)
                    <option value="{{ $t->id }}" {{ $testId == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>

    @if(!$test)
        <div class="card-premium p-12 text-center">
            <i class="fas fa-ruler-combined text-5xl text-on-surface-variant/40 mb-4 block"></i>
            <h2 class="text-lg font-headline font-bold text-on-surface">Belum Ada Tes Keahlian</h2>
            <p class="text-sm text-on-surface-variant mt-1 max-w-md mx-auto">Silakan daftarkan tes keahlian terlebih dahulu sebelum mengonfigurasi norma penilaian.</p>
            <a href="{{ route('superadmin.tests.create') }}" class="btn-premium inline-flex items-center gap-2 mt-5">
                <i class="fas fa-plus"></i> Tambah Tes Keahlian
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Add Norm Form --}}
            <div class="card-premium p-6">
                <h2 class="text-base font-headline font-bold text-on-surface mb-4">Tambah Norma</h2>
                <form action="{{ route('superadmin.norms.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="test_id" value="{{ $test->id }}">

                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1">Kategori <span class="text-error">*</span></label>
                        <select name="category" class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Sangat Baik" {{ old('category') === 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                            <option value="Baik" {{ old('category') === 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Cukup" {{ old('category') === 'Cukup' ? 'selected' : '' }}>Cukup</option>
                            <option value="Sedang" {{ old('category') === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Kurang" {{ old('category') === 'Kurang' ? 'selected' : '' }}>Kurang</option>
                            <option value="Sangat Kurang" {{ old('category') === 'Sangat Kurang' ? 'selected' : '' }}>Sangat Kurang</option>
                        </select>
                        @error('category') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1">Operator <span class="text-error">*</span></label>
                        <select name="operator" id="normOperator" class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all">
                            <option value="between" {{ old('operator') === 'between' ? 'selected' : '' }}>Antara (between)</option>
                            <option value="less_than" {{ old('operator') === 'less_than' ? 'selected' : '' }}>Kurang dari (&lt;)</option>
                            <option value="greater_than" {{ old('operator') === 'greater_than' ? 'selected' : '' }}>Lebih dari (&gt;)</option>
                            <option value="less_equal" {{ old('operator') === 'less_equal' ? 'selected' : '' }}>Kurang/sama (&lt;=)</option>
                            <option value="greater_equal" {{ old('operator') === 'greater_equal' ? 'selected' : '' }}>Lebih/sama (&gt;=)</option>
                        </select>
                        @error('operator') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-on-surface mb-1">Nilai Min</label>
                            <input type="number" step="0.01" name="min_value" value="{{ old('min_value') }}"
                                class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                                placeholder="0">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-on-surface mb-1">Nilai Max</label>
                            <input type="number" step="0.01" name="max_value" value="{{ old('max_value') }}"
                                class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                                placeholder="100">
                        </div>
                    </div>
                    @error('min_value') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    @error('max_value') <p class="text-error text-xs">{{ $message }}</p> @enderror

                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1">Skor <span class="text-error">*</span></label>
                        <input type="number" min="1" max="10" name="score" value="{{ old('score') }}"
                            class="w-full bg-surface-container-lowest rounded-xl border border-outline-variant/60 px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all"
                            placeholder="1 – 10">
                        @error('score') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full btn-premium">
                        <i class="fas fa-plus mr-2"></i> Tambah Norma
                    </button>
                </form>
            </div>

            {{-- Existing Norms Table --}}
            <div class="lg:col-span-2 card-premium overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30">
                        <h2 class="text-base font-headline font-bold text-on-surface">Daftar Norma Penilaian</h2>
                        <p class="text-xs text-on-surface-variant mt-0.5">Satuan: {{ $test->unit ?? '-' }}</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table-premium">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Rentang</th>
                                    <th class="text-center">Skor</th>
                                    <th class="text-right">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($norms as $norm)
                                <tr>
                                    <td>
                                        @if (in_array($norm->category, ['Sangat Baik', 'Baik']))
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-primary/10 text-primary">
                                                {{ $norm->category }}
                                            </span>
                                        @elseif (in_array($norm->category, ['Sedang', 'Cukup']))
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-tertiary-container text-tertiary">
                                                {{ $norm->category }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-error-container text-error">
                                                {{ $norm->category }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="font-mono text-xs text-on-surface-variant">
                                        @switch($norm->operator)
                                            @case('between')      {{ $norm->min_value }} – {{ $norm->max_value }} @break
                                            @case('less_than')    < {{ $norm->max_value }} @break
                                            @case('greater_than') > {{ $norm->min_value }} @break
                                            @case('less_equal')   ≤ {{ $norm->max_value }} @break
                                            @case('greater_equal')≥ {{ $norm->min_value }} @break
                                        @endswitch
                                    </td>
                                    <td class="text-center font-bold text-primary font-mono">{{ $norm->score }}</td>
                                    <td>
                                        <div class="flex justify-end">
                                            <form method="POST" action="{{ route('superadmin.norms.destroy', $norm) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition" title="Hapus"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-on-surface-variant py-10 text-xs">
                                        Belum ada norma. Tambahkan norma di sebelah kiri.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($norms->hasPages())
                <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">
                    {{ $norms->links() }}
                </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const operatorSelect = document.getElementById('normOperator');
    if (!operatorSelect) return;

    const form = operatorSelect.form;
    const minInput = form.querySelector('input[name="min_value"]');
    const maxInput = form.querySelector('input[name="max_value"]');

    const minContainer = minInput.closest('div');
    const maxContainer = maxInput.closest('div');

    const minLabel = minContainer.querySelector('label');
    const maxLabel = maxContainer.querySelector('label');

    const minLabelText = "Nilai Min";
    const maxLabelText = "Nilai Max";

    // Track if this is the first execution (to prevent clearing old values loaded on validation error)
    let isFirstLoad = true;

    function updateFields() {
        const op = operatorSelect.value;
        
        // Reset states
        minInput.disabled = false;
        maxInput.disabled = false;
        minInput.classList.remove('bg-surface-container-low', 'text-on-surface-variant/40', 'cursor-not-allowed');
        maxInput.classList.remove('bg-surface-container-low', 'text-on-surface-variant/40', 'cursor-not-allowed');
        
        if (op === 'between') {
            minLabel.innerHTML = `${minLabelText} <span class="text-error">*</span>`;
            maxLabel.innerHTML = `${maxLabelText} <span class="text-error">*</span>`;
        } else if (op === 'less_than' || op === 'less_equal') {
            minLabel.innerHTML = minLabelText;
            minInput.disabled = true;
            if (!isFirstLoad) {
                minInput.value = '';
            }
            minInput.classList.add('bg-surface-container-low', 'text-on-surface-variant/40', 'cursor-not-allowed');
            
            maxLabel.innerHTML = `${maxLabelText} <span class="text-error">*</span>`;
        } else if (op === 'greater_than' || op === 'greater_equal') {
            maxLabel.innerHTML = maxLabelText;
            maxInput.disabled = true;
            if (!isFirstLoad) {
                maxInput.value = '';
            }
            maxInput.classList.add('bg-surface-container-low', 'text-on-surface-variant/40', 'cursor-not-allowed');
            
            minLabel.innerHTML = `${minLabelText} <span class="text-error">*</span>`;
        }

        isFirstLoad = false;
    }

    operatorSelect.addEventListener('change', updateFields);
    updateFields(); // Trigger once on load
});
</script>
@endpush


