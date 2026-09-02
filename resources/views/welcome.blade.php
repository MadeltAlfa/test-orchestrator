@extends('layouts.landing', ['darkNav' => true, 'darkFooter' => true, 'darkTheme' => true])

@section('title', 'GetPosition')
@section('description', 'Sistem analisis berbasis data untuk menentukan posisi ideal pemain sepakbola. Dari atribut fisik hingga kemampuan teknis — semua terukur secara presisi.')

@section('content')
<!-- LOADER -->
<div id="loader">
      <div class="loader-pitch"><div class="loader-dot"></div></div>
      <div class="loader-bar"></div>
      <div class="loader-text">Memuat</div>
</div>

<!-- HERO -->
<section id="hero">
      <canvas id="pitchCanvas"></canvas>
      <canvas id="particleCanvas"></canvas>
      <div class="hero-content">
            <div class="hero-tag">Sistem Penentuan Posisi Pemain</div>
            <h1 class="hero-h1">TEMUKAN<br>POSISI<br><em>TERBAIKMU</em></h1>
            <p class="hero-sub">Analisis berbasis data untuk menentukan posisi idealmu di lapangan. Dari atribut fisik hingga kemampuan teknis — semua terukur secara presisi.</p>
            <div class="hero-actions">
                  <a href="#cta-final" class="btn-primary">
                        <span>Mulai Tes Gratis</span>
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                  </a>
                  <a href="{{ url('/panduan-posisi') }}" class="btn-secondary">
                        Panduan Posisi
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                  </a>
            </div>
      </div>
      <div class="hero-stats">
            <div class="stat-card">
                  <div class="stat-num">{{ $positionsCount }}</div>
                  <div class="stat-label">Posisi Dianalisis</div>
                  <div class="stat-trend">↑ GK hingga ST</div>
            </div>
            <div class="stat-card">
                  <div class="stat-num">{{ $indicatorsCount }}</div>
                  <div class="stat-label">Parameter Ukur</div>
                  <div class="stat-trend">↑ Fisik &amp; Teknis</div>
            </div>
      </div>
      <div class="scroll-indicator">
            <div class="scroll-line"></div>
            <span class="scroll-text">Scroll untuk explore</span>
      </div>
</section>

<!-- POSITIONS -->
<section id="positions">
      <div class="section-eyebrow reveal">Katalog Posisi</div>
      <h2 class="section-h2 reveal reveal-delay-1">Setiap Posisi<br>Punya <em>DNA</em>-nya</h2>
      <div class="positions-grid reveal reveal-delay-2">
            @forelse ($positions as $index => $position)
            <div class="pos-card" data-pos="{{ $position->code }}" onclick="window.location.href='{{ url('/panduan-posisi') }}?pos={{ $position->code }}'">
                  <span class="pos-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                  <div class="pos-icon-wrap">
                        <svg width="20" height="20" fill="none" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18"/></svg>
                  </div>
                  <div class="pos-title">{{ $position->name }}</div>
                  <div class="pos-role">{{ $position->code }}</div>
                  <div class="pos-attrs">
                        @foreach ($position->indicators->take(5) as $indicator)
                        <span>{{ $indicator->name }}</span>
                        @endforeach
                  </div>
                  <a class="pos-arrow"
                        href="{{ url('/panduan-posisi') }}?pos={{ $position->code }}"
                        onclick="event.stopPropagation()"
                  >
                        <span>Lihat</span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                  </a>
            </div>
            @empty
            <div style="padding:40px;color:var(--ink-soft);font-family:'DM Mono',monospace;font-size:12px;">Belum ada data posisi.</div>
            @endforelse
      </div>
</section>

<!-- HOW IT WORKS -->
<section id="how">
      <div class="steps-container">
            <div>
                  <div class="section-eyebrow reveal" style="color:rgba(74,103,65,.7)">Cara Kerja</div>
                  <h2 class="section-h2 reveal reveal-delay-1" style="color:var(--cream)">Proses<br><em>Ilmiah</em><br>4 Langkah</h2>
                  <div class="steps-list">
                        <div class="step" data-step>
                              <div class="step-num">01</div>
                              <div class="step-icon"><svg width="18" height="18" fill="none" stroke="rgba(74,103,65,.7)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                              <div class="step-content">
                                    <div class="step-title">Daftar &amp; Input Data</div>
                                    <div class="step-desc">Buat akun lalu isi data dirimu: tinggi, berat, dan berbagai parameter kemampuan fisik serta teknis. Hanya butuh beberapa menit.</div>
                              </div>
                        </div>
                        <div class="step" data-step>
                              <div class="step-num">02</div>
                              <div class="step-icon"><svg width="18" height="18" fill="none" stroke="rgba(74,103,65,.7)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg></div>
                              <div class="step-content">
                                    <div class="step-title">Ikuti Sesi Tes</div>
                                    <div class="step-desc">Lakukan {{ $totalTests }} jenis tes terstandarisasi sesuai panduan. Setiap tes mengukur {{ $totalIndicators }} indikator kemampuan yang telah ditetapkan.</div>
                              </div>
                        </div>
                        <div class="step" data-step>
                              <div class="step-num">03</div>
                              <div class="step-icon"><svg width="18" height="18" fill="none" stroke="rgba(74,103,65,.7)" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 3"/></svg></div>
                              <div class="step-content">
                                    <div class="step-title">Analisis Multi-Posisi</div>
                                    <div class="step-desc">Sistem menghitung skor kesesuaianmu untuk semua {{ $totalPositions }} posisi berdasarkan bobot indikator masing-masing posisi secara presisi.</div>
                              </div>
                        </div>
                        <div class="step" data-step>
                              <div class="step-num">04</div>
                              <div class="step-icon"><svg width="18" height="18" fill="none" stroke="rgba(74,103,65,.7)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
                              <div class="step-content">
                                    <div class="step-title">Lihat Hasil &amp; Rekomendasi</div>
                                    <div class="step-desc">Dapatkan rekomendasi posisi ideal dengan ranking skor, analisis kekuatan dan kelemahan, serta laporan lengkap yang bisa diunduh.</div>
                              </div>
                        </div>
                  </div>
            </div>

            <!-- Formation Pitch SVG -->
            <div id="fieldDemo">
                  <div class="pitch-svg-wrap">
                        <svg viewBox="0 0 300 400" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%;">
                              <rect x="0" y="0" width="300" height="40" class="pitch-stripe"/>
                              <rect x="0" y="80" width="300" height="40" class="pitch-stripe"/>
                              <rect x="0" y="160" width="300" height="40" class="pitch-stripe"/>
                              <rect x="0" y="240" width="300" height="40" class="pitch-stripe"/>
                              <rect x="0" y="320" width="300" height="40" class="pitch-stripe"/>

                              <rect x="18" y="18" width="264" height="364" rx="4" class="pitch-line"/>
                              <line x1="18" y1="200" x2="282" y2="200" class="pitch-line"/>
                              <circle cx="150" cy="200" r="38" class="pitch-line"/>
                              <circle cx="150" cy="200" r="3" fill="rgba(255,255,255,.55)"/>

                              <rect x="72" y="18" width="156" height="72" class="pitch-line"/>
                              <rect x="108" y="18" width="84" height="28" class="pitch-line"/>
                              <rect x="120" y="10" width="60" height="10" class="pitch-line-thin"/>
                              <path d="M 108,90 A 38,38 0 0,1 192,90" class="pitch-line-thin"/>
                              <circle cx="150" cy="66" r="2.5" fill="rgba(255,255,255,.45)"/>

                              <rect x="72" y="310" width="156" height="72" class="pitch-line"/>
                              <rect x="108" y="354" width="84" height="28" class="pitch-line"/>
                              <rect x="120" y="380" width="60" height="10" class="pitch-line-thin"/>
                              <path d="M 108,310 A 38,38 0 0,0 192,310" class="pitch-line-thin"/>
                              <circle cx="150" cy="334" r="2.5" fill="rgba(255,255,255,.45)"/>

                              <path d="M 18,28 A 10,10 0 0,1 28,18" class="pitch-line-thin"/>
                              <path d="M 282,28 A 10,10 0 0,0 272,18" class="pitch-line-thin"/>
                              <path d="M 18,372 A 10,10 0 0,0 28,382" class="pitch-line-thin"/>
                              <path d="M 282,372 A 10,10 0 0,1 272,382" class="pitch-line-thin"/>

                              <text x="22" y="36" class="formation-label">4–4–2 (DM)</text>

                              <!-- PLAYERS -->
                              <g class="player-dot gk" style="animation-delay:0s">
                                    <circle cx="150" cy="46" r="16" class="ring"/>
                                    <circle cx="150" cy="46" r="10" class="body"/>
                                    <text x="150" y="70" class="player-label">GK</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.15s">
                                    <circle cx="44" cy="135" r="14" class="ring"/>
                                    <circle cx="44" cy="135" r="10" class="body"/>
                                    <text x="44" y="158" class="player-label">RB</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.25s">
                                    <circle cx="105" cy="124" r="14" class="ring"/>
                                    <circle cx="105" cy="124" r="10" class="body"/>
                                    <text x="105" y="147" class="player-label">CB</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.35s">
                                    <circle cx="195" cy="124" r="14" class="ring"/>
                                    <circle cx="195" cy="124" r="10" class="body"/>
                                    <text x="195" y="147" class="player-label">CB</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.45s">
                                    <circle cx="256" cy="135" r="14" class="ring"/>
                                    <circle cx="256" cy="135" r="10" class="body"/>
                                    <text x="256" y="158" class="player-label">LB</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.55s">
                                    <circle cx="150" cy="188" r="14" class="ring"/>
                                    <circle cx="150" cy="188" r="10" class="body"/>
                                    <text x="150" y="211" class="player-label">DM</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.65s">
                                    <circle cx="38" cy="228" r="14" class="ring"/>
                                    <circle cx="38" cy="228" r="10" class="body"/>
                                    <text x="38" y="251" class="player-label">RM</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.75s">
                                    <circle cx="108" cy="224" r="14" class="ring"/>
                                    <circle cx="108" cy="224" r="10" class="body"/>
                                    <text x="108" y="247" class="player-label">CM</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.85s">
                                    <circle cx="192" cy="224" r="14" class="ring"/>
                                    <circle cx="192" cy="224" r="10" class="body"/>
                                    <text x="192" y="247" class="player-label">CM</text>
                              </g>
                              <g class="player-dot" style="animation-delay:.95s">
                                    <circle cx="262" cy="228" r="14" class="ring"/>
                                    <circle cx="262" cy="228" r="10" class="body"/>
                                    <text x="262" y="251" class="player-label">LM</text>
                              </g>
                              <g class="player-dot" style="animation-delay:1.05s">
                                    <circle cx="150" cy="302" r="14" class="ring"/>
                                    <circle cx="150" cy="302" r="10" class="body"/>
                                    <text x="150" y="325" class="player-label">ST</text>
                              </g>
                        </svg>
                        <div style="position:absolute;inset:0;pointer-events:none;background:repeating-linear-gradient(0deg,transparent,transparent 3px,rgba(0,0,0,.04) 3px,rgba(0,0,0,.04) 4px);border-radius:16px;"></div>
                  </div>
            </div>
      </div>
</section>

<!-- STATS BAND -->
<div id="stats-band">
      <div class="band-stat">
            <span class="band-num"><span class="count-num" data-target="{{ $assessmentsCount }}">0</span></span>
            <span class="band-label">Assessmen Dilakukan</span>
      </div>
      <div class="band-stat">
            <span class="band-num"><span class="count-num" data-target="{{ $totalIndicators }}">0</span></span>
            <span class="band-label">Parameter Ukur</span>
      </div>
      <div class="band-stat">
            <span class="band-num"><span class="count-num" data-target="{{ $totalTests }}">0</span></span>
            <span class="band-label">Jenis Tes</span>
      </div>
      <div class="band-stat">
            <span class="band-num"><span class="count-num" data-target="{{ $totalPositions }}">0</span></span>
            <span class="band-label">Posisi Tersedia</span>
      </div>
</div>

<!-- DAFTAR TES -->
<section id="testimonial">
      <div class="section-eyebrow reveal">Daftar Tes</div>
      <h2 class="section-h2 reveal reveal-delay-1">Tes Yang<br><em>Tersedia</em></h2>
      <div class="testimonial-grid">
            @forelse($skillTests as $index => $test)
            <div class="tcard reveal reveal-delay-{{ ($index % 3) + 1 }}">
                  <div class="tcard-author">
                        <div class="tcard-avatar">{{ strtoupper(substr($test->name, 0, 2)) }}</div>
                        <div>
                              <div class="tcard-name">{{ $test->name }}</div>
                              <div class="tcard-pos">Unit: {{ $test->unit ?? '-' }}</div>
                        </div>
                        <div class="tcard-badge">{{ $test->input_type_label }}</div>
                  </div>
            </div>
            @empty
            <div class="tcard reveal reveal-delay-1" style="grid-column: 1 / -1; text-align: center;">
                  <p class="tcard-quote">Belum ada tes yang ditambahkan.</p>
            </div>
            @endforelse
      </div>
</section>

<!-- CTA FINAL -->
<section id="cta-final">
      <svg class="cta-bg-pitch" viewBox="0 0 1200 600" preserveAspectRatio="xMidYMid slice">
            <rect width="1200" height="600" fill="none" stroke="#4A6741" stroke-width="1" rx="20"/>
            <line x1="600" y1="0" x2="600" y2="600" stroke="#4A6741" stroke-width=".5"/>
            <circle cx="600" cy="300" r="80" fill="none" stroke="#4A6741" stroke-width=".5"/>
            <rect x="100" y="200" width="120" height="200" rx="4" fill="none" stroke="#4A6741" stroke-width=".5"/>
            <rect x="980" y="200" width="120" height="200" rx="4" fill="none" stroke="#4A6741" stroke-width=".5"/>
            <rect x="100" y="240" width="50" height="120" rx="2" fill="none" stroke="#4A6741" stroke-width=".5"/>
            <rect x="1050" y="240" width="50" height="120" rx="2" fill="none" stroke="#4A6741" stroke-width=".5"/>
      </svg>
      <h2 class="cta-title reveal">SIAP TEMUKAN<br>POSISI <em>IDEALMU?</em></h2>
      <p class="cta-sub reveal reveal-delay-1">Bergabung dan temukan DNA sepakbola terbaikmu dengan sistem analisis berbasis data kami.</p>
      <div class="cta-form reveal reveal-delay-2">
            <a href="{{ route('login') }}" class="cta-btn cta-btn-outline"><span>Masuk</span></a>
            <a href="{{ route('register') }}" class="cta-btn"><span>Daftar Gratis</span></a>
      </div>
</section>
@endsection

@push('scripts')
<script>
      // ─── LOADER ───
      window.addEventListener('load', () => {
            setTimeout(() => {
                  const loader = document.getElementById('loader');
                  if (loader) {
                        loader.style.transition = 'opacity .6s, transform .6s';
                        loader.style.opacity = '0';
                        loader.style.transform = 'scale(1.05)';
                        setTimeout(() => loader.style.display = 'none', 650);
                  }
            }, 1200);
      });

      // ─── PITCH CANVAS HERO ───
      const pitchCanvas = document.getElementById('pitchCanvas');
      if (pitchCanvas) {
            const pctx = pitchCanvas.getContext('2d');
            let W, H;
            function resizePitch() { W = pitchCanvas.width = pitchCanvas.offsetWidth; H = pitchCanvas.height = pitchCanvas.offsetHeight; }
            resizePitch();
            window.addEventListener('resize', resizePitch);

            let pitchAnim = 0;
            function drawPitch() {
                  pctx.clearRect(0, 0, W, H);
                  pitchAnim += 0.004;
                  const grad = pctx.createLinearGradient(0, 0, W, H);
                  grad.addColorStop(0, '#100d0c');
                  grad.addColorStop(0.5, '#1a1614');
                  grad.addColorStop(1, '#100d0c');
                  pctx.fillStyle = grad;
                  pctx.fillRect(0, 0, W, H);

                  for (let i = 0; i < 8; i++) {
                        pctx.fillStyle = i % 2 === 0 ? 'rgba(44,62,40,.06)' : 'rgba(26,22,20,.04)';
                        pctx.fillRect(i * W / 8, 0, W / 8, H);
                  }

                  const pw = W * 0.58, ph = H * 0.72;
                  const px = (W - pw) / 2, py = (H - ph) / 2;

                  pctx.strokeStyle = 'rgba(245,240,232,.14)';
                  pctx.lineWidth = 1.5;
                  pctx.beginPath(); pctx.roundRect(px, py, pw, ph, 4); pctx.stroke();
                  pctx.beginPath(); pctx.moveTo(px + pw / 2, py); pctx.lineTo(px + pw / 2, py + ph); pctx.stroke();
                  pctx.beginPath(); pctx.arc(px + pw / 2, py + ph / 2, pw * 0.12, 0, Math.PI * 2); pctx.stroke();
                  pctx.beginPath(); pctx.arc(px + pw / 2, py + ph / 2, 3, 0, Math.PI * 2); pctx.fillStyle = 'rgba(74,103,65,.5)'; pctx.fill();

                  const bw = pw * 0.28, bh = ph * 0.35;
                  pctx.strokeStyle = 'rgba(245,240,232,.1)';
                  pctx.beginPath(); pctx.rect(px, py + (ph - bh) / 2, bw, bh); pctx.stroke();
                  pctx.beginPath(); pctx.rect(px + pw - bw, py + (ph - bh) / 2, bw, bh); pctx.stroke();

                  const players = [
                        { x: .5, y: .06, role:'GK' },
                        { x: .18, y: .28, role:'RB' }, { x: .38, y: .25, role:'CB' }, { x: .62, y: .25, role:'CB' }, { x: .82, y: .28, role:'LB' },
                        { x: .5,  y: .46, role:'DM' },
                        { x: .12, y: .56, role:'RM' }, { x: .36, y: .54, role:'CM' }, { x: .64, y: .54, role:'CM' }, { x: .88, y: .56, role:'LM' },
                        { x: .5,  y: .74, role:'ST' },
                  ];

                  players.forEach((p, i) => {
                        const ox = Math.sin(pitchAnim * 0.7 + i * 1.2) * 0.022;
                        const oy = Math.cos(pitchAnim * 0.5 + i * 0.9) * 0.018;
                        const dx = px + (p.x + ox) * pw, dy = py + (p.y + oy) * ph;
                        const pulse = (Math.sin(pitchAnim * 2 + i * 0.7) + 1) / 2;

                        pctx.beginPath(); pctx.arc(dx, dy, 10 + pulse * 6, 0, Math.PI * 2);
                        pctx.strokeStyle = `rgba(74,103,65,${0.2 + pulse * 0.15})`; pctx.lineWidth = 1; pctx.stroke();

                        pctx.beginPath(); pctx.arc(dx, dy, 5, 0, Math.PI * 2);
                        const g = pctx.createRadialGradient(dx, dy, 0, dx, dy, 5);
                        const isGK = p.role === 'GK';
                        g.addColorStop(0, isGK ? 'rgba(245,240,232,.95)' : 'rgba(74,103,65,.95)');
                        g.addColorStop(1, isGK ? 'rgba(180,170,160,.6)' : 'rgba(30,70,25,.8)');
                        pctx.fillStyle = g;
                        pctx.shadowBlur = 12; pctx.shadowColor = isGK ? '#F5F0E8' : '#2C3E28';
                        pctx.fill(); pctx.shadowBlur = 0;

                        pctx.fillStyle = 'rgba(245,240,232,.6)';
                        pctx.font = "bold 7px 'DM Mono',monospace";
                        pctx.textAlign = 'center';
                        pctx.fillText(p.role, dx, dy + 16);
                  });

                  const passLines = [[0,1],[0,2],[0,3],[1,4],[2,5],[3,5],[4,5],[5,6],[5,7],[5,8],[5,9],[6,10],[7,10],[8,10],[9,10]];
                  passLines.forEach(([a, b], i) => {
                        const pa = players[a], pb = players[b];
                        const ax = px + (pa.x + Math.sin(pitchAnim * 0.7 + a * 1.2) * 0.022) * pw;
                        const ay = py + (pa.y + Math.cos(pitchAnim * 0.5 + a * 0.9) * 0.018) * ph;
                        const bx = px + (pb.x + Math.sin(pitchAnim * 0.7 + b * 1.2) * 0.022) * pw;
                        const by = py + (pb.y + Math.cos(pitchAnim * 0.5 + b * 0.9) * 0.018) * ph;
                        const dashOffset = (pitchAnim * 55 + i * 18) % 28;
                        pctx.setLineDash([5, 8]); pctx.lineDashOffset = -dashOffset;
                        pctx.beginPath(); pctx.moveTo(ax, ay); pctx.lineTo(bx, by);
                        pctx.strokeStyle = 'rgba(74,103,65,.2)'; pctx.lineWidth = 1; pctx.stroke();
                        pctx.setLineDash([]); pctx.lineDashOffset = 0;
                  });

                  pctx.fillStyle = 'rgba(74,103,65,.35)';
                  pctx.font = "8px 'DM Mono',monospace"; pctx.textAlign = 'left';
                  pctx.fillText('LIVE · 4–4–2 (DM) FORMATION', px + 4, py + 14);

                  requestAnimationFrame(drawPitch);
            }
            drawPitch();
      }

      // ─── PARTICLES ───
      const particleCanvas = document.getElementById('particleCanvas');
      if (particleCanvas) {
            const actx = particleCanvas.getContext('2d');
            let PW, PH;
            const particles = [];
            function resizeParticle() { PW = particleCanvas.width = particleCanvas.offsetWidth; PH = particleCanvas.height = particleCanvas.offsetHeight; }
            resizeParticle();
            window.addEventListener('resize', resizeParticle);
            for (let i = 0; i < 40; i++) {
                  particles.push({ x: Math.random() * 1200, y: Math.random() * 800, vx: (Math.random() - 0.5) * 0.4, vy: -Math.random() * 0.6 - 0.2, r: Math.random() * 1.5 + 0.5, o: Math.random() * 0.4 + 0.1, life: Math.random() });
            }
            function drawParticles() {
                  actx.clearRect(0, 0, PW, PH);
                  particles.forEach(p => {
                        p.x += p.vx; p.y += p.vy; p.life -= 0.003;
                        if (p.life <= 0 || p.y < 0) { p.x = Math.random() * PW; p.y = PH + 10; p.life = Math.random() * 0.6 + 0.4; p.vx = (Math.random() - 0.5) * 0.4; p.vy = -Math.random() * 0.6 - 0.2; }
                        actx.beginPath(); actx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                        actx.fillStyle = `rgba(74,103,65,${p.o * p.life * 0.8})`;
                        actx.fill();
                  });
                  requestAnimationFrame(drawParticles);
            }
            drawParticles();
      }

      // ─── COUNT UP ───
      const countObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                  if (!e.isIntersecting) return;
                  const el = e.target; const target = parseInt(el.dataset.target); const duration = 1800; const start = performance.now();
                  function update(now) { const t = Math.min((now - start) / duration, 1); const ease = t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t; el.textContent = Math.round(ease * target).toLocaleString('id'); if (t < 1) requestAnimationFrame(update); else el.textContent = target.toLocaleString('id'); }
                  requestAnimationFrame(update); countObserver.unobserve(el);
            });
      }, { threshold: 0.5 });
      document.querySelectorAll('.count-num').forEach(el => countObserver.observe(el));
</script>
@endpush