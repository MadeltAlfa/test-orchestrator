@extends('user.layouts.app')
@section('title', 'Hasil Penentuan Posisi')
@section('page-title', 'Hasil Posisi')

@section('content')
<div class="space-y-8 max-w-[1600px] mx-auto w-full">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('user.position-check.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface hover:bg-surface-container-low transition-all shadow-sm">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Hasil Penentuan Posisi</h1>
            <p class="text-xs text-on-surface-variant font-bold uppercase tracking-wider mt-0.5 font-label">Assessment tanggal {{ $assessment->assessment_date?->format('d F Y') }}</p>
        </div>
    </div>

    {{-- Info Pelatih & Pemain --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant/10 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center text-lg shadow-inner">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-label font-bold mb-0.5">Nama Pelatih</p>
                <p class="text-sm font-bold text-on-surface">{{ $assessment->user->name ?? 'Pelatih' }}</p>
            </div>
        </div>
        <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant/10 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-tertiary-container/50 text-tertiary flex items-center justify-center text-lg shadow-inner">
                <i class="fas fa-running"></i>
            </div>
            <div>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-label font-bold mb-0.5">Nama Pemain</p>
                <p class="text-sm font-bold text-on-surface">{{ $assessment->player->name ?? 'Pemain Tidak Diketahui' }} <span class="text-xs font-normal text-on-surface-variant ml-1">(Umur: {{ $assessment->player->age ?? '-' }} Tahun)</span></p>
            </div>
        </div>
    </div>

    {{-- Best Position Banner --}}
    @if ($assessment->finalPosition)
    <div class="bg-primary text-on-primary rounded-2xl p-8 text-center relative overflow-hidden shadow-sm">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white rounded-full -translate-y-1/4 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white rounded-full translate-y-1/4 -translate-x-1/4"></div>
        </div>
        <div class="relative z-10">
            <div class="text-5xl mb-3 text-yellow-300"><i class="fas fa-trophy"></i></div>
            <p class="text-on-primary/70 text-[10px] uppercase tracking-widest font-bold font-label">Posisi Rekomendasi Terbaik</p>
            <h2 class="text-5xl font-headline font-black mt-1">{{ $assessment->finalPosition->code }}</h2>
            <p class="text-xl font-bold text-on-primary/95 mt-1">{{ $assessment->finalPosition->name }}</p>
            <div class="mt-4 inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/10 text-xs uppercase tracking-wider font-bold font-label">
                <i class="fas fa-star text-yellow-300"></i>
                Total Skor Akhir: <span class="text-sm font-black ml-0.5">{{ $assessment->total_score }}</span>
            </div>
        </div>
    </div>
    @endif

    <style>
        .field {
          background: #23371f; /* Forest green background */
          border-radius: 12px;
          position: relative;
          width: 280px;
          height: 580px;
          border: 3px solid #1a2917;
          overflow: hidden;
        }
        .field svg.lines {
          position: absolute;
          top: 0; left: 0;
          width: 100%;
          height: 100%;
          pointer-events: none;
        }
        .players {
          position: absolute;
          top: 0; left: 0;
          width: 100%; height: 100%;
          display: flex;
          flex-direction: column;
          justify-content: space-around;
          align-items: center;
          padding: 20px 0;
          box-sizing: border-box;
        }
        .row {
          display: flex;
          justify-content: center;
          align-items: center;
          gap: 20px;
          width: 100%;
        }
        .player-wrap {
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 3px;
        }
        .player-ring {
          position: relative;
          width: 58px;
          height: 58px;
        }
        .player-ring canvas {
          position: absolute;
          top: 0; left: 0;
        }
        .player-inner {
          position: absolute;
          top: 5px; left: 5px;
          width: 48px;
          height: 48px;
          border-radius: 50%;
          background: #F5F0E8; /* Cream background */
          border: 1px solid rgba(44, 62, 40, 0.2);
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          z-index: 1;
        }
        .player-pos {
          font-family: 'DM Sans', sans-serif;
          font-size: 10px;
          font-weight: 800;
          color: #2C3E28;
          line-height: 1.1;
        }
        .player-pct {
          font-family: 'DM Mono', monospace;
          font-size: 9px;
          font-weight: 700;
          color: #4A6741;
        }
        .pct-label {
          font-family: 'DM Mono', monospace;
          font-size: 10px;
          font-weight: 700;
          color: #F5F0E8;
          background: rgba(26,22,20,0.7);
          border-radius: 6px;
          padding: 1px 5px;
        }
    </style>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- Left Column: Soccer Field --}}
        <div class="lg:col-span-5 card-premium p-6 flex flex-col items-center w-full">
            <h2 class="font-headline font-bold text-base text-on-surface mb-1">Visualisasi Formasi</h2>
            <p class="text-xs text-on-surface-variant mb-6 text-center">Tingkat kecocokan Anda di setiap posisi pada formasi 2-3-1</p>
            
            <div class="field mx-auto shadow-md">
              <svg class="lines" viewBox="0 0 280 580" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <rect x="1" y="1" width="278" height="578" rx="10" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                <line x1="0" y1="290" x2="280" y2="290" stroke="rgba(255,255,255,0.4)" stroke-width="1.2"/>
                <circle cx="140" cy="290" r="42" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.2"/>
                <circle cx="140" cy="290" r="2" fill="rgba(255,255,255,0.4)"/>
                <rect x="80" y="10" width="120" height="55" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.2"/>
                <rect x="108" y="10" width="64" height="24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.2"/>
                <circle cx="140" cy="52" r="2" fill="rgba(255,255,255,0.4)"/>
                <rect x="80" y="515" width="120" height="55" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.2"/>
                <rect x="108" y="546" width="64" height="24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.2"/>
                <circle cx="140" cy="528" r="2" fill="rgba(255,255,255,0.4)"/>
              </svg>
            
              <div class="players">
                <!-- GK -->
                <div class="row">
                  <div class="player-wrap">
                    <div class="player-ring">
                      <canvas id="c-gk" width="58" height="58"></canvas>
                      <div class="player-inner">
                        <span class="player-pos">GK</span>
                        <span class="player-pct" id="p-gk">0%</span>
                      </div>
                    </div>
                    <span class="pct-label" id="l-gk">0%</span>
                  </div>
                </div>
            
                <!-- RD & LD -->
                <div class="row">
                  <div class="player-wrap">
                    <div class="player-ring">
                      <canvas id="c-ld" width="58" height="58"></canvas>
                      <div class="player-inner">
                        <span class="player-pos text-[9px]">DL/DR</span>
                        <span class="player-pct text-[9px]" id="p-ld">0%</span>
                      </div>
                    </div>
                    <span class="pct-label" id="l-ld">0%</span>
                  </div>
                  <div class="player-wrap">
                    <div class="player-ring">
                      <canvas id="c-rd" width="58" height="58"></canvas>
                      <div class="player-inner">
                        <span class="player-pos">CB</span>
                        <span class="player-pct" id="p-rd">0%</span>
                      </div>
                    </div>
                    <span class="pct-label" id="l-rd">0%</span>
                  </div>
                </div>
            
                <!-- RM, CM, LM -->
                <div class="row gap-4">
                  <div class="player-wrap">
                    <div class="player-ring">
                      <canvas id="c-lm" width="58" height="58"></canvas>
                      <div class="player-inner">
                        <span class="player-pos text-[9px]">WR/WL</span>
                        <span class="player-pct text-[9px]" id="p-lm">0%</span>
                      </div>
                    </div>
                    <span class="pct-label" id="l-lm">0%</span>
                  </div>
                  <div class="player-wrap">
                    <div class="player-ring">
                      <canvas id="c-cm" width="58" height="58"></canvas>
                      <div class="player-inner">
                        <span class="player-pos">MC</span>
                        <span class="player-pct" id="p-cm">0%</span>
                      </div>
                    </div>
                    <span class="pct-label" id="l-cm">0%</span>
                  </div>
                  <div class="player-wrap">
                    <div class="player-ring">
                      <canvas id="c-rm" width="58" height="58"></canvas>
                      <div class="player-inner">
                        <span class="player-pos text-[9px]">ML/MR</span>
                        <span class="player-pct text-[9px]" id="p-rm">0%</span>
                      </div>
                    </div>
                    <span class="pct-label" id="l-rm">0%</span>
                  </div>
                </div>
            
                <!-- ST -->
                <div class="row">
                  <div class="player-wrap">
                    <div class="player-ring">
                      <canvas id="c-st" width="58" height="58"></canvas>
                      <div class="player-inner">
                        <span class="player-pos">ST</span>
                        <span class="player-pct" id="p-st">0%</span>
                      </div>
                    </div>
                    <span class="pct-label" id="l-st">0%</span>
                  </div>
                </div>
              </div>
            </div>
        </div>

        {{-- Right Column: Rankings & Details --}}
        <div class="lg:col-span-7 space-y-8 w-full">
            {{-- Position Rankings --}}
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-5 border-b border-outline-variant/10 bg-surface-container-low/30">
                    <h2 class="font-headline font-bold text-base text-on-surface">Ranking Kecocokan Posisi</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Urutan rekomendasi posisi berdasarkan kecocokan atribut</p>
                </div>
                <div class="p-6 space-y-4">
                    @foreach ($results as $result)
                    @if ($result->ranking === 1 || ($result->ranking === 2 && $result->score > 80))
                    <div class="relative">
                        <div class="flex items-center gap-4">
                            {{-- Rank Badge --}}
                            <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center font-headline font-extrabold text-base border border-outline-variant/10 shadow-sm
                                {{ $result->ranking === 1 ? 'bg-tertiary-container text-tertiary' : 'bg-surface-container-high text-on-surface-variant' }}">
                                {{ $result->ranking }}
                            </div>
        
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-on-surface text-sm">{{ $result->position?->name ?? 'Unknown' }}</span>
                                        <span class="text-xs bg-primary text-on-primary font-bold px-2 py-0.5 rounded-lg font-label tracking-wide">
                                            {{ $result->position?->code ?? '-' }}
                                        </span>
                                        @if ($result->ranking === 1)
                                            <span class="text-[9px] bg-tertiary-container text-tertiary font-bold px-2 py-0.5 rounded-full uppercase tracking-wider font-label"><i class="fas fa-trophy mr-1 text-yellow-500"></i> Terbaik</span>
                                        @endif
                                    </div>
                                    <span class="text-sm font-bold text-on-surface font-mono">{{ number_format($result->score, 2) }}</span>
                                </div>
                                @php $pct = min(100, max(2, $result->score)); @endphp
                                <div class="w-full bg-surface-container-low rounded-full h-2">
                                    <div class="{{ $result->ranking === 1 ? 'bg-gradient-to-r from-tertiary to-tertiary/70' : 'bg-gradient-to-r from-primary to-primary/70' }} h-2 rounded-full transition-all duration-700"
                                        style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        
            {{-- Indicator Scores --}}
            @if ($assessment->scores->count() > 0)
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-5 border-b border-outline-variant/10 bg-surface-container-low/30">
                    <h2 class="font-headline font-bold text-base text-on-surface">Skor Per Indikator</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Nilai konversi performa di setiap indikator fisik & teknik</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-premium">
                        <thead>
                            <tr>
                                <th>Indikator</th>
                                <th class="text-center">Skor</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessment->scores as $score)
                            <tr>
                                <td class="font-bold text-on-surface">{{ $score->indicator_name }}</td>
                                <td class="text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold font-mono
                                        {{ $score->score >= 8 ? 'bg-primary/10 text-primary border border-primary/20' : ($score->score >= 5 ? 'bg-tertiary-container text-tertiary border border-tertiary/20' : 'bg-error-container text-error border border-error/20') }}">
                                        {{ $score->score }}/10
                                    </span>
                                </td>
                                <td class="w-40">
                                    <div class="w-full bg-surface-container-low rounded-full h-2">
                                        <div class="{{ $score->score >= 8 ? 'bg-primary' : ($score->score >= 5 ? 'bg-tertiary' : 'bg-error') }} h-2 rounded-full"
                                            style="width: {{ ($score->score / 10) * 100 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        
            {{-- Test Results --}}
            @if ($assessment->testResults->count() > 0)
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-5 border-b border-outline-variant/10 bg-surface-container-low/30">
                    <h2 class="font-headline font-bold text-base text-on-surface">Detail Hasil Tes</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Nilai mentah performa fisik & teknik serta kategorinya</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-premium">
                        <thead>
                            <tr>
                                <th>Nama Tes</th>
                                <th class="text-center">Nilai Mentah</th>
                                <th class="text-center">Skor</th>
                                <th class="text-center">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessment->testResults as $tr_result)
                            <tr>
                                <td class="font-bold text-on-surface">{{ $tr_result->test?->name ?? '-' }}</td>
                                <td class="text-center text-on-surface-variant font-mono">{{ $tr_result->raw_value }} {{ $tr_result->test?->unit }}</td>
                                <td class="text-center font-bold text-primary font-mono">{{ $tr_result->score }}</td>
                                <td class="text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold
                                        {{ in_array($tr_result->category, ['Sangat Baik', 'Baik']) ? 'bg-primary/10 text-primary border border-primary/20' : (in_array($tr_result->category, ['Sedang', 'Cukup']) ? 'bg-tertiary-container text-tertiary border border-tertiary/20' : 'bg-error-container text-error border border-error/20') }}">
                                        {{ $tr_result->category ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const results = @json($results);

            function getScoreForCode(code) {
                const res = results.find(r => r.position && r.position.code === code);
                if (!res) return 0;
                return Math.round(res.score);
            }

            const players = [
                { id: 'c-gk', labelId: 'l-gk', pctId: 'p-gk', pct: getScoreForCode('GK') },
                { id: 'c-ld', labelId: 'l-ld', pctId: 'p-ld', pct: getScoreForCode('DL/DR') },
                { id: 'c-rd', labelId: 'l-rd', pctId: 'p-rd', pct: getScoreForCode('CB') },
                { id: 'c-lm', labelId: 'l-lm', pctId: 'p-lm', pct: getScoreForCode('WR/WL') },
                { id: 'c-rm', labelId: 'l-rm', pctId: 'p-rm', pct: getScoreForCode('ML/MR') },
                { id: 'c-cm', labelId: 'l-cm', pctId: 'p-cm', pct: getScoreForCode('MC') },
                { id: 'c-st', labelId: 'l-st', pctId: 'p-st', pct: getScoreForCode('ST') },
            ];

            function getColor(pct) {
                if (pct >= 80) return '#2C3E28'; // Brand green
                if (pct >= 60) return '#8F6A3B'; // Brand gold
                return '#B3261E'; // Brand error
            }

            players.forEach(({ id, labelId, pctId, pct }) => {
                const pEl = document.getElementById(pctId);
                const lEl = document.getElementById(labelId);
                if (pEl) pEl.textContent = pct + '%';
                if (lEl) {
                    lEl.textContent = pct + '%';
                    lEl.style.background = getColor(pct);
                }

                const canvas = document.getElementById(id);
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                const cx = 29, cy = 29, r = 25, lw = 5;
                const start = -Math.PI / 2;
                const end = start + (2 * Math.PI * pct / 100);

                ctx.clearRect(0, 0, 58, 58);

                ctx.beginPath();
                ctx.arc(cx, cy, r, 0, 2 * Math.PI);
                ctx.strokeStyle = 'rgba(0,0,0,0.18)';
                ctx.lineWidth = lw;
                ctx.stroke();

                ctx.beginPath();
                ctx.arc(cx, cy, r, start, end);
                ctx.strokeStyle = getColor(pct);
                ctx.lineWidth = lw;
                ctx.lineCap = 'round';
                ctx.stroke();
            });
        });
    </script>
    @endpush

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 pt-4 font-label">
        <a href="{{ route('user.pdf.assessment', $assessment->id) }}" target="_blank"
            class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-error-container hover:bg-error-container/85 text-error text-xs font-bold uppercase tracking-widest rounded-xl transition-all border border-error/15 shadow-sm">
            <i class="fas fa-file-pdf text-sm"></i> Cetak PDF
        </a>
        <a href="{{ route('user.history.index') }}"
            class="flex-1 btn-premium-outline text-xs uppercase tracking-widest rounded-xl transition-all flex items-center justify-center gap-2">
            <i class="fas fa-history text-sm"></i> Lihat Riwayat
        </a>
        <a href="{{ route('user.position-check.index') }}"
            class="flex-1 btn-premium text-xs uppercase tracking-widest rounded-xl transition-all flex items-center justify-center gap-2">
            <i class="fas fa-redo text-sm"></i> Tes Ulang
        </a>
    </div>

</div>
@endsection
