<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Portal Pemain SSB')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/ball.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/ball.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,500;0,8..60,600;1,8..60,300;1,8..60,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body class="bg-background text-on-background min-h-screen flex overflow-hidden font-body antialiased">

    <div x-data="{ open: false }" class="flex h-screen w-full">

        @include('user.components.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('user.components.header')

            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 md:px-10 md:py-9 lg:px-12 lg:py-10 overflow-y-auto">
                <div class="max-w-7xl mx-auto w-full">
                    @yield('content')
                </div>
            </main>

            @include('user.components.footer')
        </div>

    </div>

    {{-- Global SweetAlert2 Toast & Flash --}}
    <script>
        window.SwalToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                SwalToast.fire({ icon: 'success', title: @json(session('success')) });
            @endif
            @if (session('error'))
                SwalToast.fire({ icon: 'error', title: @json(session('error')) });
            @endif
            @if (session('warning'))
                SwalToast.fire({ icon: 'warning', title: @json(session('warning')) });
            @endif
            @if ($errors->any())
                let errorList = '';
                @foreach ($errors->all() as $error)
                    errorList += '<li>{{ $error }}</li>';
                @endforeach
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input',
                    html: `<ul class="text-left list-disc pl-5">${errorList}</ul>`,
                    confirmButtonColor: '#2C3E28',
                });
            @endif
        });

        function confirmDelete(formEl, message) {
            Swal.fire({
                title: 'Hapus Data?',
                text: message || 'Data ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) formEl.submit();
            });
        }
    </script>

    @stack('scripts')

</body>

</html>
