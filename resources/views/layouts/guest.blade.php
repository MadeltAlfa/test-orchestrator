<!DOCTYPE html>
<html lang="id">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>@yield('title', 'GetPosition')</title>
      <meta name="description" content="@yield('description', 'Sistem analisis untuk menentukan posisi ideal pemain sepakbola.')">
      
      <!-- Favicon -->
      <link rel="icon" type="image/png" href="{{ asset('assets/ball.png') }}">
      <link rel="shortcut icon" type="image/png" href="{{ asset('assets/ball.png') }}">
      
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,500;0,8..60,600;1,8..60,300;1,8..60,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
      
      <!-- Styles -->
      @vite(['resources/css/global.css', 'resources/css/auth.css'])
      @stack('styles')
</head>
<body>
      <!-- CURSOR -->
      <div class="cursor" id="cursor"></div>
      <div class="cursor-ring" id="cursorRing"></div>

      <!-- NAV -->
      @include('layouts.landing-header', ['darkNav' => false])

      <!-- MAIN CONTENT -->
      <main class="auth-main">
            <canvas id="pitchCanvas"></canvas>
            <div class="auth-container">
                  @yield('content')
            </div>
      </main>

      <!-- FOOTER -->
      @include('layouts.landing-footer', ['darkFooter' => false])

      <!-- SCRIPTS -->
      <script>
            // Cursor Follow
            const cur = document.getElementById('cursor');
            const ring = document.getElementById('cursorRing');
            let mx = 0, my = 0, rx = 0, ry = 0;
            if (cur && ring) {
                  document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; cur.style.left = mx+'px'; cur.style.top = my+'px'; });
                  (function animRing() { rx += (mx-rx)*.15; ry += (my-ry)*.15; ring.style.left=rx+'px'; ring.style.top=ry+'px'; requestAnimationFrame(animRing); })();
            }

            // Pitch Canvas animation
            const pc = document.getElementById('pitchCanvas');
            if (pc) {
                  const ctx = pc.getContext('2d');
                  let W, H;
                  function resize() { W = pc.width = pc.offsetWidth; H = pc.height = pc.offsetHeight; }
                  resize(); window.addEventListener('resize', resize);
                  function drawPitch() {
                        ctx.clearRect(0, 0, W, H);
                        ctx.strokeStyle = 'rgba(26,22,20,.035)'; ctx.lineWidth = 1;
                        const cx = W / 2, cy = H * 1.1, r = H * 0.8;
                        ctx.beginPath(); ctx.arc(cx, cy, r, 0, Math.PI*2); ctx.stroke();
                        ctx.beginPath(); ctx.arc(cx, cy, r*0.3, 0, Math.PI*2); ctx.stroke();
                        ctx.beginPath(); ctx.arc(cx, cy, 5, 0, Math.PI*2);
                        ctx.fillStyle = 'rgba(44,62,40,.08)'; ctx.fill();
                  }
                  drawPitch(); window.addEventListener('resize', () => { resize(); drawPitch(); });
            }
      </script>

      @stack('scripts')
</body>
</html>
