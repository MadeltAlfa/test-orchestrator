@if (session()->has('success') || session()->has('error'))
    <div
        x-data="{ show: true, type: '{{ session()->has('success') ? 'success' : 'error' }}' }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="fixed top-4 right-4 p-4 rounded shadow text-white"
        :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
        role="alert"
    >
        {{ session('success') ?? session('error') }}
    </div>
@endif
