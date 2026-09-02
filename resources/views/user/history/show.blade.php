@extends('user.layouts.app')
@section('title', 'Detail Riwayat')
@section('page-title', 'Detail Riwayat')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('user.history.index') }}" class="w-9 h-9 bg-surface-container-lowest border border-outline-variant/20 rounded-xl flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Detail Riwayat</h1>
            <p class="text-sm text-on-surface-variant mt-1">Assessment {{ $assessment->assessment_date?->format('d F Y') }}</p>
        </div>
        <div class="ml-auto flex gap-2">
            <a href="{{ route('user.pdf.assessment', $assessment->id) }}" target="_blank"
                class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-error-container text-error text-xs font-bold uppercase tracking-widest rounded-xl hover:shadow-sm transition border border-outline-variant/10">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
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

    {{-- Same content as result page --}}
    @if ($assessment->finalPosition)
    <div class="bg-gradient-to-br from-primary to-primary-container rounded-2xl p-6 text-white text-center shadow-sm">
        <p class="text-cream/80 text-sm uppercase tracking-widest font-bold font-label">Posisi Rekomendasi Terbaik</p>
        <h2 class="text-4xl font-headline font-black mt-1 text-white">{{ $assessment->finalPosition->code }}</h2>
        <p class="text-xl font-semibold text-cream/90 mt-1">{{ $assessment->finalPosition->name }}</p>
        <div class="mt-3 inline-flex items-center gap-2 bg-white/20 rounded-xl px-4 py-2 text-sm font-label">
            Total Skor: <strong>{{ $assessment->total_score }}</strong>
        </div>
    </div>
    @endif

    <style>
        .field {
          background: #23371f; /* Premium dark forest green instead of lawn green */
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
          background: #F5F0E8; /* Cream background for the circle */
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
          color: #2C3E28; /* Green text instead of gray-800 */
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
        <div class="lg:col-span-7 space-y-6 w-full">
            {{-- Rankings --}}
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30"><h2 class="text-base font-headline font-bold text-on-surface">Ranking Posisi</h2></div>
                <div class="p-6 space-y-3">
                    @foreach ($rankings as $result)
                    @if ($result->ranking === 1 || ($result->ranking === 2 && $result->score > 80))
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center font-bold tracking-wider font-label text-base
                            {{ $result->ranking === 1 ? 'bg-tertiary-container text-tertiary' : 'bg-surface-container-high text-on-surface-variant' }}">
                            {{ $result->ranking }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-on-surface text-sm">{{ $result->position?->name ?? '-' }}
                                    <span class="ml-1 text-xs font-label text-primary font-semibold">({{ $result->position?->code }})</span>
                                </span>
                                <span class="text-sm font-bold text-on-surface font-mono">{{ number_format($result->score, 2) }}</span>
                            </div>
                            @php $pct = min(100, max(2, $result->score)); @endphp
                            <div class="w-full bg-surface-container-low rounded-full h-2">
                                <div class="{{ $result->ranking === 1 ? 'bg-gradient-to-r from-tertiary to-tertiary/70' : 'bg-gradient-to-r from-primary to-primary/70' }} h-2 rounded-full"
                                    style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        
            {{-- Test Results --}}
            @if ($assessment->testResults->count())
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-4 border-b border-outline-variant/10 bg-surface-container-low/30"><h2 class="text-base font-headline font-bold text-on-surface">Hasil Tes</h2></div>
                <div class="overflow-x-auto">
                    <table class="table-premium">
                        <thead>
                            <tr>
                                <th>Tes</th>
                                <th class="text-center">Nilai</th>
                                <th class="text-center">Skor</th>
                                <th class="text-center">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessment->testResults as $tr)
                            <tr>
                                <td class="font-bold text-on-surface">{{ $tr->test?->name }}</td>
                                <td class="text-center text-on-surface-variant font-mono">{{ $tr->raw_value }} {{ $tr->test?->unit }}</td>
                                <td class="text-center font-bold text-primary font-mono">{{ $tr->score }}</td>
                                <td class="text-center">
                                    @if (in_array($tr->category, ['Sangat Baik', 'Baik']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-primary/10 text-primary">
                                            <i class="fas fa-arrow-up text-[10px]"></i> {{ $tr->category }}
                                        </span>
                                    @elseif (in_array($tr->category, ['Sedang', 'Cukup']))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-tertiary-container text-tertiary">
                                            <i class="fas fa-minus text-[10px]"></i> {{ $tr->category }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-error-container text-error">
                                            <i class="fas fa-arrow-down text-[10px]"></i> {{ $tr->category }}
                                        </span>
                                    @endif
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
            const results = @json($rankings);

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
                if (pct >= 60) return '#8F6A3B'; // Brand tertiary
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
</div>
@endsection

