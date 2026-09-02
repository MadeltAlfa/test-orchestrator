<section class="space-y-4">
    <div class="border-b border-error/10 pb-4 mb-4">
        <h2 class="text-base font-headline font-bold text-error">Hapus Akun</h2>
        <p class="text-xs text-on-surface-variant mt-1 font-body">Setelah akun Anda dihapus, seluruh data profil dan riwayat akan dihapus secara permanen dari sistem.</p>
    </div>

    <form method="post" action="{{ route('profile.destroy') }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Apakah Anda yakin ingin menghapus akun Anda secara permanen?')">
        @csrf
        @method('delete')

        <div class="max-w-xl space-y-4">
            <div>
                <label for="delete_password" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2 font-label">
                    Konfirmasi Kata Sandi untuk Hapus Akun
                </label>
                <input id="delete_password" name="password" type="password"
                    class="w-full rounded-xl border border-outline-variant/60 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-error/30 focus:border-error transition outline-none"
                    placeholder="Masukkan kata sandi akun Anda">
                @if($errors->userDeletion->get('password'))
                    <p class="text-error text-xs mt-1.5">{{ $errors->userDeletion->get('password')[0] }}</p>
                @endif
            </div>

            <button type="submit" class="px-5 py-2.5 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition">
                <i class="fas fa-trash-alt mr-1.5"></i> Hapus Akun Saya
            </button>
        </div>
    </form>
</section>
