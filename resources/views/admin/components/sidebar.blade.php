{{-- Overlay (mobile) --}}
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
                    <p class="text-on-surface-variant font-label text-[10px] uppercase tracking-widest mt-1">Portal Superadmin</p>
                </div>
            </div>
            <button @click="open = false" class="md:hidden shrink-0 ml-2 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-surface-container-high transition text-on-surface-variant">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>

    <nav class="p-4 space-y-1 flex-grow overflow-y-auto">

        {{-- Dashboard --}}
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.dashboard') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-home text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Dashboard</span>
        </a>

        {{-- Pengguna --}}
        <div class="pt-2 pb-1">
            <p class="px-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Pengguna</p>
        </div>

        <a href="{{ route('superadmin.users.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.users.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-users text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Pengguna</span>
        </a>

        <a href="{{ route('superadmin.players.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.players.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-running text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Data Pemain</span>
        </a>

        {{-- Konfigurasi Sistem --}}
        <div class="pt-3 pb-1">
            <p class="px-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Konfigurasi Posisi</p>
        </div>

        <a href="{{ route('superadmin.positions.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.positions.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-map-marker-alt text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Posisi</span>
        </a>

        <a href="{{ route('superadmin.indicators.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.indicators.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-layer-group text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Indikator</span>
        </a>

        <a href="{{ route('superadmin.tests.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.tests.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-dumbbell text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Tes Keahlian</span>
        </a>


        {{-- Penilaian --}}
        <div class="pt-3 pb-1">
            <p class="px-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Penilaian</p>
        </div>

        <a href="{{ route('superadmin.norms.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.norms.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-ruler-combined text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Norma Penilaian</span>
        </a>

        <a href="{{ route('superadmin.scoring-categories.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.scoring-categories.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-star-half-alt text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Kategori Skor</span>
        </a>

        <a href="{{ route('superadmin.assessments.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.assessments.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-clipboard-list text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Assessment</span>
        </a>

        {{-- Panduan & Laporan --}}
        <div class="pt-3 pb-1">
            <p class="px-3 text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Panduan & Laporan</p>
        </div>

        <a href="{{ route('superadmin.guides.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.guides.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-book text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Panduan Tes</span>
        </a>

        <a href="{{ route('superadmin.reports.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.reports.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-chart-bar text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Laporan</span>
        </a>
<!-- 
        <a href="{{ route('superadmin.settings.index') }}"
            class="flex items-center space-x-3 p-3 rounded-lg transition-all group
                {{ request()->routeIs('superadmin.settings.*') ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <i class="fas fa-cog text-sm group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-semibold">Pengaturan</span>
        </a> -->

    </nav>

    {{-- User Profile & Compact Actions --}}
    <div class="p-3 border-t border-outline-variant/20">
        <div class="flex items-center justify-between gap-2 bg-surface-container-low p-2 rounded-xl border border-outline-variant/10">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary font-bold text-xs uppercase shadow-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-bold text-on-surface truncate" title="{{ auth()->user()->name ?? 'Admin' }}">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </span>
                    <span class="text-[9px] text-on-surface-variant uppercase tracking-wider font-semibold">Superadmin</span>
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
