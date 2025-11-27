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

        /* =======================
           Zebra Stripe Table - DIPERBARUI
        ======================= */
        .table-custom {
            border-collapse: collapse;
            width: 100%;
        }

        .table-custom thead {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .table-custom th {
            border-right: 1px solid #93c5fd;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: white;
            padding: 12px 16px;
        }

        .table-custom th:last-child {
            border-right: none;
        }

        .table-custom td {
            border-right: 1px solid #e5e7eb;
            vertical-align: top;
            padding: 12px 16px;
        }

        .table-custom td:last-child {
            border-right: none;
        }

        /* Zebra striping untuk baris - DIPERBARUI */
        .table-custom tbody tr:nth-child(odd) {
            background-color: #ffffff;
            /* Putih untuk baris ganjil */
        }

        .table-custom tbody tr:nth-child(even) {
            background-color: #e3f4ff;
            /* Biru sangat muda untuk baris genap */
        }



        /* Styling untuk sel aksi */
        .table-custom .action-cell {
            background-color: transparent !important;
        }
    </style>

    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Dosen</h1>
            @if (auth()->check() && auth()->user()->canCrud('dosen'))
                <button onclick="window.location='{{ route('dosen.create') }}'" class="cssbuttons-io-button">
                    <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                    </svg>
                    <span>Tambah</span>
                </button>
            @endif
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
            <table class="table-custom">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        @if (auth()->check() && auth()->user()->canCrud('dosen'))
                            <th class="px-4 py-2 border text-center w-12" rowspan="3">
                                <input type="checkbox" id="select-all">
                            </th>
                        @endif
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
                                    @if (auth()->check() && auth()->user()->canCrud('dosen'))
                                        <td class="border px-3 py-2 text-center" rowspan="{{ $maxRows }}">
                                            <input type="checkbox" class="select-item" name="selected_dosen[]"
                                                value="{{ $d->id }}">
                                        </td>
                                    @endif
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
                                            @if (auth()->check() && auth()->user()->canCrud('dosen'))
                                                <!-- Edit Button with Modal -->
                                                <a href="{{ route('dosen.edit', $d->id) }}"
                                                    class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </a>

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
                                            @endif
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
