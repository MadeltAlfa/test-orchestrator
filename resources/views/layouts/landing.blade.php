<!DOCTYPE html>
<html lang="id">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>@yield('title', 'GetPosition — Temukan Posisi Terbaikmu')</title>
      <meta name="description" content="@yield('description', 'Sistem analisis berbasis data untuk menentukan posisi ideal pemain sepakbola.')">
      
      <!-- Favicon -->
      <link rel="icon" type="image/png" href="{{ asset('assets/ball.png') }}">
      <link rel="shortcut icon" type="image/png" href="{{ asset('assets/ball.png') }}">
      
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,500;0,8..60,600;1,8..60,300;1,8..60,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
      
      <!-- Styles -->
      @vite(['resources/css/global.css', 'resources/css/landing.css'])
      @stack('styles')
</head>
<body class="{{ isset($darkTheme) && !$darkTheme ? 'light-theme' : '' }}">

      <!-- CURSOR -->
      <div class="cursor" id="cursor"></div>
      <div class="cursor-ring" id="cursorRing"></div>

      <!-- HEADER -->
      @include('layouts.landing-header', ['darkNav' => $darkNav ?? true])

      <!-- MAIN CONTENT -->
      @yield('content')

      <!-- FOOTER -->
      @include('layouts.landing-footer', ['darkFooter' => $darkFooter ?? true])

      <!-- GLOBAL SCRIPTS -->
      <script>
            // Cursor Follow
            const cur = document.getElementById('cursor');
            const ring = document.getElementById('cursorRing');
            let mx = 0, my = 0, rx = 0, ry = 0;
            if (cur && ring) {
                  document.addEventListener('mousemove', e => {
                        mx = e.clientX; my = e.clientY;
                        cur.style.left = mx + 'px';
                        cur.style.top = my + 'px';
                  });
                  (function animRing() {
                        rx += (mx - rx) * 0.15;
                        ry += (my - ry) * 0.15;
                        ring.style.left = rx + 'px';
                        ring.style.top = ry + 'px';
                        requestAnimationFrame(animRing);
                  })();
            }

            // Scroll Reveal Observer
            const io = new IntersectionObserver(entries => {
                  entries.forEach(e => {
                        if (e.isIntersecting) e.target.classList.add('visible');
                  });
            }, { threshold: 0.08 });
            document.querySelectorAll('.reveal, .fade-up, .step').forEach(el => io.observe(el));
      </script>

      @stack('scripts')
</body>
</html>
