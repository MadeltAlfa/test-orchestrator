@extends('layouts.landing', ['darkNav' => false, 'darkFooter' => false, 'darkTheme' => false])

@section('title', $guide->title . ' — GetPosition')
@section('description', Str::limit($guide->description, 155))

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
            background-size: cover; background-position: 72% 48%;
            opacity: .78; transform: scale(1.02);
            transition: opacity .55s, transform .8s cubic-bezier(.22,1,.36,1);
      }
      .hero:hover .hero-action-bg { opacity: .92; transform: scale(1.06); }
      .hero-action-bg::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 72% 42%, rgba(44,62,40,.14), transparent 24%),
                        radial-gradient(circle at 88% 35%, rgba(0,0,0,.46), transparent 36%);
            mix-blend-mode: soft-light;
      }
      .hero-content {
            position: relative; z-index: 10;
            padding: 60px 56px 56px; width: 100%;
            display: flex; align-items: flex-end;
            justify-content: space-between; gap: 24px; flex-wrap: wrap;
      }
      .breadcrumb { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 3px; text-transform: uppercase; color: rgba(245,240,232,.35); margin-bottom: 22px; display: flex; align-items: center; gap: 10px; }
      .breadcrumb a { color: rgba(245,240,232,.35); text-decoration: none; transition: color .25s; }
      .breadcrumb a:hover { color: var(--coral-light); }
      .breadcrumb span { opacity: .3; }

      .hero-category { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: var(--coral-light); margin-bottom: 14px; display: flex; align-items: center; gap: 12px; }
      .hero-category::before { content: ''; width: 24px; height: 1.5px; background: var(--coral-light); border-radius: 2px; }

      .hero-title { font-family: 'Source Serif 4', Georgia, serif; font-size: clamp(38px, 5.5vw, 80px); line-height: .92; font-weight: 300; letter-spacing: -2px; color: var(--cream); }
      .hero-title .outline { color: transparent; -webkit-text-stroke: 1px rgba(74,103,65,.7); }

      .hero-tags { display: flex; gap: 8px; margin-top: 20px; flex-wrap: wrap; }
      .pill { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; padding: 5px 14px; border-radius: 100px; border: 1px solid rgba(74,103,65,.22); color: var(--coral-light); background: rgba(74,103,65,.07); }

      .hero-jersey { font-family: 'Source Serif 4', Georgia, serif; font-size: clamp(64px, 11vw, 140px); line-height: 1; font-weight: 300; color: transparent; -webkit-text-stroke: 1px rgba(74,103,65,.12); letter-spacing: -6px; user-select: none; flex-shrink: 0; align-self: flex-end; margin-bottom: -8px; }

      /* ── PAGE WRAP ── */
      .page-wrap { position: relative; z-index: 2; max-width: 100%; padding: 60px 56px 110px; display: flex; flex-direction: column; gap: 20px; }
      .sec-label { display: flex; align-items: center; gap: 14px; font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 3.5px; text-transform: uppercase; color: rgba(26,22,20,.28); }
      .sec-label::after { content: ''; flex: 1; height: 1px; background: var(--ink-hairline); }

      /* ── CARD ── */
      .card { background: #fff; border: 1px solid var(--ink-hairline); border-radius: 16px; position: relative; overflow: hidden; transition: border-color .25s, box-shadow .25s, transform .2s; box-shadow: 0 1px 3px rgba(26,22,20,.04), 0 4px 16px rgba(26,22,20,.03); }
      .card:hover { border-color: rgba(44,62,40,.15); transform: translateY(-1px); box-shadow: 0 4px 20px rgba(26,22,20,.07); }
      .card::before { content: ''; position: absolute; top: 0; left: 10%; right: 10%; height: 1px; background: linear-gradient(90deg, transparent, rgba(44,62,40,.15), transparent); }

      .card-head { padding: 22px 28px 0; }
      .card-label { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 3px; text-transform: uppercase; color: rgba(26,22,20,.3); display: flex; align-items: center; gap: 8px; }
      .card-label svg { opacity: .5; }
      .card-body { padding: 18px 28px 28px; }

      /* SUMMARY */
      .summary-text { font-family: 'Source Serif 4', Georgia, serif; font-size: 15.5px; font-weight: 400; line-height: 1.85; color: rgba(26,22,20,.7); white-space: pre-line; }

      /* VIDEO */
      .video-wrapper { border-radius: 12px; overflow: hidden; position: relative; aspect-ratio: 16/9; background: var(--ink); border: 1px solid var(--ink-faint); box-shadow: 0 8px 32px rgba(26,22,20,.1); }
      .video-wrapper iframe { width: 100%; height: 100%; border: none; display: block; }
      .video-controls { display: flex; gap: 8px; justify-content: flex-end; margin-top: 10px; }
      .ctrl-btn { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-soft); background: rgba(26,22,20,.04); border: 1px solid var(--ink-hairline); padding: 7px 16px; border-radius: 8px; cursor: pointer; transition: all .25s; }
      .ctrl-btn:hover { color: var(--coral); border-color: rgba(44,62,40,.25); }

      .no-video-placeholder { background: linear-gradient(135deg, var(--cream-deeper), var(--cream-dark)); border: 1px solid var(--ink-hairline); border-radius: 12px; aspect-ratio: 16/9; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; }
      .no-video-placeholder p { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-soft); }

      /* SECTION CARDS */
      .section-card { margin-bottom: 0; }
      .section-card-head { padding: 22px 28px 18px; border-bottom: 1px solid var(--ink-hairline); display: flex; align-items: center; gap: 14px; }
      .sec-badge { font-family: 'DM Mono', monospace; font-size: 10px; letter-spacing: 1px; width: 28px; height: 28px; border-radius: 8px; background: rgba(44,62,40,.08); color: var(--coral); display: flex; align-items: center; justify-content: center; font-weight: 500; flex-shrink: 0; }
      .sec-title { font-family: 'Source Serif 4', Georgia, serif; font-size: 19px; font-weight: 500; color: var(--ink); letter-spacing: -.3px; margin: 0; }

      .body-prose { font-size: 14px; line-height: 1.85; color: rgba(26,22,20,.75); }
      .body-prose p { margin-bottom: 12px; }
      .body-prose ul, .body-prose ol { margin-left: 20px; margin-bottom: 12px; }
      .body-prose li { margin-bottom: 4px; }

      /* SCORE NORMS TABLE */
      .norms-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
      .norms-table th, .norms-table td { padding: 12px 18px; text-align: left; font-size: 13px; border-bottom: 1px solid var(--ink-hairline); }
      .norms-table th { font-family: 'DM Mono', monospace; font-size: 9.5px; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-soft); background: var(--surface-low); }

      /* NORMS CARD */
      .norm-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-top: 12px; }
      .norm-item { padding: 16px; border-radius: 12px; background: var(--surface-low); border: 1px solid var(--ink-hairline); }
      .norm-item-label { font-family: 'DM Mono', monospace; font-size: 9.5px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--ink-soft); margin-bottom: 4px; }
      .norm-item-val { font-family: 'Source Serif 4', Georgia, serif; font-size: 22px; font-weight: 500; color: var(--coral); }

      /* CTA Card */
      .cta-card { background: var(--ink); border-radius: 24px; padding: 48px 56px; display: flex; align-items: center; justify-content: space-between; gap: 32px; color: var(--cream); position: relative; overflow: hidden; margin-top: 20px; }
      .cta-text h3 { font-family: 'Source Serif 4', Georgia, serif; font-size: 28px; font-weight: 300; margin-bottom: 8px; letter-spacing: -.5px; }
      .cta-text p { font-family: 'DM Mono', monospace; font-size: 11.5px; color: rgba(245,240,232,.5); line-height: 1.7; }
      .cta-btn { font-family: 'DM Sans', sans-serif; font-weight: 600; font-size: 13.5px; letter-spacing: .5px; color: var(--cream); background: var(--coral); padding: 14px 32px; border-radius: 100px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; white-space: nowrap; transition: all .3s cubic-bezier(.22,1,.36,1); }
      .cta-btn:hover { background: var(--coral-light); box-shadow: 0 8px 24px rgba(44,62,40,.35); transform: translateY(-2px); }

      @media (max-width: 768px) {
            .hero-content { padding: 40px 24px 40px; }
            .hero-jersey { display: none; }
            .page-wrap { padding: 40px 24px 80px; }
            .cta-card { flex-direction: column; text-align: center; padding: 36px 24px; }
            .cta-btn { width: 100%; justify-content: center; }
      }
</style>
@endpush

@section('content')
<!-- HERO -->
<div class="hero">
      <canvas id="pitchCanvas"></canvas>
      <div class="hero-action-bg" style="background-image: 
            linear-gradient(90deg, rgba(26,22,20,.97) 0%, rgba(26,22,20,.72) 44%, rgba(26,22,20,.28) 100%),
            linear-gradient(0deg, rgba(26,22,20,.94) 0%, rgba(26,22,20,.18) 48%, rgba(26,22,20,.55) 100%),
            url('{{ $guide->image ? asset('storage/' . $guide->image) : 'https://cdn.pixabay.com/photo/2020/05/17/06/42/football-5180297_1280.jpg' }}');" aria-hidden="true"></div>
      <div class="hero-content">
            <div class="hero-left">
                  <div class="breadcrumb">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span>/</span>
                        <a href="{{ route('panduan-tes') }}">Panduan Tes</a>
                        <span>/</span>
                        {{ Str::limit($guide->title, 30) }}
                  </div>
                  <div class="hero-category">Protokol Penilaian</div>
                  <h1 class="hero-title">{{ strtoupper($guide->title) }}</h1>
                  <div class="hero-tags">
                        @if($guide->test)
                        <span class="pill">Tes: {{ $guide->test->name }}</span>
                        @if($guide->test->unit)
                        <span class="pill">Satuan: {{ $guide->test->unit }}</span>
                        @endif
                        @endif
                        <span class="pill">{{ $guide->sections->count() }} Modul Panduan</span>
                  </div>
            </div>
            <div class="hero-jersey">{{ sprintf('%02d', $guide->id) }}</div>
      </div>
</div>

<!-- MAIN PAGE WRAP -->
<div class="page-wrap">

      <!-- DESKRIPSI UTAMA -->
      @if ($guide->description)
      <div class="sec-label fade-up">Ringkasan Panduan</div>
      <div class="card fade-up">
            <div class="card-head">
                  <div class="card-label">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Tinjauan Umum
                  </div>
            </div>
            <div class="card-body">
                  <div class="summary-text">{{ $guide->description }}</div>
            </div>
      </div>
      @endif

      <!-- VIDEO TUTORIAL -->
      @php
            $embedUrl = null;
            if ($guide->video_url && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $guide->video_url, $m)) {
                  $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1';
            }
      @endphp

      @if ($embedUrl || $guide->video_url)
      <div class="sec-label fade-up" style="margin-top: 10px;">Video Tutorial</div>
      <div class="card fade-up">
            <div class="card-head">
                  <div class="card-label">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        Peragaan Visual
                  </div>
            </div>
            <div class="card-body">
                  @if ($embedUrl)
                  <div class="video-wrapper">
                        <iframe src="{{ $embedUrl }}" id="guideVideo" title="{{ $guide->title }}"
                              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                              allowfullscreen loading="lazy"></iframe>
                  </div>
                  @else
                  <div class="no-video-placeholder">
                        <svg width="40" height="40" fill="none" stroke="var(--ink-soft)" stroke-width="1.5" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                        <p>Tautan Video: <a href="{{ $guide->video_url }}" target="_blank" style="color:var(--coral);">{{ $guide->video_url }}</a></p>
                  </div>
                  @endif
            </div>
      </div>
      @endif

      <!-- MODUL / SECTION PANDUAN -->
      @if ($guide->sections && $guide->sections->count() > 0)
      <div class="sec-label fade-up" style="margin-top: 10px;">Langkah &amp; Prosedur Pelaksanaan</div>

      @foreach ($guide->sections as $sIdx => $sec)
      <div class="card section-card fade-up">
            <div class="section-card-head">
                  <div class="sec-badge">{{ sprintf('%02d', $sIdx + 1) }}</div>
                  <h3 class="sec-title">{{ $sec->title }}</h3>
            </div>
            <div class="card-body">
                  <div class="body-prose">
                        {!! $sec->content !!}
                  </div>
            </div>
      </div>
      @endforeach
      @endif

      <!-- NORMA PENILAIAN / SCORE NORMS -->
      @if ($guide->test?->norms?->count() > 0)
      <div class="sec-label fade-up" style="margin-top: 10px;">Norma Penilaian Terstandar</div>
      <div class="card fade-up">
            <div class="card-head">
                  <div class="card-label">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                        Acuan Skor Tes: {{ $guide->test->name }}
                  </div>
            </div>
            <div class="card-body" style="padding-top: 10px;">
                  <table class="norms-table">
                        <thead>
                              <tr>
                                    <th>Kategori</th>
                                    <th>Rentang Nilai</th>
                                    <th style="text-align: center;">Skor Konversi</th>
                              </tr>
                        </thead>
                        <tbody>
                              @foreach ($guide->test->norms as $norm)
                              <tr>
                                    <td>
                                          <span class="pill" style="font-size:9.5px; padding: 4px 12px; background: var(--coral-pale); color: var(--coral); border-color: rgba(44,62,40,.2);">{{ $norm->category }}</span>
                                    </td>
                                    <td style="font-family: 'DM Mono', monospace; font-size:12.5px; color: var(--ink-mid);">
                                          @switch($norm->operator)
                                                @case('between')      {{ $norm->min_value }} – {{ $norm->max_value }} {{ $guide->test->unit }} @break
                                                @case('less_than')    < {{ $norm->max_value }} {{ $guide->test->unit }} @break
                                                @case('greater_than') > {{ $norm->min_value }} {{ $guide->test->unit }} @break
                                                @case('less_equal')   ≤ {{ $norm->max_value }} {{ $guide->test->unit }} @break
                                                @case('greater_equal')≥ {{ $norm->min_value }} {{ $guide->test->unit }} @break
                                                @default {{ $norm->min_value }} – {{ $norm->max_value }} {{ $guide->test->unit }}
                                          @endswitch
                                    </td>
                                    <td style="text-align: center; font-family: 'DM Mono', monospace; font-weight: 600; font-size: 14px; color: var(--coral);">{{ $norm->score }}</td>
                              </tr>
                              @endforeach
                        </tbody>
                  </table>
            </div>
      </div>
      @endif

      <!-- CTA -->
      <div class="cta-card fade-up">
            <div class="cta-text">
                  <h3>Siap Untuk Mengikuti Tes Ini?</h3>
                  <p>Mulai sesi assessment dan masukkan hasil pengukuranmu untuk dianalisis oleh sistem.</p>
            </div>
            <a href="{{ route('register') }}" class="cta-btn">
                  Mulai Tes
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
