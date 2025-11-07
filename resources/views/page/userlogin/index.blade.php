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
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">🏆 Ranking Pengguna Berdasarkan Total Durasi</h3>
                    
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('userlogin.index') }}" class="flex gap-2">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari nama atau email..." 
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('userlogin.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
                
                <div class="overflow-x-auto">
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
                                <td class="border px-3 py-2 font-medium">{{ $ranking->name }}</td>
                                <td class="border px-3 py-2">{{ $ranking->email }}</td>
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
            </div>
        </div>
    </div>
</x-app-layout>