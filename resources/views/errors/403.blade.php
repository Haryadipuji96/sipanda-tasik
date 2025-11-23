<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - SIPANDA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
            }

            to {
                box-shadow: 0 0 30px rgba(239, 68, 68, 0.6);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-40 -right-32 w-80 h-80 bg-red-200 rounded-full mix-blend-multiply filter blur-xl opacity-20">
        </div>
        <div
            class="absolute -bottom-40 -left-32 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-20">
        </div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-10">
        </div>
    </div>

    <div class="relative w-full max-w-2xl">
        <!-- Main Card -->
        <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Illustration -->
                <div
                    class="md:w-2/5 bg-gradient-to-br from-green-400 to-cyan-400 p-8 flex items-center justify-center relative">
                    <div class="text-center text-white">
                        <div class="floating mb-6">
                            <div
                                class="w-24 h-24 mx-auto bg-white/20 rounded-full flex items-center justify-center pulse-glow">
                                <i class="fas fa-lock text-white text-4xl"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Akses Terkunci</h3>
                        <p class="text-red-100 text-sm">Izin diperlukan</p>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute top-4 left-4 w-3 h-3 bg-white/30 rounded-full"></div>
                    <div class="absolute bottom-4 right-4 w-2 h-2 bg-white/40 rounded-full"></div>
                    <div class="absolute top-1/2 left-6 w-1 h-1 bg-white/20 rounded-full"></div>
                </div>

                <!-- Right Side - Content -->
                <div class="md:w-3/5 p-8">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                            <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Akses Ditolak</h1>
                        <p class="text-gray-600">Anda tidak memiliki izin untuk mengakses halaman ini</p>
                    </div>

                    <!-- User Info Card -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 mb-8 border border-gray-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-500">Sedang login sebagai</p>
                                <p class="text-lg font-semibold text-gray-800 truncate">
                                    {{ Auth::user()->name ?? 'Guest' }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-envelope mr-1"></i>
                                        {{ Auth::user()->email ?? 'Tidak login' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-user-tag mr-1"></i>
                                        {{ Auth::user()->role ?? 'Tidak diketahui' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <a href="#" onclick="goBackSafe()"
                            class="group bg-gray-500 hover:bg-gray-600 text-white py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i
                                class="fas fa-arrow-left text-white group-hover:transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                            <span class="font-semibold">Kembali</span>
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="group bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-home text-white"></i>
                            <span class="font-semibold">Dashboard</span>
                        </a>
                    </div>

                    <!-- Help Text -->
                    <div class="text-center">
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Jika Anda merasa ini kesalahan, hubungi administrator sistem
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <div class="inline-flex items-center space-x-2 bg-black/10 backdrop-blur-sm rounded-full px-4 py-2">
                <i class="fas fa-shield-alt text-gray-600"></i>
                <span class="text-sm text-gray-700 font-medium">SIPANDA Security System</span>
                <span class="text-xs text-gray-500">•</span>
                <span class="text-xs text-gray-500">Error 403</span>
            </div>
        </div>

        <!-- Floating Icons -->
        <div
            class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
            <i class="fas fa-exclamation text-white text-sm"></i>
        </div>
        <div
            class="absolute -bottom-4 -left-4 w-6 h-6 bg-green-400 rounded-full flex items-center justify-center shadow-lg">
            <i class="fas fa-lock text-white text-xs"></i>
        </div>
    </div>

    <!-- Animated Background Circles -->
    <div class="fixed bottom-10 left-10 w-4 h-4 bg-red-300 rounded-full opacity-50 animate-pulse"></div>
    <div class="fixed top-20 right-20 w-3 h-3 bg-blue-300 rounded-full opacity-40 animate-pulse delay-75"></div>
    <div class="fixed top-40 left-20 w-2 h-2 bg-purple-300 rounded-full opacity-30 animate-pulse delay-150"></div>

</body>

<script>
    // Tambah efek interaktif
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('a');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>

<script>
    function goBackSafe() {
        const previousUrl = document.referrer;
        const currentUrl = window.location.href;

        // Jika previous URL ada dan bukan halaman yang sama
        if (previousUrl && previousUrl !== currentUrl) {
            window.history.back();
        } else {
            // Default ke dashboard
            window.location.href = "{{ route('dashboard') }}";
        }

        return false; // Prevent default link behavior
    }
</script>

</html>
