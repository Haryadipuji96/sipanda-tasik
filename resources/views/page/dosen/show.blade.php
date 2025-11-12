<x-app-layout>
    <x-slot name="title">Detail Dosen - {{ $dosen->nama }}</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">

                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3 mb-3 md:mb-0">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Data Lengkap Dosen</h1>
                            <p class="text-sm text-gray-500">
                                {{ $dosen->gelar_depan ? $dosen->gelar_depan . ' ' : '' }}{{ $dosen->nama }}{{ $dosen->gelar_belakang ? ', ' . $dosen->gelar_belakang : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('dosen.preview-single.pdf', $dosen->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview PDF
                        </a>

                        <a href="{{ route('dosen.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
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
                                <td class="border px-4 py-2">
                                    <div class="font-semibold">
                                        {{ $dosen->gelar_depan ? $dosen->gelar_depan . ' ' : '' }}{{ $dosen->nama }}{{ $dosen->gelar_belakang ? ', ' . $dosen->gelar_belakang : '' }}
                                    </div>
                                    @if ($dosen->gelar_depan || $dosen->gelar_belakang)
                                        <div class="text-xs text-gray-500 mt-1">
                                            <strong>Gelar Depan:</strong> {{ $dosen->gelar_depan ?? '-' }} |
                                            <strong>Gelar Belakang:</strong> {{ $dosen->gelar_belakang ?? '-' }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">Program Studi</td>
                                <td class="border px-4 py-2">{{ $dosen->prodi->nama_prodi ?? '-' }}
                                    ({{ $dosen->prodi->fakultas->nama_fakultas ?? '-' }})</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">Tempat/Tanggal Lahir</td>
                                <td class="border px-4 py-2">{{ $dosen->tempat_tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">NIDN</td>
                                <td class="border px-4 py-2">{{ $dosen->nik ?? '-' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">NUPTK</td>
                                <td class="border px-4 py-2">{{ $dosen->nuptk ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- RIWAYAT PENDIDIKAN -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-white text-gray-800 px-3 py-1 rounded">🎓 Riwayat Pendidikan</span>
                    </h2>

                    @if ($dosen->pendidikan_terakhir)
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <strong>Pendidikan Terakhir:</strong> {{ $dosen->pendidikan_terakhir }}
                        </div>
                    @endif

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
                                    {{ $dosen->masa_kerja_tahun ?? 0 }} Tahun {{ $dosen->masa_kerja_bulan ?? 0 }}
                                    Bulan
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">Pangkat/Golongan</td>
                                <td class="border px-4 py-2">{{ $dosen->pangkat_golongan ?? '-' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">Jabatan Fungsional</td>
                                <td class="border px-4 py-2">{{ $dosen->jabatan_fungsional ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">Masa Kerja Golongan</td>
                                <td class="border px-4 py-2">
                                    {{ $dosen->masa_kerja_golongan_tahun ?? 0 }} Tahun
                                    {{ $dosen->masa_kerja_golongan_bulan ?? 0 }} Bulan
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-2 font-medium">No SK</td>
                                <td class="border px-4 py-2">{{ $dosen->no_sk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-medium bg-gray-50">JaFung (No SK)</td>
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
                            <div class="flex items-center justify-between">
                                <span
                                    class="px-4 py-2 text-sm rounded-full font-semibold {{ $dosen->sertifikasi == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->sertifikasi }}
                                </span>
                                @if ($dosen->sertifikasi == 'SUDAH' && $dosen->file_sertifikasi)
                                    <a href="{{ asset('dokumen_dosen/' . $dosen->file_sertifikasi) }}"
                                        target="_blank"
                                        class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat File
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <p class="text-sm text-gray-600 mb-2">Inpasing</p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="px-4 py-2 text-sm rounded-full font-semibold {{ $dosen->inpasing == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->inpasing }}
                                </span>
                                @if ($dosen->inpasing == 'SUDAH' && $dosen->file_inpasing)
                                    <a href="{{ asset('dokumen_dosen/' . $dosen->file_inpasing) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat File
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BERKAS UPLOAD -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-white text-gray-800 px-3 py-1 rounded">📎 Berkas Upload</span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- KTP -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">KTP</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_ktp ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_ktp ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_ktp)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_ktp) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Ijazah S1 -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Ijazah S1</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_ijazah_s1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_ijazah_s1 ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_ijazah_s1)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_ijazah_s1) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Transkrip S1 -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Transkrip S1</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_transkrip_s1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_transkrip_s1 ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_transkrip_s1)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_transkrip_s1) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Ijazah S2 -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Ijazah S2</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_ijazah_s2 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_ijazah_s2 ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_ijazah_s2)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_ijazah_s2) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Transkrip S2 -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Transkrip S2</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_transkrip_s2 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_transkrip_s2 ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_transkrip_s2)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_transkrip_s2) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Ijazah S3 -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Ijazah S3</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_ijazah_s3 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_ijazah_s3 ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_ijazah_s3)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_ijazah_s3) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Transkrip S3 -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Transkrip S3</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_transkrip_s3 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_transkrip_s3 ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_transkrip_s3)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_transkrip_s3) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Jafung -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Jafung</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_jafung ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_jafung ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_jafung)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_jafung) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- KK -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Kartu Keluarga</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_kk ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_kk ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_kk)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_kk) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Perjanjian Kerja -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Perjanjian Kerja</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_perjanjian_kerja ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_perjanjian_kerja ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_perjanjian_kerja)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_perjanjian_kerja) }}"
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- SK Pengangkatan -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">SK Pengangkatan</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_sk_pengangkatan ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_sk_pengangkatan ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_sk_pengangkatan)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_sk_pengangkatan) }}"
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Surat Pernyataan -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Surat Pernyataan</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_surat_pernyataan ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_surat_pernyataan ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_surat_pernyataan)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_surat_pernyataan) }}"
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- SKTP -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">SKTP</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_sktp ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_sktp ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_sktp)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_sktp) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- Surat Tugas -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Surat Tugas</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_surat_tugas ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_surat_tugas ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_surat_tugas)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_surat_tugas) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>

                        <!-- SK Aktif Tridharma -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">SK Aktif Tridharma</p>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $dosen->file_sk_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $dosen->file_sk_aktif ? 'ADA' : 'TIDAK ADA' }}
                                </span>
                            </div>
                            @if ($dosen->file_sk_aktif)
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_sk_aktif) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- DOKUMEN LAMA (jika ada) -->
                @if ($dosen->file_dokumen)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">📎
                                Dokumen Lainnya</span>
                        </h2>
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $dosen->file_dokumen }}</p>
                                        <p class="text-sm text-gray-600">Dokumen terlampir</p>
                                    </div>
                                </div>
                                <a href="{{ asset('dokumen_dosen/' . $dosen->file_dokumen) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm rounded-lg hover:bg-orange-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
