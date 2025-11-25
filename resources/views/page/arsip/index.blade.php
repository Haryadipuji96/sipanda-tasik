<x-app-layout>
    <x-slot name="title">Data arsip</x-slot>
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
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Arsip</h1>
            @canCrud('arsip')
            <button onclick="window.location='{{ route('arsip.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                </svg>
                <span>Tambah</span>
            </button>
            @endcanCrud
        </div>

        <x-search-bar route="arsip.index" placeholder="Cari judul / kategori..." />


        <!-- Letakkan setelah button "Hapus Terpilih" dan sebelum tabel -->
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-2 mb-4">
            @canCrud('arsip')
            <!-- Button Hapus Terpilih -->
            <button id="delete-selected"
                class="order-2 sm:order-1 px-3 py-1.5 text-sm rounded-full font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-center sm:w-auto"
                disabled>
                <span>Hapus Terpilih</span>
            </button>
            @endcanCrud

            <!-- Export Buttons -->
            <div class="order-1 sm:order-2 flex gap-2">
                <!-- Button Preview PDF -->
                <a href="{{ route('arsip.preview-all.pdf', request()->query()) }}"
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
                <a href="{{ route('arsip.export.excel', ['search' => request('search')]) }}"
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

        <!-- Tabel Arsip -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        @canCrud('arsip')
                        <th class="px-4 py-2 border text-center w-12" rowspan="2">
                            <input type="checkbox" id="select-all">
                        </th>
                        @endcanCrud
                        <th class="border px-3 py-2 text-center w-12">No</th>
                        <th class="border px-3 py-2 text-left">Judul Dokumen</th>
                        <th class="border px-3 py-2 text-left">Nomor Dokumen</th>
                        <th class="border px-3 py-2 text-left">Tanggal</th>
                        <th class="border px-3 py-2 text-left">Tahun</th>
                        <th class="border px-3 py-2 text-left">Kategori</th>

                        <th class="border px-3 py-2 text-left">Keterangan</th>
                        <th class="border px-3 py-2 text-center">File</th>
                        <th class="border px-3 py-2 text-center w-32">Aksi</th>
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
                    @forelse ($arsip as $index => $a)
                        <tr class="hover:bg-gray-50">
                            <!-- Di dalam tabel, ganti name="selected_dosen[]" menjadi name="selected_arsip[]" -->
                            @canCrud('arsip')
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" class="select-item" name="selected_arsip[]"
                                    value="{{ $a->id }}">
                            </td>
                            @endcanCrud
                            <td class="border px-3 py-2 text-center">{{ $index + $arsip->firstItem() }}</td>
                            <td class="border px-3 py-2">{!! highlight($a->judul_dokumen, request('search')) !!}</td>
                            <td class="border px-3 py-2">{{ $a->nomor_dokumen ?? '-' }}</td>
                            <td class="border px-3 py-2">
                                {{ $a->tanggal_dokumen ? \Carbon\Carbon::parse($a->tanggal_dokumen)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="border px-3 py-2 text-center">{{ $a->tahun ?? '-' }}</td>
                            <td class="border px-3 py-2">{!! highlight($a->kategori->nama_kategori ?? '-', request('search')) !!}</td>

                            <td class="border px-3 py-2">{{ $a->keterangan ?? '-' }}</td>

                            <td class="border px-4 py-2 text-center">
                                @if ($a->file_dokumen)
                                    <a href="{{ asset('dokumen_arsip/' . $a->file_dokumen) }}" target="_blank"
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
                                <div class="flex items-center justify-center gap-2">
                                    <div x-data="{ openModal: false }">
                                        @canCrud('arsip')
                                        <!-- Tombol Edit -->
                                        <button @click="openModal = true"
                                            class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </button>
                                        @endcanCrud

                                        <form action="{{ route('arsip.destroy', $a->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            @canCrud('arsip')
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
                                            @endcanCrud
                                        </form>
                                        <!-- Modal Edit -->
                                        <div x-show="openModal" x-cloak
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                            <div @click.away="openModal = false"
                                                class="relative bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 mx-4 overflow-y-auto max-h-[90vh]">
                                                <button @click="openModal = false"
                                                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>
                                                <h1
                                                    class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2 text-start">
                                                    Edit Data Arsip
                                                </h1>

                                                <form action="{{ route('arsip.update', $a->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    {{-- Kategori Arsip --}}
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-start">Kategori
                                                            Arsip</label>
                                                        <select name="id_kategori"
                                                            class="w-full border rounded px-3 py-2" required>
                                                            @foreach ($kategori as $k)
                                                                <option value="{{ $k->id }}"
                                                                    {{ $k->id == $a->id_kategori ? 'selected' : '' }}>
                                                                    {{ $k->nama_kategori }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    {{-- Judul --}}
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-start">Judul
                                                            Dokumen</label>
                                                        <input type="text" name="judul_dokumen"
                                                            value="{{ $a->judul_dokumen }}"
                                                            class="w-full border rounded px-3 py-2" required>
                                                    </div>

                                                    {{-- Nomor & Tanggal --}}
                                                    <div class="mb-4 grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Nomor
                                                                Dokumen</label>
                                                            <input type="text" name="nomor_dokumen"
                                                                value="{{ $a->nomor_dokumen }}"
                                                                class="w-full border rounded px-3 py-2">
                                                        </div>
                                                        <div>
                                                            <label class="block font-medium mb-1 text-start">Tanggal
                                                                Dokumen</label>
                                                            <input type="date" name="tanggal_dokumen"
                                                                value="{{ $a->tanggal_dokumen }}"
                                                                class="w-full border rounded px-3 py-2">
                                                        </div>
                                                    </div>

                                                    {{-- Tahun --}}
                                                    <div class="mb-4">
                                                        <label class="block font-medium mb-1 text-start">Tahun</label>
                                                        <input type="text" name="tahun"
                                                            value="{{ $a->tahun }}"
                                                            class="w-full border rounded px-3 py-2">
                                                    </div>


                                                    {{-- 🔹 File Dokumen Saat Ini --}}
                                                    <!-- GANTI bagian file info di modal edit -->
                                                    <div
                                                        class="grid w-full max-w-xs items-start gap-1.5 mb-4 text-start">
                                                        <label class="text-sm text-gray-400 font-medium leading-none">
                                                            File Dokumen Saat Ini
                                                        </label>

                                                        @if ($a->file_dokumen)
                                                            <a href="{{ asset('dokumen_arsip/' . $a->file_dokumen) }}"
                                                                target="_blank" class="text-blue-600 hover:underline">
                                                                {{ $a->file_dokumen }}
                                                            </a>
                                                            <p class="text-gray-500 text-xs mt-1">
                                                                Upload file baru untuk mengganti yang lama.
                                                                <strong>Maks. 2MB</strong> <!-- TAMBAHKAN INI -->
                                                            </p>
                                                        @else
                                                            <p class="text-gray-500 italic text-sm">Belum ada file.</p>
                                                        @endif

                                                        <input type="file" name="file_dokumen" id="file_dokumen"
                                                            class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                                            accept=".pdf,.doc,.docx,.jpg,.png" />
                                                        <p class="text-gray-500 text-xs">Format: PDF, DOC, DOCX, JPG,
                                                            PNG - Maks. 2MB</p> <!-- TAMBAHKAN INI -->
                                                    </div>
                                                    {{-- Keterangan --}}
                                                    <div class="mb-4">
                                                        <label
                                                            class="block font-medium mb-1 text-start">Keterangan</label>
                                                        <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ $a->keterangan }}</textarea>
                                                    </div>

                                                    {{-- Tombol --}}
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('arsip.index') }}"
                                                            class="bg-red-500 text-white px-4 py-2 rounded">Batal</a>
                                                        <button type="submit"
                                                            class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-3 text-gray-600">Belum ada data arsip.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $arsip->links() }}
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
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    toggleDeleteBtn();
                });
            }

            // Toggle tombol hapus ketika checkbox dipilih
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    toggleDeleteBtn();
                    // Uncheck select all jika ada checkbox yang diuncheck
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

            // Event hapus terpilih - FIXED VERSION
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
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        html: `Anda akan menghapus <strong>${selected.length} data arsip</strong> yang terpilih!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create form dynamically - FIXED VERSION
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('arsip.deleteSelected') }}";

                            // CSRF Token
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            // Selected items
                            selected.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'selected_arsip[]';
                                input.value = id;
                                form.appendChild(input);
                            });

                            // Submit form
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // File validation untuk modal edit
        const editFileInput = document.getElementById('file_dokumen');
        if (editFileInput) {
            editFileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB'
                        });
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    const allowedTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'image/jpeg', 'image/jpg', 'image/png'
                    ];
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Didukung',
                            text: 'Hanya file PDF, DOC, DOCX, JPG, dan PNG yang diizinkan.'
                        });
                        this.value = '';
                        return;
                    }

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'File Valid',
                        text: 'File siap diupload: ' + file.name,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }

        // Form validation untuk modal edit
        const editForm = document.querySelector('form[action*="arsip"]');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const kategori = this.querySelector('select[name="id_kategori"]');
                const judulDokumen = this.querySelector('input[name="judul_dokumen"]');
                
                if (!kategori || !judulDokumen) return;

                if (!kategori.value || !judulDokumen.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Belum Lengkap',
                        text: 'Kategori Arsip dan Judul Dokumen wajib diisi!'
                    });
                    return;
                }
            });
        }
    });
</script>

</x-app-layout>
