<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Fakultas</h1>
            <a href="{{ route('fakultas.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Tambah Fakultas</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">No</th>
                    <th class="border px-3 py-2 text-left">Nama Fakultas</th>
                    <th class="border px-3 py-2 text-left">Dekan</th>
                    <th class="border px-3 py-2 text-left">Deskripsi</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fakultas as $index => $f)
                    <tr>
                        <td class="border px-3 py-2">{{ $index + $fakultas->firstItem() }}</td>
                        <td class="border px-3 py-2">{{ $f->nama_fakultas }}</td>
                        <td class="border px-3 py-2">{{ $f->dekan }}</td>
                        <td class="border px-3 py-2">{{ $f->deskripsi }}</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <a href="{{ route('fakultas.edit', $f->id_fakultas) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('fakultas.destroy', $f->id_fakultas) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3">Belum ada data fakultas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $fakultas->links() }}
        </div>
    </div>
</x-app-layout>
