<x-app-layout>
    <x-slot name="title">Preview Laporan Sarpras</x-slot>
    
    <div class="p-4 md:p-6 bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
            <h2 class="text-base md:text-lg font-semibold text-gray-700">
                Preview Laporan Sarpras 
                @if ($kondisi)
                    <span class="block sm:inline text-sm text-gray-600">({{ $kondisi }})</span>
                @endif
            </h2>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('sarpras.index') }}"
                    class="flex-1 sm:flex-none bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 text-sm text-center">
                    Kembali
                </a>
                <a href="{{ route('sarpras.laporan.pdf', ['kondisi' => $kondisi]) }}"
                    class="flex-1 sm:flex-none bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm text-center">
                    Download PDF
                </a>
            </div>
        </div>

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden lg:block overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border border-gray-300 px-3 py-2">No</th>
                        <th class="border border-gray-300 px-3 py-2">Nama Barang</th>
                        <th class="border border-gray-300 px-3 py-2">Prodi</th>
                        <th class="border border-gray-300 px-3 py-2">Kategori</th>
                        <th class="border border-gray-300 px-3 py-2">Jumlah</th>
                        <th class="border border-gray-300 px-3 py-2">Kondisi</th>
                        <th class="border border-gray-300 px-3 py-2">Tgl Pengadaan</th>
                        <th class="border border-gray-300 px-3 py-2">Kode/Seri</th>
                        <th class="border border-gray-300 px-3 py-2">Sumber</th>
                        <th class="border border-gray-300 px-3 py-2">Lokasi Lain</th>
                        <th class="border border-gray-300 px-3 py-2">Spesifikasi</th>
                        <th class="border border-gray-300 px-3 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sarpras as $index => $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->nama_barang }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->prodi->nama_prodi ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->kategori }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $item->jumlah }}</td>
                            <td class="border border-gray-300 px-3 py-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $item->kondisi == 'Baik' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $item->kondisi == 'Rusak Ringan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $item->kondisi == 'Rusak Berat' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') }}
                            </td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->kode_seri }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->sumber }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->lokasi_lain ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->spesifikasi }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4 text-gray-500">
                                Tidak ada data untuk kondisi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (hidden on desktop) -->
        <div class="lg:hidden space-y-4">
            @forelse ($sarpras as $index => $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <!-- Header Card -->
                    <div class="flex justify-between items-start mb-3 pb-3 border-b">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $index + 1 }}
                                </span>
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $item->kondisi == 'Baik' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $item->kondisi == 'Rusak Ringan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $item->kondisi == 'Rusak Berat' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $item->kondisi }}
                                </span>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-base">{{ $item->nama_barang }}</h3>
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Program Studi</p>
                            <p class="font-medium text-gray-800">{{ $item->prodi->nama_prodi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Kategori</p>
                            <p class="font-medium text-gray-800">{{ $item->kategori }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Jumlah</p>
                            <p class="font-medium text-gray-800">{{ $item->jumlah }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Tanggal Pengadaan</p>
                            <p class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Kode/Seri</p>
                            <p class="font-medium text-gray-800">{{ $item->kode_seri }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Sumber</p>
                            <p class="font-medium text-gray-800">{{ $item->sumber }}</p>
                        </div>
                    </div>

                    <!-- Full Width Details -->
                    @if($item->lokasi_lain)
                    <div class="mt-3 pt-3 border-t">
                        <p class="text-gray-500 text-xs mb-1">Lokasi Lain</p>
                        <p class="font-medium text-gray-800 text-sm">{{ $item->lokasi_lain }}</p>
                    </div>
                    @endif

                    <div class="mt-3 pt-3 border-t">
                        <p class="text-gray-500 text-xs mb-1">Spesifikasi</p>
                        <p class="font-medium text-gray-800 text-sm">{{ $item->spesifikasi }}</p>
                    </div>

                    @if($item->keterangan)
                    <div class="mt-3 pt-3 border-t">
                        <p class="text-gray-500 text-xs mb-1">Keterangan</p>
                        <p class="font-medium text-gray-800 text-sm">{{ $item->keterangan }}</p>
                    </div>
                    @endif
                </div>
            @empty
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada data untuk kondisi ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>