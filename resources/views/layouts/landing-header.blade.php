<!-- LANDING HEADER -->
<nav class="{{ isset($darkNav) && $darkNav ? 'nav-dark' : 'nav-light' }}">
      <a href="{{ url('/') }}" class="nav-logo">
            <img class="logo-ball" src="{{ asset('assets/ball.png') }}" alt="GetPosition">
            GetPosition
      </a>
      <div class="nav-links">
            <a href="{{ url('/panduan-posisi') }}">Panduan Posisi</a>
            <a href="{{ url('/') }}#how">Cara Kerja</a>
            <a href="{{ route('panduan-tes') }}">Panduan Tes</a>
      </div>
      @auth
            <a href="{{ auth()->user()->role === 'superadmin' ? route('superadmin.dashboard') : route('user.dashboard') }}" class="nav-cta">Dashboard</a>
      @else
            @if (Route::currentRouteName() === 'login')
                  <a href="{{ route('register') }}" class="nav-cta">Daftar</a>
            @elseif (Route::currentRouteName() === 'register')
                  <a href="{{ route('login') }}" class="nav-cta">Masuk</a>
            @else
                  <a href="{{ route('register') }}" class="nav-cta">Mulai Tes</a>
            @endif
      @endauth
</nav>
