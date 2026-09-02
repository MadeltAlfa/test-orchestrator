@extends('layouts.guest')

@section('title', 'Konfirmasi Password — GetPosition')

@section('content')
<div class="auth-header">
      <div class="auth-eyebrow">Area Aman</div>
      <h1 class="auth-title">KONFIRMASI<br><span class="outline">PASSWORD</span></h1>
      <p class="auth-subtitle">Ini adalah area aman aplikasi. Harap masukkan password Anda sebelum melanjutkan.</p>
</div>

<div class="auth-card">
      <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="form-group">
                  <label for="password" class="form-label">Password Anda</label>
                  <input type="password" id="password" class="form-input" name="password" required autocomplete="current-password" autofocus placeholder="Masukkan password Anda">
                  @error('password')
                        <p class="error-text">
                              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                              </svg>
                              {{ $message }}
                        </p>
                  @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                  Konfirmasi Password
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
            </button>
      </form>
</div>
@endsection
