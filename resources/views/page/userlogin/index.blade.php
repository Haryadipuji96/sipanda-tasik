<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

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
                            <td class="border px-3 py-2">{{ $login->user->role ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $login->ip_address ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $login->logged_in_at ? $login->logged_in_at->format('d/m/Y H:i:s') : '-' }}</td>
                            <td class="border px-3 py-2">{{ $login->logged_out_at ? $login->logged_out_at->format('d/m/Y H:i:s') : 'Masih Login' }}</td>
                            <td class="border px-3 py-2">
                                @if($login->logged_in_at)
                                    @php
                                        $end = $login->logged_out_at ?? now();
                                        $diff = $login->logged_in_at->diff($end);
                                    @endphp
                                    {{ $diff->h }} jam {{ $diff->i }} menit {{ $diff->s }} detik
                                @else
                                    -
                                @endif
                            </td>
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

                @if($logins->hasPages())
                <div class="mt-4">
                    {{ $logins->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
