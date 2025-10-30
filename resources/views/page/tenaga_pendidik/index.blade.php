<x-app-layout>
<div class="py-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Data Tenaga Pendidik</h2>
        <a href="{{ route('tenaga-pendidik.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">No</th>
                <th class="border px-3 py-2">Nama</th>
                <th class="border px-3 py-2">Prodi</th>
                <th class="border px-3 py-2">Jabatan</th>
                <th class="border px-3 py-2">Status</th>
                <th class="border px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tenaga as $no => $t)
            <tr>
                <td class="border px-3 py-2 text-center">{{ $no+1 }}</td>
                <td class="border px-3 py-2">{{ $t->nama_tendik }}</td>
                <td class="border px-3 py-2">{{ $t->prodi->nama_prodi ?? '-' }}</td>
                <td class="border px-3 py-2">{{ $t->jabatan }}</td>
                <td class="border px-3 py-2">{{ $t->status_kepegawaian }}</td>
                <td class="border px-3 py-2 text-center space-x-1">
                    <a href="{{ route('tenaga-pendidik.show',$t->id_tenaga_pendidik) }}" class="bg-gray-600 text-white px-2 py-1 rounded">👁️</a>
                    <a href="{{ route('tenaga-pendidik.edit',$t->id_tenaga_pendidik) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">✏️</a>
                    <form action="{{ route('tenaga-pendidik.destroy',$t->id_tenaga_pendidik) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>
