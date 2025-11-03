<x-app-layout>
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

        /* =======================
           Highlight Animasi
        ======================= */
        .highlight {
            background-color: #fde68a;
            /* kuning lembut */
            font-weight: 600;
            border-radius: 4px;
            padding: 0 2px;
            animation: fadeGlow 1.2s ease-out;
        }

        @keyframes fadeGlow {
            0% {
                background-color: #facc15;
                /* kuning terang */
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

    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Dosen</h1>
            @canSuperadmin
            <button onclick="window.location='{{ route('dosen.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                </svg>
                <span>Tambah</span>
            </button>
            @endcanSuperadmin
        </div>


        <x-search-bar route="dosen.index" placeholder="Cari nama / prodi / jabatan..." />

        <button id="delete-selected"
            class="px-3 py-1.5 text-sm rounded-full font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed mb-4"
            disabled>
            <span>Hapus Terpilih</span>
        </button>


        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2 border text-center w-12" rowspan="2">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th rowspan="2" class="px-4 py-2 border text-center w-12">No</th>
                        <th rowspan="2" class="border px-4 py-2">Nama</th>
                        <th rowspan="2" class="border px-4 py-2">Prodi</th>
                        <th rowspan="2" class="border px-4 py-2">Tempat Lahir</th>
                        <th rowspan="2" class="border px-4 py-2">NIK</th>
                        <th rowspan="2" class="border px-4 py-2">Pendidikan Terakhir</th>
                        <th rowspan="2" class="border px-4 py-2">Jabatan</th>
                        <th rowspan="2" class="border px-4 py-2">TMT Kerja</th>
                        <th colspan="2" class="border px-4 py-2 text-center">Masa Kerja</th>
                        <th rowspan="2" class="border px-4 py-2 text-center">Golongan</th>
                        <th colspan="2" class="border px-4 py-2 text-center">Masa Kerja Golongan</th>
                        <th rowspan="2" class="border px-4 py-2 text-center">File Dokumen</th>
                        <th rowspan="2" class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th class="border px-2 py-1">Thn</th>
                        <th class="border px-2 py-1">Bln</th>
                        <th class="border px-2 py-1">Thn</th>
                        <th class="border px-2 py-1">Bln</th>
                    </tr>
                </thead>
                @php
                    function highlight($text, $search)
                    {
                        if (!$search) {
                            return e($text);
                        }
                        // Hanya ini yang diganti:
                        return preg_replace(
                            '/(' . preg_quote($search, '/') . ')/i',
                            '<span class="highlight">$1</span>',
                            e($text),
                        );
                    }
                @endphp
                <tbody>
                    @forelse ($dosen as $index => $d)
                        <tr class="hover:bg-gray-50" x-data="{ openModal: false }">
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" class="select-item" name="selected_dosen[]"
                                    value="{{ $d->id }}">
                            </td>
                            <td class="border px-3 py-2 text-center">{{ $index + $dosen->firstItem() }}</td>
                            <td class="border px-4 py-2">{!! highlight($d->nama, request('search')) !!}</td>
                            <td class="border px-4 py-2">{!! highlight($d->prodi->nama_prodi ?? '-', request('search')) !!}</td>
                            <td class="border px-4 py-2">{{ $d->tempat_lahir ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $d->nik ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $d->pendidikan_terakhir ?? '-' }}</td>
                            <td class="border px-4 py-2">{!! highlight($d->jabatan, request('search')) !!}</td>
                            <td class="border px-4 py-2 text-center">{{ $d->tmt_kerja ?? '-' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_tahun ?? 0 }}</td>
                            <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_bulan ?? 0 }}</td>
                            <td class="border px-4 py-2 text-center">{{ $d->golongan ?? '-' }}</td>
                            <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_golongan_tahun ?? 0 }}</td>
                            <td class="border px-4 py-2 text-center">{{ $d->masa_kerja_golongan_bulan ?? 0 }}</td>
                            <td class="border px-4 py-2 text-center">
                                @if ($d->file_dokumen)
                                    <a href="{{ asset('dokumen_dosen/' . $d->file_dokumen) }}" target="_blank"
                                        class="inline-flex items-center text-blue-600 hover:text-blue-800 underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-gray-500 italic">-</span>
                                @endif
                            </td>
                            <td class="border px-3 py-2 text-center">
                                @canSuperadmin
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openModal = true"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('dosen.destroy', $d->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition btn-delete"
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @endcanSuperadmin

                                <!-- Modal Edit -->
                                <div x-show="openModal" x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                    <div @click.away="openModal = false"
                                        class="relative bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 mx-4 overflow-y-auto max-h-[90vh]">
                                        <button @click="openModal = false"
                                            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>
                                        <h1 class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2 text-start">
                                            Edit
                                            Data Dosen
                                        </h1>

                                        <form action="{{ route('dosen.update', $d->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <!-- Program Studi -->
                                            <div class="mb-4">
                                                <label class="block font-medium mb-1 text-start">Program Studi</label>
                                                <select name="id_prodi" class="w-full border rounded px-3 py-2"
                                                    required>
                                                    <option value="">-- Pilih Prodi --</option>
                                                    @foreach ($prodi as $p)
                                                        <option value="{{ $p->id }}"
                                                            {{ $p->id == $d->id ? 'selected' : '' }}>
                                                            {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Nama -->
                                            <div class="mb-4">
                                                <label class="block font-medium mb-1 text-start">Nama Lengkap</label>
                                                <input type="text" name="nama" value="{{ $d->nama }}"
                                                    class="w-full border rounded px-3 py-2" required>
                                            </div>

                                            <!-- Tempat & Tanggal Lahir -->
                                            <div class="mb-4 grid grid-cols-2 gap-4">
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

                                            <!-- NIK -->
                                            <div class="mb-4">
                                                <label class="block font-medium mb-1 text-start">NIK</label>
                                                <input type="text" name="nik" value="{{ $d->nik }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <!-- Pendidikan Terakhir -->
                                            <div class="mb-4">
                                                <label class="block font-medium mb-1 text-start">Pendidikan
                                                    Terakhir</label>
                                                <input type="text" name="pendidikan_terakhir"
                                                    value="{{ $d->pendidikan_terakhir }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <!-- Jabatan -->
                                            <div class="mb-4">
                                                <label class="block font-medium mb-1 text-start">Jabatan</label>
                                                <input type="text" name="jabatan" value="{{ $d->jabatan }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <!-- TMT Kerja -->
                                            <div class="mb-4">
                                                <label class="block font-medium mb-1 text-start">TMT Kerja</label>
                                                <input type="date" name="tmt_kerja" value="{{ $d->tmt_kerja }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <!-- Masa Kerja -->
                                            <div class="mb-4 grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block font-medium mb-1 text-start">Masa Kerja
                                                        (Tahun)
                                                    </label>
                                                    <input type="number" name="masa_kerja_tahun"
                                                        value="{{ $d->masa_kerja_tahun }}"
                                                        class="w-full border rounded px-3 py-2" min="0">
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
                                            <div class="mb-4">
                                                <label class="block font-medium mb-1 text-start">Golongan</label>
                                                <input type="text" name="golongan" value="{{ $d->golongan }}"
                                                    class="w-full border rounded px-3 py-2">
                                            </div>

                                            <!-- Masa Kerja Golongan -->
                                            <div class="mb-4 grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block font-medium mb-1 text-start">Masa Kerja
                                                        Golongan
                                                        (Tahun)
                                                    </label>
                                                    <input type="number" name="masa_kerja_golongan_tahun"
                                                        value="{{ $d->masa_kerja_golongan_tahun }}"
                                                        class="w-full border rounded px-3 py-2" min="0">
                                                </div>
                                                <div>
                                                    <label class="block font-medium mb-1 text-start">Masa Kerja
                                                        Golongan
                                                        (Bulan)</label>
                                                    <input type="number" name="masa_kerja_golongan_bulan"
                                                        value="{{ $d->masa_kerja_golongan_bulan }}"
                                                        class="w-full border rounded px-3 py-2" min="0"
                                                        max="11">
                                                </div>
                                            </div>


                                            {{-- 🔹 File Dokumen Saat Ini --}}
                                            <div class="grid w-full max-w-xs items-start gap-1.5 mb-4 text-start">
                                                <label class="text-sm text-gray-400 font-medium leading-none">
                                                    File Dokumen Saat Ini
                                                </label>

                                                @if ($d->file_dokumen)
                                                    <a href="{{ asset('dokumen_dosen/' . $d->file_dokumen) }}"
                                                        target="_blank" class="text-blue-600 hover:underline">
                                                        {{ $d->file_dokumen }}
                                                    </a>

                                                    <p class="text-gray-500 text-xs mt-1">
                                                        Upload file baru untuk mengganti yang lama.
                                                    </p>
                                                @else
                                                    <p class="text-gray-500 italic text-sm">Belum ada file.</p>
                                                @endif

                                                <input type="file" name="file_dokumen" id="file_dokumen"
                                                    class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                                    accept=".pdf,.doc,.docx,.jpg,.png" />
                                            </div>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="openModal = false"
                                                    class="bg-red-500 text-white px-4 py-2 rounded">Batal</button>
                                                <button type="submit"
                                                    class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center py-3 text-gray-600">Belum ada data dosen.</td>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.select-item');
            const deleteBtn = document.getElementById('delete-selected');

            // Toggle semua checkbox
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                toggleDeleteBtn();
            });

            // Toggle tombol hapus ketika checkbox dipilih
            checkboxes.forEach(cb => {
                cb.addEventListener('change', toggleDeleteBtn);
            });

            function toggleDeleteBtn() {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                deleteBtn.disabled = !anyChecked;
            }

            // Event hapus terpilih
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

</x-app-layout>
