<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Program Studi</h1>
            <a href="{{ route('prodi.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Tambah Prodi</a>
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
                    <th class="border px-3 py-2 text-left">Nama Prodi</th>
                    <th class="border px-3 py-2 text-left">Fakultas</th>
                    <th class="border px-3 py-2 text-left">Jenjang</th>
                    <th class="border px-3 py-2 text-left">Deskripsi</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prodi as $index => $p)
                    <tr>
                        <td class="border px-3 py-2">{{ $index + $prodi->firstItem() }}</td>
                        <td class="border px-3 py-2">{{ $p->nama_prodi }}</td>
                        <td class="border px-3 py-2">{{ $p->fakultas->nama_fakultas ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $p->jenjang }}</td>
                        <td class="border px-3 py-2">{{ $p->deskripsi }}</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <a href="{{ route('prodi.edit', $p->id_prodi) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                            <form action="{{ route('prodi.destroy', $p->id_prodi) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">Belum ada data program studi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $prodi->links() }}
        </div>
    </div>
</x-app-layout>
