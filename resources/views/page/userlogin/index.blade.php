<x-app-layout>
    <x-slot name="title">Log aktivitas</x-slot>
    <style>
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
        }
        .rank-1 { background: linear-gradient(135deg, #FFD700, #FFA500); color: white; }
        .rank-2 { background: linear-gradient(135deg, #C0C0C0, #808080); color: white; }
        .rank-3 { background: linear-gradient(135deg, #CD7F32, #8B4513); color: white; }
        .rank-other { background: linear-gradient(135deg, #4A5568, #2D3748); color: white; }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-online {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .status-offline {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .dot-online {
            background-color: #10B981;
            animation: pulse 2s infinite;
        }
        .dot-offline {
            background-color: #EF4444;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Highlight untuk hasil pencarian */
        .highlight {
            background-color: #FEF3C7;
            color: #92400E;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 600;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .table-container {
                font-size: 12px;
            }
            
            .mobile-hidden {
                display: none;
            }
            
            .mobile-text-sm {
                font-size: 11px;
            }
            
            .mobile-p-2 {
                padding: 8px 4px;
            }
            
            .mobile-flex-col {
                flex-direction: column;
            }
            
            .mobile-gap-1 {
                gap: 4px;
            }
            
            .mobile-w-full {
                width: 100%;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Ranking Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 mb-4">
                    <h3 class="text-lg font-semibold">🏆 Ranking Pengguna Berdasarkan Total Durasi</h3>
                    
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('userlogin.index') }}" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari nama atau email..." 
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                        >
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 w-full sm:w-auto">
                                Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('userlogin.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 w-full sm:w-auto text-center">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Info Filter -->
                @if(request()->has('search'))
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-yellow-800 mb-2">Filter yang diterapkan:</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                            Pencarian: "{{ request('search') }}"
                        </span>
                    </div>
                </div>
                @endif
                
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-blue-500 text-white">
                                <th class="border px-3 py-2">Rank</th>
                                <th class="border px-3 py-2">Nama User</th>
                                <th class="border px-3 py-2">Email</th>
                                <th class="border px-3 py-2">Role</th>
                                <th class="border px-3 py-2">Total Login</th>
                                <th class="border px-3 py-2">Total Durasi</th>
                                <th class="border px-3 py-2">Total Jam</th>
                                <th class="border px-3 py-2">Status Aktivitas</th>
                                <th class="border px-3 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rankings as $ranking)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-3 py-2 text-center">
                                    <span class="rank-badge {{ $ranking->rank <= 3 ? 'rank-'.$ranking->rank : 'rank-other' }}">
                                        {{ $ranking->rank }}
                                    </span>
                                </td>
                                <td class="border px-3 py-2 font-medium">
                                    @if(request('search') && stripos($ranking->name, request('search')) !== false)
                                        {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="highlight">$1</span>', $ranking->name) !!}
                                    @else
                                        {{ $ranking->name }}
                                    @endif
                                </td>
                                <td class="border px-3 py-2">
                                    @if(request('search') && stripos($ranking->email, request('search')) !== false)
                                        {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="highlight">$1</span>', $ranking->email) !!}
                                    @else
                                        {{ $ranking->email }}
                                    @endif
                                </td>
                                <td class="border px-3 py-2 capitalize">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $ranking->role == 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $ranking->role }}
                                    </span>
                                </td>
                                <td class="border px-3 py-2 text-center">{{ $ranking->total_login }}x</td>
                                <td class="border px-3 py-2">{{ $ranking->formatted_duration }}</td>
                                <td class="border px-3 py-2 text-center font-semibold text-blue-600">{{ $ranking->total_hours }} jam</td>
                                <td class="border px-3 py-2 text-center">
                                    @if($ranking->status === 'online')
                                        <span class="status-badge status-online">
                                            <span class="status-dot dot-online"></span>
                                            Online
                                        </span>
                                    @else
                                        <span class="status-badge status-offline">
                                            <span class="status-dot dot-offline"></span>
                                            Offline
                                        </span>
                                    @endif
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    <a href="{{ route('userlogin.detail', $ranking->id) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                        📋 Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="border px-3 py-2 text-center text-gray-500">
                                    @if(request('search'))
                                        Tidak ada data yang sesuai dengan pencarian "{{ request('search') }}"
                                    @else
                                        Belum ada data aktivitas
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-4">
                    @forelse($rankings as $ranking)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-3 pb-3 border-b">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="rank-badge {{ $ranking->rank <= 3 ? 'rank-'.$ranking->rank : 'rank-other' }}">
                                        {{ $ranking->rank }}
                                    </span>
                                    @if($ranking->status === 'online')
                                        <span class="status-badge status-online">
                                            <span class="status-dot dot-online"></span>
                                            Online
                                        </span>
                                    @else
                                        <span class="status-badge status-offline">
                                            <span class="status-dot dot-offline"></span>
                                            Offline
                                        </span>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-gray-800 text-base">
                                    @if(request('search') && stripos($ranking->name, request('search')) !== false)
                                        {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="highlight">$1</span>', $ranking->name) !!}
                                    @else
                                        {{ $ranking->name }}
                                    @endif
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    @if(request('search') && stripos($ranking->email, request('search')) !== false)
                                        {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="highlight">$1</span>', $ranking->email) !!}
                                    @else
                                        {{ $ranking->email }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-500 text-xs mb-1">Role</p>
                                <p class="font-medium text-gray-800 capitalize">{{ $ranking->role }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs mb-1">Total Login</p>
                                <p class="font-medium text-gray-800">{{ $ranking->total_login }}x</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs mb-1">Total Jam</p>
                                <p class="font-medium text-gray-800 text-blue-600">{{ $ranking->total_hours }} jam</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs mb-1">Total Durasi</p>
                                <p class="font-medium text-gray-800 text-sm">{{ $ranking->formatted_duration }}</p>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-4 pt-3 border-t">
                            <a href="{{ route('userlogin.detail', $ranking->id) }}" 
                               class="inline-flex items-center justify-center w-full px-3 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                📋 Lihat Detail Aktivitas
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">
                            @if(request('search'))
                                Tidak ada data yang sesuai dengan pencarian "{{ request('search') }}"
                            @else
                                Belum ada data aktivitas
                            @endif
                        </p>
                    </div>
                    @endforelse
                </div>

                <!-- Summary -->
                @if($rankings->count() > 0)
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $rankings->count() }}</p>
                            <p class="text-gray-600">Total User</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $rankings->where('status', 'online')->count() }}</p>
                            <p class="text-gray-600">Online</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-red-600">{{ $rankings->where('status', 'offline')->count() }}</p>
                            <p class="text-gray-600">Offline</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-purple-600">{{ $rankings->where('role', 'admin')->count() }}</p>
                            <p class="text-gray-600">Admin</p>
                        </div>
                    </div>
                    
                    @if(request('search'))
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-yellow-700">
                            Menampilkan <strong>{{ $rankings->count() }}</strong> hasil pencarian untuk "<strong>{{ request('search') }}</strong>"
                        </p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>