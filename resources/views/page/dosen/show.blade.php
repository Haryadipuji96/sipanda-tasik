<x-app-layout>
    <x-slot name="title">Detail Dosen - {{ $dosen->nama }}</x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
                
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3 mb-3 md:mb-0">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Data Lengkap Dosen</h1>
                            <p class="text-sm text-gray-500">{{ $dosen->nama }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('dosen.preview-pdf', $dosen->id) }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview PDF
                        </a>
                               
                        <a href="{{ route('dosen.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- DATA PRIBADI -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-white text-gray-800 px-3 py-1 rounded">📋 Data Pribadi</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium w-1/4">Nama Lengkap</td>
                                <td class="border px-4 py-2">{{ $dosen->nama }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">Program Studi</td>
                                <td class="border px-4 py-2">{{ $dosen->prodi->nama_prodi ?? '-' }} ({{ $dosen->prodi->fakultas->nama_fakultas ?? '-' }})</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">Tempat/Tanggal Lahir</td>
                                <td class="border px-4 py-2">{{ $dosen->tempat_tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">NIDN</td>
                                <td class="border px-4 py-2">{{ $dosen->nik ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- RIWAYAT PENDIDIKAN -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-wihte text-gray-800 px-3 py-1 rounded">🎓 Riwayat Pendidikan</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <thead class="bg-green-500 text-white">
                                <tr>
                                    <th class="border px-4 py-2">Jenjang</th>
                                    <th class="border px-4 py-2">Prodi/Jurusan</th>
                                    <th class="border px-4 py-2">Tahun Lulus</th>
                                    <th class="border px-4 py-2">Nama Universitas/PT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dosen->pendidikan_array as $pend)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2 text-center">{{ $pend['jenjang'] ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $pend['prodi'] ?? '-' }}</td>
                                    <td class="border px-4 py-2 text-center">{{ $pend['tahun_lulus'] ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $pend['universitas'] ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500 italic">
                                        Belum ada data riwayat pendidikan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($dosen->pendidikan_terakhir)
                    <p class="text-sm text-gray-600 mt-2">
                        <strong>Pendidikan Terakhir:</strong> {{ $dosen->pendidikan_terakhir }}
                    </p>
                    @endif
                </div>

                <!-- DATA KEPEGAWAIAN -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-white text-gray-800 px-3 py-1 rounded">💼 Data Kepegawaian</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium w-1/4">Jabatan</td>
                                <td class="border px-4 py-2">{{ $dosen->jabatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">TMT Kerja</td>
                                <td class="border px-4 py-2">{{ $dosen->tmt_kerja ?? '-' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">Masa Kerja</td>
                                <td class="border px-4 py-2">
                                    {{ $dosen->masa_kerja_tahun ?? 0 }} Tahun {{ $dosen->masa_kerja_bulan ?? 0 }} Bulan
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">Golongan (Lama)</td>
                                <td class="border px-4 py-2">{{ $dosen->golongan ?? '-' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">Pangkat/Golongan</td>
                                <td class="border px-4 py-2">{{ $dosen->pangkat_golongan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">Jabatan Fungsional</td>
                                <td class="border px-4 py-2">{{ $dosen->jabatan_fungsional ?? '-' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">Masa Kerja Golongan</td>
                                <td class="border px-4 py-2">
                                    {{ $dosen->masa_kerja_golongan_tahun ?? 0 }} Tahun {{ $dosen->masa_kerja_golongan_bulan ?? 0 }} Bulan
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">No SK</td>
                                <td class="border px-4 py-2">{{ $dosen->no_sk ?? '-' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">JaFung (No SK)</td>
                                <td class="border px-4 py-2">{{ $dosen->no_sk_jafung ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- STATUS -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-white text-gray-800 px-3 py-1 rounded">✅ Status</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <p class="text-sm text-gray-600 mb-2">Sertifikasi</p>
                            <span class="px-4 py-2 text-sm rounded-full font-semibold {{ $dosen->sertifikasi == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $dosen->sertifikasi }}
                            </span>
                        </div>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <p class="text-sm text-gray-600 mb-2">Inpasing</p>
                            <span class="px-4 py-2 text-sm rounded-full font-semibold {{ $dosen->inpasing == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $dosen->inpasing }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>