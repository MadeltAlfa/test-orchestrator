@extends('layouts.guest')

@section('title', 'Masuk — GetPosition')

@section('content')
<div class="auth-header">
      <div class="auth-eyebrow">Akses Akun</div>
      <h1 class="auth-title">MASUK<br><span class="outline">SISTEM</span></h1>
      <p class="auth-subtitle">Masukkan email dan password untuk melanjutkan ke akun Anda</p>
</div>

<div class="auth-card">
      <!-- Session Status -->
      @if (session('status'))
            <div class="status-alert">
                  {{ session('status') }}
            </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                  <label for="email" class="form-label">Alamat Email</label>
                  <input type="email" id="email" class="form-input" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="contoh@domain.com">
                  @error('email')
                        <p class="error-text">
                              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                              </svg>
                              {{ $message }}
                        </p>
                  @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" id="password" class="form-input" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                  @error('password')
                        <p class="error-text">
                              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                              </svg>
                              {{ $message }}
                        </p>
                  @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex-row">
                  <div class="checkbox-group">
                        <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
                        <label for="remember_me" class="checkbox-label">Ingat Saya</label>
                  </div>

                  @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                              Lupa Password?
                        </a>
                  @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                  Masuk ke Sistem
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
            </button>
      </form>
</div>

<div class="auth-footer">
      Belum memiliki akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
</div>
@endsection
