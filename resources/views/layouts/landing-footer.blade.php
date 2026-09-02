<!-- LANDING / PUBLIC FOOTER -->
<footer class="{{ isset($darkFooter) && $darkFooter ? 'footer-dark' : 'footer-light' }}">
      <div class="footer-copy">© {{ date('Y') }} GetPosition — Sistem Penentuan Posisi Pemain</div>
      <div class="footer-links">
            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ url('/panduan-posisi') }}">Panduan Posisi</a>
            <a href="{{ route('panduan-tes') }}">Panduan Tes</a>
      </div>
</footer>
