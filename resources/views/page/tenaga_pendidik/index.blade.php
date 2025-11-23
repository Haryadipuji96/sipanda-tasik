<x-app-layout>
    <x-slot name="title">Data Tenaga Pendidik</x-slot>
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
    </style>

    <div class="py-10 px-6" x-data="{ openModal: null }">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">Data Tenaga Pendidik</h2>
            @canCrud('tenaga-pendidik')
            <button onclick="window.location='{{ route('tenaga-pendidik.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor" />
                </svg>
                <span>Tambah</span>
            </button>
            @endcanCrud
        </div>

        <x-search-bar route="tenaga-pendidik.index" placeholder="Cari nama / NIP / prodi..." />

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-2 mb-4">

            <!-- Button Hapus Terpilih -->
            <button id="delete-selected"
                class="order-2 sm:order-1 px-3 py-1.5 text-sm rounded-full font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-center sm:w-auto"
                disabled>
                <span>Hapus Terpilih</span>
            </button>


            <div class="order-1 sm:order-2 flex gap-2">
                <!-- Button Preview PDF -->
                <a href="{{ route('tenaga-pendidik.preview-all.pdf', ['search' => request('search')]) }}"
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
                <a href="{{ route('tenaga-pendidik.export.excel', ['search' => request('search')]) }}"
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

        <!-- Table -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        @canCrud('tenaga-pendidik')
                        <th rowspan="2" class="px-4 py-2 border text-center w-12">
                            <input type="checkbox" id="select-all">
                        </th>
                        @endcanCrud
                        <th rowspan="2" class="px-4 py-2 border text-center w-12">No</th>
                        <th rowspan="2" class="border px-4 py-2">Nama Lengkap</th>
                        <th rowspan="2" class="border px-4 py-2">Posisi/Jabatan</th>
                        <th rowspan="2" class="border px-4 py-2">Gelar Depan</th>
                        <th rowspan="2" class="border px-4 py-2">Gelar Belakang</th>
                        <th rowspan="2" class="border px-4 py-2">Program Studi</th>
                        <th rowspan="2" class="border px-4 py-2">Status Kepegawaian</th>
                        <th rowspan="2" class="border px-4 py-2">Jenis Kelamin</th>
                        <th rowspan="2" class="border px-4 py-2">TMT Kerja</th>
                        <th rowspan="2" class="border px-4 py-2 text-center">NIP/NIK</th>
                        <th rowspan="2" class="border px-4 py-2 text-center">Keterangan</th>
                        
                        <th rowspan="2" class="border px-4 py-2 text-center w-40">Aksi</th>
                        
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
                @endphp

                <tbody>
                    @forelse ($tenaga as $index => $t)
                        <tr class="hover:bg-gray-50" x-data="{ openModal: false }">
                            @canCrud('tenaga-pendidik')
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" class="select-item" name="selected_tendik[]"
                                    value="{{ $t->id }}">
                            </td>
                            @endcanCrud
                            <td class="border px-3 py-2 text-center">
                                {{ $index + $tenaga->firstItem() }}
                            </td>
                            <td class="border px-4 py-2">
                                {!! highlight($t->nama_tendik, request('search')) !!}
                            </td>
                            <td class="border px-4 py-2"> <!-- KOLOM BARU -->
                                {!! highlight($t->jabatan_struktural ?? '-', request('search')) !!}
                            </td>
                            <td class="border px-4 py-2">
                                {!! highlight($t->gelar_depan, request('search')) !!}
                            </td>
                            <td class="border px-4 py-2">
                                {!! highlight($t->gelar_belakang, request('search')) !!}
                            </td>
                            <td class="border px-4 py-2">
                                {!! highlight($t->prodi->nama_prodi ?? '-', request('search')) !!}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $t->status_kepegawaian ?? '-' }}
                            </td>
                            <td class="border px-4 py-2">
                                @if ($t->jenis_kelamin == 'laki-laki')
                                    Laki-laki
                                @elseif($t->jenis_kelamin == 'perempuan')
                                    Perempuan
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">
                                {{ $t->tmt_kerja ? $t->tmt_kerja->format('d/m/Y') : '-' }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                {!! highlight($t->nip ?? '-', request('search')) !!}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                {{ $t->keterangan ?? '-' }}
                            </td>
                            <td class="border px-3 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('tenaga-pendidik.show', $t->id) }}"
                                        class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full transition"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @canCrud('tenaga-pendidik')
                                    <!-- Tombol Edit -->
                                    <button @click="openModal = {{ $t->id }}"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('tenaga-pendidik.destroy', $t->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn-delete p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition"
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endcanCrud
                                </div>
                                <!-- Modal Edit -->
                                <div x-show="openModal === {{ $t->id }}" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div @click.away="openModal = null"
                                        class="bg-white rounded-lg w-full max-w-6xl p-6 shadow-lg overflow-y-auto max-h-[90vh]"
                                        x-data="formGolongan({{ json_encode($t->golongan_array) }})">
                                        <h2 class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2">Edit Data
                                            Tenaga Pendidik</h2>

                                        <form action="{{ route('tenaga-pendidik.update', $t->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <!-- Program Studi & Jabatan Struktural -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label class="block font-medium mb-1 text-sm">Program Studi</label>
                                                    <select name="id_prodi" class="border p-2 rounded w-full text-sm">
                                                        <option value="">-- Pilih Prodi (Opsional) --</option>
                                                        @foreach ($prodi as $p)
                                                            <option value="{{ $p->id }}"
                                                                {{ $t->id_prodi == $p->id ? 'selected' : '' }}>
                                                                {{ $p->nama_prodi }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block font-medium mb-1 text-sm">Posisi/Jabatan
                                                        Struktural</label>
                                                    <select name="jabatan_struktural"
                                                        class="border p-2 rounded w-full text-sm">
                                                        <option value="">-- Pilih Posisi --</option>
                                                        @foreach (App\Models\TenagaPendidik::getJabatanStrukturalOptions() as $jabatan)
                                                            <option value="{{ $jabatan }}"
                                                                {{ $t->jabatan_struktural == $jabatan ? 'selected' : '' }}>
                                                                {{ $jabatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                                <!-- Kolom Kiri -->
                                                <div class="space-y-4">
                                                    <!-- Nama & Gelar -->
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">Gelar
                                                                Depan</label>
                                                            <input type="text" name="gelar_depan"
                                                                value="{{ $t->gelar_depan }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Contoh: Dr.">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">Nama Tenaga
                                                                Pendidik</label>
                                                            <input type="text" name="nama_tendik"
                                                                value="{{ $t->nama_tendik }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Masukkan nama lengkap" required>
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">Gelar
                                                                Belakang</label>
                                                            <input type="text" name="gelar_belakang"
                                                                value="{{ $t->gelar_belakang }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Contoh: S.Pd">
                                                        </div>
                                                    </div>

                                                    <!-- Status Kepegawaian & Jenis Kelamin -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">Status
                                                                Kepegawaian</label>
                                                            <select name="status_kepegawaian"
                                                                class="border p-2 rounded w-full text-sm">
                                                                <option value="">-- Pilih Status --</option>
                                                                <option value="PNS"
                                                                    {{ $t->status_kepegawaian == 'PNS' ? 'selected' : '' }}>
                                                                    PNS</option>
                                                                <option value="Non PNS Tetap"
                                                                    {{ $t->status_kepegawaian == 'Non PNS Tetap' ? 'selected' : '' }}>
                                                                    Non PNS Tetap</option>
                                                                <option value="Non PNS Tidak Tetap"
                                                                    {{ $t->status_kepegawaian == 'Non PNS Tidak Tetap' ? 'selected' : '' }}>
                                                                    Non PNS Tidak Tetap</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">Jenis
                                                                Kelamin</label>
                                                            <select name="jenis_kelamin"
                                                                class="border p-2 rounded w-full text-sm">
                                                                <option value="">-- Pilih Jenis Kelamin --
                                                                </option>
                                                                <option value="laki-laki"
                                                                    {{ $t->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                                                                    Laki-laki</option>
                                                                <option value="perempuan"
                                                                    {{ $t->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                                                                    Perempuan</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Tempat, Tanggal Lahir & TMT Kerja -->
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">Tempat
                                                                Lahir</label>
                                                            <input type="text" name="tempat_lahir"
                                                                value="{{ $t->tempat_lahir }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="Tempat lahir">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">Tanggal
                                                                Lahir</label>
                                                            <input type="date" name="tanggal_lahir"
                                                                value="{{ $t->tanggal_lahir ? $t->tanggal_lahir->format('Y-m-d') : '' }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">TMT
                                                                Kerja</label>
                                                            <input type="date" name="tmt_kerja"
                                                                value="{{ $t->tmt_kerja ? $t->tmt_kerja->format('Y-m-d') : '' }}"
                                                                class="border p-2 rounded w-full text-sm">
                                                        </div>
                                                    </div>

                                                    <!-- Pendidikan Terakhir -->
                                                    <div>
                                                        <label class="block font-medium mb-1 text-sm">Pendidikan
                                                            Terakhir</label>
                                                        <select name="pendidikan_terakhir"
                                                            class="border p-2 rounded w-full text-sm">
                                                            <option value="">-- Pilih Pendidikan Terakhir --
                                                            </option>
                                                            <option value="SMA/Sederajat"
                                                                {{ $t->pendidikan_terakhir == 'SMA/Sederajat' ? 'selected' : '' }}>
                                                                SMA/Sederajat</option>
                                                            <option value="D1"
                                                                {{ $t->pendidikan_terakhir == 'D1' ? 'selected' : '' }}>
                                                                D1</option>
                                                            <option value="D2"
                                                                {{ $t->pendidikan_terakhir == 'D2' ? 'selected' : '' }}>
                                                                D2</option>
                                                            <option value="D3"
                                                                {{ $t->pendidikan_terakhir == 'D3' ? 'selected' : '' }}>
                                                                D3</option>
                                                            <option value="D4"
                                                                {{ $t->pendidikan_terakhir == 'D4' ? 'selected' : '' }}>
                                                                D4</option>
                                                            <option value="S1"
                                                                {{ $t->pendidikan_terakhir == 'S1' ? 'selected' : '' }}>
                                                                S1</option>
                                                            <option value="S2"
                                                                {{ $t->pendidikan_terakhir == 'S2' ? 'selected' : '' }}>
                                                                S2</option>
                                                            <option value="S3"
                                                                {{ $t->pendidikan_terakhir == 'S3' ? 'selected' : '' }}>
                                                                S3</option>
                                                            <option value="Profesi"
                                                                {{ $t->pendidikan_terakhir == 'Profesi' ? 'selected' : '' }}>
                                                                Profesi</option>
                                                            <option value="Spesialis"
                                                                {{ $t->pendidikan_terakhir == 'Spesialis' ? 'selected' : '' }}>
                                                                Spesialis</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Kolom Kanan -->
                                                <div class="space-y-4">
                                                    <!-- NIP, No HP, Email -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">NIP</label>
                                                            <input type="text" name="nip"
                                                                value="{{ $t->nip }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="NIP">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-sm">No HP</label>
                                                            <input type="text" name="no_hp"
                                                                value="{{ $t->no_hp }}"
                                                                class="border p-2 rounded w-full text-sm"
                                                                placeholder="08xxxx">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-sm">Email</label>
                                                        <input type="email" name="email"
                                                            value="{{ $t->email }}"
                                                            class="border p-2 rounded w-full text-sm"
                                                            placeholder="email@example.com">
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-sm">Alamat</label>
                                                        <input type="text" name="alamat"
                                                            value="{{ $t->alamat }}"
                                                            class="border p-2 rounded w-full text-sm"
                                                            placeholder="Alamat lengkap">
                                                    </div>

                                                    <!-- Keterangan -->
                                                    <div>
                                                        <label
                                                            class="block font-medium mb-1 text-sm">Keterangan</label>
                                                        <textarea name="keterangan" class="border p-2 rounded w-full text-sm" rows="3"
                                                            placeholder="Tambahkan keterangan">{{ $t->keterangan }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Riwayat Golongan -->
                                            <div class="mt-6 border-t pt-6">
                                                <div class="flex justify-between items-center mb-3">
                                                    <label class="block font-medium text-sm">Riwayat Golongan</label>
                                                    <button type="button" @click="addGolongan()"
                                                        class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                                        + Update Riwayat
                                                    </button>
                                                </div>

                                                <template x-for="(item, index) in golongan" :key="index">
                                                    <div
                                                        class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-2 p-2 bg-gray-50 rounded">
                                                        <div>
                                                            <input type="text"
                                                                :name="'golongan[' + index + '][tahun]'"
                                                                x-model="item.tahun"
                                                                class="border rounded px-2 py-1 w-full text-sm"
                                                                placeholder="Tahun">
                                                        </div>
                                                        <div>
                                                            <input type="text"
                                                                :name="'golongan[' + index + '][golongan]'"
                                                                x-model="item.golongan"
                                                                class="border rounded px-2 py-1 w-full text-sm"
                                                                placeholder="Golongan">
                                                        </div>
                                                        <div class="flex items-center">
                                                            <button type="button" @click="removeGolongan(index)"
                                                                class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600"
                                                                x-show="golongan.length > 1">
                                                                × Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>

                                            <!-- UPLOAD BERKAS BARU -->
                                            <div class="mt-6 border-t pt-6">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-4">📎 Upload Berkas
                                                </h3>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    @php
                                                        $berkasFields = [
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

                                                    @foreach ($berkasFields as $field => $label)
                                                        <div>
                                                            <label
                                                                class="block font-medium mb-1 text-sm">{{ $label }}</label>
                                                            @if ($t->$field)
                                                                <div class="mb-2">
                                                                    <a href="{{ asset('dokumen_tendik/' . $t->$field) }}"
                                                                        target="_blank"
                                                                        class="text-blue-600 hover:underline text-sm inline-flex items-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-4 w-4 mr-1" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
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
                                                                    <p class="text-gray-500 text-xs mt-1">Upload file
                                                                        baru untuk mengganti.</p>
                                                                </div>
                                                            @endif
                                                            <input type="file" name="{{ $field }}"
                                                                class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                                                accept=".pdf,.jpg,.png">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <p class="text-gray-500 text-xs mt-3">Format: <b>PDF, JPG, PNG</b> |
                                                    Maksimal <b>2MB</b> per file</p>
                                            </div>

                                            <!-- Upload File Utama (Lama) -->
                                            <div class="mt-6 border-t pt-6">
                                                <label for="file" class="block font-medium mb-1 text-sm">Upload
                                                    File Dokumen Lainnya</label>
                                                @if ($t->file)
                                                    <div class="mb-2">
                                                        <a href="{{ asset('dokumen_tendik/' . $t->file) }}"
                                                            target="_blank"
                                                            class="text-blue-600 hover:underline text-sm inline-flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            {{ $t->file }}
                                                        </a>
                                                        <p class="text-gray-500 text-xs mt-1">Upload file baru untuk
                                                            mengganti yang lama.</p>
                                                    </div>
                                                @else
                                                    <p class="text-gray-500 italic text-sm mb-2">Belum ada file.</p>
                                                @endif

                                                <input type="file" name="file" id="file"
                                                    class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                                    accept=".pdf,.doc,.docx,.jpg,.png" />
                                                <p class="text-gray-500 text-xs mt-1">Format: <b>PDF, DOC, DOCX, JPG,
                                                        PNG</b> | Max 2MB</p>
                                            </div>

                                            <!-- Tombol Aksi -->
                                            <div class="flex justify-end mt-6 gap-2 pt-6 border-t">
                                                <button type="button" @click="openModal = null"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">Batal</button>
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-6 text-gray-500 italic">
                                Belum ada data tenaga pendidik.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $tenaga->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function formGolongan(initialData = []) {
            return {
                golongan: initialData.length > 0 ? initialData : [{
                    tahun: '',
                    golongan: ''
                }],
                addGolongan() {
                    this.golongan.push({
                        tahun: '',
                        golongan: ''
                    });
                },
                removeGolongan(index) {
                    if (this.golongan.length > 1) {
                        this.golongan.splice(index, 1);
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
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
            const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
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
                    form.action = "{{ route('tenaga-pendidik.deleteSelected') }}";
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                        ${selected.map(id => `<input type="hidden" name="selected_tendik[]" value="${id}">`).join('')}
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
</x-app-layout>
