<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Login - Sipanda IAIT Tasikmalaya')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <link rel="icon" href="{{ asset('images/Logo-IAIT.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/Logo-IAIT.png') }}" type="image/png">

    <style>
        .login-container {
            max-width: 28rem;
            width: 90%;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 640px) {
            .login-container {
                width: 100%;
                margin: 3rem auto;
                padding: 2.5rem;
            }
        }

        @media (min-width: 1024px) {
            .login-container {
                margin: 4rem auto;
                padding: 3rem;
            }
        }

        .login-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
            color: #1e3c72;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="login-container">
            <h1 class="login-title"></h1>
            {{ $slot }}
        </div>
    </div>
</body>

</html>