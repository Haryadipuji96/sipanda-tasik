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
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                            <div @click.away="openModal = false"
                                                class="relative bg-white rounded-xl shadow-xl w-full max-w-6xl p-6 mx-4 overflow-y-auto max-h-[90vh]"
                                                x-data="formDosenEdit({{ json_encode($d->pendidikan_array ?? []) }}, '{{ $d->sertifikasi }}', '{{ $d->inpasing }}')">
                                                <button @click="openModal = false"
                                                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>
                                                <h1
                                                    class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2 text-start">
                                                    Edit Data Dosen - {{ $d->nama }}
                                                </h1>

                                                <form action="{{ route('dosen.update', $d->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Program Studi -->
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-start">Program Studi
                                                            <span class="text-red-500">*</span></label>
                                                        <select name="id_prodi"
                                                            class="w-full border rounded px-3 py-2" required>
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
                                                    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Gelar
                                                                Depan</label>
                                                            <input type="text" name="gelar_depan"
                                                                value="{{ $d->gelar_depan }}"
                                                                class="w-full border rounded px-3 py-2"
                                                                placeholder="Dr.">
                                                        </div>
                                                        <div class="md:col-span-2">
                                                            <label class="block font-medium mb-1 text-start">Nama
                                                                Lengkap
                                                                <span class="text-red-500">*</span></label>
                                                            <input type="text" name="nama"
                                                                value="{{ $d->nama }}"
                                                                class="w-full border rounded px-3 py-2" required>
                                                        </div>
                                                    </div>

                                                    <!-- Gelar Belakang -->
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-start">Gelar
                                                            Belakang</label>
                                                        <input type="text" name="gelar_belakang"
                                                            value="{{ $d->gelar_belakang }}"
                                                            class="w-full border rounded px-3 py-2"
                                                            placeholder="M.Pd., M.Kom.">
                                                    </div>

                                                    <!-- Tempat & Tanggal Lahir -->
                                                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Tempat
                                                                Lahir</label>
                                                            <input type="text" name="tempat_lahir"
                                                                value="{{ $d->tempat_lahir }}"
                                                                class="w-full border rounded px-3 py-2">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Tanggal
                                                                Lahir</label>
                                                            <input type="date" name="tanggal_lahir"
                                                                value="{{ $d->tanggal_lahir }}"
                                                                class="w-full border rounded px-3 py-2">
                                                        </div>
                                                    </div>

                                                    <!-- NIDN & NUPTK -->
                                                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-start">NIDN</label>
                                                            <input type="text" name="nik"
                                                                value="{{ $d->nik }}"
                                                                class="w-full border rounded px-3 py-2">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-start">NUPTK</label>
                                                            <input type="text" name="nuptk"
                                                                value="{{ $d->nuptk }}"
                                                                class="w-full border rounded px-3 py-2">
                                                        </div>
                                                    </div>

                                                    <!-- Pendidikan Terakhir -->
                                                    <div class="mb-4" x-data="{ pendidikanTerakhir: '{{ $d->pendidikan_terakhir ?? '' }}' }">
                                                        <label class="block font-medium mb-1 text-start">Pendidikan
                                                            Terakhir</label>
                                                        <select name="pendidikan_terakhir"
                                                            x-model="pendidikanTerakhir"
                                                            class="w-full border rounded px-3 py-2 mb-2">
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
                                                                class="w-full border rounded px-3 py-2"
                                                                placeholder="Masukkan pendidikan lainnya">
                                                        </div>
                                                    </div>

                                                    <!-- Riwayat Pendidikan -->
                                                    <div class="mb-6 border-t pt-4">
                                                        <div class="flex justify-between items-center mb-3">
                                                            <label class="block font-medium">Riwayat Pendidikan</label>
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
                                                                        class="text-xs text-gray-600">Jenjang</label>
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
                                                                        class="text-xs text-gray-600">Prodi/Jurusan</label>
                                                                    <input type="text"
                                                                        :name="'pendidikan[' + index + '][prodi]'"
                                                                        x-model="item.prodi"
                                                                        class="w-full border rounded px-2 py-1 text-sm"
                                                                        placeholder="PAI">
                                                                </div>
                                                                <div>
                                                                    <label class="text-xs text-gray-600">Tahun
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
                                                                            class="text-xs text-gray-600">Universitas/PT</label>
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

                                                    <!-- Jabatan -->
                                                    <div class="mb-4">
                                                        <label
                                                            class="block font-medium mb-1 text-start">Jabatan</label>
                                                        <input type="text" name="jabatan"
                                                            value="{{ $d->jabatan }}"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <!-- TMT Kerja -->
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-start">TMT
                                                            Kerja</label>
                                                        <input type="date" name="tmt_kerja"
                                                            value="{{ $d->tmt_kerja }}"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>

                                                    <!-- Masa Kerja -->
                                                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Masa Kerja
                                                                (Tahun)</label>
                                                            <input type="number" name="masa_kerja_tahun"
                                                                value="{{ $d->masa_kerja_tahun }}"
                                                                class="w-full border rounded px-3 py-2"
                                                                min="0">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Masa Kerja
                                                                (Bulan)</label>
                                                            <input type="number" name="masa_kerja_bulan"
                                                                value="{{ $d->masa_kerja_bulan }}"
                                                                class="w-full border rounded px-3 py-2" min="0"
                                                                max="11">
                                                        </div>
                                                    </div>

                                                    <!-- Golongan -->
                                                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-start">Pangkat/Golongan</label>
                                                            <input type="text" name="pangkat_golongan"
                                                                value="{{ $d->pangkat_golongan }}"
                                                                class="w-full border rounded px-3 py-2"
                                                                placeholder="III/b">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Jabatan
                                                                Fungsional</label>
                                                            <input type="text" name="jabatan_fungsional"
                                                                value="{{ $d->jabatan_fungsional }}"
                                                                class="w-full border rounded px-3 py-2"
                                                                placeholder="Lektor">
                                                        </div>
                                                    </div>

                                                    <!-- Masa Kerja Golongan -->
                                                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Masa Kerja
                                                                Golongan (Tahun)</label>
                                                            <input type="number" name="masa_kerja_golongan_tahun"
                                                                value="{{ $d->masa_kerja_golongan_tahun }}"
                                                                class="w-full border rounded px-3 py-2"
                                                                min="0">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Masa Kerja
                                                                Golongan (Bulan)</label>
                                                            <input type="number" name="masa_kerja_golongan_bulan"
                                                                value="{{ $d->masa_kerja_golongan_bulan }}"
                                                                class="w-full border rounded px-3 py-2" min="0"
                                                                max="11">
                                                        </div>
                                                    </div>

                                                    <!-- No SK & JaFung -->
                                                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">No
                                                                SK</label>
                                                            <input type="text" name="no_sk"
                                                                value="{{ $d->no_sk }}"
                                                                class="w-full border rounded px-3 py-2"
                                                                placeholder="123/SK/2024">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">JaFung (No
                                                                SK)</label>
                                                            <input type="text" name="no_sk_jafung"
                                                                value="{{ $d->no_sk_jafung }}"
                                                                class="w-full border rounded px-3 py-2"
                                                                placeholder="Lektor">
                                                        </div>
                                                    </div>

                                                    <!-- Sertifikasi & Inpasing -->
                                                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-start">Sertifikasi
                                                                <span class="text-red-500">*</span></label>
                                                            <select name="sertifikasi" x-model="sertifikasi"
                                                                class="w-full border rounded px-3 py-2" required>
                                                                <option value="BELUM">BELUM</option>
                                                                <option value="SUDAH">SUDAH</option>
                                                            </select>

                                                            <!-- Upload Sertifikasi -->
                                                            <div x-show="sertifikasi === 'SUDAH'" x-transition
                                                                class="mt-2">
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    Sertifikasi</label>
                                                                @if ($d->file_sertifikasi)
                                                                    <div class="mb-2">
                                                                        <p class="text-sm text-green-600">File saat
                                                                            ini: {{ $d->file_sertifikasi }}</p>
                                                                        <p class="text-xs text-gray-500">Upload file
                                                                            baru untuk mengganti</p>
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="file_sertifikasi"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                                <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG,
                                                                    PNG | Maks: 2MB</p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Inpasing
                                                                <span class="text-red-500">*</span></label>
                                                            <select name="inpasing" x-model="inpasing"
                                                                class="w-full border rounded px-3 py-2" required>
                                                                <option value="BELUM">BELUM</option>
                                                                <option value="SUDAH">SUDAH</option>
                                                            </select>

                                                            <!-- Upload Inpasing -->
                                                            <div x-show="inpasing === 'SUDAH'" x-transition
                                                                class="mt-2">
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    Inpasing</label>
                                                                @if ($d->file_inpasing)
                                                                    <div class="mb-2">
                                                                        <p class="text-sm text-green-600">File saat
                                                                            ini: {{ $d->file_inpasing }}</p>
                                                                        <p class="text-xs text-gray-500">Upload file
                                                                            baru untuk mengganti</p>
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="file_inpasing"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                                <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG,
                                                                    PNG | Maks: 2MB</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Upload Berkas Dosen -->
                                                    <div class="mb-6 border-t pt-6">
                                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload
                                                            Berkas Dosen</h3>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <!-- Kolom 1 -->
                                                            <div class="space-y-4">
                                                                <!-- KTP -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        KTP</label>
                                                                    @if ($d->file_ktp)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_ktp }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_ktp"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>

                                                                <!-- Ijazah S1 -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        Ijazah S1</label>
                                                                    @if ($d->file_ijazah_s1)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_ijazah_s1 }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_ijazah_s1"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>

                                                                <!-- Transkrip S1 -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        Transkrip S1</label>
                                                                    @if ($d->file_transkrip_s1)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_transkrip_s1 }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_transkrip_s1"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>

                                                                <!-- Ijazah S2 -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        Ijazah S2</label>
                                                                    @if ($d->file_ijazah_s2)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_ijazah_s2 }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_ijazah_s2"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>
                                                            </div>

                                                            <!-- Kolom 2 -->
                                                            <div class="space-y-4">
                                                                <!-- Transkrip S2 -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        Transkrip S2</label>
                                                                    @if ($d->file_transkrip_s2)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_transkrip_s2 }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_transkrip_s2"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>

                                                                <!-- Ijazah S3 -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        Ijazah S3</label>
                                                                    @if ($d->file_ijazah_s3)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_ijazah_s3 }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_ijazah_s3"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>

                                                                <!-- Transkrip S3 -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        Transkrip S3</label>
                                                                    @if ($d->file_transkrip_s3)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_transkrip_s3 }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_transkrip_s3"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>

                                                                <!-- Jafung -->
                                                                <div>
                                                                    <label
                                                                        class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                        Jafung</label>
                                                                    @if ($d->file_jafung)
                                                                        <p class="text-sm text-green-600 mb-1">File:
                                                                            {{ $d->file_jafung }}</p>
                                                                    @endif
                                                                    <input type="file" name="file_jafung"
                                                                        class="w-full border rounded px-3 py-2 text-sm">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Baris 2 -->
                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                                            <!-- KK -->
                                                            <div>
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    KK</label>
                                                                @if ($d->file_kk)
                                                                    <p class="text-sm text-green-600 mb-1">File:
                                                                        {{ $d->file_kk }}</p>
                                                                @endif
                                                                <input type="file" name="file_kk"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                            </div>

                                                            <!-- Perjanjian Kerja -->
                                                            <div>
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    Perjanjian Kerja</label>
                                                                @if ($d->file_perjanjian_kerja)
                                                                    <p class="text-sm text-green-600 mb-1">File:
                                                                        {{ $d->file_perjanjian_kerja }}</p>
                                                                @endif
                                                                <input type="file" name="file_perjanjian_kerja"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                            </div>

                                                            <!-- SK Pengangkatan -->
                                                            <div>
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    SK Pengangkatan</label>
                                                                @if ($d->file_sk_pengangkatan)
                                                                    <p class="text-sm text-green-600 mb-1">File:
                                                                        {{ $d->file_sk_pengangkatan }}</p>
                                                                @endif
                                                                <input type="file" name="file_sk_pengangkatan"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                            </div>
                                                        </div>

                                                        <!-- Baris 3 -->
                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                                            <!-- Surat Pernyataan -->
                                                            <div>
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    Surat Pernyataan</label>
                                                                @if ($d->file_surat_pernyataan)
                                                                    <p class="text-sm text-green-600 mb-1">File:
                                                                        {{ $d->file_surat_pernyataan }}</p>
                                                                @endif
                                                                <input type="file" name="file_surat_pernyataan"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                            </div>

                                                            <!-- SKTP -->
                                                            <div>
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    SKTP</label>
                                                                @if ($d->file_sktp)
                                                                    <p class="text-sm text-green-600 mb-1">File:
                                                                        {{ $d->file_sktp }}</p>
                                                                @endif
                                                                <input type="file" name="file_sktp"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                            </div>

                                                            <!-- Surat Tugas -->
                                                            <div>
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    Surat Tugas</label>
                                                                @if ($d->file_surat_tugas)
                                                                    <p class="text-sm text-green-600 mb-1">File:
                                                                        {{ $d->file_surat_tugas }}</p>
                                                                @endif
                                                                <input type="file" name="file_surat_tugas"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                            </div>
                                                        </div>

                                                        <!-- Baris 4 -->
                                                        <div class="mt-4">
                                                            <!-- SK Aktif -->
                                                            <div>
                                                                <label
                                                                    class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                                    SK Aktif Tridharma</label>
                                                                @if ($d->file_sk_aktif)
                                                                    <p class="text-sm text-green-600 mb-1">File:
                                                                        {{ $d->file_sk_aktif }}</p>
                                                                @endif
                                                                <input type="file" name="file_sk_aktif"
                                                                    class="w-full border rounded px-3 py-2 text-sm">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Aksi -->
                                                    <div class="flex justify-end space-x-2 mt-6">
                                                        <button type="button" @click="openModal = false"
                                                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Batal</button>
                                                        <button type="submit"
                                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Update</button>
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

        // Checkbox & Delete Selected
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.select-item');
            const deleteBtn = document.getElementById('delete-selected');

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                toggleDeleteBtn();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', toggleDeleteBtn);
            });

            function toggleDeleteBtn() {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                deleteBtn.disabled = !anyChecked;
            }

            deleteBtn.addEventListener('click', function() {
                const selected = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selected.length === 0) return;

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang terpilih akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('dosen.deleteSelected') }}";
                        form.innerHTML = `
                    @csrf
                    @method('DELETE')
                    ${selected.map(id => `<input type="hidden" name="selected_dosen[]" value="${id}">`).join('')}
                `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        function formDosenEdit(existingData, sertifikasiValue, inpasingValue) {
            return {
                pendidikan: existingData.length ? existingData : [{
                    jenjang: '',
                    prodi: '',
                    tahun_lulus: '',
                    universitas: ''
                }],
                sertifikasi: sertifikasiValue,
                inpasing: inpasingValue,
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
                }
            }
        }
    </script>
</x-app-layout>
