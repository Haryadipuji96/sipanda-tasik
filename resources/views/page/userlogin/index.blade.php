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
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Ranking Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">🏆 Ranking Pengguna Berdasarkan Total Durasi</h3>
                
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="border px-3 py-2 text-center text-gray-500">
                                    Belum ada data aktivitas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- History Login Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">📋 History Login/Logout</h3>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-3 py-2">No</th>
                                <th class="border px-3 py-2">Nama User</th>
                                <th class="border px-3 py-2">Email</th>
                                <th class="border px-3 py-2">Role</th>
                                <th class="border px-3 py-2">IP Address</th>
                                <th class="border px-3 py-2">Login</th>
                                <th class="border px-3 py-2">Logout</th>
                                <th class="border px-3 py-2">Durasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logins as $index => $login)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-3 py-2 text-center">{{ ($logins->currentPage() - 1) * $logins->perPage() + $index + 1 }}</td>
                                <td class="border px-3 py-2">{{ $login->user->name ?? 'User Tidak Ditemukan' }}</td>
                                <td class="border px-3 py-2">{{ $login->user->email ?? '-' }}</td>
                                <td class="border px-3 py-2 capitalize">{{ $login->user->role ?? '-' }}</td>
                                <td class="border px-3 py-2">{{ $login->ip_address ?? '-' }}</td>
                                <td class="border px-3 py-2">{{ $login->logged_in_at ? $login->logged_in_at->format('d/m/Y H:i:s') : '-' }}</td>
                                <td class="border px-3 py-2">
                                    @if($login->logged_out_at)
                                        <span class="text-green-600">{{ $login->logged_out_at->format('d/m/Y H:i:s') }}</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                            ⚡ Masih Login
                                        </span>
                                    @endif
                                </td>
                                <td class="border px-3 py-2">{{ $login->getFormattedDuration() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="border px-3 py-2 text-center text-gray-500">
                                    Belum ada data aktivitas login
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logins->hasPages())
                <div class="mt-4">
                    {{ $logins->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>