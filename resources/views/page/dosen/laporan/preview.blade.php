<x-app-layout>
    <x-slot name="title">Preview Laporan Dosen</x-slot>
    
    <div class="p-4 md:p-6 bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
            <h2 class="text-base md:text-lg font-semibold text-gray-700">
                Preview Laporan Dosen
                @if (request('prodi'))
                    <span class="block sm:inline text-sm text-gray-600">({{ request('prodi') }})</span>
                @endif
            </h2>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('dosen.index') }}"
                    class="flex-1 sm:flex-none bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 text-sm text-center">
                    Kembali
                </a>
                <a href="{{ route('dosen.download-all.pdf', request()->query()) }}"
                    class="flex-1 sm:flex-none bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm text-center">
                    Download PDF
                </a>
            </div>
        </div>

        <!-- Info Filter -->
        @if(request()->has('search') || request()->has('prodi') || request()->has('sertifikasi') || request()->has('inpasing'))
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-blue-800 mb-2">Filter yang diterapkan:</h3>
            <div class="flex flex-wrap gap-2">
                @if(request('search'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Pencarian: "{{ request('search') }}"
                </span>
                @endif
                @if(request('prodi'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Prodi: {{ request('prodi') }}
                </span>
                @endif
                @if(request('sertifikasi'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Sertifikasi: {{ request('sertifikasi') }}
                </span>
                @endif
                @if(request('inpasing'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Inpasing: {{ request('inpasing') }}
                </span>
                @endif
            </div>
        </div>
        @endif

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden lg:block overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2">No</th>
                        <th class="border border-gray-300 px-3 py-2">Nama</th>
                        <th class="border border-gray-300 px-3 py-2">Program Studi</th>
                        <th class="border border-gray-300 px-3 py-2">Tempat/Tgl Lahir</th>
                        <th class="border border-gray-300 px-3 py-2">NIDN</th>
                        <th class="border border-gray-300 px-3 py-2">Pendidikan</th>
                        <th class="border border-gray-300 px-3 py-2">Jabatan</th>
                        <th class="border border-gray-300 px-3 py-2">TMT Kerja</th>
                        <th class="border border-gray-300 px-3 py-2">MK Thn</th>
                        <th class="border border-gray-300 px-3 py-2">MK Bln</th>
                        <th class="border border-gray-300 px-3 py-2">Pangkat/Gol</th>
                        <th class="border border-gray-300 px-3 py-2">Sertifikasi</th>
                        <th class="border border-gray-300 px-3 py-2">Inpasing</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosen as $index => $d)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $d->nama }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $d->prodi->nama_prodi ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $d->tempat_tanggal_lahir ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $d->nik ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $d->pendidikan_terakhir ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $d->jabatan ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ $d->tmt_kerja ? \Carbon\Carbon::parse($d->tmt_kerja)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $d->masa_kerja_tahun ?? 0 }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $d->masa_kerja_bulan ?? 0 }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $d->pangkat_golongan ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $d->sertifikasi == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $d->sertifikasi }}
                                </span>
                            </td>
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $d->inpasing == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $d->inpasing }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center py-4 text-gray-500">
                                Tidak ada data dosen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (hidden on desktop) -->
        <div class="lg:hidden space-y-4">
            @forelse ($dosen as $index => $d)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <!-- Header Card -->
                    <div class="flex justify-between items-start mb-3 pb-3 border-b">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex gap-1">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        {{ $d->sertifikasi == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        Sertif: {{ $d->sertifikasi }}
                                    </span>
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        {{ $d->inpasing == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        Inpasing: {{ $d->inpasing }}
                                    </span>
                                </div>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-base">{{ $d->nama }}</h3>
                            @if($d->nik)
                            <p class="text-gray-600 text-sm mt-1">NIDN: {{ $d->nik }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Program Studi</p>
                            <p class="font-medium text-gray-800">{{ $d->prodi->nama_prodi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Tempat/Tgl Lahir</p>
                            <p class="font-medium text-gray-800">{{ $d->tempat_tanggal_lahir ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Pendidikan</p>
                            <p class="font-medium text-gray-800">{{ $d->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Jabatan</p>
                            <p class="font-medium text-gray-800">{{ $d->jabatan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">TMT Kerja</p>
                            <p class="font-medium text-gray-800">
                                {{ $d->tmt_kerja ? \Carbon\Carbon::parse($d->tmt_kerja)->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Masa Kerja</p>
                            <p class="font-medium text-gray-800">{{ $d->masa_kerja_tahun ?? 0 }} Thn {{ $d->masa_kerja_bulan ?? 0 }} Bln</p>
                        </div>
                    </div>

                    <!-- Full Width Details -->
                    @if($d->pangkat_golongan)
                    <div class="mt-3 pt-3 border-t">
                        <p class="text-gray-500 text-xs mb-1">Pangkat/Golongan</p>
                        <p class="font-medium text-gray-800 text-sm">{{ $d->pangkat_golongan }}</p>
                    </div>
                    @endif
                </div>
            @empty
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l9-5-9-5-9 5 9 5zm0 0v10" />
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada data dosen.</p>
                </div>
            @endforelse
        </div>

        <!-- Summary -->
        @if($dosen->count() > 0)
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $dosen->count() }}</p>
                    <p class="text-gray-600">Total Dosen</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $dosen->where('sertifikasi', 'SUDAH')->count() }}</p>
                    <p class="text-gray-600">Sudah Sertifikasi</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $dosen->where('sertifikasi', 'BELUM')->count() }}</p>
                    <p class="text-gray-600">Belum Sertifikasi</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $dosen->where('inpasing', 'SUDAH')->count() }}</p>
                    <p class="text-gray-600">Sudah Inpasing</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>