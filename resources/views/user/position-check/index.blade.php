@extends('user.layouts.app')
@section('title', 'Cek Posisi - Input Tes')
@section('page-title', 'Cek Posisi')

@section('content')
<div class="space-y-8 max-w-[1600px] mx-auto w-full" x-data="positionCheck()">

    {{-- Header --}}
    <div class="bg-primary text-on-primary rounded-2xl p-6 relative overflow-hidden shadow-sm">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white rounded-full -translate-y-1/4 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white rounded-full translate-y-1/4 -translate-x-1/4"></div>
        </div>
        <div class="relative z-10">
            <h1 class="text-2xl font-headline font-extrabold"><i class="fas fa-futbol mr-2"></i> Penentuan Posisi Pemain</h1>
            <p class="text-on-primary/80 text-sm mt-1 font-body">Masukkan hasil setiap tes fisik & keahlian untuk mendapatkan rekomendasi posisi terbaik Anda</p>
            <div class="mt-4 flex flex-wrap gap-2 text-xs font-label">
                <span class="bg-white/20 backdrop-blur-sm rounded-xl px-3 py-1 font-bold"><i class="fas fa-stopwatch mr-1"></i>Stopwatch</span>
                <span class="bg-white/20 backdrop-blur-sm rounded-xl px-3 py-1 font-bold"><i class="fas fa-plus-circle mr-1"></i>Counter</span>
                <span class="bg-white/20 backdrop-blur-sm rounded-xl px-3 py-1 font-bold"><i class="fas fa-keyboard mr-1"></i>Manual</span>
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
                        Semua Tes
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

            {{-- Dynamic Checklist for All Tests --}}
            <div class="mt-6 border-t border-white/10 pt-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-on-primary/75 mb-3 flex items-center gap-1.5 font-label">
                    <i class="fas fa-tasks text-primary-fixed-dim"></i> Daftar Kelengkapan Tes:
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach ($tests as $t)
                    <div x-show="isTestVisible('{{ $t->id }}')" 
                         class="flex items-center gap-2.5 bg-white/5 border border-white/10 rounded-xl px-3.5 py-2 transition-all duration-300"
                         :class="isTestSaved('{{ $t->id }}') ? 'bg-secondary-container/20 border-secondary-container/30 text-white' : 'text-on-primary/70'">
                        <div class="w-5 h-5 rounded-md flex items-center justify-center transition-all duration-300 flex-shrink-0"
                             :class="isTestSaved('{{ $t->id }}') ? 'bg-secondary text-on-secondary' : 'border border-white/25'">
                            <i class="fas fa-check text-[10px]" x-show="isTestSaved('{{ $t->id }}')"></i>
                        </div>
                        <span class="text-xs font-semibold truncate">{{ $t->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('user.position-check.store') }}" method="POST" id="positionCheckForm">
        @csrf

        {{-- Hidden date field --}}
        <input type="hidden" name="assessment_date" value="{{ now()->toDateString() }}">

        {{-- Test Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($tests as $test)
            <div x-show="isTestVisible('{{ $test->id }}')" 
                 class="card-premium overflow-hidden flex flex-col justify-between transition-all duration-300"
                 x-data="singleTest('{{ $test->id }}')"
                 :class="isSaved ? 'ring-2 ring-secondary !border-secondary bg-secondary/[0.02] shadow-md' : 'hover:border-primary/20'">

                {{-- Test Header --}}
                <div class="px-5 py-4 bg-surface-container-low/50 border-b border-outline-variant/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm transition-all duration-300"
                             :class="isSaved ? 'bg-secondary text-on-secondary' : 'bg-primary text-on-primary'">
                            <template x-if="isSaved">
                                <i class="fas fa-check-double text-sm"></i>
                            </template>
                            <template x-if="!isSaved">
                                <span>
                                    @if ($test->use_stopwatch)
                                        <i class="fas fa-stopwatch text-sm"></i>
                                    @elseif ($test->use_increment)
                                        <i class="fas fa-plus text-sm"></i>
                                    @else
                                        <i class="fas fa-pencil-alt text-sm"></i>
                                    @endif
                                </span>
                            </template>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-on-surface truncate">{{ $test->name }}</h3>
                            <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider mt-0.5 font-label">Satuan: {{ $test->unit }} | Tipe: {{ $test->input_type_label ?? $test->input_type }}</p>
                        </div>
                    </div>
                </div>

                {{-- Test Content --}}
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">

                    <!-- Live State: Input and Controls -->
                    <div x-show="!isSaved" class="space-y-4">
                        @if ($test->use_stopwatch)
                            {{-- Stopwatch UI --}}
                            <div class="text-center">
                                <div class="text-3xl font-mono font-bold text-primary bg-surface-container rounded-xl py-3 px-4 mb-3 border border-outline-variant/5" x-text="formatted()">00.00</div>
                                <div class="flex gap-2 justify-center">
                                    <button type="button" @click="startStop()"
                                        :class="running ? 'bg-error hover:bg-error/95' : 'bg-secondary hover:bg-secondary/95'"
                                        class="flex-1 py-2.5 text-on-primary text-xs font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm font-label">
                                        <span class="inline-flex items-center gap-1.5 justify-center">
                                            <i class="fas" :class="running ? 'fa-pause' : 'fa-play'"></i>
                                            <span x-text="running ? 'STOP' : 'START'">START</span>
                                        </span>
                                    </button>
                                    <button type="button" @click="reset()"
                                        class="px-4 py-2.5 bg-surface-container-highest text-on-surface text-xs font-bold rounded-xl border border-outline-variant/10 hover:bg-surface-container-high transition-all shadow-sm">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </div>
                            </div>

                        @elseif ($test->use_increment)
                            {{-- Increment UI --}}
                            <div class="text-center bg-surface-container/30 border border-outline-variant/5 rounded-2xl p-4">
                                <div class="text-4xl font-headline font-extrabold text-primary py-3" x-text="count">0</div>
                                <div class="flex gap-3 justify-center">
                                    <button type="button" @click="decrement()"
                                        class="w-11 h-11 bg-error-container text-on-error-container rounded-xl text-lg font-bold hover:bg-error-container/80 transition-all border border-error/5 flex items-center justify-center">−</button>
                                    <button type="button" @click="increment()"
                                        class="w-11 h-11 bg-secondary-container text-on-secondary-container rounded-xl text-lg font-bold hover:bg-secondary-container/80 transition-all border border-secondary/5 flex items-center justify-center">+</button>
                                </div>
                            </div>
                        @endif

                        {{-- Value Input --}}
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1.5 font-label">
                                Nilai {{ $test->use_stopwatch || $test->use_increment ? '(auto-terisi)' : '' }}
                            </label>
                            <div class="relative">
                                <input type="number" step="0.01" min="0"
                                    x-model="rawValue"
                                    @wheel="$el.blur()"
                                    class="w-full rounded-xl border border-outline-variant/20 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary bg-surface-container-lowest text-on-surface outline-none transition-all font-bold font-mono no-spinners"
                                    placeholder="Masukkan nilai"
                                    {!! ($test->use_stopwatch || $test->use_increment) ? '' : ":required=\"isTestVisible('{$test->id}')\"" !!}>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-on-surface-variant uppercase tracking-wide font-label">{{ $test->unit }}</span>
                            </div>
                        </div>

                        {{-- Temporary Submit Button --}}
                        <div class="pt-2">
                            <button type="button" @click="saveTemp()"
                                :disabled="rawValue === ''"
                                :class="rawValue === '' ? 'opacity-40 cursor-not-allowed bg-primary/50 text-white/50' : 'btn-premium hover:shadow-md'"
                                class="w-full py-2.5 text-xs font-bold uppercase tracking-widest rounded-xl transition-all flex items-center justify-center gap-1.5 font-label">
                                <i class="fas fa-check-circle text-sm"></i> Simpan Skor Sementara
                            </button>
                        </div>
                    </div>

                    <!-- Saved State: Show category & conversions -->
                    <div x-show="isSaved" x-cloak class="space-y-4">
                        <div class="bg-secondary/5 border border-secondary/15 rounded-2xl p-5 text-center space-y-3.5 shadow-inner">
                            <p class="text-[10px] text-secondary font-bold uppercase tracking-widest font-label">Hasil Terdaftar</p>
                            
                            <div class="text-3xl font-mono font-black text-secondary">
                                <span x-text="savedValue"></span> <span class="text-xs uppercase" style="font-family: inherit;">{{ $test->unit }}</span>
                            </div>

                            <div>
                                <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold inline-flex items-center gap-1.5 border"
                                      :class="savedCategory === 'Sangat Baik' || savedCategory === 'Baik' 
                                              ? 'bg-primary/10 text-primary border-primary/20' 
                                              : (savedCategory === 'Sedang' || savedCategory === 'Cukup' 
                                                 ? 'bg-tertiary-container text-tertiary border-tertiary/20' 
                                                 : 'bg-error-container text-error border-error/20')">
                                    <i class="fas fa-trophy text-[10px]"></i>
                                    Kategori: <span class="font-extrabold" x-text="savedCategory"></span>
                                </span>
                            </div>

                            <div class="text-xs text-on-surface-variant font-medium pt-1 font-body">
                                Skor Konversi Norma: <strong class="text-primary font-mono text-base" x-text="savedScore"></strong> / 10
                            </div>

                            <div class="pt-2 border-t border-outline-variant/10">
                                <button type="button" @click="repeatTest()"
                                    class="w-full btn-premium-outline py-2 text-xs font-bold uppercase tracking-wider rounded-xl transition-all flex items-center justify-center gap-1.5 font-label">
                                    <i class="fas fa-redo"></i> Ulangi Tes
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Form Hidden Field (Transmits savedValue or rawValue to backend) --}}
                    <input type="hidden" name="results[{{ $test->id }}]" :value="isSaved ? savedValue : rawValue" :disabled="!isTestVisible('{{ $test->id }}')" :required="isTestVisible('{{ $test->id }}') && !isSaved">
                    @error("results.{$test->id}") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    {{-- Collapsible Norm Guidelines --}}
                    <div class="mt-4 border-t border-outline-variant/10 pt-3">
                        <div x-data="{ open: false }">
                            <button type="button" @click="open = !open" 
                                     class="w-full flex items-center justify-between text-[11px] font-bold text-primary/85 hover:text-primary transition-all font-label">
                                <span><i class="fas fa-info-circle mr-1"></i> Norma Penilaian ({{ $test->unit }})</span>
                                <i class="fas text-[9px]" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-cloak class="mt-2.5 space-y-1.5 bg-surface-container-low/40 rounded-xl p-3 border border-outline-variant/5">
                                @forelse ($test->norms->sortByDesc('score') as $norm)
                                <div class="flex items-center justify-between text-[10px] py-1 border-b border-outline-variant/5 last:border-b-0 last:pb-0 font-body">
                                    <span class="font-bold {{ in_array($norm->category, ['Sangat Baik', 'Baik']) ? 'text-primary' : (in_array($norm->category, ['Sedang', 'Cukup']) ? 'text-tertiary' : 'text-error') }}">
                                        {{ $norm->category }}
                                    </span>
                                    <span class="font-mono text-on-surface-variant font-semibold">
                                        {{ $norm->range_label }} &rarr; <strong class="text-primary font-bold">Skor {{ $norm->score }}</strong>
                                    </span>
                                </div>
                                @empty
                                <div class="text-[10px] text-center text-on-surface-variant/60 py-2">
                                    Tidak ada norma penilaian untuk tes ini.
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        {{-- Overall Submit Section --}}
        <div class="mt-10">
            <button type="button"
                @click="if(allCompleted) showPlayerModal = true"
                :disabled="!allCompleted"
                :class="!allCompleted ? 'opacity-50 cursor-not-allowed bg-primary/70 text-white/50' : 'btn-premium hover:shadow-lg scale-[1.01]'"
                class="w-full py-4 text-xs uppercase tracking-widest rounded-xl transition-all duration-300 flex items-center justify-center gap-2 font-label">
                <i class="fas fa-arrow-right text-sm"></i>
                <span x-text="allCompleted ? 'Lanjut: Pilih Pemain & Simpan' : 'Selesaikan Semua Tes Terlebih Dahulu (' + savedCount + '/' + visibleTestCount + ')'"></span>
            </button>
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
                    <button type="submit" class="px-6 py-2 rounded-xl text-sm font-bold text-on-primary bg-primary hover:bg-primary/90 transition shadow-md">Simpan Assessment</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Define all norms in a page-level safe Javascript object
const allTestNorms = {
    @foreach ($tests as $test)
    "{{ $test->id }}": {!! $test->norms->toJson() !!},
    @endforeach
};

function singleTest(testId) {
    return {
        rawValue: '',
        timer: 0,
        running: false,
        interval: null,
        count: 0,
        savedValue: '',
        savedCategory: '',
        savedScore: null,
        isSaved: false,
        norms: allTestNorms[testId] || [],
        startStop() {
             if (this.running) {
                 clearInterval(this.interval);
                 this.rawValue = (this.timer / 100).toFixed(2);
             } else {
                 this.interval = setInterval(() => { this.timer++; }, 10);
             }
             this.running = !this.running;
         },
         reset() {
             clearInterval(this.interval);
             this.running = false;
             this.timer = 0;
             this.rawValue = '';
         },
         formatted() {
             let t = this.timer;
             let cs = t % 100;
             let s = Math.floor(t / 100) % 60;
             let m = Math.floor(t / 6000);
             return (m > 0 ? m + ':' : '') + String(s).padStart(2,'0') + '.' + String(cs).padStart(2,'0');
         },
         increment() { this.count++; this.rawValue = this.count; },
         decrement() { if (this.count > 0) { this.count--; this.rawValue = this.count; } },
         matchNorm() {
             let val = parseFloat(this.rawValue);
             if (isNaN(val)) return null;
             for (let norm of this.norms) {
                 let min = norm.min_value ? parseFloat(norm.min_value) : null;
                 let max = norm.max_value ? parseFloat(norm.max_value) : null;
                 let matched = false;
                 switch (norm.operator) {
                     case 'between':
                         matched = (val >= min && val <= max);
                         break;
                      case 'less_than':
                          matched = (val < max);
                          break;
                      case 'greater_than':
                          matched = (val > min);
                          break;
                      case 'less_equal':
                          matched = (val <= max);
                          break;
                      case 'greater_equal':
                          matched = (val >= min);
                          break;
                  }
                  if (matched) {
                      return norm;
                  }
              }
              return null;
          },
          saveTemp() {
              if (this.rawValue === '') return;
              let matched = this.matchNorm();
              this.savedValue = this.rawValue;
              if (matched) {
                  this.savedCategory = matched.category;
                  this.savedScore = matched.score;
              } else {
                  this.savedCategory = 'Tidak Terkategori';
                  this.savedScore = 0;
              }
              this.isSaved = true;
              this.markTestSaved(testId, true);
          },
          repeatTest() {
              this.reset();
              this.rawValue = '';
              this.savedValue = '';
              this.savedCategory = '';
              this.savedScore = null;
              this.isSaved = false;
              this.count = 0;
              this.markTestSaved(testId, false);
          }
     };
 }

 function positionCheck() {
    return {
        savedTests: {},
        selectedPosition: 'all',
        positionTestMap: @json($positionTestMap),
        allTestIds: @json($tests->pluck('id')),
        showPlayerModal: false,
        selectedPlayer: '',
        markTestSaved(testId, isSaved) {
            if (isSaved) {
                this.savedTests[testId] = true;
            } else {
                delete this.savedTests[testId];
            }
        },
        isTestSaved(testId) {
            return !!this.savedTests[testId];
        },
        isTestVisible(testId) {
            if (this.selectedPosition === 'all') return true;
            let visibleTests = this.positionTestMap[this.selectedPosition] || [];
            return visibleTests.includes(testId);
        },
        get visibleTestCount() {
            if (this.selectedPosition === 'all') return this.allTestIds.length;
            let visibleTests = this.positionTestMap[this.selectedPosition] || [];
            return visibleTests.length;
        },
        get savedCount() {
            // Count only saved tests that are currently visible
            return Object.keys(this.savedTests).filter(id => this.isTestVisible(id)).length;
        },
        get allCompleted() {
            return this.visibleTestCount > 0 && this.savedCount === this.visibleTestCount;
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
