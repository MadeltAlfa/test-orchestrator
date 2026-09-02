@props([
    'action',
    'title' => 'Hapus Data',
    'message' => 'Data yang dihapus tidak dapat dikembalikan.',
])

<style>[x-cloak]{display:none!important}</style>

<form
    x-ref="form"
    x-data="{ open: false }"
    x-on:submit.prevent="open = true"
    method="POST"
    action="{{ $action }}"
    class="inline"
>
    @csrf
    @method('DELETE')

    {{-- Trigger: tombol/link pembuka modal, diisi via slot --}}
    {{ $slot }}

    {{-- Overlay --}}
    <div
        x-cloak
        x-show="open"
        x-transition.opacity
        x-on:keydown.escape.window="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    >
        <div
            x-on:click.outside="open = false"
            class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl"
        >
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            <p class="mt-2 text-sm text-gray-600">{{ $message }}</p>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="open = false"
                    class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300"
                >
                    Batal
                </button>
                <button
                    type="button"
                    x-on:click="$refs.form.submit()"
                    class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                >
                    Hapus
                </button>
            </div>
        </div>
    </div>
</form>
