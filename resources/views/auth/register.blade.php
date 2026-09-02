@extends('layouts.guest')

@section('title', 'Daftar — GetPosition')

@section('content')
<div class="auth-header">
      <div class="auth-eyebrow">Pendaftaran Akun</div>
      <h1 class="auth-title">DAFTAR<br><span class="outline">BARU</span></h1>
      <p class="auth-subtitle">Buat akun untuk memulai analisis dan menentukan posisi sepakbola terbaikmu</p>
</div>

<div class="auth-card">
      <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input type="text" id="name" class="form-input" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus autocomplete="name">
                  @error('name')
                        <p class="error-text">
                              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                              </svg>
                              {{ $message }}
                        </p>
                  @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                  <label for="email" class="form-label">Alamat Email</label>
                  <input type="email" id="email" class="form-input" name="email" value="{{ old('email') }}" placeholder="contoh@domain.com" required autocomplete="username">
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
                  <input type="password" id="password" class="form-input" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password">
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
                  <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                  <input type="password" id="password_confirmation" class="form-input" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
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
                  Daftar Akun Baru
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
            </button>
      </form>
</div>

<div class="auth-footer">
      Sudah terdaftar? <a href="{{ route('login') }}">Masuk Sekarang</a>
</div>
@endsection
