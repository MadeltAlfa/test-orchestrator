@extends('user.layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Profil Saya</h1>
            <p class="text-sm text-on-surface-variant mt-1">Data biodata dan informasi pribadi pemain</p>
        </div>
        <a href="{{ route('user.profile.edit') }}" class="btn-premium font-label">
            <i class="fas fa-edit"></i> Edit Profil
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        {{-- Profile Header --}}
        <div class="bg-gradient-to-br from-primary to-primary-container px-6 py-8 text-white text-center border-b border-outline-variant/10">
            <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center mx-auto text-4xl font-headline font-bold mb-3 shadow-inner">
                {{ strtoupper(substr($profile?->full_name ?? auth()->user()->name ?? 'P', 0, 1)) }}
            </div>
            <h2 class="text-xl font-headline font-bold text-white">{{ $profile?->full_name ?? auth()->user()->name ?? '-' }}</h2>
            <p class="text-cream/80 text-sm mt-1 font-mono">{{ auth()->user()->email ?? '-' }}</p>
        </div>

        {{-- Profile Details --}}
        <div class="p-6">
            @if ($profile)
                <div class="grid grid-cols-2 gap-4">
                    @php
                        $details = [
                            ['icon' => 'fa-envelope', 'label' => 'Email', 'value' => auth()->user()->email],
                            ['icon' => 'fa-id-card', 'label' => 'Nama Lengkap', 'value' => $profile->full_name],
                        ];
                    @endphp
                    @foreach ($details as $detail)
                    <div class="bg-surface-container-low/30 border border-outline-variant/5 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas {{ $detail['icon'] }} text-primary text-sm"></i>
                            <span class="text-xs text-on-surface-variant font-medium">{{ $detail['label'] }}</span>
                        </div>
                        <p class="text-base font-bold text-on-surface font-mono">{{ $detail['value'] }}</p>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-on-surface-variant/50">
                    <i class="fas fa-user-slash text-4xl mb-3 block text-on-surface-variant/30"></i>
                    <p class="font-bold">Biodata belum diisi</p>
                    <a href="{{ route('user.profile.edit') }}" class="mt-3 btn-premium font-label">
                        Lengkapi Biodata Sekarang &rarr;
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
