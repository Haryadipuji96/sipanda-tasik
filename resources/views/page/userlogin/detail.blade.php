<x-app-layout>
    <x-slot name="title">Detail History - {{ $user->name }}</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail History Login') }} - {{ $user->name }}
            </h2>
            <a href="{{ route('userlogin.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- User Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Role</p>
                        <p class="text-lg font-semibold text-gray-800 capitalize">{{ $user->role }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Total Login</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $stats['total_login'] }}x</p>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Total Durasi</p>
                        <p class="text-xl font-bold text-indigo-600">{{ $stats['formatted_duration'] }}</p>
                    </div>
                    <div class="bg-pink-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Total Jam</p>
                        <p class="text-xl font-bold text-pink-600">{{ $stats['total_hours'] }} jam</p>
                    </div>
                </div>
            </div>

            <!-- History Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">📋 Riwayat Login/Logout</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-3 py-2">No</th>
                                <th class="border px-3 py-2">Waktu Login</th>
                                <th class="border px-3 py-2">Waktu Logout</th>
                                <th class="border px-3 py-2">Durasi</th>
                                <th class="border px-3 py-2">IP Address</th>
                                <th class="border px-3 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories as $index => $history)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-3 py-2 text-center">
                                    {{ ($histories->currentPage() - 1) * $histories->perPage() + $index + 1 }}
                                </td>
                                <td class="border px-3 py-2">
                                    {{ $history->logged_in_at ? $history->logged_in_at->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td class="border px-3 py-2">
                                    @if($history->logged_out_at)
                                        <span class="text-green-600">{{ $history->logged_out_at->format('d/m/Y H:i:s') }}</span>
                                    @else
                                        <span class="text-yellow-600 font-semibold">-</span>
                                    @endif
                                </td>
                                <td class="border px-3 py-2 font-medium">
                                    {{ $history->getFormattedDuration() }}
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $history->ip_address ?? '-' }}</code>
                                </td>
                                <td class="border px-3 py-2 text-center">
                                    @if($history->logged_out_at)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                            ✓ Selesai
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                            ⚡ Masih Login
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="border px-3 py-2 text-center text-gray-500">
                                    Belum ada riwayat login
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($histories->hasPages())
                <div class="mt-4">
                    {{ $histories->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>