<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'SIPANDA') }}</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('images/Logo-IAIT.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Background -->
    <style>
        
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
            /* Background image */
            background-image: url('{{ asset('images/gambar.jpg') }}');
            background-size: cover;
            /* membuat gambar memenuhi seluruh layar */
            background-repeat: no-repeat;
            /* tidak diulang */
            background-position: center;
            /* posisi di tengah */
            position: relative;
            /* penting agar ::before z-index bekerja */
        }

        /* Overlay putih transparan supaya gambar lebih soft */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            /* putih 50% transparan */
            z-index: -1;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @stack('scripts')

    </div>
</body>

</html>
