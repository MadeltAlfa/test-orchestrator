@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Pemain</h1>
            <form method="GET" action="{{ route('superadmin.players.index') }}" class="flex flex-col sm:flex-row gap-3">
                <input type="search"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari nama / email coach..."
                       class="w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <select name="sort"
                        onchange="this.form.submit()"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="created_at" @selected($sort === 'created_at')>Terbaru</option>
                    <option value="name" @selected($sort === 'name')>Nama</option>
                </select>
                <select name="order"
                        onchange="this.form.submit()"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="asc" @selected($order === 'asc')>Naik</option>
                    <option value="desc" @selected($order === 'desc')>Turun</option>
                </select>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    Cari
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email Coach</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assessment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($data as $player)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $player->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $player->coach->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $player->profile->position->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $player->assessments_count }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $player->created_at->translatedFormat('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection
