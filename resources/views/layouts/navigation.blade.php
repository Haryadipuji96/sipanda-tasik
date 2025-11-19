<!-- Navbar -->
<div class="navbar-bg relative" x-data="{ open: false }">
    <style>
        .navbar-bg {
            width: 100%;
            background-color: #0f172a;
            background-image: linear-gradient(45deg,
                    rgba(59, 130, 246, 0.08) 25%,
                    transparent 25%,
                    transparent 75%,
                    rgba(59, 130, 246, 0.08) 75%),
                linear-gradient(-45deg,
                    rgba(59, 130, 246, 0.08) 25%,
                    transparent 25%,
                    transparent 75%,
                    rgba(59, 130, 246, 0.08) 75%),
                linear-gradient(45deg,
                    transparent 40%,
                    rgba(99, 102, 241, 0.1) 40%,
                    rgba(99, 102, 241, 0.1) 60%,
                    transparent 60%),
                linear-gradient(-45deg,
                    transparent 40%,
                    rgba(99, 102, 241, 0.1) 40%,
                    rgba(99, 102, 241, 0.1) 60%,
                    transparent 60%),
                radial-gradient(circle at 50% 50%, #1e293b 0%, #0f172a 100%);
            background-size: 60px 60px, 60px 60px, 120px 120px, 120px 120px, 100% 100%;
            background-position: 0 0, 30px 30px, 0 0, 60px 60px, 0 0;
        }

        .navbar-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(45deg,
                    rgba(255, 255, 255, 0.03) 0px,
                    rgba(255, 255, 255, 0.03) 1px,
                    transparent 1px,
                    transparent 10px),
                repeating-linear-gradient(-45deg,
                    rgba(255, 255, 255, 0.03) 0px,
                    rgba(255, 255, 255, 0.03) 1px,
                    transparent 1px,
                    transparent 10px);
            background-size: 20px 20px;
            filter: blur(0.5px);
        }

        [x-cloak] {
            display: none !important;
        }

        /* Animasi hamburger yang ditingkatkan */
        .hamburger-line {
            display: block;
            height: 2px;
            width: 24px;
            background-color: white;
            border-radius: 1px;
            transition: all 0.3s ease-in-out;
            transform-origin: center;
        }

        .hamburger-line:nth-child(1) {
            transform: translateY(-6px);
        }

        .hamburger-line:nth-child(3) {
            transform: translateY(6px);
        }

        .open .hamburger-line:nth-child(1) {
            transform: translateY(0) rotate(45deg);
        }

        .open .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: scale(0);
        }

        .open .hamburger-line:nth-child(3) {
            transform: translateY(0) rotate(-45deg);
        }

        /* Animasi menu mobile */
        .mobile-menu {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top;
        }

        .mobile-menu-enter {
            opacity: 0;
            transform: scaleY(0.8) translateY(-10px);
        }

        .mobile-menu-enter-active {
            opacity: 1;
            transform: scaleY(1) translateY(0);
        }

        .mobile-menu-leave {
            opacity: 1;
            transform: scaleY(1) translateY(0);
        }

        .mobile-menu-leave-active {
            opacity: 0;
            transform: scaleY(0.8) translateY(-10px);
        }
    </style>

    <nav class="shadow-md text-white relative z-10" x-data="{ openMaster: false, openSetting: false }">
        <div class="max-w-8xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="flex justify-between h-16 items-center">

                <!-- Kiri: Logo + Menu -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/Logo-IAIT.png') }}" alt="Logo IAIT" class="h-10 w-auto">
                        <span class="font-semibold text-lg tracking-wide">SIPANDA</span>
                    </a>

                    <!-- Menu Desktop -->
                    <div class="hidden sm:flex space-x-4">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <!-- Dropdown Master Data -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center justify-between w-full text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white focus:outline-none">
                                <span>Master Data</span>
                                <svg class="w-4 h-4 ml-2 pointer-events-none transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition x-cloak @click.away="open = false"
                                class="absolute left-0 mt-2 w-56 bg-white text-gray-700 rounded-lg shadow-lg z-50 border border-gray-200">
                                @canSuperadmin
                                <a href="{{ route('fakultas.index') }}"
                                    class="flex items-center px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded transition">
                                    <i class="fas fa-university w-4 h-4 mr-3"></i>
                                    Fakultas
                                </a>
                                <a href="{{ route('prodi.index') }}"
                                    class="flex items-center px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded transition">
                                    <i class="fas fa-graduation-cap w-4 h-4 mr-3"></i>
                                    Program Studi
                                </a>
                                {{-- <a href="{{ route('ruangan.index') }}"
       class="flex items-center px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded transition">
        <i class="fas fa-door-open w-4 h-4 mr-3"></i>
        Kelola Ruangan
    </a> --}}
                                <a href="{{ route('kategori-arsip.index') }}"
                                    class="flex items-center px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded transition">
                                    <i class="fas fa-folder w-4 h-4 mr-3"></i>
                                    Kategori Arsip
                                </a>

                                <!-- Menu Dokumen Mahasiswa -->
                                <a href="{{ route('dokumen-mahasiswa.index') }}"
                                    class="flex items-center px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded transition">
                                    <i class="fas fa-file-alt w-4 h-4 mr-3"></i>
                                    Dokumen Mahasiswa
                                </a>
                                @endcanSuperadmin
                            </div>
                        </div>

                        <x-nav-link :href="route('arsip.index')" :active="request()->routeIs('arsip.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Arsip') }}
                        </x-nav-link>

                        <x-nav-link :href="route('ruangan.index')" :active="request()->routeIs('ruangan.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Sarpras') }}
                        </x-nav-link>

                        {{-- <x-nav-link :href="route('sarpras.index')" :active="request()->routeIs('sarpras.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Sarpras') }}
                        </x-nav-link> --}}

                        <x-nav-link :href="route('tenaga-pendidik.index')" :active="request()->routeIs('tenaga-pendidik.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Tendik') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dosen.index')" :active="request()->routeIs('dosen*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Dosen') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Kanan: Setting + Profile -->
                <div class="hidden sm:flex items-center space-x-4">
                    <!-- Setting Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center justify-center text-white p-2.5 rounded-lg transition-colors hover:bg-blue-500 hover:text-white focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 pointer-events-none"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition x-cloak @click.away="open = false"
                            class="absolute right-0 mt-2 w-56 bg-white text-gray-700 rounded-lg shadow-lg z-50 border border-gray-200">
                            @canSuperadmin
                            <a href="{{ route('userlogin.index') }}"
                                class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Laporan
                                Aktivitas User</a>
                            <a href="{{ route('register') }}"
                                class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Pengguna</a>
                            @endcanSuperadmin
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md transition duration-200 ease-in-out transform hover:scale-105 hover:opacity-90 cursor-pointer">
                        @php
                            $user = Auth::user();
                            $avatar = $user->profile_photo
                                ? asset('profile_photos/' . $user->profile_photo)
                                : 'https://ui-avatars.com/api/?name=' .
                                    urlencode($user->name) .
                                    '&background=047857&color=fff';
                        @endphp

                        <img src="{{ $avatar }}" class="w-8 h-8 rounded-full object-cover border-2 border-white"
                            alt="Foto Profil"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=047857&color=fff'">

                        <div class="text-left">
                            <h2 class="font-medium text-sm text-white truncate max-w-[120px]">{{ $user->name }}</h2>
                            <p class="text-xs text-green-100 truncate max-w-[120px]">{{ $user->email }}</p>
                        </div>
                    </a>
                </div>

                <!-- Hamburger Mobile - Versi yang ditingkatkan -->
                <div class="sm:hidden flex items-center">
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white focus:outline-none transition-all duration-300"
                        :class="{ 'open': open }">
                        <div class="relative w-6 h-6 flex flex-col justify-center items-center">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu dengan animasi yang ditingkatkan -->
        <!-- Mobile Menu dengan animasi yang ditingkatkan -->
        <div x-show="open" x-transition:enter="mobile-menu-enter" x-transition:enter-start="mobile-menu-enter"
            x-transition:enter-end="mobile-menu-enter-active" x-transition:leave="mobile-menu-leave"
            x-transition:leave-start="mobile-menu-leave" x-transition:leave-end="mobile-menu-leave-active"
            class="sm:hidden bg-gradient-to-b from-blue-50 to-white text-gray-800 shadow-inner mobile-menu overflow-hidden"
            x-cloak>
            <div class="pt-2 pb-3 space-y-1 px-4">

                <!-- Profile Section untuk Mobile -->
                <div
                    class="flex items-center space-x-3 px-3 py-4 mb-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg text-white shadow-sm">
                    @php
                        $user = Auth::user();
                        $avatar = $user->profile_photo
                            ? asset('profile_photos/' . $user->profile_photo)
                            : 'https://ui-avatars.com/api/?name=' .
                                urlencode($user->name) .
                                '&background=ffffff&color=3b82f6';
                    @endphp

                    <img src="{{ $avatar }}"
                        class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md" alt="Foto Profil"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ffffff&color=3b82f6'">

                    <div class="text-left flex-1 min-w-0">
                        <h2 class="font-semibold text-sm truncate">{{ $user->name }}</h2>
                        <p class="text-xs text-blue-100 truncate">{{ $user->email }}</p>
                        <a href="{{ route('profile.edit') }}"
                            class="text-xs text-blue-200 hover:text-white underline mt-1 inline-block">
                            Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Dashboard -->
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Dashboard</span>
                    </div>
                </x-responsive-nav-link>

                <!-- Mobile Dropdown Master Data -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-3 py-3 text-left rounded-lg transition-all duration-200 bg-white shadow-sm hover:shadow-md hover:bg-blue-50 border border-blue-100">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-800">Master Data</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                        class="space-y-1 pl-4 mt-2 border-l-2 border-blue-200 ml-5">
                        @canSuperadmin
                        <x-responsive-nav-link :href="route('fakultas.index')" class="group">
                            <div class="flex items-center space-x-3 py-2">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-green-400 to-green-500 rounded-md flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <span class="text-gray-700">Fakultas</span>
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('prodi.index')" class="group">
                            <div class="flex items-center space-x-3 py-2">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-blue-400 to-blue-500 rounded-md flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <span class="text-gray-700">Program Studi</span>
                            </div>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('kategori-arsip.index')" class="group">
                            <div class="flex items-center space-x-3 py-2">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-md flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <span class="text-gray-700">Kategori Arsip</span>
                            </div>
                        </x-responsive-nav-link>
                        <!-- Dokumen Mahasiswa Mobile -->
                        <x-responsive-nav-link :href="route('dokumen-mahasiswa.index')" class="group">
                            <div class="flex items-center space-x-3 py-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fas fa-file-alt text-white text-lg"></i>
                                </div>
                                <span class="font-medium text-gray-800">Dokumen Mahasiswa</span>
                            </div>
                        </x-responsive-nav-link>
                        @endcanSuperadmin

                    </div>
                </div>

                <!-- Data Menu Items -->
                <x-responsive-nav-link :href="route('arsip.index')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Data Arsip</span>
                    </div>
                </x-responsive-nav-link>


                <x-responsive-nav-link :href="route('ruangan.index')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-teal-500 to-teal-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Data Sarpras</span>
                    </div>
                </x-responsive-nav-link>

                {{-- <x-responsive-nav-link :href="route('sarpras.index')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-teal-500 to-teal-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Data Sarpras</span>
                    </div>
                </x-responsive-nav-link> --}}

                <x-responsive-nav-link :href="route('tenaga-pendidik.index')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Data Tendik</span>
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('dosen.index')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Data Dosen</span>
                    </div>
                </x-responsive-nav-link>

                <!-- Management Menu Items -->
                @canSuperadmin
                <x-responsive-nav-link :href="route('register')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Pengguna</span>
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('userlogin.index')" class="group">
                    <div class="flex items-center space-x-3 py-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-800">Laporan Aktivitas</span>
                    </div>
                </x-responsive-nav-link>
                @endcanSuperadmin

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center space-x-3 px-3 py-3 text-left rounded-lg transition-all duration-200 bg-gradient-to-r from-red-500 to-red-600 text-white shadow-sm hover:shadow-md hover:from-red-600 hover:to-red-700 mt-4">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
