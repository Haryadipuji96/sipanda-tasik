<!-- Navbar dengan background Uiverse.io -->
<div class="container relative">
    <style>
        /* From Uiverse.io by themrsami */
        .container {
            width: 100%;
            height: 100%;
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
            background-size:
                60px 60px,
                60px 60px,
                120px 120px,
                120px 120px,
                100% 100%;
            background-position:
                0 0,
                30px 30px,
                0 0,
                60px 60px,
                0 0;
        }

        .container::before {
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
    </style>

    <nav x-data="{ open: false, openMaster: false, openSetting: false }" class="shadow-md text-white relative z-10">
        <div class="max-w-8xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="flex justify-between h-16 items-center">

                <!-- Kiri: Logo + Menu Utama -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/Logo-IAIT.png') }}" alt="Logo IAIT" class="h-10 w-auto">
                        <span class="font-semibold text-lg tracking-wide">SIPANDA</span>
                    </a>

                    <!-- Menu -->
                    <div class="hidden sm:flex space-x-4">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-none">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <!-- Dropdown Master Data -->
                        <div class="relative" x-data="{ openMaster: false }">
                            <button @click="openMaster = !openMaster"
                                class="flex items-center justify-between w-full text-white px-3 py-2 rounded-md font-medium transition-none focus:outline-none">
                                <span>Master Data</span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200"
                                    :class="{ 'rotate-180': openMaster }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="openMaster" @click.away="openMaster = false" x-transition
                                class="absolute left-0 mt-2 w-48 bg-white text-gray-700 rounded-lg shadow-lg z-50 border border-gray-200">
                                <a href="{{ route('fakultas.index') }}"
                                    class="block px-4 py-2 text-sm transition-none">Fakultas</a>
                                <a href="{{ route('prodi.index') }}"
                                    class="block px-4 py-2 text-sm transition-none">Program Studi</a>
                                <a href="{{ route('kategori-arsip.index') }}"
                                    class="block px-4 py-2 text-sm transition-none">Kategori Arsip</a>
                                <a href="{{ route('dosen.index') }}"
                                    class="block px-4 py-2 text-sm transition-none">Dosen</a>
                            </div>
                        </div>

                        <x-nav-link :href="route('arsip.index')" :active="request()->routeIs('arsip.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-none">
                            {{ __('Data Arsip') }}
                        </x-nav-link>

                        <x-nav-link :href="route('sarpras.index')" :active="request()->routeIs('sarpras.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-none">
                            {{ __('Data Sarpras') }}
                        </x-nav-link>

                        <x-nav-link :href="route('tenaga-pendidik.index')" :active="request()->routeIs('tenaga-pendidik.*')"
                            class="text-white px-3 py-2 rounded-md font-medium transition-none">
                            {{ __('Data Tendik') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Kanan: Setting + Profile -->
                <div class="hidden sm:flex items-center space-x-4">
                    <!-- Ikon Setting -->
                    <div class="relative" x-data="{ openSetting: false }">
                        <button @click="openSetting = !openSetting"
                            class="flex items-center justify-center text-white p-2.5 rounded-lg transition-none focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="openSetting" @click.away="openSetting = false" x-transition
                            class="absolute right-0 mt-2 w-56 bg-white text-gray-700 rounded-lg shadow-lg z-50 border border-gray-200">
                            <a href="{{ route('users.index') }}"
                                class="flex items-center px-4 py-2 text-sm transition-none">
                                Pengguna
                            </a>
                            <a href="{{ route('userlogin.index') }}"
                                class="flex items-center px-4 py-2 text-sm transition-none">
                                Laporan Aktivitas User
                            </a>
                        </div>
                    </div>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md transition duration-200 ease-in-out transform hover:scale-105 hover:opacity-90 cursor-pointer">
                        @php
                            $user = Auth::user();
                            $avatar =
                                'https://ui-avatars.com/api/?name=' .
                                urlencode($user->name) .
                                '&background=047857&color=fff';
                        @endphp

                        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : $avatar }}"
                            class="w-8 h-8 rounded-full object-cover border-2 border-white" alt="Foto Profil">

                        <div class="text-left">
                            <h2 class="font-medium text-sm text-white truncate max-w-[120px]">
                                {{ $user->name }}
                            </h2>
                            <p class="text-xs text-green-100 truncate max-w-[120px]">
                                {{ $user->email }}
                            </p>
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

        <!-- Responsive Menu (Mobile) -->
        <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-green-700 text-white">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('fakultas.index')" :active="request()->routeIs('fakultas.*')">
                    {{ __('Fakultas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('prodi.index')" :active="request()->routeIs('prodi.*')">
                    {{ __('Program Studi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kategori-arsip.index')" :active="request()->routeIs('kategori-arsip.*')">
                    {{ __('Kategori Arsip') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dosen.index')" :active="request()->routeIs('dosen.*')">
                    {{ __('Dosen') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('arsip.index')" :active="request()->routeIs('arsip.*')">
                    {{ __('Data Arsip') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sarpras.index')" :active="request()->routeIs('sarpras.*')">
                    {{ __('Data Sarpras') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tenaga-pendidik.index')" :active="request()->routeIs('tenaga-pendidik.*')">
                    {{ __('Data Tendik') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Pengguna') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('userlogin.index')" :active="request()->routeIs('userlogin.*')">
                    {{ __('Laporan Aktivitas User') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </nav>
</div>
