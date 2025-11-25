<x-app-layout>
    <x-slot name="title">Data Dosen</x-slot>
    <style>
        .cssbuttons-io-button {
            display: flex;
            align-items: center;
            font-family: inherit;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            padding: 0.4em 0.8em;
            color: white;
            background: #2563eb;
            border: none;
            letter-spacing: 0.05em;
            border-radius: 15em;
            transition: all 0.2s;
        }

        .cssbuttons-io-button svg {
            margin-right: 4px;
            fill: white;
        }

        .cssbuttons-io-button:hover {
            box-shadow: 0 0.4em 1em -0.3em #0740bb;
        }

        .cssbuttons-io-button:active {
            box-shadow: 0 0.2em 0.7em -0.3em #0740bb;
            transform: translateY(1px);
        }

        [x-cloak] {
            display: none !important;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .highlight {
            background-color: #fde68a;
            font-weight: 600;
            border-radius: 4px;
            padding: 0 2px;
            animation: fadeGlow 1.2s ease-out;
        }

        @keyframes fadeGlow {
            0% {
                background-color: #facc15;
                box-shadow: 0 0 8px #facc15;
            }

            50% {
                background-color: #fde68a;
                box-shadow: 0 0 5px #fde68a;
            }

            100% {
                background-color: #fde68a;
                box-shadow: none;
            }
        }

        /* Badge untuk status file upload */
        .file-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 500;
        }

        .file-uploaded {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .file-missing {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
    </style>

    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Dosen</h1>
            @canCrud('dosen')
            <button onclick="window.location='{{ route('dosen.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                </svg>
                <span>Tambah</span>
            </button>
            @endcanCrud
        </div>

        <x-search-bar route="dosen.index" placeholder="Cari nama / prodi / jabatan / NUPTK..." />

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-2 mb-4">

            <!-- Button Hapus Terpilih -->
            <button id="delete-selected"
                class="order-2 sm:order-1 px-3 py-1.5 text-sm rounded-full font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-center sm:w-auto"
                disabled>
                <span>Hapus Terpilih</span>
            </button>


            <!-- Export Buttons -->
            <div class="order-1 sm:order-2 flex gap-2">
                <!-- Button Preview PDF -->
                <a href="{{ route('dosen.preview.pdf', ['search' => request('search')]) }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-sm rounded-full font-medium text-white bg-orange-600 hover:bg-orange-700 transition text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="sm:hidden">Preview</span>
                    <span class="hidden sm:inline">Preview PDF</span>
                </a>

                <!-- Button Export Excel -->
                <a href="{{ route('dosen.export.excel', ['search' => request('search')]) }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-sm rounded-full font-medium text-white bg-green-600 hover:bg-green-700 transition text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="sm:hidden">Excel</span>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>
            </div>
        </div>

        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        @canCrud('dosen')
                        <th class="px-4 py-2 border text-center w-12" rowspan="3">
                            <input type="checkbox" id="select-all">
                        </th>
                        @endcanCrud
                        <th rowspan="3" class="px-4 py-2 border text-center w-12">No</th>
                        <th rowspan="3" class="border px-4 py-2">Nama Lengkap</th>
                        <th rowspan="3" class="border px-4 py-2">Gelar</th>
                        <th rowspan="3" class="border px-4 py-2">Prodi</th>
                        <th rowspan="3" class="border px-4 py-2">Tempat/Tgl Lahir</th>
                        <th rowspan="3" class="border px-4 py-2">NIDN</th>

                        <th rowspan="3" class="border px-4 py-2">NUPTK</th>
                        <th rowspan="3" class="border px-4 py-1">Status Dosen</th>
                        <th colspan="3" class="border px-4 py-2 text-center">PENDIDIKAN</th>
                        <th rowspan="3" class="border px-4 py-2">Jabatan</th>
                        <th rowspan="3" class="border px-4 py-2">TMT Kerja</th>
                        <th colspan="2" class="border px-4 py-2 text-center">Masa Kerja</th>
                        <th colspan="2" class="border px-4 py-2 text-center">Pangkat/Gol & JaFung</th>
                        <th colspan="2" class="border px-4 py-2 text-center">Masa Kerja Gol</th>
                        <th colspan="2" class="border px-4 py-2 text-center">No SK & JaFung</th>
                        <th colspan="2" class="border px-4 py-2 text-center">Status</th>
                        <th rowspan="3" class="border px-4 py-2 text-center">File Upload</th>
                        <th rowspan="3" class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="border px-2 py-1">Prodi/Jurusan</th>
                        <th rowspan="2" class="border px-2 py-1">Tahun Lulus</th>
                        <th rowspan="2" class="border px-2 py-1">Nama Univ/PT</th>
                        <th rowspan="2" class="border px-2 py-1">Thn</th>
                        <th rowspan="2" class="border px-2 py-1">Bln</th>
                        <th rowspan="2" class="border px-2 py-1">Pangkat/Gol</th>
                        <th rowspan="2" class="border px-2 py-1">JaFung</th>
                        <th rowspan="2" class="border px-2 py-1">Thn</th>
                        <th rowspan="2" class="border px-2 py-1">Bln</th>
                        <th rowspan="2" class="border px-2 py-1">No SK</th>
                        <th rowspan="2" class="border px-2 py-1">JaFung</th>
                        <th rowspan="2" class="border px-2 py-1">Sertifikasi</th>
                        <th rowspan="2" class="border px-2 py-1">Inpasing</th>
                    </tr>
                </thead>
                @php
                    function highlight($text, $search)
                    {
                        if (!$search) {
                            return e($text);
                        }
                        return preg_replace(
                            '/(' . preg_quote($search, '/') . ')/i',
                            '<span class="highlight">$1</span>',
                            e($text),
                        );
                    }

                    function getFileBadge($file)
                    {
                        if ($file) {
                            return '<span class="file-badge file-uploaded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                ADA
                            </span>';
                        }
                        return '<span class="file-badge file-missing">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            TIDAK ADA
                        </span>';
                    }
                @endphp
                <tbody>
                    @forelse ($dosen as $index => $d)
                        @php
                            $pendidikan = $d->pendidikan_array;
                            $maxRows = max(1, count($pendidikan));
                        @endphp
                        @for ($i = 0; $i < $maxRows; $i++)
                            <tr class="hover:bg-gray-50" x-data="{ openModal: false }">
                                @if ($i === 0)
                                    @canCrud('dosen')
                                    <td class="border px-3 py-2 text-center" rowspan="{{ $maxRows }}">
                                        <input type="checkbox" class="select-item" name="selected_dosen[]"
                                            value="{{ $d->id }}">
                                    </td>
                                    @endcanCrud
                                    <td class="border px-3 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $index + $dosen->firstItem() }}</td>
                                    <td class="border px-4 py-2" rowspan="{{ $maxRows }}">
                                        <div class="font-medium">{!! highlight($d->nama, request('search')) !!}</div>
                                        @if ($d->gelar_depan || $d->gelar_belakang)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $d->gelar_depan }} {{ $d->nama }}
                                                {{ $d->gelar_belakang ? ', ' . $d->gelar_belakang : '' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        @if ($d->gelar_depan || $d->gelar_belakang)
                                            <div class="text-sm">
                                                @if ($d->gelar_depan)
                                                    <span
                                                        class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $d->gelar_depan }}</span>
                                                @endif
                                                @if ($d->gelar_belakang)
                                                    <span
                                                        class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs mt-1 block">{{ $d->gelar_belakang }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2" rowspan="{{ $maxRows }}">
                                        {!! highlight($d->prodi->nama_prodi ?? '-', request('search')) !!}
                                    </td>
                                    <td class="border px-4 py-2" rowspan="{{ $maxRows }}">
                                        {{ $d->tempat_tanggal_lahir }}</td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $d->nik ?? '-' }}
                                    </td>

                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $d->nuptk ?? '-' }}
                                    </td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full font-semibold 
        {{ $d->status_dosen == 'DOSEN_TETAP' ? 'bg-green-100 text-green-800' : '' }}
        {{ $d->status_dosen == 'DOSEN_TIDAK_TETAP' ? 'bg-yellow-100 text-yellow-800' : '' }}
        {{ $d->status_dosen == 'PNS' ? 'bg-blue-100 text-blue-800' : '' }}">
                                            {{ $d->status_dosen_text }}
                                        </span>
                                    </td>
                                @endif

                                <!-- Pendidikan Dynamic Rows -->
                                @if (isset($pendidikan[$i]))
                                    <td class="border px-2 py-1 text-xs">{{ $pendidikan[$i]['prodi'] ?? '-' }}</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        {{ $pendidikan[$i]['tahun_lulus'] ?? '-' }}</td>
                                    <td class="border px-2 py-1 text-xs">{{ $pendidikan[$i]['universitas'] ?? '-' }}
                                    </td>
                                @else
                                    <td class="border px-2 py-1 text-center text-gray-400">-</td>
                                    <td class="border px-2 py-1 text-center text-gray-400">-</td>
                                    <td class="border px-2 py-1 text-center text-gray-400">-</td>
                                @endif

                                @if ($i === 0)
                                    <td class="border px-4 py-2" rowspan="{{ $maxRows }}">
                                        {!! highlight($d->jabatan ?? '-', request('search')) !!}</td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $d->tmt_kerja ?? '-' }}</td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $d->masa_kerja_tahun ?? 0 }}</td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $d->masa_kerja_bulan ?? 0 }}</td>

                                    <td class="border px-2 py-1 text-xs" rowspan="{{ $maxRows }}">
                                        {{ $d->pangkat_golongan ?? '-' }}</td>
                                    <td class="border px-2 py-1 text-xs" rowspan="{{ $maxRows }}">
                                        {{ $d->jabatan_fungsional ?? '-' }}</td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $d->masa_kerja_golongan_tahun ?? 0 }}</td>
                                    <td class="border px-4 py-2 text-center" rowspan="{{ $maxRows }}">
                                        {{ $d->masa_kerja_golongan_bulan ?? 0 }}</td>
                                    <td class="border px-2 py-1 text-xs" rowspan="{{ $maxRows }}">
                                        {{ $d->no_sk ?? '-' }}</td>
                                    <td class="border px-2 py-1 text-xs" rowspan="{{ $maxRows }}">
                                        {{ $d->no_sk_jafung ?? '-' }}</td>
                                    <td class="border px-2 py-1 text-center" rowspan="{{ $maxRows }}">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $d->sertifikasi == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $d->sertifikasi }}
                                        </span>
                                    </td>
                                    <td class="border px-2 py-1 text-center" rowspan="{{ $maxRows }}">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $d->inpasing == 'SUDAH' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $d->inpasing }}
                                        </span>
                                    </td>
                                    <td class="border px-2 py-1 text-center" rowspan="{{ $maxRows }}">
                                        <div class="flex flex-col gap-1 items-center">
                                            <!-- KTP -->
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs text-gray-600 w-8 text-left">KTP:</span>
                                                {!! getFileBadge($d->file_ktp) !!}
                                            </div>

                                            <!-- Sertifikasi -->
                                            @if ($d->sertifikasi == 'SUDAH')
                                                <div class="flex items-center gap-1">
                                                    <span class="text-xs text-gray-600 w-8 text-left">Sertif:</span>
                                                    {!! getFileBadge($d->file_sertifikasi) !!}
                                                </div>
                                            @endif

                                            <!-- Inpasing -->
                                            @if ($d->inpasing == 'SUDAH')
                                                <div class="flex items-center gap-1">
                                                    <span class="text-xs text-gray-600 w-8 text-left">Inpas:</span>
                                                    {!! getFileBadge($d->file_inpasing) !!}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border px-3 py-2 text-center" rowspan="{{ $maxRows }}">

                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Detail Button -->
                                            <a href="{{ route('dosen.show', $d->id) }}"
                                                class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full transition"
                                                title="Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @canCrud('dosen')
                                            <!-- Edit Button with Modal -->
                                            <button @click="openModal = true"
                                                class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('dosen.destroy', $d->id) }}" method="POST"
                                                class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition btn-delete"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endcanCrud
                                        </div>


                                        <!-- Modal Edit -->
                                        <div x-show="openModal" x-cloak
                                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                            <div @click.away="openModal = false"
                                                class="bg-white rounded-lg w-full max-w-6xl p-6 shadow-lg overflow-y-auto max-h-[90vh]"
                                                x-data="formDosenEdit({{ json_encode($d->pendidikan_array ?? []) }}, '{{ $d->sertifikasi }}', '{{ $d->inpasing }}')">
                                                <h2
                                                    class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2 text-start">
                                                    Edit Data Dosen - {{ $d->nama }}</h2>

                                                <form action="{{ route('dosen.update', $d->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Program Studi -->
                                                    <div class="mb-4">
                                                        <label
                                                            class="block font-medium mb-1 text-sm text-start">Program
                                                            Studi <span class="text-red-500">*</span></label>
                                                        <select name="id_prodi"
                                                            class="border p-2 rounded w-full text-sm" required>
                                                            <option value="">-- Pilih Prodi --</option>
                                                            @foreach ($prodi as $p)
                                                                <option value="{{ $p->id }}"
                                                                    {{ $p->id == $d->id_prodi ? 'selected' : '' }}>
                                                                    {{ $p->nama_prodi }}
                                                                    ({{ $p->fakultas->nama_fakultas }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Gelar Depan & Nama -->
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Gelar
                                                                Depan</label>
                                                            <input type="text" name="gelar_depan"
                                                                value="{{ $d->gelar_depan }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Dr.">
                                                        </div>
                                                        <div class="md:col-span-2">
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Nama
                                                                Lengkap <span class="text-red-500">*</span></label>
                                                            <input type="text" name="nama"
                                                                value="{{ $d->nama }}"
                                                                class="border p-2 rounded w-full text-sm" required>
                                                        </div>
                                                    </div>

                                                    <!-- Gelar Belakang -->
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-sm text-start">Gelar
                                                            Belakang</label>
                                                        <input type="text" name="gelar_belakang"
                                                            value="{{ $d->gelar_belakang }}"
                                                            class="border p-2 rounded w-full text-sm"
                                                            placeholder="M.Pd., M.Kom.">
                                                    </div>

                                                    <!-- Tempat & Tanggal Lahir -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Tempat
                                                                Lahir</label>
                                                            <input type="text" name="tempat_lahir"
                                                                value="{{ $d->tempat_lahir }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Tanggal
                                                                Lahir</label>
                                                            <input type="date" name="tanggal_lahir"
                                                                value="{{ $d->tanggal_lahir }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                    </div>

                                                    <!-- NIDN & NUPTK -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">NIDN</label>
                                                            <input type="text" name="nik"
                                                                value="{{ $d->nik }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">NUPTK</label>
                                                            <input type="text" name="nuptk"
                                                                value="{{ $d->nuptk }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                    </div>

                                                    <!-- Pendidikan Terakhir -->
                                                    <div class="mb-4" x-data="{ pendidikanTerakhir: '{{ $d->pendidikan_terakhir ?? '' }}' }">
                                                        <label
                                                            class="block font-medium mb-1 text-sm text-start">Pendidikan
                                                            Terakhir</label>
                                                        <select name="pendidikan_terakhir"
                                                            x-model="pendidikanTerakhir"
                                                            class="border p-2 rounded w-full text-sm mb-2">
                                                            <option value="">-- Pilih Pendidikan Terakhir --
                                                            </option>
                                                            <option value="D3">D3</option>
                                                            <option value="D4">D4</option>
                                                            <option value="S1">S1</option>
                                                            <option value="S2">S2</option>
                                                            <option value="S3">S3</option>
                                                            <option value="Prof">Prof</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </select>

                                                        <!-- Input untuk pilihan lainnya -->
                                                        <div x-show="pendidikanTerakhir === 'Lainnya'" x-transition>
                                                            <input type="text" name="pendidikan_lainnya"
                                                                value="{{ $d->pendidikan_lainnya ?? '' }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Masukkan pendidikan lainnya">
                                                        </div>
                                                    </div>

                                                    <!-- Riwayat Pendidikan -->
                                                    <div class="mb-6 border-t pt-4">
                                                        <div class="flex justify-between items-center mb-3">
                                                            <label class="block font-medium text-sm text-start">Riwayat
                                                                Pendidikan</label>
                                                            <button type="button" @click="addPendidikan()"
                                                                class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                                                + Tambah Pendidikan
                                                            </button>
                                                        </div>

                                                        <template x-for="(item, index) in pendidikan"
                                                            :key="index">
                                                            <div
                                                                class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3 p-3 bg-gray-50 rounded border">
                                                                <div>
                                                                    <label
                                                                        class="text-xs text-gray-600 text-start">Jenjang</label>
                                                                    <select :name="'pendidikan[' + index + '][jenjang]'"
                                                                        x-model="item.jenjang"
                                                                        class="w-full border rounded px-2 py-1 text-sm">
                                                                        <option value="">-- Pilih Jenjang --
                                                                        </option>
                                                                        <option value="D3">D3 - Diploma 3</option>
                                                                        <option value="D4">D4 - Diploma 4</option>
                                                                        <option value="S1">S1 - Sarjana</option>
                                                                        <option value="S2">S2 - Magister</option>
                                                                        <option value="S3">S3 - Doktor</option>
                                                                        <option value="Prof">Prof - Profesor</option>
                                                                        <option value="Lainnya">Lainnya</option>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="text-xs text-gray-600 text-start">Prodi/Jurusan</label>
                                                                    <input type="text"
                                                                        :name="'pendidikan[' + index + '][prodi]'"
                                                                        x-model="item.prodi"
                                                                        class="w-full border rounded px-2 py-1 text-sm"
                                                                        placeholder="PAI">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="text-xs text-gray-600 text-start">Tahun
                                                                        Lulus</label>
                                                                    <input type="text"
                                                                        :name="'pendidikan[' + index + '][tahun_lulus]'"
                                                                        x-model="item.tahun_lulus"
                                                                        class="w-full border rounded px-2 py-1 text-sm"
                                                                        placeholder="2015">
                                                                </div>
                                                                <div class="flex gap-2">
                                                                    <div class="flex-1">
                                                                        <label
                                                                            class="text-xs text-gray-600 text-start">Universitas/PT</label>
                                                                        <input type="text"
                                                                            :name="'pendidikan[' + index + '][universitas]'"
                                                                            x-model="item.universitas"
                                                                            class="w-full border rounded px-2 py-1 text-sm"
                                                                            placeholder="STAI Tasikmalaya">
                                                                    </div>
                                                                    <div class="flex items-end">
                                                                        <button type="button"
                                                                            @click="removePendidikan(index)"
                                                                            class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">×</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>

                                                    <!-- Jabatan & TMT Kerja -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Jabatan</label>
                                                            <input type="text" name="jabatan"
                                                                value="{{ $d->jabatan }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">TMT
                                                                Kerja</label>
                                                            <input type="date" name="tmt_kerja"
                                                                value="{{ $d->tmt_kerja }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                    </div>

                                                    <!-- Masa Kerja -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Masa
                                                                Kerja (Tahun)</label>
                                                            <input type="number" name="masa_kerja_tahun"
                                                                value="{{ $d->masa_kerja_tahun }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                min="0">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Masa
                                                                Kerja (Bulan)</label>
                                                            <input type="number" name="masa_kerja_bulan"
                                                                value="{{ $d->masa_kerja_bulan }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                min="0" max="11">
                                                        </div>
                                                    </div>

                                                    <!-- Status Dosen -->
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-sm text-start">Status
                                                            Dosen <span class="text-red-500">*</span></label>
                                                        <select name="status_dosen"
                                                            class="border p-2 rounded w-full text-sm" required>
                                                            <option value="">-- Pilih Status Dosen --</option>
                                                            <option value="DOSEN_TETAP"
                                                                {{ $d->status_dosen == 'DOSEN_TETAP' ? 'selected' : '' }}>
                                                                Dosen Tetap</option>
                                                            <option value="DOSEN_TIDAK_TETAP"
                                                                {{ $d->status_dosen == 'DOSEN_TIDAK_TETAP' ? 'selected' : '' }}>
                                                                Dosen Tidak Tetap</option>
                                                            <option value="PNS"
                                                                {{ $d->status_dosen == 'PNS' ? 'selected' : '' }}>PNS
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <!-- Golongan & Jabatan Fungsional -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Pangkat/Golongan</label>
                                                            <input type="text" name="pangkat_golongan"
                                                                value="{{ $d->pangkat_golongan }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="III/b">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Jabatan
                                                                Fungsional</label>
                                                            <input type="text" name="jabatan_fungsional"
                                                                value="{{ $d->jabatan_fungsional }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Lektor">
                                                        </div>
                                                    </div>

                                                    <!-- Masa Kerja Golongan -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Masa
                                                                Kerja Golongan (Tahun)</label>
                                                            <input type="number" name="masa_kerja_golongan_tahun"
                                                                value="{{ $d->masa_kerja_golongan_tahun }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                min="0">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Masa
                                                                Kerja Golongan (Bulan)</label>
                                                            <input type="number" name="masa_kerja_golongan_bulan"
                                                                value="{{ $d->masa_kerja_golongan_bulan }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                min="0" max="11">
                                                        </div>
                                                    </div>

                                                    <!-- No SK & JaFung -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm text-start">No
                                                                SK</label>
                                                            <input type="text" name="no_sk"
                                                                value="{{ $d->no_sk }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="123/SK/2024">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">JaFung
                                                                (No SK)</label>
                                                            <input type="text" name="no_sk_jafung"
                                                                value="{{ $d->no_sk_jafung }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Lektor">
                                                        </div>
                                                    </div>

                                                    <!-- Sertifikasi & Inpasing -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Sertifikasi
                                                                <span class="text-red-500">*</span></label>
                                                            <select name="sertifikasi" x-model="sertifikasi"
                                                                class="border p-2 rounded w-full text-sm" required>
                                                                <option value="BELUM">BELUM</option>
                                                                <option value="SUDAH">SUDAH</option>
                                                            </select>

                                                            <!-- Upload Sertifikasi -->
                                                            <div x-show="sertifikasi === 'SUDAH'" x-transition
                                                                class="mt-2">
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700 text-start">Upload
                                                                    Sertifikasi</label>
                                                                @if ($d->file_sertifikasi)
                                                                    <div class="mb-2">
                                                                        <a href="{{ asset('dokumen_dosen/' . $d->file_sertifikasi) }}"
                                                                            target="_blank"
                                                                            class="text-blue-600 hover:underline text-sm inline-flex items-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 mr-1" fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                            </svg>
                                                                            Lihat file saat ini
                                                                        </a>
                                                                        <p
                                                                            class="text-gray-500 text-xs mt-1 text-start">
                                                                            Upload file baru untuk mengganti.</p>
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="file_sertifikasi"
                                                                    class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm text-start">Inpasing
                                                                <span class="text-red-500">*</span></label>
                                                            <select name="inpasing" x-model="inpasing"
                                                                class="border p-2 rounded w-full text-sm" required>
                                                                <option value="BELUM">BELUM</option>
                                                                <option value="SUDAH">SUDAH</option>
                                                            </select>

                                                            <!-- Upload Inpasing -->
                                                            <div x-show="inpasing === 'SUDAH'" x-transition
                                                                class="mt-2">
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700 text-start">Upload
                                                                    Inpasing</label>
                                                                @if ($d->file_inpasing)
                                                                    <div class="mb-2">
                                                                        <a href="{{ asset('dokumen_dosen/' . $d->file_inpasing) }}"
                                                                            target="_blank"
                                                                            class="text-blue-600 hover:underline text-sm inline-flex items-center">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="h-4 w-4 mr-1" fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke="currentColor">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                            </svg>
                                                                            Lihat file saat ini
                                                                        </a>
                                                                        <p
                                                                            class="text-gray-500 text-xs mt-1 text-start">
                                                                            Upload file baru untuk mengganti.</p>
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="file_inpasing"
                                                                    class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UPLOAD BERKAS DOSEN -->
                                                    <div class="mt-6 border-t pt-6">
                                                        <h3
                                                            class="text-lg font-semibold text-gray-800 mb-4 text-start">
                                                            📎 Upload Berkas Dosen</h3>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-start">
                                                            @php
                                                                $berkasDosenFields = [
                                                                    'file_ktp' => 'KTP',
                                                                    'file_ijazah_s1' => 'Ijazah S1',
                                                                    'file_transkrip_s1' => 'Transkrip Nilai S1',
                                                                    'file_ijazah_s2' => 'Ijazah S2',
                                                                    'file_transkrip_s2' => 'Transkrip Nilai S2',
                                                                    'file_ijazah_s3' => 'Ijazah S3',
                                                                    'file_transkrip_s3' => 'Transkrip Nilai S3',
                                                                    'file_jafung' => 'Jafung',
                                                                    'file_kk' => 'Kartu Keluarga (KK)',
                                                                    'file_perjanjian_kerja' => 'Perjanjian Kerja',
                                                                    'file_sk_pengangkatan' => 'SK Pengangkatan',
                                                                    'file_surat_pernyataan' => 'Surat Pernyataan',
                                                                    'file_sktp' => 'SKTP',
                                                                    'file_surat_tugas' => 'Surat Tugas',
                                                                    'file_sk_aktif' => 'SK Aktif Tridharma',
                                                                ];
                                                            @endphp

                                                            @foreach ($berkasDosenFields as $field => $label)
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm">{{ $label }}</label>
                                                                    @if ($d->$field)
                                                                        <div class="mb-2">
                                                                            <a href="{{ asset('dokumen_dosen/' . $d->$field) }}"
                                                                                target="_blank"
                                                                                class="text-blue-600 hover:underline text-sm inline-flex items-center">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    class="h-4 w-4 mr-1"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke="currentColor">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                                </svg>
                                                                                Lihat file saat ini
                                                                            </a>
                                                                            <p
                                                                                class="text-gray-500 text-xs mt-1 text-start">
                                                                                Upload file baru untuk mengganti.</p>
                                                                        </div>
                                                                    @endif
                                                                    <input type="file" name="{{ $field }}"
                                                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                                                        accept=".pdf,.jpg,.png">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <p class="text-gray-500 text-xs mt-3 text-start">Format:
                                                            <b>PDF, JPG, PNG</b> | Maksimal <b>2MB</b> per file
                                                        </p>
                                                    </div>

                                                    <!-- Tombol Aksi -->
                                                    <div class="flex justify-end mt-6 gap-2 pt-6 border-t">
                                                        <button type="button" @click="openModal = false"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">Batal</button>
                                                        <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endfor
                    @empty
                        <tr>
                            <td colspan="25" class="text-center py-3 text-gray-600">Belum ada data dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dosen->links() }}
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Apakah anda yakin??',
                        text: "Data yang sudah dihapus tidak bisa di kembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
        });

        // Checkbox & Delete Selected - FIXED VERSION
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.select-item');
            const deleteBtn = document.getElementById('delete-selected');

            // Select All functionality
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    toggleDeleteBtn();
                });
            }

            // Individual checkbox change
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    toggleDeleteBtn();
                    // Uncheck select all if any checkbox is unchecked
                    if (selectAll && !this.checked) {
                        selectAll.checked = false;
                    }
                });
            });

            function toggleDeleteBtn() {
                if (!deleteBtn) return;
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                deleteBtn.disabled = !anyChecked;
            }

            // Delete selected handler - IMPROVED VERSION
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    const selected = Array.from(checkboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);

                    if (selected.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Tidak ada data yang dipilih!',
                            timer: 2000
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        html: `Anda akan menghapus <strong>${selected.length} data</strong> yang terpilih!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            const originalText = deleteBtn.innerHTML;
                            deleteBtn.disabled = true;
                            deleteBtn.innerHTML = '<span>Menghapus...</span>';

                            // Kirim data menggunakan fetch API
                            fetch("{{ route('dosen.deleteSelected') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        selected_dosen: selected
                                    })
                                })
                                .then(response => {
                                    // Check if response is JSON
                                    const contentType = response.headers.get('content-type');
                                    if (!contentType || !contentType.includes(
                                            'application/json')) {
                                        throw new TypeError('Response bukan JSON');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: data.message,
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location
                                                .reload(); // Reload halaman setelah sukses
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal!',
                                            text: data.message
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Terjadi kesalahan saat menghapus data: ' +
                                            error.message
                                    });
                                })
                                .finally(() => {
                                    // Reset button state
                                    deleteBtn.disabled = false;
                                    deleteBtn.innerHTML = originalText;
                                });
                        }
                    });
                });
            }
        });
    </script>
    <script>
        // Fungsi untuk form edit dosen
        function formDosenEdit(pendidikanData = [], sertifikasi = 'BELUM', inpasing = 'BELUM') {
            return {
                pendidikan: pendidikanData.length > 0 ? pendidikanData : [{
                    jenjang: '',
                    prodi: '',
                    tahun_lulus: '',
                    universitas: ''
                }],
                sertifikasi: sertifikasi,
                inpasing: inpasing,
                addPendidikan() {
                    this.pendidikan.push({
                        jenjang: '',
                        prodi: '',
                        tahun_lulus: '',
                        universitas: ''
                    });
                },
                removePendidikan(index) {
                    if (this.pendidikan.length > 1) {
                        this.pendidikan.splice(index, 1);
                    }
                },
                initFileValidation() {
                    // Inisialisasi validasi file untuk modal edit
                    const fileInputs = this.$el.querySelectorAll('input[type="file"]');
                    fileInputs.forEach(input => {
                        input.addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                // Validasi ukuran file (2MB)
                                if (file.size > 2 * 1024 * 1024) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'File Terlalu Besar',
                                        text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size /
                                            (1024 * 1024)).toFixed(2) + 'MB',
                                        confirmButtonColor: '#3b82f6'
                                    });
                                    this.value = '';
                                    return;
                                }

                                // Validasi tipe file
                                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg',
                                    'image/png'
                                ];
                                if (!allowedTypes.includes(file.type)) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Format File Tidak Didukung',
                                        text: 'Hanya file PDF, JPG, dan PNG yang diizinkan.',
                                        confirmButtonColor: '#3b82f6'
                                    });
                                    this.value = '';
                                    return;
                                }

                                // Notifikasi sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'File Valid',
                                    text: 'File siap diupload: ' + file.name,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    });
                }
            }
        }

        // Validasi form edit saat submit
        document.addEventListener('DOMContentLoaded', function() {
            // Delegasi event untuk form edit di modal
            document.addEventListener('submit', function(e) {
                if (e.target.closest('form') && e.target.closest('form').getAttribute('action')?.includes(
                        '/dosen/')) {
                    const form = e.target;
                    let isValid = true;
                    let largeFiles = [];

                    // Validasi field required
                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500');
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    // Validasi file upload
                    const fileInputs = form.querySelectorAll('input[type="file"]');
                    fileInputs.forEach(input => {
                        if (input.files.length > 0) {
                            const file = input.files[0];
                            if (file.size > 2 * 1024 * 1024) {
                                isValid = false;
                                largeFiles.push({
                                    name: file.name,
                                    size: (file.size / (1024 * 1024)).toFixed(2)
                                });
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();

                        if (largeFiles.length > 0) {
                            let errorMessage = 'File berikut melebihi 2MB:\n';
                            largeFiles.forEach(file => {
                                errorMessage += `• ${file.name} (${file.size}MB)\n`;
                            });
                            errorMessage += '\nHarap kompres file atau pilih file yang lebih kecil.';

                            Swal.fire({
                                icon: 'error',
                                title: 'File Terlalu Besar',
                                text: errorMessage,
                                confirmButtonColor: '#3b82f6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Belum Lengkap',
                                text: 'Harap isi semua field yang wajib diisi!',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
