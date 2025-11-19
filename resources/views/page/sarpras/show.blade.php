{{-- <x-app-layout>
    <x-slot name="title">{{ $sarpras->nama_barang ?? 'Detail Sarpras' }}</x-slot>
    <div class="py-6 px-6">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Detail Data Sarpras</h1>
                <p class="text-gray-600 mt-1">Informasi lengkap mengenai sarana dan prasarana</p>
            </div>

            <!-- Card Container -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-white">{{ $sarpras->nama_barang }}</h2>
                        <span class="bg-green-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                            {{ $sarpras->kategori_barang }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Lokasi</h3>

                            <table class="w-full text-sm">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50 w-1/3">Program Studi
                                        </td>
                                        <td class="py-3 px-4">
                                            @if ($sarpras->prodi)
                                                <span class="inline-flex items-center">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                                    {{ $sarpras->prodi->nama_prodi }}
                                                    <span class="text-gray-500 text-xs ml-2">
                                                        ({{ $sarpras->prodi->fakultas->nama_fakultas ?? '-' }})
                                                    </span>
                                                </span>
                                            @else
                                                <span class="text-gray-400">Unit Umum</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Ruangan</td>
                                        <td class="py-3 px-4">
                                            <div class="font-medium">{{ $sarpras->nama_ruangan }}</div>
                                            <div class="text-xs text-gray-500">{{ $sarpras->kategori_ruangan }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Kategori Barang</td>
                                        <td class="py-3 px-4">{{ $sarpras->kategori_barang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Merk Barang</td>
                                        <td class="py-3 px-4">
                                            {{ $sarpras->merk_barang ?? '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Barang</h3>

                            <table class="w-full text-sm">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50 w-1/3">Jumlah Barang
                                        </td>
                                        <td class="py-3 px-4">
                                            <span
                                                class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                {{ $sarpras->jumlah }} {{ $sarpras->satuan }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Harga Barang</td>
                                        <td class="py-3 px-4">
                                            @if ($sarpras->harga)
                                                <span class="font-semibold text-green-600">
                                                    Rp {{ number_format($sarpras->harga, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Kondisi</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $kondisiColor = match ($sarpras->kondisi) {
                                                    'Baik Sekali' => 'bg-green-100 text-green-800',
                                                    'Baik' => 'bg-green-100 text-green-800',
                                                    'Cukup' => 'bg-yellow-100 text-yellow-800',
                                                    'Rusak Ringan' => 'bg-orange-100 text-orange-800',
                                                    'Rusak Berat' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $kondisiColor }}">
                                                {{ $sarpras->kondisi }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Tanggal Pengadaan
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center text-gray-700">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($sarpras->tanggal_pengadaan)->format('d F Y') }}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Baris Kedua -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Teknis</h3>

                            <table class="w-full text-sm">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50 w-1/3">Kode / Seri
                                        </td>
                                        <td class="py-3 px-4 font-mono text-blue-600">{{ $sarpras->kode_seri }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Sumber Barang</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $sumberColor = match ($sarpras->sumber) {
                                                    'HIBAH' => 'bg-purple-100 text-purple-800',
                                                    'LEMBAGA' => 'bg-indigo-100 text-indigo-800',
                                                    'YAYASAN' => 'bg-pink-100 text-pink-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $sumberColor }}">
                                                {{ $sarpras->sumber }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Lokasi Lain</td>
                                        <td class="py-3 px-4">
                                            @if ($sarpras->lokasi_lain)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                    {{ $sarpras->lokasi_lain }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">File Dokumen</td>
                                        <td class="py-3 px-4">
                                            @if ($sarpras->file_dokumen)
                                                @php
                                                    $filePath = public_path(
                                                        'dokumen_sarpras/' . $sarpras->file_dokumen,
                                                    );
                                                @endphp

                                                @if (file_exists($filePath))
                                                    <a href="{{ asset('dokumen_sarpras/' . $sarpras->file_dokumen) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium hover:bg-green-200 transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                        Lihat Dokumen
                                                    </a>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $sarpras->file_dokumen }}
                                                    </p>
                                                @else
                                                    <span class="text-red-500 text-sm">File tidak ditemukan:
                                                        {{ $sarpras->file_dokumen }}</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400">Tidak ada file</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Kolom Kanan - Spesifikasi -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Spesifikasi Barang</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <p class="text-gray-700 leading-relaxed">{{ $sarpras->spesifikasi }}</p>
                            </div>

                            <!-- Keterangan -->
                            @if ($sarpras->keterangan)
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Keterangan</h3>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-gray-700 leading-relaxed">{{ $sarpras->keterangan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Di dalam card footer, tambahkan button -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Data dibuat: {{ $sarpras->created_at->format('d F Y H:i') }}
                            @if ($sarpras->updated_at != $sarpras->created_at)
                                | Diperbarui: {{ $sarpras->updated_at->format('d F Y H:i') }}
                            @endif
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('sarpras.ruangan.pdf', $sarpras->ruangan_id) }}"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF Ruangan
                            </a>

                            <a href="{{ route('sarpras.index') }}"
                                class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                <span>Kembali ke Daftar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
