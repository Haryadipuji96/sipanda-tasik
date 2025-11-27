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

    <div class="py-10 px-6" x-data="{ openModal: null }">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">Data Tenaga Pendidik</h2>
            @if (auth()->check() && auth()->user()->canCrud('tenaga-pendidik'))
                <button onclick="window.location='{{ route('tenaga-pendidik.create') }}'" class="cssbuttons-io-button">
                    <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor" />
                    </svg>
                    <span>Tambah</span>
                </button>
            @endif
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
            <table class="table-custom">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        @if (auth()->check() && auth()->user()->canCrud('tenaga-pendidik'))
                            <th rowspan="2" class="px-4 py-2 border text-center w-12">
                                <input type="checkbox" id="select-all">
                            </th>
                        @endif
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
                            @if (auth()->check() && auth()->user()->canCrud('tenaga-pendidik'))
                                <td class="border px-3 py-2 text-center">
                                    <input type="checkbox" class="select-item" name="selected_tendik[]"
                                        value="{{ $t->id }}">
                                </td>
                            @endif
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

                                    @if (auth()->check() && auth()->user()->canCrud('tenaga-pendidik'))
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('tenaga-pendidik.edit', $t->id) }}"
                                            class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('tenaga-pendidik.destroy', $t->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn-delete p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition"
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
        // Function untuk form golongan (Alpine.js)
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
                },
                init() {
                    // Auto-capitalize untuk input nama dalam modal ini
                    const namaInput = this.$el.querySelector('input[name="nama_tendik"]');
                    if (namaInput) {
                        namaInput.addEventListener('blur', function() {
                            this.value = this.value.replace(/\w\S*/g, function(txt) {
                                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                            });
                        });
                    }

                    // Validasi file inputs dalam modal ini
                    const fileInputs = this.$el.querySelectorAll('input[type="file"]');
                    fileInputs.forEach(input => {
                        input.addEventListener('change', function(e) {
                            validateFileEdit(this, true);
                        });
                    });

                    // Form validation untuk modal edit
                    const editForm = this.$el.querySelector('form[action*="tenaga-pendidik"]');
                    if (editForm) {
                        editForm.addEventListener('submit', function(e) {
                            handleEditFormSubmit.call(this, e);
                        });
                    }
                }
            }
        }

        // Function untuk validasi file
        function validateFileEdit(input, showSuccess = false) {
            const file = input.files[0];
            if (!file) return true;

            console.log('Validating file:', file.name, file.size, file.type);

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB',
                    confirmButtonText: 'Mengerti'
                });
                input.value = '';
                return false;
            }

            // Validate file type
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/jpg',
                'image/png'
            ];

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Tidak Didukung',
                    text: 'Hanya file PDF, DOC, DOCX, JPG, dan PNG yang diizinkan.',
                    confirmButtonText: 'Mengerti'
                });
                input.value = '';
                return false;
            }

            // Show success message jika diminta
            if (showSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: 'File Valid',
                    text: 'File siap diupload: ' + file.name,
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            return true;
        }

        // Function untuk handle form submit modal edit
        function handleEditFormSubmit(e) {
            const namaTendik = this.querySelector('input[name="nama_tendik"]');

            // Validasi nama wajib diisi
            if (!namaTendik || !namaTendik.value.trim()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Lengkap',
                    text: 'Nama Tenaga Pendidik wajib diisi!',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            // Validasi semua file inputs sebelum submit
            const fileInputs = this.querySelectorAll('input[type="file"]');
            let allFilesValid = true;

            fileInputs.forEach(input => {
                if (input.files.length > 0) {
                    if (!validateFileEdit(input, false)) {
                        allFilesValid = false;
                    }
                }
            });

            if (!allFilesValid) {
                e.preventDefault();
            } else {
                // Jika semua valid, tampilkan konfirmasi update
                e.preventDefault();

                Swal.fire({
                    title: 'Update Data Tenaga Pendidik?',
                    html: `Apakah Anda yakin ingin mengupdate data <strong>${namaTendik.value}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form jika dikonfirmasi
                        this.submit();
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - initializing event listeners');

            // SweetAlert untuk delete confirmation
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Checkbox & Delete Selected functionality
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

            // Delete selected handler
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
                            // Create form dynamically
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('tenaga-pendidik.deleteSelected') }}";

                            // Add CSRF token
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            // Add selected items
                            selected.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'selected_tendik[]';
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

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: true
                });
            @endif
        });

        // Initialize Alpine.js component
        document.addEventListener('alpine:init', () => {
            Alpine.data('formGolongan', formGolongan);
        });
    </script>
</x-app-layout>
