@extends('layouts.guest')

@section('title', 'Verifikasi Email — GetPosition')

@section('content')
<div class="auth-header">
      <div class="auth-eyebrow">Verifikasi</div>
      <h1 class="auth-title">VERIFIKASI<br><span class="outline">EMAIL</span></h1>
      <p class="auth-subtitle">Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi email Anda dengan mengeklik tautan yang baru saja kami kirimkan.</p>
</div>

<div class="auth-card">
      <!-- Verification Status Alert -->
      @if (session('status') == 'verification-link-sent')
            <div class="status-alert">
                  Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
            </div>
      @endif

      <div class="flex-actions">
            <!-- Resend Form -->
            <form method="POST" action="{{ route('verification.send') }}">
                  @csrf
                  <button type="submit" class="btn-submit">
                        Kirim Ulang Email
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18" />
                        </svg>
                  </button>
            </form>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="btn-logout">
                        Keluar Akun
                  </button>
            </form>
      </div>
</div>
@endsection
