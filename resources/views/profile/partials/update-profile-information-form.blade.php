<section>
    <div class="border-b border-outline-variant/10 pb-4 mb-6">
        <h2 class="text-base font-headline font-bold text-on-surface">Informasi Akun</h2>
        <p class="text-xs text-on-surface-variant mt-1 font-body">Perbarui nama pengguna dan alamat email akun yang digunakan untuk login.</p>
    </div>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5 max-w-xl">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2 font-label">
                Nama Lengkap <span class="text-error">*</span>
            </label>
            <input id="name" name="name" type="text"
                class="w-full rounded-xl border border-outline-variant/60 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary transition outline-none"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                placeholder="Masukkan nama lengkap">
            @if($errors->get('name'))
                <p class="text-error text-xs mt-1.5">{{ $errors->get('name')[0] }}</p>
            @endif
        </div>

        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2 font-label">
                Alamat Email <span class="text-error">*</span>
            </label>
            <input id="email" name="email" type="email"
                class="w-full rounded-xl border border-outline-variant/60 px-4 py-2.5 text-sm bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-primary/30 focus:border-primary transition outline-none"
                value="{{ old('email', $user->email) }}" required autocomplete="username"
                placeholder="email@domain.com">
            @if($errors->get('email'))
                <p class="text-error text-xs mt-1.5">{{ $errors->get('email')[0] }}</p>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-premium">
                <i class="fas fa-save mr-2"></i> Simpan Profil
            </button>
        </div>
    </form>
</section>
