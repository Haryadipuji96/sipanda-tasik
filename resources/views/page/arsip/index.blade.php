<x-app-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Arsip</h1>
            <a href="{{ route('arsip.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
               Tambah Arsip
            </a>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Arsip -->
        <table class="w-full border text-sm">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="border px-3 py-2 text-center w-12">No</th>
                    <th class="border px-3 py-2 text-left">Judul Dokumen</th>
                    <th class="border px-3 py-2 text-left">Nomor Dokumen</th>
                    <th class="border px-3 py-2 text-left">Tanggal</th>
                    <th class="border px-3 py-2 text-left">Tahun</th>
                    <th class="border px-3 py-2 text-left">Kategori</th>
                    <th class="border px-3 py-2 text-left">Program Studi</th>
                    <th class="border px-3 py-2 text-left">Dosen</th>
                    <th class="border px-3 py-2 text-left">Keterangan</th>
                    <th class="border px-3 py-2 text-center">File</th>
                    <th class="border px-3 py-2 text-center w-32">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($arsip as $index => $a)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">{{ $index + $arsip->firstItem() }}</td>
                        <td class="border px-3 py-2">{{ $a->judul_dokumen ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $a->nomor_dokumen ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $a->tanggal_dokumen ? \Carbon\Carbon::parse($a->tanggal_dokumen)->format('d-m-Y') : '-' }}</td>
                        <td class="border px-3 py-2 text-center">{{ $a->tahun ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $a->kategori->nama_kategori ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $a->prodi->nama_prodi ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $a->dosen->nama ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $a->keterangan ?? '-' }}</td>

                        <!-- File Dokumen -->
                        <td class="border px-3 py-2 text-center">
                            @if ($a->file_dokumen)
                                <a href="{{ asset('storage/arsip/' . $a->file_dokumen) }}" target="_blank"
                                   class="text-blue-600 underline">Lihat</a>
                            @else
                                <span class="text-gray-500 italic">-</span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="border px-3 py-2 text-center space-x-2">
                            <a href="{{ route('arsip.edit', $a->id_arsip) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>

                            <form action="{{ route('arsip.destroy', $a->id_arsip) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-3 text-gray-600">Belum ada data arsip.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $arsip->links() }}
        </div>
    </div>
</x-app-layout>
