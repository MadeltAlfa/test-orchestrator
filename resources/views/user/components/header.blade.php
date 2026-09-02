<header class="md:hidden bg-background h-14 flex items-center justify-between px-4 sticky top-0 z-30">
    <button @click="open = true" class="text-primary flex items-center justify-center w-9 h-9 rounded-xl hover:bg-surface-container-high transition bg-surface-container-lowest border border-outline-variant/20 shadow-sm" aria-label="Buka Menu">
        <i class="fas fa-bars text-base"></i>
    </button>

    <a href="{{ route('profile.edit') }}" class="flex items-center" title="Edit Profil">
        <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-xs shadow-sm">
            {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
        </div>
    </a>
</header>
