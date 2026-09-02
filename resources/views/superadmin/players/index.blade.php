@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
         x-data="playersTable()"
         x-effect="search; sort; page = 1; load()">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Pemain</h1>
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="search"
                       x-model.debounce.300ms="search"
                       placeholder="Cari nama / email..."
                       class="w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <select x-model="sort"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="created_at_desc">Terbaru</option>
                    <option value="created_at_asc">Terlama</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr x-show="loading">
                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400">Memuat...</td>
                    </tr>
                    <tr x-show="!loading && rows.length === 0">
                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400">Tidak ada data.</td>
                    </tr>
                    <template x-for="row in rows" :key="row.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="row.name"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="row.email"></td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="new Date(row.created_at).toLocaleDateString('id-ID')"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">
            <p class="text-sm text-gray-600" x-show="meta.total > 0"
               x-text="`Menampilkan ${meta.from}–${meta.to} dari ${meta.total} pemain`"></p>
            <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                <template x-for="link in links" :key="link.label">
                    <button type="button"
                            @click="go(link.url)"
                            :disabled="!link.url"
                            :class="link.active
                                ? 'z-10 bg-indigo-600 border-indigo-600 text-white'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'"
                            class="relative inline-flex items-center px-3 py-2 border text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed first:rounded-l-md last:rounded-r-md"
                            x-html="link.label">
                    </button>
                </template>
            </nav>
        </div>
    </div>
</div>

<script>
    function playersTable() {
        return {
            search: '',
            sort: 'created_at_desc',
            page: 1,
            rows: [],
            links: [],
            meta: {},
            loading: false,

            // ponytail: asumsi kolom name/email/created_at & controller return paginator JSON untuk XHR. Sesuaikan field bila beda.
            async load() {
                this.loading = true;
                try {
                    const params = new URLSearchParams({ search: this.search, sort: this.sort, page: this.page });
                    const res = await fetch(`{{ url()->current() }}?${params}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    this.rows = data.data;
                    this.links = data.links;
                    this.meta = data;
                } finally {
                    this.loading = false;
                }
            },

            go(url) {
                if (!url) return;
                this.page = new URL(url).searchParams.get('page') || 1;
                this.load();
            }
        }
    }
</script>
@endsection
