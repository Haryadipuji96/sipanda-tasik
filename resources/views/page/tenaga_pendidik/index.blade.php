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

    <div class="py-10 px-6" x-data="{ openModal: null }">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">Data Tenaga Pendidik</h2>
            @canSuperadmin
            <button onclick="window.location='{{ route('tenaga-pendidik.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor" />
                </svg>
                <span>Tambah</span>
            </button>
            @endcanSuperadmin
        </div>

        <x-search-bar route="tenaga-pendidik.index" placeholder="Cari nama / prodi / jabatan..." />

        <button id="delete-selected"
            class="px-3 py-1.5 text-sm rounded-full font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed mb-4"
            disabled>
            <span>Hapus Terpilih</span>
        </button>

        <!-- Card Table -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2 border text-center w-12" rowspan="2">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="px-4 py-3 border text-center w-16">No</th>
                        <th class="px-4 py-3 border text-left w-64">Nama</th>
                        <th class="px-4 py-3 border text-left w-56">Program Studi</th>
                        <th class="px-4 py-3 border text-left w-48">Jabatan</th>
                        <th class="px-4 py-3 border text-center w-44">Status</th>
                        <th class="px-4 py-3 border text-center w-40">Aksi</th>
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
                    @forelse($tenaga as $no => $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" class="select-item" name="selected_dosen[]"
                                    value="{{ $t->id }}">
                            </td>
                           <td class="border px-3 py-2 text-center">{{ $no + $tenaga->firstItem() }}</td>
                            <td class="border px-4 py-2">{!! highlight($t->nama_tendik, request('search')) !!}</td>
                            <td class="border px-4 py-2">{!! highlight($t->prodi->nama_prodi ?? '-', request('search')) !!}</td>
                            <td class="border px-4 py-2">{!! highlight($t->jabatan, request('search')) !!}</td>
                            <td class="border px-4 py-2 text-center">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $t->status_kepegawaian === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $t->status_kepegawaian }}
                                </span>
                            </td>

                            <td class="border px-3 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('tenaga-pendidik.show', $t) }}"
                                        class="inline-flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 text-white px-2 py-1 rounded transition"
                                        title="Lihat Detail">
                                        <i class="fa-solid fa-eye-low-vision"></i>
                                    </a>

                                    @canSuperadmin
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
                                    @endcanSuperadmin

                                    @canSuperadmin
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
                                    @endcanSuperadmin
                                </div>

                                <!-- Modal Edit -->
                                <div x-show="openModal === {{ $t->id }}" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div @click.away="openModal = null"
                                        class="bg-white rounded-lg w-full max-w-5xl p-6 shadow-lg overflow-y-auto max-h-[90vh]">
                                        <h2 class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2">Edit Data
                                            Tenaga Pendidik</h2>

                                        <form action="{{ route('tenaga-pendidik.update', $t->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <!-- Grid Landscape -->
                                            <div class="grid grid-cols-2 gap-4">
                                                <!-- Kolom Kiri -->
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">Program
                                                            Studi</label>
                                                        <select name="id_prodi" class="border p-2 rounded w-full">
                                                            <option value="">-- Pilih Prodi --</option>
                                                            @foreach ($prodi as $p)
                                                                <option value="{{ $p->id }}"
                                                                    {{ $t->id_prodi == $p->id ? 'selected' : '' }}>
                                                                    {{ $p->nama_prodi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">Nama Tenaga
                                                            Pendidik</label>
                                                        <input type="text" name="nama_tendik"
                                                            value="{{ $t->nama_tendik }}"
                                                            class="border p-2 rounded w-full">
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">NIP</label>
                                                        <input type="text" name="nip"
                                                            value="{{ $t->nip }}"
                                                            class="border p-2 rounded w-full">
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">Jabatan</label>
                                                        <input type="text" name="jabatan"
                                                            value="{{ $t->jabatan }}"
                                                            class="border p-2 rounded w-full">
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">Status
                                                            Kepegawaian</label>
                                                        <select name="status_kepegawaian"
                                                            class="border p-2 rounded w-full">
                                                            @foreach (['PNS', 'Honorer', 'Kontrak'] as $status)
                                                                <option value="{{ $status }}"
                                                                    {{ $t->status_kepegawaian == $status ? 'selected' : '' }}>
                                                                    {{ $status }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Kolom Kanan -->
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">Pendidikan
                                                            Terakhir</label>
                                                        <input type="text" name="pendidikan_terakhir"
                                                            value="{{ $t->pendidikan_terakhir }}"
                                                            class="border p-2 rounded w-full">
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">Jenis
                                                            Kelamin</label>
                                                        <select name="jenis_kelamin"
                                                            class="border p-2 rounded w-full">
                                                            @foreach (['laki-laki', 'perempuan'] as $jk)
                                                                <option value="{{ $jk }}"
                                                                    {{ $t->jenis_kelamin == $jk ? 'selected' : '' }}>
                                                                    {{ ucfirst($jk) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">No HP</label>
                                                        <input type="text" name="no_hp"
                                                            value="{{ $t->no_hp }}"
                                                            class="border p-2 rounded w-full">
                                                    </div>

                                                    <div>
                                                        <label class="block font-medium mb-1 text-start">Email</label>
                                                        <input type="email" name="email"
                                                            value="{{ $t->email }}"
                                                            class="border p-2 rounded w-full">
                                                    </div>

                                                    {{-- 🔹 File Dokumen Saat Ini --}}
                                                    <div
                                                        class="grid w-full max-w-xs items-start gap-1.5 mb-4 text-start">
                                                        <label class="text-sm text-gray-400 font-medium leading-none">
                                                            File Dokumen Saat Ini
                                                        </label>

                                                        @if ($t->file)
                                                            <a href="{{ asset('dokumen_tendik/' . $t->file) }}"
                                                                target="_blank" class="text-blue-600 hover:underline">
                                                                {{ $t->file }}
                                                            </a>

                                                            <p class="text-gray-500 text-xs mt-1">
                                                                Upload file baru untuk mengganti yang lama.
                                                            </p>
                                                        @else
                                                            <p class="text-gray-500 italic text-sm">Belum ada file.</p>
                                                        @endif

                                                        <input type="file" name="file" id="file"
                                                            class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                                            accept=".pdf,.doc,.docx,.jpg,.png" />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Baris bawah -->
                                            <div class="mt-4 grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block font-medium mb-1 text-start">Alamat</label>
                                                    <textarea name="alamat" class="border p-2 rounded w-full">{{ $t->alamat }}</textarea>
                                                </div>
                                                <div>
                                                    <label class="block font-medium mb-1 text-start">Keterangan</label>
                                                    <textarea name="keterangan" class="border p-2 rounded w-full">{{ $t->keterangan }}</textarea>
                                                </div>
                                            </div>

                                            <div class="flex justify-end mt-6 gap-2">
                                                <button type="button" @click="openModal = null"
                                                    class="bg-red-500 text-white px-4 py-2 rounded">Batal</button>
                                                <button type="submit"
                                                    class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500 italic">
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
