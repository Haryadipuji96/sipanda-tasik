<x-app-layout>
     <x-slot name="title">{{ $tenagaPendidik->nama_tendik ?? 'Detail Sarpras' }}</x-slot>
    <div class="py-6 px-6">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Detail Tenaga Pendidik</h1>
                <p class="text-gray-600 mt-1">Informasi lengkap mengenai tenaga pendidik</p>
            </div>

            <!-- Card Container -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-white">{{ $tenagaPendidik->nama_tendik }}</h2>
                        <span class="bg-white/20 text-white text-sm font-medium px-3 py-1 rounded-full">
                            {{ $tenagaPendidik->jabatan ?? 'Tidak diketahui' }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Utama</h3>
                            <table class="w-full text-sm">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50 w-1/3">Nama</td>
                                        <td class="py-3 px-4">{{ $tenagaPendidik->nama_tendik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Prodi</td>
                                        <td class="py-3 px-4">
                                            {{ $tenagaPendidik->prodi->nama_prodi ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">NIP</td>
                                        <td class="py-3 px-4 font-mono text-blue-600">
                                            {{ $tenagaPendidik->nip ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Jabatan</td>
                                        <td class="py-3 px-4">{{ $tenagaPendidik->jabatan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Tambahan</h3>
                            <table class="w-full text-sm">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50 w-1/3">Status
                                            Kepegawaian</td>
                                        <td class="py-3 px-4">
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                                {{ $tenagaPendidik->status_kepegawaian }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Pendidikan Terakhir
                                        </td>
                                        <td class="py-3 px-4">{{ $tenagaPendidik->pendidikan_terakhir }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Jenis Kelamin</td>
                                        <td class="py-3 px-4">{{ $tenagaPendidik->jenis_kelamin }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">No. HP</td>
                                        <td class="py-3 px-4">{{ $tenagaPendidik->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">Email</td>
                                        <td class="py-3 px-4">{{ $tenagaPendidik->email }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Alamat</h3>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-700 leading-relaxed">{{ $tenagaPendidik->alamat }}</p>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    @if ($tenagaPendidik->keterangan)
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Keterangan</h3>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-gray-700 leading-relaxed">{{ $tenagaPendidik->keterangan }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- File -->
                    <td class="py-3 px-4 font-medium text-gray-700 bg-gray-50">File Dokumen</td>
                    <td class="py-3 px-4">
                        @if ($tenagaPendidik->file)
                            <a href="{{ asset('dokumen_tendik/' . $tenagaPendidik->file) }}" target="_blank"
                                class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium hover:bg-green-200 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Lihat Dokumen
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada file</span>
                        @endif
                    </td>
                </div>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Terakhir diperbarui:
                            {{ $tenagaPendidik->updated_at ? \Carbon\Carbon::parse($tenagaPendidik->updated_at)->format('d F Y') : '-' }}
                        </div>
                        <a href="{{ route('tenaga-pendidik.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
