@extends('layouts.landing', ['darkNav' => false, 'darkFooter' => false, 'darkTheme' => false])

@section('title', 'Panduan Posisi — GetPosition')
@section('description', 'Panduan lengkap indikator dan tes untuk setiap posisi sepakbola. Temukan parameter penilaian yang tepat untuk posisimu.')

@push('styles')
<style>
      /* ══ HERO ══ */
      .hero {
            padding-top: 66px;
            min-height: 340px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            background: linear-gradient(160deg, #1A1614 0%, #2E2926 55%, #3A2E2A 100%);
      }
      .hero-pitch { position: absolute; inset: 0; z-index: 1; pointer-events: none; }
      .hero-action-bg {
            position: absolute; inset: 0; z-index: 2; pointer-events: none;
            background-image:
                  linear-gradient(90deg, rgba(26, 22, 20, .97) 0%, rgba(26, 22, 20, .72) 44%, rgba(26, 22, 20, .28) 100%),
                  linear-gradient(0deg, rgba(26, 22, 20, .94) 0%, rgba(26, 22, 20, .18) 48%, rgba(26, 22, 20, .55) 100%),
                  url('https://cdn.pixabay.com/photo/2020/05/17/06/42/football-5180297_1280.jpg');
            background-size: cover; background-position: 72% 48%; opacity: .78; transform: scale(1.02);
            transition: opacity .55s ease, transform .8s cubic-bezier(.22, 1, .36, 1);
      }
      .hero:hover .hero-action-bg { opacity: .92; transform: scale(1.07); }
      .hero-content { position: relative; z-index: 10; padding: 60px 56px 56px; width: 100%; }

      .breadcrumb { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 3px; text-transform: uppercase; color: rgba(245, 240, 232, 0.35); margin-bottom: 22px; display: flex; align-items: center; gap: 10px; }
      .breadcrumb a { color: rgba(245, 240, 232, 0.35); text-decoration: none; transition: color .25s; }
      .breadcrumb a:hover { color: var(--coral-light); }

      .hero-category { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: var(--coral-light); margin-bottom: 14px; display: flex; align-items: center; gap: 12px; }
      .hero-category::before { content: ''; width: 24px; height: 1.5px; background: var(--coral-light); border-radius: 2px; }

      .hero-title { font-family: 'Source Serif 4', Georgia, serif; font-size: clamp(48px, 7.5vw, 108px); line-height: .88; font-weight: 300; letter-spacing: -2px; color: var(--cream); }
      .hero-title .outline { color: transparent; -webkit-text-stroke: 1px rgba(74, 103, 65, .7); }
      .hero-subtitle { font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 400; color: rgba(245, 240, 232, .4); margin-top: 18px; letter-spacing: .2px; }

      /* ══ TABS STRIP ══ */
      .pos-tabs-wrap { position: sticky; top: 70px; z-index: 400; background: rgba(26, 22, 20, 0.97); border-bottom: 1px solid rgba(245, 240, 232, .06); overflow-x: auto; scrollbar-width: none; backdrop-filter: blur(12px); }
      .pos-tabs-wrap::-webkit-scrollbar { display: none; }
      .pos-tabs { display: flex; gap: 0; padding: 0 56px; white-space: nowrap; min-width: max-content; }
      .pos-tab { font-family: 'DM Mono', monospace; font-size: 9.5px; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(245, 240, 232, .3); padding: 18px 20px; border: none; background: transparent; cursor: pointer; transition: all .3s; position: relative; white-space: nowrap; }
      .pos-tab::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: var(--coral-light); transform: scaleX(0); transition: transform .3s; border-radius: 2px 2px 0 0; }
      .pos-tab:hover { color: rgba(245, 240, 232, .65); }
      .pos-tab.active { color: var(--coral-light); }
      .pos-tab.active::after { transform: scaleX(1); }

      /* ══ POSITION PANEL ══ */
      .pos-panel { display: none; padding: 64px 56px 96px; background: var(--cream); }
      .pos-panel.active { display: block; animation: panelFadeIn .45s ease forwards; }
      @keyframes panelFadeIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

      .panel-header { display: grid; grid-template-columns: 1fr auto; gap: 40px; align-items: end; margin-bottom: 56px; padding-bottom: 40px; border-bottom: 1px solid var(--ink-hairline); }
      .panel-eyebrow { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 4px; text-transform: uppercase; color: var(--coral); margin-bottom: 14px; display: flex; align-items: center; gap: 12px; }
      .panel-eyebrow::before { content: ''; width: 24px; height: 1.5px; background: var(--coral); border-radius: 2px; }
      .panel-title { font-family: 'Source Serif 4', Georgia, serif; font-size: clamp(48px, 6.5vw, 96px); line-height: .88; font-weight: 300; letter-spacing: -2px; color: var(--ink); }
      .panel-title .outline { color: transparent; -webkit-text-stroke: 1px rgba(44, 62, 40, .55); }
      .panel-desc { font-family: 'DM Sans', sans-serif; font-size: 13.5px; line-height: 1.85; color: var(--ink-soft); max-width: 500px; margin-top: 20px; }
      .panel-badge-wrap { display: flex; flex-direction: column; align-items: flex-end; gap: 12px; }
      .pos-big-badge { font-family: 'Source Serif 4', Georgia, serif; font-size: clamp(72px, 12vw, 160px); line-height: 1; font-weight: 300; color: transparent; -webkit-text-stroke: 1px rgba(44, 62, 40, .12); letter-spacing: -6px; user-select: none; }
      .pos-code-tag { font-family: 'DM Mono', monospace; font-size: 9.5px; letter-spacing: 3px; text-transform: uppercase; color: var(--coral); padding: 6px 18px; border: 1px solid rgba(44, 62, 40, .2); border-radius: 100px; background: var(--coral-pale); }

      /* ══ INDICATOR SECTION ══ */
      .indicators-section-title { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 3.5px; text-transform: uppercase; color: var(--ink); margin-bottom: 28px; display: flex; align-items: center; gap: 14px; }
      .indicators-section-title::after { content: ''; flex: 1; height: 1px; background: var(--ink-hairline); }

      .indicator-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 20px; margin-bottom: 64px; }
      .indicator-card { background: var(--white); border: 1px solid var(--ink-hairline); border-radius: 16px; padding: 28px 24px; transition: all .3s cubic-bezier(.22, 1, .36, 1); position: relative; overflow: hidden; }
      .indicator-card:hover { border-color: rgba(44, 62, 40, .25); transform: translateY(-4px); box-shadow: 0 16px 40px rgba(26, 22, 20, .07); }

      .card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 16px; }
      .card-name { font-family: 'Source Serif 4', Georgia, serif; font-size: 20px; font-weight: 500; color: var(--ink); letter-spacing: -.3px; line-height: 1.2; }
      .weight-badge { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 1.5px; font-weight: 500; padding: 4px 12px; border-radius: 100px; white-space: nowrap; flex-shrink: 0; background: var(--coral-pale); color: var(--coral); border: 1px solid rgba(44, 62, 40, .18); }
      .card-desc { font-family: 'DM Sans', sans-serif; font-size: 12.5px; line-height: 1.7; color: var(--ink-soft); margin-bottom: 20px; }

      /* Weight bar */
      .weight-bar-wrap { margin-bottom: 20px; }
      .weight-bar-label { display: flex; justify-content: space-between; font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--ink-faint); margin-bottom: 6px; }
      .weight-bar-bg { height: 4px; background: var(--ink-hairline); border-radius: 100px; overflow: hidden; position: relative; }
      .weight-bar-fill { height: 100%; background: var(--coral); border-radius: 100px; transition: width .8s cubic-bezier(.22, 1, .36, 1); }

      /* Tests linked */
      .linked-tests-title { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-soft); margin-bottom: 10px; }
      .test-chips { display: flex; flex-wrap: wrap; gap: 6px; }
      .test-chip { font-family: 'DM Mono', monospace; font-size: 9.5px; letter-spacing: 1px; padding: 5px 12px; border-radius: 8px; background: var(--surface-low); border: 1px solid var(--ink-hairline); color: var(--ink-mid); text-decoration: none; transition: all .25s; display: inline-flex; align-items: center; gap: 6px; }
      .test-chip:hover { background: var(--coral); border-color: var(--coral); color: var(--cream); }
      .test-chip svg { transition: transform .25s; }
      .test-chip:hover svg { transform: translateX(3px); }

      /* Responsive */
      @media(max-width: 768px) {
            .hero-content { padding: 40px 24px 40px; }
            .pos-tabs { padding: 0 24px; }
            .pos-panel { padding: 40px 24px 64px; }
            .panel-header { grid-template-columns: 1fr; gap: 20px; }
            .panel-badge-wrap { align-items: flex-start; }
            .indicator-grid { grid-template-columns: 1fr; }
      }
</style>
@endpush

@section('content')
<!-- HERO -->
<div class="hero">
      <canvas id="pitchCanvas" class="hero-pitch"></canvas>
      <div class="hero-action-bg" aria-hidden="true"></div>

      <div class="hero-content">
            <div class="breadcrumb">
                  <a href="{{ url('/') }}">Beranda</a>
                  <span>/</span>
                  Panduan Posisi
            </div>
            <div class="hero-category">Indikator &amp; Protokol</div>
            <div class="hero-title">
                  PANDUAN<br><span class="outline">POSISI</span>
            </div>
            <div class="hero-subtitle">Indikator &amp; Tes untuk setiap posisi — pilih posisimu di bawah</div>
      </div>
</div>

<!-- TABS -->
<div class="pos-tabs-wrap" id="tabsWrap">
      <div class="pos-tabs" id="posTabs">
            @foreach ($positions as $index => $position)
            <button class="pos-tab {{ $index === 0 ? 'active' : '' }}" data-target="pos-{{ $position->code }}">
                  {{ $position->code }}
            </button>
            @endforeach
      </div>
</div>

<!-- MAIN CONTENT -->
<main class="main-content">
      @foreach ($positions as $index => $position)
      <div class="pos-panel {{ $index === 0 ? 'active' : '' }}" id="panel-pos-{{ $position->code }}">

            <!-- PANEL HEADER -->
            <div class="panel-header fade-up">
                  <div>
                        <div class="panel-eyebrow">{{ $position->code }}</div>
                        @php
                              $titleParts = explode(' ', strtoupper($position->name), 2);
                        @endphp
                        <div class="panel-title">
                              {{ $titleParts[0] }}<br>
                              @if (isset($titleParts[1]))
                              <span class="outline">{{ $titleParts[1] }}</span>
                              @endif
                        </div>
                        <p class="panel-desc">
                              {{ $position->description ?? 'Deskripsi posisi belum tersedia.' }}
                        </p>
                  </div>
                  <div class="panel-badge-wrap">
                        <div class="pos-big-badge">{{ $position->code }}</div>
                        <span class="pos-code-tag">{{ $position->indicators->count() }} Indikator Dinilai</span>
                  </div>
            </div>

            <!-- INDICATORS GRID -->
            <div class="indicators-section-title fade-up">
                  Indikator Penilaian &amp; Bobot Posisi {{ $position->code }}
            </div>

            <div class="indicator-grid">
                  @forelse($position->indicators as $indIndex => $indicator)
                  @php
                        $weightPct = min(100, round(($indicator->pivot->weight ?? 1) * 20));
                  @endphp
                  <div class="indicator-card fade-up">
                        <div class="card-top">
                              <div class="card-name">{{ $indicator->name }}</div>
                              <span class="weight-badge">Bobot: {{ $indicator->pivot->weight ?? '-' }}</span>
                        </div>
                        <p class="card-desc">
                              {{ $indicator->description ?? 'Indikator kemampuan penting untuk mengukur efektivitas di posisi ini.' }}
                        </p>
                        <div class="weight-bar-wrap">
                              <div class="weight-bar-label">
                                    <span>Tingkat Kepentingan</span>
                                    <span>{{ $weightPct }}%</span>
                              </div>
                              <div class="weight-bar-bg">
                                    <div class="weight-bar-fill" style="width: {{ $weightPct }}%"></div>
                              </div>
                        </div>

                        @if ($indicator->skillTests && $indicator->skillTests->count() > 0)
                        <div class="linked-tests-title">Tes Terkait:</div>
                        <div class="test-chips">
                              @foreach ($indicator->skillTests as $test)
                              <a href="{{ route('panduan-tes') }}#test-{{ $test->id }}" class="test-chip">
                                    {{ $test->name }}
                                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                              </a>
                              @endforeach
                        </div>
                        @endif
                  </div>
                  @empty
                  <div style="grid-column: 1/-1; padding: 40px; background: var(--white); border-radius: 16px; border: 1px solid var(--ink-hairline); text-align: center; color: var(--ink-soft); font-family: 'DM Mono', monospace; font-size: 12px;">
                        Belum ada indikator yang terhubung dengan posisi ini.
                  </div>
                  @endforelse
            </div>

      </div>
      @endforeach
</main>
@endsection

@push('scripts')
<script>
      // ─── PITCH CANVAS (hero background) ───
      const pc = document.getElementById('pitchCanvas');
      if (pc) {
            const ctx = pc.getContext('2d');
            let W, H;
            function resize() { W = pc.width = pc.offsetWidth; H = pc.height = pc.offsetHeight; }
            resize();
            window.addEventListener('resize', resize);

            function drawPitch() {
                  ctx.clearRect(0, 0, W, H);
                  const stripeH = 80;
                  for (let i = 0; i < Math.ceil(H / stripeH) + 1; i++) {
                        ctx.fillStyle = i % 2 === 0 ? 'rgba(255,255,255,.015)' : 'rgba(0,0,0,.0)';
                        ctx.fillRect(0, i * stripeH, W, stripeH);
                  }
                  ctx.strokeStyle = 'rgba(255,255,255,.07)';
                  ctx.lineWidth = 1;
                  const cx = W * 0.72, cy = H * 1.1, r = H * 0.85;
                  ctx.beginPath(); ctx.arc(cx, cy, r, 0, Math.PI * 2); ctx.stroke();
                  ctx.beginPath(); ctx.arc(cx, cy, r * 0.28, 0, Math.PI * 2); ctx.stroke();
                  ctx.beginPath(); ctx.arc(cx, cy, 5, 0, Math.PI * 2);
                  ctx.fillStyle = 'rgba(74,103,65,.25)'; ctx.fill();
                  ctx.beginPath(); ctx.arc(-W * 0.06, H * 0.5, H * 0.55, -Math.PI * 0.4, Math.PI * 0.4);
                  ctx.strokeStyle = 'rgba(255,255,255,.07)'; ctx.stroke();
                  const grad = ctx.createRadialGradient(cx, cy, 0, cx, cy, r * 0.4);
                  grad.addColorStop(0, 'rgba(74,103,65,.08)');
                  grad.addColorStop(1, 'rgba(74,103,65,0)');
                  ctx.fillStyle = grad;
                  ctx.beginPath(); ctx.arc(cx, cy, r * 0.4, 0, Math.PI * 2); ctx.fill();
            }
            drawPitch();
            window.addEventListener('resize', () => { resize(); drawPitch(); });
      }

      // ─── TABS ───
      const tabs = document.querySelectorAll('.pos-tab');
      const panels = document.querySelectorAll('.pos-panel');

      function activateTab(target) {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            const tab = document.querySelector(`[data-target="${target}"]`);
            const panel = document.getElementById(`panel-${target}`);
            if (tab) tab.classList.add('active');
            if (panel) panel.classList.add('active');
            if (tab) tab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });

            if (panel) {
                  panel.querySelectorAll('.fade-up').forEach(el => el.classList.remove('visible'));
                  panel.querySelectorAll('.fade-up').forEach((el, index) => {
                        setTimeout(() => el.classList.add('visible'), index * 80);
                  });
            }
      }

      tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                  const target = tab.dataset.target;
                  activateTab(target);
                  const url = new URL(window.location);
                  url.searchParams.set('pos', target.replace('pos-', ''));
                  history.replaceState(null, '', url);
            });
      });

      window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            let pos = params.get('pos');
            if (pos) {
                  if (!pos.startsWith('pos-')) pos = 'pos-' + pos;
                  activateTab(pos);
            }
      });
</script>
@endpush
