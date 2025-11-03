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
                                class="absolute left-0 mt-2 w-48 bg-white text-gray-700 rounded-lg shadow-lg z-50 border border-gray-200">
                                @canSuperadmin
                                <a href="{{ route('fakultas.index') }}"
                                    class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Fakultas</a>
                                <a href="{{ route('prodi.index') }}"
                                    class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Program
                                    Studi</a>
                                <a href="{{ route('kategori-arsip.index') }}"
                                    class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Kategori
                                    Arsip</a>
                                @endcanSuperadmin
                                <a href="{{ route('dosen.index') }}"
                                    class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Dosen</a>
                            </div>
                        </div>

                        <x-nav-link :href="route('arsip.index')" :active="request()->routeIs('arsip.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Arsip') }}
                        </x-nav-link>

                        <x-nav-link :href="route('sarpras.index')" :active="request()->routeIs('sarpras.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Sarpras') }}
                        </x-nav-link>

                        <x-nav-link :href="route('tenaga-pendidik.index')" :active="request()->routeIs('tenaga-pendidik.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-colors hover:bg-blue-500 hover:text-white">
                            {{ __('Data Tendik') }}
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
                            <a href="{{ route('userlogin.index') }}"
                                class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Laporan
                                Aktivitas User</a>
                            <a href="{{ route('register') }}"
                                class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white rounded">Pengguna</a>
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
                                ? asset('storage/' . $user->profile_photo)
                                : 'https://ui-avatars.com/api/?name=' .
                                    urlencode($user->name) .
                                    '&background=047857&color=fff';
                        @endphp
                        <img src="{{ $avatar }}" class="w-8 h-8 rounded-full object-cover border-2 border-white"
                            alt="Foto Profil">
                        <div class="text-left">
                            <h2 class="font-medium text-sm text-white truncate max-w-[120px]">{{ $user->name }}</h2>
                            <p class="text-xs text-green-100 truncate max-w-[120px]">{{ $user->email }}</p>
                        </div>
                    </a>
                </div>

                <!-- Hamburger Mobile -->
                <div class="sm:hidden flex items-center">
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-white text-gray-800" x-cloak>
            <div class="pt-2 pb-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>

                <!-- Mobile Dropdown Master Data -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-3 py-2 text-left rounded-md text-gray-800 hover:bg-blue-500 hover:text-white">
                        Master Data
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition x-cloak class="space-y-1 pl-4">
                        <x-responsive-nav-link :href="route('fakultas.index')">Fakultas</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('prodi.index')">Program Studi</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('kategori-arsip.index')">Kategori Arsip</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dosen.index')">Dosen</x-responsive-nav-link>
                    </div>
                </div>

                <x-responsive-nav-link :href="route('arsip.index')">Data Arsip</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sarpras.index')">Data Sarpras</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tenaga-pendidik.index')">Data Tendik</x-responsive-nav-link>

                <x-responsive-nav-link :href="route('users.index')">Pengguna</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('userlogin.index')">Laporan Aktivitas User</x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-3 py-2 text-gray-800 hover:bg-blue-500 hover:text-white rounded-md">Logout</button>
                </form>
            </div>
        </div>
    </nav>
</div>
