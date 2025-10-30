<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-xl font-semibold">Data Sarpras</h1>
            <a href="{{ route('sarpras.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Tambah</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2">Nama Barang</th>
                    <th class="border px-3 py-2">Kategori</th>
                    <th class="border px-3 py-2">Jumlah</th>
                    <th class="border px-3 py-2">Kondisi</th>
                    <th class="border px-3 py-2">Prodi</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sarpras as $index => $s)
                    <tr>
                        <td class="border px-3 py-2 text-center">{{ $index + $sarpras->firstItem() }}</td>
                        <td class="border px-3 py-2">{{ $s->nama_barang }}</td>
                        <td class="border px-3 py-2">{{ $s->kategori }}</td>
                        <td class="border px-3 py-2 text-center">{{ $s->jumlah }}</td>
                        <td class="border px-3 py-2 text-center">{{ $s->kondisi }}</td>
                        <td class="border px-3 py-2">{{ $s->prodi->nama_prodi ?? '-' }}</td>
                        <td class="border px-3 py-2 text-center space-x-1">
                            <!-- Tombol Detail -->
                            <a href="{{ route('sarpras.show', $s) }}"
                                class="inline-flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded transition"
                                title="Lihat Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <!-- Tombol Edit -->
                            <a href="{{ route('sarpras.edit', $s) }}"
                                class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded transition"
                                title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('sarpras.destroy', $s) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded transition"
                                    title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $sarpras->links() }}</div>
    </div>
</x-app-layout>
