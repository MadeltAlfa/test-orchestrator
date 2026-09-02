{{-- Overlay --}}
<div x-show="open" @click="open = false" class="fixed inset-0 bg-black bg-opacity-40 z-40 md:hidden" x-transition></div>

<aside :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed md:static z-50 w-64 lg:w-72 bg-surface-container-low flex flex-col border-r border-outline-variant/20 h-full overflow-y-auto transform md:translate-x-0 transition-transform duration-300 ease-in-out">

    {{-- Brand --}}
    <div class="px-6 py-6 md:py-7 flex flex-col gap-1 border-b border-outline-variant/20 justify-between">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <img class="w-7 h-7 object-contain" src="{{ asset('assets/ball.png') }}" alt="GetPosition">
                <div>
                    <h1 class="text-primary font-headline font-extrabold text-xl tracking-tight leading-none">GetPosition</h1>
                    <p class="text-on-surface-variant font-label text-[10px] uppercase tracking-widest mt-1">Portal Pelatih</p>
                </div>
            </div>
            <button @click="open = false" class="md:hidden shrink-0 ml-2 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-surface-container-high transition text-on-surface-variant">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>

    <nav class="p-4 space-y-1 flex-grow overflow-y-auto">
        @php
            $navUser = [
                ['route' => 'user.dashboard', 'icon' => 'fa-home', 'label' => 'Dashboard'],
                ['route' => 'user.players.index', 'icon' => 'fa-users', 'label' => 'Daftar Pemain'],
                ['route' => 'user.position-check.index', 'icon' => 'fa-crosshairs', 'label' => 'Cek Posisi (Live)'],
                ['route' => 'user.position-check.input-score', 'icon' => 'fa-sliders-h', 'label' => 'Cek Posisi (Input Skor)'],
                ['route' => 'user.history.index', 'icon' => 'fa-history', 'label' => 'Riwayat'],
                ['route' => 'user.guides.index', 'icon' => 'fa-book-open', 'label' => 'Panduan Tes'],
            ];
        @endphp

        @foreach ($navUser as $nav)
            @if (\Illuminate\Support\Facades\Route::has($nav['route']))
                <a href="{{ route($nav['route']) }}"
                    class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                        {{ request()->routeIs($nav['route']) || request()->routeIs($nav['route'].'.*')
                            ? 'bg-primary text-on-primary shadow-sm'
                            : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <i class="fas {{ $nav['icon'] }} text-sm group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm font-semibold">{{ $nav['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    {{-- User Profile & Compact Actions --}}
    <div class="p-3 border-t border-outline-variant/20">
        <div class="flex items-center justify-between gap-2 bg-surface-container-low p-2 rounded-xl border border-outline-variant/10">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary font-bold text-xs uppercase shadow-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-bold text-on-surface truncate" title="{{ auth()->user()->name ?? 'Pelatih' }}">
                        {{ auth()->user()->name ?? 'Pelatih' }}
                    </span>
                    <span class="text-[9px] text-on-surface-variant uppercase tracking-wider font-semibold">Pelatih</span>
                </div>
            </div>

            <div class="flex items-center gap-1 flex-shrink-0">
                <a href="{{ route('profile.edit') }}"
                    class="w-7 h-7 rounded-lg flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors {{ request()->routeIs('profile.edit') ? 'bg-primary/10 text-primary' : '' }}"
                    title="Edit Profil">
                    <i class="fas fa-user-edit text-xs"></i>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-on-surface-variant hover:text-error hover:bg-error-container/30 transition-colors"
                        title="Logout">
                        <i class="fas fa-sign-out-alt text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
