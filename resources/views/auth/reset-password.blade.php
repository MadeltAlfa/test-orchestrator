@extends('layouts.guest')

@section('title', 'Setel Ulang Password — GetPosition')

@section('content')
<div class="auth-header">
      <div class="auth-eyebrow">Pembaruan Sandi</div>
      <h1 class="auth-title">RESET<br><span class="outline">PASSWORD</span></h1>
      <p class="auth-subtitle">Masukkan email Anda dan buat password baru yang aman untuk akun Anda.</p>
</div>

<div class="auth-card">
      <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                  <label for="email" class="form-label">Alamat Email</label>
                  <input type="email" id="email" class="form-input" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="contoh@domain.com">
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
                  <label for="password" class="form-label">Password Baru</label>
                  <input type="password" id="password" class="form-input" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                  @error('password')
                        <p class="error-text">
                              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                              </svg>
                              {{ $message }}
                        </p>
                  @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                  <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" id="password_confirmation" class="form-input" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru">
                  @error('password_confirmation')
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
                  Reset Password
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
            </button>
      </form>
</div>
@endsection
