<section>
    <div class="border-b border-outline-variant/10 pb-4 mb-6">
        <h2 class="text-base font-headline font-bold text-on-surface">Perbarui Kata Sandi</h2>
        <p class="text-xs text-on-surface-variant mt-1 font-body">Pastikan akun Anda menggunakan kata sandi yang panjang dan aman.</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5 max-w-xl">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2 font-label">
                Kata Sandi Saat Ini <span class="text-error">*</span>
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full rounded-xl border border-outline-variant/60 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary transition outline-none"
                autocomplete="current-password" placeholder="Masukkan kata sandi saat ini">
            @if($errors->updatePassword->get('current_password'))
                <p class="text-error text-xs mt-1.5">{{ $errors->updatePassword->get('current_password')[0] }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2 font-label">
                Kata Sandi Baru <span class="text-error">*</span>
            </label>
            <input id="update_password_password" name="password" type="password"
                class="w-full rounded-xl border border-outline-variant/60 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary transition outline-none"
                autocomplete="new-password" placeholder="Masukkan kata sandi baru">
            @if($errors->updatePassword->get('password'))
                <p class="text-error text-xs mt-1.5">{{ $errors->updatePassword->get('password')[0] }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2 font-label">
                Konfirmasi Kata Sandi Baru <span class="text-error">*</span>
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full rounded-xl border border-outline-variant/60 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary transition outline-none"
                autocomplete="new-password" placeholder="Ulangi kata sandi baru">
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="text-error text-xs mt-1.5">{{ $errors->updatePassword->get('password_confirmation')[0] }}</p>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-premium">
                <i class="fas fa-key mr-2"></i> Perbarui Kata Sandi
            </button>
        </div>
    </form>
</section>
