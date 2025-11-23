<x-app-layout>
    <x-slot name="title">Detail Tenaga Pendidik - {{ $tenagaPendidik->nama_tendik }}</x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
                            <h1 class="text-2xl font-semibold text-gray-800">Data Lengkap Tenaga Pendidik</h1>
                            <p class="text-sm text-gray-500">
                                {{ $tenagaPendidik->gelar_depan ? $tenagaPendidik->gelar_depan . ' ' : '' }}
                                {{ $tenagaPendidik->nama_tendik }}
                                {{ $tenagaPendidik->gelar_belakang ? ', ' . $tenagaPendidik->gelar_belakang : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <!-- SELALU TAMPILKAN TOMBOL PREVIEW PDF -->
                        <a href="{{ route('tenaga-pendidik.preview-pdf', $tenagaPendidik->id) }}" target="_blank"
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
                        <a href="{{ route('tenaga-pendidik.index') }}"
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
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">📋 Data
                            Pribadi</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-3 font-medium w-1/4">Nama Lengkap</td>
                                <td class="border px-4 py-3">
                                    {{ $tenagaPendidik->gelar_depan ? $tenagaPendidik->gelar_depan . ' ' : '' }}
                                    {{ $tenagaPendidik->nama_tendik }}
                                    {{ $tenagaPendidik->gelar_belakang ? ', ' . $tenagaPendidik->gelar_belakang : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-3 font-medium bg-gray-50">Program Studi</td>
                                <td class="border px-4 py-3">{{ $tenagaPendidik->prodi->nama_prodi ?? '-' }}</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-3 font-medium">Status Kepegawaian</td>
                                <td class="border px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $tenagaPendidik->status_kepegawaian == 'PNS' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $tenagaPendidik->status_kepegawaian == 'Honorer' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $tenagaPendidik->status_kepegawaian == 'Kontrak' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ $tenagaPendidik->status_kepegawaian ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-3 font-medium bg-gray-50">Jenis Kelamin</td>
                                <td class="border px-4 py-3">
                                    @if ($tenagaPendidik->jenis_kelamin == 'laki-laki')
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Laki-laki</span>
                                    @elseif($tenagaPendidik->jenis_kelamin == 'perempuan')
                                        <span
                                            class="px-2 py-1 bg-pink-100 text-pink-800 rounded-full text-xs font-medium">Perempuan</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-3 font-medium">Tempat Lahir</td>
                                <td class="border px-4 py-3">{{ $tenagaPendidik->tempat_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-3 font-medium bg-gray-50">Tanggal Lahir</td>
                                <td class="border px-4 py-3">
                                    {{ $tenagaPendidik->tanggal_lahir ? $tenagaPendidik->tanggal_lahir->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-3 font-medium">TMT Kerja</td>
                                <td class="border px-4 py-3">
                                    {{ $tenagaPendidik->tmt_kerja ? $tenagaPendidik->tmt_kerja->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-3 font-medium bg-gray-50">NIP/NIK</td>
                                <td class="border px-4 py-3 font-mono">{{ $tenagaPendidik->nip ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Tambahkan setelah section Data Pribadi -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">🏢 Posisi
                            & Jabatan</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-3 font-medium w-1/4">Posisi/Jabatan Struktural</td>
                                <td class="border px-4 py-3">{{ $tenagaPendidik->jabatan_struktural ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-3 font-medium bg-gray-50">Program Studi</td>
                                <td class="border px-4 py-3">{{ $tenagaPendidik->prodi->nama_prodi ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- KONTAK DAN ALAMAT -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">📞 Kontak &
                            Alamat</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-3 font-medium w-1/4">Email</td>
                                <td class="border px-4 py-3">
                                    @if ($tenagaPendidik->email)
                                        <a href="mailto:{{ $tenagaPendidik->email }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $tenagaPendidik->email }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-3 font-medium bg-gray-50">No. Telepon/HP</td>
                                <td class="border px-4 py-3">
                                    @if ($tenagaPendidik->no_hp)
                                        <a href="tel:{{ $tenagaPendidik->no_hp }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $tenagaPendidik->no_hp }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="border px-4 py-3 font-medium">Alamat</td>
                                <td class="border px-4 py-3">{{ $tenagaPendidik->alamat ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- RIWAYAT GOLONGAN -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">📊
                            Riwayat Golongan</span>
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border">
                            <thead class="bg-purple-500 text-white">
                                <tr>
                                    <th class="border px-4 py-2">No</th>
                                    <th class="border px-4 py-2">Tahun</th>
                                    <th class="border px-4 py-2">Golongan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $golonganArray = [];
                                    if (is_array($tenagaPendidik->golongan_array)) {
                                        $golonganArray = $tenagaPendidik->golongan_array;
                                    } else {
                                        $decoded = json_decode($tenagaPendidik->golongan_array, true);
                                        $golonganArray = is_array($decoded) ? $decoded : [];
                                    }
                                @endphp

                                @forelse($golonganArray as $index => $gol)
                                    <tr class="hover:bg-gray-50 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="border px-4 py-2 text-center font-medium">{{ $index + 1 }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $gol['tahun'] ?? '-' }}</td>
                                        <td class="border px-4 py-2 text-center font-semibold text-purple-600">
                                            {{ $gol['golongan'] ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="border px-4 py-4 text-center text-gray-500 italic bg-gray-50">
                                            <div class="flex flex-col items-center justify-center py-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-8 w-8 text-gray-400 mb-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Belum ada data riwayat golongan
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tambahkan section untuk berkas yang diupload -->
                @if ($tenagaPendidik->file_ktp || $tenagaPendidik->file_ijazah_s1 || $tenagaPendidik->file_kk)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">📎
                                Berkas Terlampir</span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $berkas = [
                                    'file_ktp' => 'KTP',
                                    'file_kk' => 'Kartu Keluarga (KK)',
                                    'file_ijazah_s1' => 'Ijazah S1',
                                    'file_transkrip_s1' => 'Transkrip Nilai S1',
                                    'file_ijazah_s2' => 'Ijazah S2',
                                    'file_transkrip_s2' => 'Transkrip Nilai S2',
                                    'file_ijazah_s3' => 'Ijazah S3',
                                    'file_transkrip_s3' => 'Transkrip Nilai S3',
                                    'file_perjanjian_kerja' => 'Perjanjian Kerja',
                                    'file_sk' => 'Surat Keputusan (SK)',
                                    'file_surat_tugas' => 'Surat Tugas',
                                ];
                            @endphp

                            @foreach ($berkas as $field => $label)
                                @if ($tenagaPendidik->$field)
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <div>
                                                    <p class="font-medium text-gray-800 text-sm">{{ $label }}
                                                    </p>
                                                    <p class="text-xs text-gray-600">{{ $tenagaPendidik->$field }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ asset('dokumen_tendik/' . $tenagaPendidik->$field) }}"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- DOKUMEN -->
                @if ($tenagaPendidik->file)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">📎
                                Dokumen</span>
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
                                        <p class="font-medium text-gray-800">{{ $tenagaPendidik->file }}</p>
                                        <p class="text-sm text-gray-600">Dokumen terlampir</p>
                                    </div>
                                </div>
                                <a href="{{ asset('dokumen_tendik/' . $tenagaPendidik->file) }}" target="_blank"
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

                <!-- KETERANGAN -->
                @if ($tenagaPendidik->keterangan)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">📝
                                Keterangan</span>
                        </h2>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $tenagaPendidik->keterangan }}</p>
                        </div>
                    </div>
                @endif

                <!-- TANGGAL INPUT & UPDATE -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Dibuat: {{ $tenagaPendidik->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Diupdate: {{ $tenagaPendidik->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
