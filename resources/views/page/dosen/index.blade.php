<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Dosen</h1>
            <a href="{{ route('dosen.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
               Tambah Dosen
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border text-sm">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th rowspan="2" class="px-4 py-2 border text-center w-12">No</th>
                    <th rowspan="2" class="border px-4 py-2">Nama</th>
                    <th rowspan="2" class="border px-4 py-2">Prodi</th>
                    <th rowspan="2" class="border px-4 py-2">Tempat Lahir</th>
                    <th rowspan="2" class="border px-4 py-2">NIK</th>
                    <th rowspan="2" class="border px-4 py-2">Pendidikan Terakhir</th>
                    <th rowspan="2" class="border px-4 py-2">Jabatan</th>
                    <th rowspan="2" class="border px-4 py-2">TMT Kerja</th>
                    <th colspan="2" class="border px-4 py-2 text-center">Masa Kerja</th>
                    <th rowspan="2" class="border px-4 py-2 text-center">Golongan</th>
                    <th colspan="2" class="border px-4 py-2 text-center">Masa Kerja Golongan</th>
                    <th rowspan="2" class="border px-4 py-2 text-center">File Dokumen</th>
                    <th rowspan="2" class="border px-4 py-2 text-center">Aksi</th>
                </tr>
                <tr>
                    <th class="border px-2 py-1">Thn</th>
                    <th class="border px-2 py-1">Bln</th>
                    <th class="border px-2 py-1">Thn</th>
                    <th class="border px-2 py-1">Bln</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosen as $index => $d)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 text-center">{{ $index + $dosen->firstItem() }}</td>
                        <td class="border px-4 py-2">{{ $d->nama ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $d->prodi->nama_prodi ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $d->tempat_lahir ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $d->nik ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $d->pendidikan_terakhir ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $d->jabatan ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $d->tmt_kerja ?? '-' }}</td>

                        <!-- Masa Kerja -->
                        <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_tahun ?? 0 }}</td>
                        <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_bulan ?? 0 }}</td>

                        <!-- Golongan -->
                        <td class="border px-4 py-2 text-center">{{ $d->golongan ?? '-' }}</td>

                        <!-- Masa Kerja Golongan -->
                        <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_golongan_tahun ?? 0 }}</td>
                        <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_golongan_bulan ?? 0 }}</td>

                        <!-- File Dokumen -->
                        <td class="border px-3 py-2 text-center">
                            @if ($d->file_dokumen)
                                <a href="{{ asset('storage/dokumen_dosen/' . $d->file_dokumen) }}"
                                   target="_blank"
                                   class="text-blue-600 underline">Lihat</a>
                            @else
                                <span class="text-gray-500 italic">-</span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="border px-3 py-2 text-center space-x-2">
                            <a href="{{ route('dosen.edit', $d->id_dosen) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                               Edit
                            </a>
                            <form action="{{ route('dosen.destroy', $d->id_dosen) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Yakin hapus data ini?')">
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
                        <td colspan="14" class="text-center py-3 text-gray-600">Belum ada data dosen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $dosen->links() }}
        </div>
    </div>
</x-app-layout>
