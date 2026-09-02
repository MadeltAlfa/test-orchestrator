@extends('layouts.landing', ['darkNav' => false, 'darkFooter' => false, 'darkTheme' => false])

@section('title', 'Panduan Tes — GetPosition')
@section('description', 'Panduan lengkap pelaksanaan setiap tes keahlian sepakbola. Pelajari protokol, langkah-langkah, dan norma penilaian sebelum melakukan assessment.')

@push('styles')
<style>
      /* ── HERO ── */
      .hero {
            padding-top: 66px; min-height: 340px;
            position: relative; overflow: hidden;
            display: flex; align-items: flex-end;
            background: linear-gradient(160deg, #1A1614 0%, #2E2926 55%, #3A2E2A 100%);
      }
      #pitchCanvas { position: absolute; inset: 0; z-index: 1; pointer-events: none; }
      .hero-action-bg {
            position: absolute; inset: 0; z-index: 2; pointer-events: none;
            background-image:
                  linear-gradient(90deg, rgba(26,22,20,.97) 0%, rgba(26,22,20,.72) 44%, rgba(26,22,20,.28) 100%),
                  linear-gradient(0deg, rgba(26,22,20,.94) 0%, rgba(26,22,20,.18) 48%, rgba(26,22,20,.55) 100%),
                  url('https://cdn.pixabay.com/photo/2020/05/17/06/42/football-5180297_1280.jpg');
            background-size: cover; background-position: 72% 48%; opacity: .78; transform: scale(1.02);
            transition: opacity .55s ease, transform .8s cubic-bezier(.22,1,.36,1);
      }
      .hero:hover .hero-action-bg { opacity: .92; transform: scale(1.07); }
      .hero-content { position: relative; z-index: 10; padding: 60px 56px 56px; width: 100%; }

      .breadcrumb { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 3px; text-transform: uppercase; color: rgba(245,240,232,0.35); margin-bottom: 22px; display: flex; align-items: center; gap: 10px; }
      .breadcrumb a { color: rgba(245,240,232,0.35); text-decoration: none; transition: color .25s; }
      .breadcrumb a:hover { color: var(--coral-light); }

      .hero-category { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: var(--coral-light); margin-bottom: 14px; display: flex; align-items: center; gap: 12px; }
      .hero-category::before { content: ''; width: 24px; height: 1.5px; background: var(--coral-light); border-radius: 2px; }

      .hero-title { font-family: 'Source Serif 4', Georgia, serif; font-size: clamp(48px, 7.5vw, 108px); line-height: .88; font-weight: 300; letter-spacing: -2px; color: var(--cream); }
      .hero-title .outline { color: transparent; -webkit-text-stroke: 1px rgba(74, 103, 65, .7); }
      .hero-subtitle { font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 400; color: rgba(245,240,232,.4); margin-top: 18px; letter-spacing: .2px; }

      /* ── CONTENT WRAP ── */
      .page-wrap { max-width: 1280px; margin: 0 auto; padding: 64px 56px 96px; position: relative; z-index: 2; }

      .sec-label { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: var(--ink-soft); margin-bottom: 28px; display: flex; align-items: center; gap: 12px; }
      .sec-label::after { content: ''; flex: 1; height: 1px; background: var(--ink-hairline); }

      /* Grid */
      .guides-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 24px; margin-bottom: 64px; }

      /* Guide Card */
      .guide-card { background: var(--white); border: 1px solid var(--ink-hairline); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; text-decoration: none; color: inherit; transition: all .35s cubic-bezier(.22,1,.36,1); box-shadow: 0 2px 12px rgba(26,22,20,.03); position: relative; }
      .guide-card:hover { border-color: rgba(44,62,40,.28); transform: translateY(-5px); box-shadow: 0 20px 48px rgba(26,22,20,.09); }

      .guide-card-thumb { position: relative; aspect-ratio: 16/9; background: var(--ink-mid); overflow: hidden; }
      .guide-card-thumb iframe { width: 100%; height: 100%; border: 0; pointer-events: none; }
      .guide-card-thumb-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1A1614 0%, #2E2926 100%); }

      .guide-card-play { position: absolute; inset: 0; background: rgba(26,22,20,.35); backdrop-filter: blur(2px); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .3s; }
      .guide-card:hover .guide-card-play { opacity: 1; }

      .play-badge { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--cream); background: var(--coral); padding: 8px 18px; border-radius: 100px; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(44,62,40,.4); }

      .guide-card-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
      .guide-card-meta { font-family: 'DM Mono', monospace; font-size: 9.5px; letter-spacing: 2px; text-transform: uppercase; color: var(--coral-light); margin-bottom: 8px; }
      .guide-card-title { font-family: 'Source Serif 4', Georgia, serif; font-size: 20px; font-weight: 500; color: var(--ink); line-height: 1.25; margin-bottom: 8px; letter-spacing: -.3px; }
      .guide-card-desc { font-size: 13px; color: var(--ink-soft); line-height: 1.6; margin-bottom: 20px; flex: 1; }

      .guide-card-footer { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--ink-hairline); padding-top: 16px; margin-top: auto; }
      .guide-card-stats { display: flex; align-items: center; gap: 12px; font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--ink-soft); }
      .stat-item { display: flex; align-items: center; gap: 5px; }
      .stat-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--coral); }
      .guide-card-arrow { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--coral); display: flex; align-items: center; gap: 4px; font-weight: 500; }
      .guide-card-arrow svg { transition: transform .25s; }
      .guide-card:hover .guide-card-arrow svg { transform: translateX(4px); }

      /* CTA Card */
      .cta-card { background: var(--ink); border-radius: 24px; padding: 48px 56px; display: flex; align-items: center; justify-content: space-between; gap: 32px; color: var(--cream); position: relative; overflow: hidden; }
      .cta-text h3 { font-family: 'Source Serif 4', Georgia, serif; font-size: 28px; font-weight: 300; margin-bottom: 8px; letter-spacing: -.5px; }
      .cta-text p { font-family: 'DM Mono', monospace; font-size: 11.5px; color: rgba(245,240,232,.5); line-height: 1.7; }
      .cta-btn { font-family: 'DM Sans', sans-serif; font-weight: 600; font-size: 13.5px; letter-spacing: .5px; color: var(--cream); background: var(--coral); padding: 14px 32px; border-radius: 100px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; white-space: nowrap; transition: all .3s cubic-bezier(.22,1,.36,1); }
      .cta-btn:hover { background: var(--coral-light); box-shadow: 0 8px 24px rgba(44,62,40,.35); transform: translateY(-2px); }

      .empty-state { grid-column: 1/-1; padding: 64px; text-align: center; background: var(--white); border-radius: 20px; border: 1px solid var(--ink-hairline); }
      .empty-state-icon { width: 48px; height: 48px; border-radius: 50%; background: var(--surface-low); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-family: 'DM Mono', monospace; color: var(--ink-soft); }

      @media (max-width: 768px) {
            .hero-content { padding: 40px 24px 40px; }
            .page-wrap { padding: 40px 24px 64px; }
            .guides-grid { grid-template-columns: 1fr; }
            .cta-card { flex-direction: column; text-align: center; padding: 36px 24px; }
            .cta-btn { width: 100%; justify-content: center; }
      }
</style>
@endpush

@section('content')
<!-- HERO -->
<div class="hero">
      <canvas id="pitchCanvas"></canvas>
      <div class="hero-action-bg" aria-hidden="true"></div>
      <div class="hero-content">
            <div class="breadcrumb">
                  <a href="{{ url('/') }}">Beranda</a>
                  <span>/</span>
                  Panduan Tes
            </div>
            <div class="hero-category">Protokol &amp; Norma</div>
            <div class="hero-title">
                  PANDUAN<br><span class="outline">TES</span>
            </div>
            <div class="hero-subtitle">Pelajari cara pelaksanaan setiap tes sebelum melakukan assessment</div>
      </div>
</div>

<!-- CONTENT -->
<div class="page-wrap">

      <div class="sec-label fade-up">Semua Panduan Tes — {{ $guides->count() }} Panduan</div>

      <div class="guides-grid">
            @forelse ($guides as $guide)
            @php
                  $embedUrl = null;
                  if ($guide->video_url && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $guide->video_url, $m)) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1&autoplay=0';
                  }
            @endphp
            <a href="{{ route('panduan-tes.show', $guide->id) }}" class="guide-card fade-up">
                  <div class="guide-card-thumb">
                        @if ($guide->image)
                        <img src="{{ asset('storage/' . $guide->image) }}" class="w-full h-full object-cover" style="display: block; width: 100%; height: 100%; object-fit: cover;" alt="{{ $guide->title }}">
                        @elseif ($embedUrl)
                        <iframe src="{{ $embedUrl }}" title="{{ $guide->title }}"
                              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                              allowfullscreen loading="lazy"></iframe>
                        @else
                        <div class="guide-card-thumb-placeholder">
                              <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#F5F0E8" stroke-width="1">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polygon points="10,8 16,12 10,16"/>
                              </svg>
                        </div>
                        @endif
                        <div class="guide-card-play">
                              <div class="play-badge">
                                    <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24">
                                          <path d="M8 5v14l11-7z"/>
                                    </svg>
                                    Lihat Panduan
                              </div>
                        </div>
                  </div>

                  <div class="guide-card-body">
                        <div class="guide-card-meta">{{ $guide->test?->name ?? 'Tes Keahlian' }}</div>
                        <div class="guide-card-title">{{ $guide->title }}</div>
                        @if ($guide->description)
                        <div class="guide-card-desc">{{ Str::limit($guide->description, 90) }}</div>
                        @endif
                        <div class="guide-card-footer">
                              <div class="guide-card-stats">
                                    <div class="stat-item">
                                          <div class="stat-dot"></div>
                                          {{ $guide->sections->count() }} Bagian
                                    </div>
                                    @if ($guide->video_url)
                                    <div class="stat-item">
                                          <div class="stat-dot"></div>
                                          Video Tutorial
                                    </div>
                                    @endif
                              </div>
                              <div class="guide-card-arrow">
                                    Baca
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                          <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                              </div>
                        </div>
                  </div>
            </a>
            @empty
            <div class="empty-state fade-up">
                  <div class="empty-state-icon">?</div>
                  <p>Belum ada panduan tes tersedia</p>
            </div>
            @endforelse
      </div>

      <!-- CTA -->
      <div class="cta-card fade-up">
            <div class="cta-text">
                  <h3>Siap Lakukan Tes?</h3>
                  <p>Daftar sekarang dan mulai assessment untuk mengetahui<br>posisi terbaik sesuai kemampuanmu.</p>
            </div>
            <a href="{{ route('register') }}" class="cta-btn">
                  Mulai Sekarang
                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                  </svg>
            </a>
      </div>

</div>
@endsection

@push('scripts')
<script>
      // ── PITCH CANVAS ──
      const pc = document.getElementById('pitchCanvas');
      if (pc) {
            const ctx = pc.getContext('2d');
            let W, H;
            function resize() { W = pc.width = pc.offsetWidth; H = pc.height = pc.offsetHeight; }
            resize(); window.addEventListener('resize', resize);
            function drawPitch() {
                  ctx.clearRect(0, 0, W, H);
                  for (let i = 0; i < Math.ceil(H/80)+1; i++) {
                        ctx.fillStyle = i%2===0 ? 'rgba(255,255,255,.015)' : 'rgba(0,0,0,0)';
                        ctx.fillRect(0, i*80, W, 80);
                  }
                  ctx.strokeStyle = 'rgba(255,255,255,.07)'; ctx.lineWidth = 1;
                  const cx = W*.72, cy = H*1.1, r = H*.85;
                  ctx.beginPath(); ctx.arc(cx, cy, r, 0, Math.PI*2); ctx.stroke();
                  ctx.beginPath(); ctx.arc(cx, cy, r*.28, 0, Math.PI*2); ctx.stroke();
                  ctx.beginPath(); ctx.arc(cx, cy, 5, 0, Math.PI*2);
                  ctx.fillStyle = 'rgba(74,103,65,.25)'; ctx.fill();
                  const grad = ctx.createRadialGradient(cx, cy, 0, cx, cy, r*.4);
                  grad.addColorStop(0, 'rgba(74,103,65,.08)'); grad.addColorStop(1, 'rgba(74,103,65,0)');
                  ctx.fillStyle = grad; ctx.beginPath(); ctx.arc(cx, cy, r*.4, 0, Math.PI*2); ctx.fill();
            }
            drawPitch(); window.addEventListener('resize', () => { resize(); drawPitch(); });
      }
</script>
@endpush
