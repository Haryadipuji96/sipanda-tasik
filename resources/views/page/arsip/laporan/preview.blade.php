<x-app-layout>
    <x-slot name="title">Preview Laporan Arsip</x-slot>
    
    <div class="p-4 md:p-6 bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
            <h2 class="text-base md:text-lg font-semibold text-gray-700">
                Preview Laporan Arsip Dokumen
                @if (request('kategori'))
                    <span class="block sm:inline text-sm text-gray-600">({{ request('kategori') }})</span>
                @endif
            </h2>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="{{ route('arsip.index') }}"
                    class="flex-1 sm:flex-none bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 text-sm text-center">
                    Kembali
                </a>
                <a href="{{ route('arsip.download-all.pdf', request()->query()) }}"
                    class="flex-1 sm:flex-none bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm text-center">
                    Download PDF
                </a>
            </div>
        </div>

        <!-- Info Filter -->
        @if(request()->has('search') || request()->has('kategori') || request()->has('prodi') || request()->has('tahun'))
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-blue-800 mb-2">Filter yang diterapkan:</h3>
            <div class="flex flex-wrap gap-2">
                @if(request('search'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Pencarian: "{{ request('search') }}"
                </span>
                @endif
                @if(request('kategori'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Kategori: {{ request('kategori') }}
                </span>
                @endif
                @if(request('prodi'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Prodi: {{ request('prodi') }}
                </span>
                @endif
                @if(request('tahun'))
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                    Tahun: {{ request('tahun') }}
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
                        <th class="border border-gray-300 px-3 py-2">Judul Dokumen</th>
                        <th class="border border-gray-300 px-3 py-2">Nomor Dokumen</th>
                        <th class="border border-gray-300 px-3 py-2">Tanggal</th>
                        <th class="border border-gray-300 px-3 py-2">Tahun</th>
                        <th class="border border-gray-300 px-3 py-2">Kategori</th>
                        <th class="border border-gray-300 px-3 py-2">Program Studi</th>
                        <th class="border border-gray-300 px-3 py-2">Keterangan</th>
                        <th class="border border-gray-300 px-3 py-2">File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($arsip as $index => $a)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $a->judul_dokumen }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $a->nomor_dokumen ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                {{ $a->tanggal_dokumen ? \Carbon\Carbon::parse($a->tanggal_dokumen)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="border border-gray-300 px-3 py-2 text-center">{{ $a->tahun ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $a->kategori->nama_kategori ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $a->prodi->nama_prodi ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">{{ $a->keterangan ?? '-' }}</td>
                            <td class="border border-gray-300 px-3 py-2">
                                @if($a->file_dokumen)
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">
                                    Ada File
                                </span>
                                @else
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-100 text-gray-800">
                                    Tidak Ada
                                </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">
                                Tidak ada data arsip.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (hidden on desktop) -->
        <div class="lg:hidden space-y-4">
            @forelse ($arsip as $index => $a)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <!-- Header Card -->
                    <div class="flex justify-between items-start mb-3 pb-3 border-b">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $index + 1 }}
                                </span>
                                @if($a->file_dokumen)
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">
                                    File Tersedia
                                </span>
                                @else
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-100 text-gray-800">
                                    Tanpa File
                                </span>
                                @endif
                            </div>
                            <h3 class="font-semibold text-gray-800 text-base">{{ $a->judul_dokumen }}</h3>
                            @if($a->nomor_dokumen)
                            <p class="text-gray-600 text-sm mt-1">No: {{ $a->nomor_dokumen }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Kategori</p>
                            <p class="font-medium text-gray-800">{{ $a->kategori->nama_kategori ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Program Studi</p>
                            <p class="font-medium text-gray-800">{{ $a->prodi->nama_prodi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Tanggal</p>
                            <p class="font-medium text-gray-800">
                                {{ $a->tanggal_dokumen ? \Carbon\Carbon::parse($a->tanggal_dokumen)->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Tahun</p>
                            <p class="font-medium text-gray-800">{{ $a->tahun ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Full Width Details -->
                    @if($a->keterangan)
                    <div class="mt-3 pt-3 border-t">
                        <p class="text-gray-500 text-xs mb-1">Keterangan</p>
                        <p class="font-medium text-gray-800 text-sm">{{ $a->keterangan }}</p>
                    </div>
                    @endif

                    @if($a->file_dokumen)
                    <div class="mt-3 pt-3 border-t">
                        <p class="text-gray-500 text-xs mb-1">File</p>
                        <p class="font-medium text-gray-800 text-sm">{{ $a->file_dokumen }}</p>
                    </div>
                    @endif
                </div>
            @empty
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada data arsip.</p>
                </div>
            @endforelse
        </div>

        <!-- Summary -->
        @if($arsip->count() > 0)
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $arsip->count() }}</p>
                    <p class="text-gray-600">Total Arsip</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $arsip->whereNotNull('file_dokumen')->count() }}</p>
                    <p class="text-gray-600">Dengan File</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-purple-600">{{ $arsip->unique('kategori_id')->count() }}</p>
                    <p class="text-gray-600">Kategori</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-orange-600">{{ $arsip->unique('prodi_id')->count() }}</p>
                    <p class="text-gray-600">Program Studi</p>
                </div>
            </div>
            
            <!-- Tahun Summary -->
            @if($arsip->unique('tahun')->count() > 0)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm font-medium text-gray-700 mb-2">Distribusi per Tahun:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($arsip->groupBy('tahun') as $tahun => $items)
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                        {{ $tahun }}: {{ $items->count() }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</x-app-layout>