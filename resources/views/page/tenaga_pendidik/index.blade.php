<x-app-layout>
    <div class="py-10 px-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">📚 Data Tenaga Pendidik</h2>
            <a href="{{ route('tenaga-pendidik.create') }}" 
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition">
                + Tambah Data
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-5 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm text-gray-700">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-3 border text-center w-16">No</th>
                            <th class="px-4 py-3 border text-left w-64">Nama</th>
                            <th class="px-4 py-3 border text-left w-56">Program Studi</th>
                            <th class="px-4 py-3 border text-left w-48">Jabatan</th>
                            <th class="px-4 py-3 border text-center w-44">Status</th>
                            <th class="px-4 py-3 border text-center w-40">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($tenaga as $no => $t)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="border px-4 py-2 text-center font-medium">{{ $no+1 }}</td>
                                <td class="border px-4 py-2">{{ $t->nama_tendik }}</td>
                                <td class="border px-4 py-2">{{ $t->prodi->nama_prodi ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $t->jabatan }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $t->status_kepegawaian === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $t->status_kepegawaian }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('tenaga-pendidik.show', $t->id_tenaga_pendidik) }}" 
                                           class="bg-gray-600 hover:bg-gray-700 text-white p-2 rounded-md" 
                                           title="Lihat Detail">👁️</a>

                                        <a href="{{ route('tenaga-pendidik.edit', $t->id_tenaga_pendidik) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-md" 
                                           title="Edit Data">✏️</a>

                                        <form action="{{ route('tenaga-pendidik.destroy', $t->id_tenaga_pendidik) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-md" 
                                                    title="Hapus Data">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500 italic">
                                    Belum ada data tenaga pendidik.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
