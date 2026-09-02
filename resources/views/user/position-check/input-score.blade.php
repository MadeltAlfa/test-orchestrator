@extends('user.layouts.app')
@section('title', 'Cek Posisi - Input Skor')
@section('page-title', 'Cek Posisi (Input Skor)')

@section('content')
<div class="space-y-8 max-w-[1600px] mx-auto w-full" x-data="scoreCheck()">

    {{-- Header --}}
    <div class="bg-primary text-on-primary rounded-2xl p-6 relative overflow-hidden shadow-sm">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white rounded-full -translate-y-1/4 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white rounded-full translate-y-1/4 -translate-x-1/4"></div>
        </div>
        <div class="relative z-10">
            <h1 class="text-2xl font-headline font-extrabold"><i class="fas fa-futbol mr-2"></i> Penentuan Posisi (Input Skor)</h1>
            <p class="text-on-primary/80 text-sm mt-1 font-body">Masukkan skor kesiapan atribut Anda secara manual (skala 1 - 10) untuk menghitung rekomendasi posisi terbaik</p>
            <div class="mt-4 flex flex-wrap gap-2 text-xs font-label">
                <span class="bg-white/20 backdrop-blur-sm rounded-xl px-3 py-1 font-bold"><i class="fas fa-edit mr-1"></i>Skor Manual</span>
                <span class="bg-white/20 backdrop-blur-sm rounded-xl px-3 py-1 font-bold"><i class="fas fa-calculator mr-1"></i>Rasio Bobot</span>
                <span class="bg-white/20 backdrop-blur-sm rounded-xl px-3 py-1 font-bold"><i class="fas fa-chart-line mr-1"></i>Analisis Cepat</span>
            </div>

            {{-- Position Filter --}}
            <div class="mt-6 pt-4 border-t border-white/10">
                <h3 class="text-xs font-bold uppercase tracking-wider text-on-primary/75 mb-3 flex items-center gap-1.5 font-label">
                    <i class="fas fa-filter text-primary-fixed-dim"></i> Filter Berdasarkan Posisi:
                </h3>
                <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                    <button type="button" 
                            @click="selectedPosition = 'all'"
                            :class="selectedPosition === 'all' ? 'bg-white text-primary shadow-md' : 'bg-white/10 hover:bg-white/20 text-white'"
                            class="whitespace-nowrap px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/20 font-label">
                        Semua Indikator
                    </button>
                    @foreach($positions as $pos)
                    <button type="button" 
                            @click="selectedPosition = '{{ $pos->id }}'"
                            :class="selectedPosition === '{{ $pos->id }}' ? 'bg-white text-primary shadow-md' : 'bg-white/10 hover:bg-white/20 text-white'"
                            class="whitespace-nowrap px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/20 font-label">
                        {{ $pos->name }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('user.position-check.store-input-score') }}" method="POST" id="scoreCheckForm">
        @csrf

        {{-- Hidden date field --}}
        <input type="hidden" name="assessment_date" value="{{ now()->toDateString() }}">

        {{-- Indicators Score Inputs --}}
        <div class="card-premium p-6 space-y-6">
            <div class="border-b border-outline-variant/10 pb-4">
                <h2 class="font-headline font-bold text-base text-on-surface">Atribut & Indikator Fisik/Teknik</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Tentukan nilai kesiapan di bawah ini dari skala 1 (sangat rendah) sampai 10 (sempurna)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($indicators as $indicator)
                <div x-show="isIndicatorVisible('{{ $indicator->id }}')" 
                     class="bg-surface-container-low/20 rounded-xl border border-outline-variant/5 p-4 hover:border-primary/20 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <label for="score_{{ $indicator->id }}" class="text-sm font-bold text-on-surface truncate pr-2">
                            {{ $indicator->name }}
                        </label>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-primary/10 text-primary font-label uppercase tracking-wide">
                            Atribut
                        </span>
                    </div>

                    <div class="space-y-2">
                        <input type="number" name="scores[{{ $indicator->id }}]"
                            id="score_{{ $indicator->id }}"
                            min="1" max="10" step="1"
                            value="{{ old('scores.' . $indicator->id) }}"
                            @wheel="$el.blur()"
                            :disabled="!isIndicatorVisible('{{ $indicator->id }}')"
                            :required="isIndicatorVisible('{{ $indicator->id }}')"
                            class="w-full rounded-xl border border-outline-variant/20 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface font-bold font-mono focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all no-spinners"
                            placeholder="Input skor (1 - 10)">
                        
                        @error("scores.{$indicator->id}")
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Submit --}}
        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <button type="button" @click="showPlayerModal = true"
                class="flex-1 py-4 btn-premium text-xs uppercase tracking-widest rounded-xl transition-all font-label">
                <i class="fas fa-arrow-right mr-2 text-sm"></i> Lanjut: Pilih Pemain & Simpan
            </button>
            <a href="{{ route('user.dashboard') }}"
                class="px-8 py-4 btn-premium-outline text-xs uppercase tracking-widest rounded-xl transition-all font-label flex items-center justify-center">
                Batal
            </a>
        </div>

        {{-- AlpineJS Modal for Player Selection --}}
        <div x-show="showPlayerModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" 
             @keydown.escape.window="showPlayerModal = false"
             @click="showPlayerModal = false">
            <div @click.stop class="bg-surface rounded-2xl shadow-xl w-full max-w-md p-6 relative overflow-hidden" x-transition>
                
                <h3 class="text-lg font-bold text-on-surface mb-4">Data Pemain</h3>
                <p class="text-sm text-on-surface-variant mb-4">Pilih pemain yang mengikuti tes ini, atau tambahkan pemain baru.</p>

                <div class="space-y-4">
                    {{-- Select Existing Player --}}
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Pilih Pemain</label>
                        <select name="player_id" x-model="selectedPlayer" class="w-full rounded-xl border border-outline-variant/20 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-primary focus:border-primary">
                            <option value="">-- Buat Pemain Baru --</option>
                            @foreach($players as $player)
                            <option value="{{ $player->id }}">{{ $player->name }} (Umur: {{ $player->age }} thn)</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Create New Player Fields --}}
                    <div x-show="!selectedPlayer" class="p-4 bg-surface-container rounded-xl space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-1">Nama Pemain Baru</label>
                            <input type="text" name="new_player_name" class="w-full rounded-lg border border-outline-variant/20 px-3 py-2 text-sm bg-white" placeholder="Masukkan nama">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant mb-1">Tanggal Lahir</label>
                            <input type="text" name="new_player_dob" 
                                x-init="flatpickr($el, { locale: 'id', dateFormat: 'Y-m-d', maxDate: 'today' })"
                                class="w-full rounded-lg border border-outline-variant/20 px-3 py-2 text-sm bg-white" 
                                placeholder="Pilih tanggal lahir">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showPlayerModal = false" class="px-4 py-2 rounded-xl text-sm font-bold text-on-surface-variant bg-surface-container hover:bg-surface-container-high transition">Batal</button>
                    <button type="submit" class="px-6 py-2 rounded-xl text-sm font-bold text-on-primary bg-primary hover:bg-primary/90 transition shadow-md">Simpan Skor</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function scoreCheck() {
    return {
        showPlayerModal: false, 
        selectedPlayer: '',
        selectedPosition: 'all',
        positionIndicatorMap: @json($positionIndicatorMap),
        isIndicatorVisible(indicatorId) {
            if (this.selectedPosition === 'all') return true;
            let visibleIndicators = this.positionIndicatorMap[this.selectedPosition] || [];
            return visibleIndicators.includes(indicatorId);
        }
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Hide spin-buttons for Chrome, Safari, Edge, Opera */
    .no-spinners::-webkit-outer-spin-button,
    .no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide spin-buttons for Firefox */
    .no-spinners {
        -moz-appearance: textfield;
    }
</style>
@endpush
