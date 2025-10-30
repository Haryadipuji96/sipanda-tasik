<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Kategori Arsip</h1>
            <a href="{{ route('kategori-arsip.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Tambah Kategori</a>
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
                    <th class="border px-3 py-2 text-left">Nama Kategori</th>
                    <th class="border px-3 py-2 text-left">Deskripsi</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $index => $k)
                    <tr>
                        <td class="border px-3 py-2">{{ $index + $kategori->firstItem() }}</td>
                        <td class="border px-3 py-2">{{ $k->nama_kategori }}</td>
                        <td class="border px-3 py-2">{{ $k->deskripsi }}</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <a href="{{ route('kategori-arsip.edit', $k->id_kategori) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('kategori-arsip.destroy', $k->id_kategori) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3">Belum ada data kategori arsip.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $kategori->links() }}
        </div>
    </div>
</x-app-layout>
