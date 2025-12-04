<x-app-layout>
    <x-slot name="title">Preview Laporan Tenaga Pendidik</x-slot>

    <div class="p-4 md:p-6 bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
            <h2 class="text-base md:text-lg font-semibold text-gray-700">
                Preview Laporan Tenaga Pendidik
                @if (request('status_kepegawaian'))
                    <span class="block sm:inline text-sm text-gray-600">
                        ({{ ucfirst(request('status_kepegawaian')) }})
                    </span>
                @endif
            </h2>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('tenaga-pendidik.download-all.pdf', request()->query()) }}"
                    class="flex-1 sm:flex-none bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm text-center">
                    Download PDF
                </a>
                <a href="{{ route('tenaga-pendidik.index') }}"
                    class="flex-1 sm:flex-none bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 text-sm text-center">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Info Filter -->
        @if (request()->has('search') || request()->has('status_kepegawaian') || request()->has('id_prodi'))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">Filter yang diterapkan:</h3>
                <div class="flex flex-wrap gap-2">
                    @if (request('search'))
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Pencarian: "{{ request('search') }}"
                        </span>
                    @endif
                    @if (request('status_kepegawaian'))
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            Status: {{ ucfirst(request('status_kepegawaian')) }}
                        </span>
                    @endif
                    @if (request('id_prodi'))
                        @php
                            $selectedProdi = $prodi->where('id', request('id_prodi'))->first();
                        @endphp
                        @if ($selectedProdi)
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                Prodi: {{ $selectedProdi->nama_prodi }}
                            </span>
                        @endif
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
                        <th class="border border-gray-300 px-3 py-2">Nama Lengkap</th>
                        <th class="border border-gray-300 px-3 py-2">Posisi/Jabatan</th>
                        <th class="border border-gray-300 px-3 py-2">NIP</th>
                        <th class="border border-gray-300 px-3 py-2">Prodi</th>
                        <th class="border border-gray-300 px-3 py-2">Status Kepegawaian</th>
                        <th class="border border-gray-300 px-3 py-2">Jenis Kelamin</th>
                        <th class="border border-gray-300 px-3 py-2">Pendidikan Terakhir</th>
                        <th class="border border-gray-300 px-3 py-2">TMT Kerja</th>
                        <th class="border border-gray-300 px-3 py-2">Masa Kerja</th>
                        <th class="border border-gray-300 px-3 py-2">Masa Kerja Gol</th>
                        <th class="border border-gray-300 px-3 py-2">Gol</th>
                        <th class="border border-gray-300 px-3 py-2">KNP YAD</th>
                        <th class="border border-gray-300 px-3 py-2">Email</th>
                        <th class="border border-gray-300 px-3 py-2">No HP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenaga as $index => $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ $item->gelar_depan ? $item->gelar_depan . ' ' : '' }}
                                {{ $item->nama_tendik }}
                                {{ $item->gelar_belakang ? ', ' . $item->gelar_belakang : '' }}
                            </td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->jabatan_struktural ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->nip ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->prodi->nama_prodi ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $item->status_kepegawaian == 'TETAP' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $item->status_kepegawaian == 'KONTRAK' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    @if ($item->status_kepegawaian == 'TETAP')
                                        TETAP
                                    @elseif($item->status_kepegawaian == 'KONTRAK')
                                        KONTRAK
                                    @else
                                        {{ $item->status_kepegawaian }}
                                    @endif
                                </span>
                            </td>
                            <td class="border border-gray-300 px-3 py-2 capitalize">{{ $item->jenis_kelamin }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->pendidikan_terakhir ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ $item->tmt_kerja ? \Carbon\Carbon::parse($item->tmt_kerja)->format('d/m/Y') : '-' }}
                            </td>
                            <!-- Masa Kerja -->
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                @if($item->masa_kerja_tahun || $item->masa_kerja_bulan)
                                    <span class="font-medium">
                                        {{ $item->masa_kerja_tahun ?? '0' }}T {{ $item->masa_kerja_bulan ?? '0' }}B
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <!-- Masa Kerja Golongan -->
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                @if($item->masa_kerja_golongan_tahun || $item->masa_kerja_golongan_bulan)
                                    <span class="font-medium">
                                        {{ $item->masa_kerja_golongan_tahun ?? '0' }}T {{ $item->masa_kerja_golongan_bulan ?? '0' }}B
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <!-- Golongan (Gol) -->
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                @if($item->gol)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                        {{ $item->gol }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <!-- KNP YAD -->
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                {{ $item->knp_yad ? \Carbon\Carbon::parse($item->knp_yad)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->email ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->no_hp ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center py-4 text-gray-500">
                                Tidak ada data tenaga pendidik.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (hidden on desktop) -->
        <div class="lg:hidden space-y-4">
            @forelse ($tenaga as $index => $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <!-- Header Card -->
                    <div class="flex justify-between items-start mb-3 pb-3 border-b">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $index + 1 }}
                                </span>
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $item->status_kepegawaian == 'TETAP' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $item->status_kepegawaian == 'KONTRAK' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    @if ($item->status_kepegawaian == 'TETAP')
                                        TETAP
                                    @elseif($item->status_kepegawaian == 'KONTRAK')
                                        KONTRAK
                                    @else
                                        {{ $item->status_kepegawaian }}
                                    @endif
                                </span>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-base">
                                {{ $item->gelar_depan ? $item->gelar_depan . ' ' : '' }}
                                {{ $item->nama_tendik }}
                                {{ $item->gelar_belakang ? ', ' . $item->gelar_belakang : '' }}
                            </h3>
                            @if ($item->nip)
                                <p class="text-gray-600 text-sm mt-1">NIP: {{ $item->nip }}</p>
                            @endif
                            @if ($item->jabatan_struktural)
                                <p class="text-gray-600 text-sm mt-1">Posisi: {{ $item->jabatan_struktural }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Program Studi</p>
                            <p class="font-medium text-gray-800">{{ $item->prodi->nama_prodi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Jenis Kelamin</p>
                            <p class="font-medium text-gray-800 capitalize">{{ $item->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Pendidikan Terakhir</p>
                            <p class="font-medium text-gray-800">{{ $item->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">TMT Kerja</p>
                            <p class="font-medium text-gray-800">
                                {{ $item->tmt_kerja ? \Carbon\Carbon::parse($item->tmt_kerja)->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        
                        <!-- Masa Kerja -->
                        @if($item->masa_kerja_tahun || $item->masa_kerja_bulan)
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Masa Kerja</p>
                            <p class="font-medium text-blue-600">
                                {{ $item->masa_kerja_tahun ?? '0' }}T {{ $item->masa_kerja_bulan ?? '0' }}B
                            </p>
                        </div>
                        @endif
                        
                        <!-- Masa Kerja Golongan -->
                        @if($item->masa_kerja_golongan_tahun || $item->masa_kerja_golongan_bulan)
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Masa Kerja Gol</p>
                            <p class="font-medium text-purple-600">
                                {{ $item->masa_kerja_golongan_tahun ?? '0' }}T {{ $item->masa_kerja_golongan_bulan ?? '0' }}B
                            </p>
                        </div>
                        @endif
                        
                        <!-- Golongan (Gol) -->
                        @if($item->gol)
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Golongan (Gol)</p>
                            <p class="font-medium text-green-600">{{ $item->gol }}</p>
                        </div>
                        @endif
                        
                        <!-- KNP YAD -->
                        @if($item->knp_yad)
                        <div>
                            <p class="text-gray-500 text-xs mb-1">KNP YAD</p>
                            <p class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($item->knp_yad)->format('d/m/Y') }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Full Width Details -->
                    @if ($item->email)
                        <div class="mt-3 pt-3 border-t">
                            <p class="text-gray-500 text-xs mb-1">Email</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $item->email }}</p>
                        </div>
                    @endif

                    @if ($item->no_hp)
                        <div class="mt-3 pt-3 border-t">
                            <p class="text-gray-500 text-xs mb-1">No HP</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $item->no_hp }}</p>
                        </div>
                    @endif

                    @if ($item->alamat)
                        <div class="mt-3 pt-3 border-t">
                            <p class="text-gray-500 text-xs mb-1">Alamat</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $item->alamat }}</p>
                        </div>
                    @endif

                    @if ($item->keterangan)
                        <div class="mt-3 pt-3 border-t">
                            <p class="text-gray-500 text-xs mb-1">Keterangan</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $item->keterangan }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada data tenaga pendidik.</p>
                </div>
            @endforelse
        </div>

        <!-- Summary -->
        @if ($tenaga->count() > 0)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ $tenaga->count() }}</p>
                        <p class="text-gray-600">Total Tenaga</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-600">
                            {{ $tenaga->where('status_kepegawaian', 'TETAP')->count() }}</p>
                        <p class="text-gray-600">TETAP</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $tenaga->where('status_kepegawaian', 'KONTRAK')->count() }}</p>
                        <p class="text-gray-600">KONTRAK</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>