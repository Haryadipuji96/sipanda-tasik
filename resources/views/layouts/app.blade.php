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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
            background-image: url('{{ asset('images/gambar.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            z-index: -1;
        }

        .min-h-screen {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* MAIN CONTENT AREA - FIXED FOR LARGE SCREENS */
        .main-content-wrapper {
            flex: 1;
            width: 100%;
            max-width: 1536px;
            margin: 0 auto;
            padding: 1rem;
            box-sizing: border-box;
        }

        @media (min-width: 640px) {
            .main-content-wrapper {
                padding: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .main-content-wrapper {
                padding: 2rem;
            }
        }

        @media (min-width: 1536px) {
            .main-content-wrapper {
                padding: 2.5rem;
            }
        }

        /* HEADER STYLES */
        .page-header {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1536px;
            margin: 0 auto;
            padding: 1rem;
        }

        @media (min-width: 640px) {
            .header-container {
                padding: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .header-container {
                padding: 2rem;
            }
        }

        .header-title {
            font-size: clamp(1.25rem, 4vw, 2rem);
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        /* FOOTER STYLES - IMPROVED */
        .site-footer {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            margin-top: auto;
            border-top: 4px solid #f8c300;
        }

        .footer-main {
            max-width: 1536px;
            margin: 0 auto;
            padding: 2rem 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .footer-main {
                padding: 2.5rem 1.5rem;
                gap: 2.5rem;
            }
        }

        @media (min-width: 1024px) {
            .footer-main {
                padding: 3rem 2rem;
                grid-template-columns: repeat(3, 1fr);
                gap: 3rem;
            }
        }

        .footer-section h4 {
            color: #f8c300;
            margin-bottom: 1.25rem;
            font-size: clamp(1rem, 2vw, 1.25rem);
            border-bottom: 2px solid #f8c300;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 768px) {
            .footer-logo {
                flex-direction: column;
                text-align: center;
            }
        }

        .logo-img {
            width: clamp(50px, 8vw, 70px);
            height: clamp(50px, 8vw, 70px);
            margin-right: 1rem;
            background: white;
            padding: 0.375rem;
            border-radius: 0.5rem;
        }

        @media (max-width: 768px) {
            .logo-img {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }

        .logo-text h3 {
            margin: 0;
            color: #f8c300;
            font-size: clamp(1.125rem, 3vw, 1.5rem);
        }

        .logo-text p {
            margin: 0.375rem 0 0 0;
            font-size: clamp(0.875rem, 2vw, 1rem);
            opacity: 0.9;
        }

        .footer-info p {
            margin: 0.875rem 0;
            display: flex;
            align-items: center;
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        @media (max-width: 768px) {
            .footer-info p {
                justify-content: center;
                text-align: center;
            }
        }

        .footer-info i {
            margin-right: 0.75rem;
            color: #f8c300;
            width: 1.125rem;
        }

        .footer-description {
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-size: clamp(0.875rem, 2vw, 1rem);
            padding: 0.5rem 0;
        }

        @media (max-width: 768px) {
            .footer-links a {
                justify-content: center;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .footer-links a:last-child {
                border-bottom: none;
            }
        }

        .footer-links a:hover {
            color: #f8c300;
            transform: translateX(0.5rem);
        }

        .footer-links i {
            margin-right: 0.75rem;
            width: 1.125rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        @media (max-width: 768px) {
            .social-links {
                justify-content: center;
            }
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: clamp(2.75rem, 6vw, 3.5rem);
            height: clamp(2.75rem, 6vw, 3.5rem);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: clamp(1rem, 2vw, 1.25rem);
        }

        .social-link:hover {
            transform: translateY(-0.25rem);
            background: #f8c300;
        }

        .facebook:hover { background: #3b5998 !important; }
        .instagram:hover { background: #e4405f !important; }
        .youtube:hover { background: #cd201f !important; }
        .twitter:hover { background: #1da1f2 !important; }

        .footer-contact h5 {
            color: #f8c300;
            margin-bottom: 0.75rem;
            font-size: clamp(1rem, 2vw, 1.125rem);
        }

        .footer-contact p {
            margin: 0.625rem 0;
            display: flex;
            align-items: center;
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        @media (max-width: 768px) {
            .footer-contact p {
                justify-content: center;
                text-align: center;
            }
        }

        .footer-contact i {
            margin-right: 0.75rem;
            color: #f8c300;
            width: 1.125rem;
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.3);
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bottom-container {
            max-width: 1536px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .footer-bottom-container {
                flex-direction: column;
                text-align: center;
                gap: 0.875rem;
            }
        }

        .footer-bottom p {
            margin: 0;
            font-size: clamp(0.875rem, 2vw, 1rem);
            opacity: 0.8;
        }

        .footer-credits {
            font-size: clamp(0.75rem, 1.5vw, 0.875rem);
            opacity: 0.7;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Touch device improvements */
        @media (hover: none) and (pointer: coarse) {
            .footer-links a:active {
                color: #f8c300;
                transform: translateX(0.5rem);
            }
            
            .social-link:active {
                transform: translateY(-0.25rem);
                background: #f8c300;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="page-header">
                <div class="header-container">
                    <h1 class="header-title">{{ $header }}</h1>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="main-content-wrapper">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="site-footer">
            {{-- <div class="footer-main">
                <!-- Bagian Informasi Kampus -->
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="{{ asset('images/Logo-IAIT.png') }}" alt="IAIT Logo" class="logo-img">
                        <div class="logo-text">
                            <h3>IAIT Tasikmalaya</h3>
                            <p>Institut Agama Islam Tasikmalaya</p>
                        </div>
                    </div>
                    <div class="footer-info">
                        <p><i class="fas fa-map-marker-alt"></i> Jl. Raya Sukaratu No. 01, Tasikmalaya</p>
                        <p><i class="fas fa-phone"></i> (0265) 123456</p>
                        <p><i class="fas fa-envelope"></i> info@iait.ac.id</p>
                        <p><i class="fas fa-globe"></i> www.iait.ac.id</p>
                    </div>
                </div>

                <!-- Bagian SIPANDA -->
                <div class="footer-section">
                    <h4>SIPANDA</h4>
                    <p class="footer-description">
                        Sistem Informasi Pangkalan Arsip dan Data<br>
                        Institut Agama Islam Tasikmalaya
                    </p>
                    <div class="footer-links">
                        <a href="#"><i class="fas fa-info-circle"></i> Tentang SIPANDA</a>
                        <a href="#"><i class="fas fa-question-circle"></i> Bantuan</a>
                        <a href="#"><i class="fas fa-file-alt"></i> Panduan Penggunaan</a>
                        <a href="#"><i class="fas fa-shield-alt"></i> Kebijakan Privasi</a>
                    </div>
                </div>

                <!-- Bagian Kontak & Sosial Media -->
                <div class="footer-section">
                    <h4>Kontak & Media Sosial</h4>
                    <div class="social-links">
                        <a href="#" class="social-link facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                    
                    <div class="footer-contact">
                        <h5>Layanan Pengaduan</h5>
                        <p><i class="fas fa-headset"></i> 0800-1234-5678</p>
                        <p><i class="fas fa-envelope"></i> sipanda@iait.ac.id</p>
                    </div>
                </div>
            </div> --}}

            <!-- Copyright -->
            <div class="footer-bottom">
                <div class="footer-bottom-container">
                    <p>&copy; {{ date('Y') }} SIPANDA - Sistem Informasi Pangkalan Arsip dan Data. IAIT Tasikmalaya. All rights reserved.</p>
                    <div class="footer-credits">
                        <span>Developed by IT Team IAIT Tasikmalaya</span>
                    </div>
                </div>
            </div>
        </footer>

        @stack('scripts')
    </div>
</body>

</html>