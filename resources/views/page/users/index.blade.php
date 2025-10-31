<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Pengguna</h1>
            <a href="{{ route('users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Tambah Pengguna</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="border px-3 py-2 text-left">No</th>
                    <th class="border px-3 py-2 text-left">Nama</th>
                    <th class="border px-3 py-2 text-left">Email</th>
                    <th class="border px-3 py-2 text-left">Role</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $u)
                    <tr>
                        <td class="border px-3 py-2">{{ $index + $users->firstItem() }}</td>
                        <td class="border px-3 py-2">{{ $u->name }}</td>
                        <td class="border px-3 py-2">{{ $u->email }}</td>
                        <td class="border px-3 py-2 capitalize">{{ $u->role }}</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <a href="{{ route('users.edit', $u->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
