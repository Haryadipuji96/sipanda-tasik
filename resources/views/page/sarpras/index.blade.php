<x-app-layout>
    <x-slot name="title">Sarpras</x-slot>
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
        <div class="flex justify-between mb-4">
            <h1 class="text-xl font-semibold">Data Sarpras</h1>
            @canSuperadmin
            <button onclick="window.location='{{ route('sarpras.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor" />
                </svg>
                <span>Tambah</span>
            </button>
            @endcanSuperadmin
        </div>

        <x-search-bar route="sarpras.index" placeholder="Cari nama barang / kategori / prodi..." />

        <button id="delete-selected"
            class="px-3 py-1.5 text-sm rounded-full font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed mb-4"
            disabled>
            <span>Hapus Terpilih</span>
        </button>

        <form method="GET" action="{{ route('sarpras.index') }}" class="mb-4 flex items-center space-x-3">
            <select name="kondisi" class="border rounded px-3 py-2 text-sm">
                <option value="">-- Pilih Kondisi Barang --</option>
                <option value="Baik Sekali" {{ request('kondisi') == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali
                </option>
                <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Cukup" {{ request('kondisi') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan
                </option>
                <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat
                </option>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                Filter
            </button>

            @if (request('kondisi'))
                <a href="{{ route('sarpras.laporan.preview', ['kondisi' => request('kondisi')]) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Preview Laporan
                </a>
            @endif

        </form>



        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2 border text-center w-12" rowspan="2">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Nama Barang</th>
                        <th class="border px-3 py-2">Kategori</th>
                        <th class="border px-3 py-2">Jumlah</th>
                        <th class="border px-3 py-2">Kondisi</th>
                        <th class="border px-3 py-2">Prodi</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
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
                    @forelse ($sarpras as $index => $s)
                        <tr x-data="{ openModal: false }">
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" class="select-item" name="selected_dosen[]"
                                    value="{{ $s->id }}">
                            </td>
                            <td class="border px-3 py-2 text-center">{{ $index + $sarpras->firstItem() }}</td>
                            <td class="border px-3 py-2">{!! highlight($s->nama_barang, request('search')) !!}</td>
                            <td class="border px-3 py-2">{!! highlight($s->kategori, request('search')) !!}</td>
                            <td class="border px-3 py-2 text-center">{{ $s->jumlah }}</td>
                            <td class="border px-3 py-2 text-center">{{ $s->kondisi }}</td>
                            <td class="border px-3 py-2">{!! highlight($s->prodi->nama_prodi ?? '-', request('search')) !!}</td>
                            <td class="border px-3 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('sarpras.show', $s) }}"
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

                                    @canSuperadmin
                                    {{-- Tombol Edit --}}
                                    <button @click="openModal = true"
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
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('sarpras.destroy', $s->id) }}" method="POST"
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
                                        @endcanSuperadmin
                                    </form>
                                </div>

                                {{-- Modal Edit (Landscape Style) --}}
                                <div x-show="openModal" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div @click.away="openModal = false"
                                        class="bg-white rounded-lg w-full max-w-5xl p-6 shadow-lg overflow-y-auto max-h-[90vh]">
                                        <h2 class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2">Edit Data
                                            Sarpras
                                        </h2>

                                        <form action="{{ route('sarpras.update', $s->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="grid grid-cols-2 gap-6">
                                                {{-- === KIRI === --}}
                                                <div>
                                                    {{-- Prodi --}}
                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-start">Program
                                                            Studi
                                                            (Opsional)
                                                        </label>
                                                        <select name="id_prodi"
                                                            class="w-full border rounded px-3 py-2">
                                                            <option value="">-- Pilih Prodi --</option>
                                                            @foreach ($prodi as $p)
                                                                <option value="{{ $p->id }}"
                                                                    {{ $s->id_prodi == $p->id ? 'selected' : '' }}>
                                                                    {{ $p->nama_prodi }}
                                                                    ({{ $p->fakultas->nama_fakultas }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Nama Barang --}}
                                                    <div class="mb-4">
                                                        <label class="block text-sm font-medium mb-1 text-start">Nama
                                                            Barang</label>
                                                        <input type="text" name="nama_barang"
                                                            class="w-full border rounded px-3 py-2"
                                                            value="{{ $s->nama_barang }}" required>
                                                    </div>

                                                    {{-- Kategori --}}
                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-start">Kategori</label>
                                                        <input type="text" name="kategori"
                                                            class="w-full border rounded px-3 py-2"
                                                            value="{{ $s->kategori }}" required>
                                                    </div>

                                                    {{-- Kondisi --}}
                                                    <select name="kondisi"
                                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                                        required>
                                                        <option value="">-- Pilih Kondisi Barang --</option>
                                                        <option value="Baik Sekali"
                                                            {{ old('kondisi', $s->kondisi ?? '') == 'Baik Sekali' ? 'selected' : '' }}>
                                                            Baik Sekali</option>
                                                        <option value="Baik"
                                                            {{ old('kondisi', $s->kondisi ?? '') == 'Baik' ? 'selected' : '' }}>
                                                            Baik</option>
                                                        <option value="Cukup"
                                                            {{ old('kondisi', $s->kondisi ?? '') == 'Cukup' ? 'selected' : '' }}>
                                                            Cukup</option>
                                                        <option value="Rusak Ringan"
                                                            {{ old('kondisi', $s->kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}>
                                                            Rusak Ringan</option>
                                                        <option value="Rusak Berat"
                                                            {{ old('kondisi', $s->kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}>
                                                            Rusak Berat</option>
                                                    </select>


                                                    {{-- Jumlah --}}
                                                    <div class="mb-4">
                                                        <label class="block text-sm font-medium mb-1 text-start">Jumlah
                                                            Barang</label>
                                                        <input type="number" name="jumlah"
                                                            class="w-full border rounded px-3 py-2"
                                                            value="{{ $s->jumlah }}" min="1" required>
                                                    </div>

                                                    {{-- Tanggal Pengadaan --}}
                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-start">Tanggal
                                                            Pengadaan</label>
                                                        <input type="date" name="tanggal_pengadaan"
                                                            class="w-full border rounded px-3 py-2"
                                                            value="{{ $s->tanggal_pengadaan }}" required>
                                                    </div>
                                                </div>

                                                {{-- === KANAN === --}}
                                                <div>
                                                    {{-- Spesifikasi --}}
                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-start">Spesifikasi
                                                            Barang</label>
                                                        <textarea name="spesifikasi" rows="3" class="w-full border rounded px-3 py-2" required>{{ $s->spesifikasi }}</textarea>
                                                    </div>

                                                    {{-- Kode Seri & Sumber --}}
                                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium mb-1 text-start">Kode
                                                                / Seri
                                                                Barang</label>
                                                            <input type="text" name="kode_seri"
                                                                class="w-full border rounded px-3 py-2"
                                                                value="{{ $s->kode_seri }}" required>
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium mb-1 text-start">Sumber
                                                                Barang</label>
                                                            <select name="sumber"
                                                                class="w-full border rounded px-3 py-2" required>
                                                                <option value="HIBAH"
                                                                    {{ $s->sumber == 'HIBAH' ? 'selected' : '' }}>HIBAH
                                                                </option>
                                                                <option value="LEMBAGA"
                                                                    {{ $s->sumber == 'LEMBAGA' ? 'selected' : '' }}>
                                                                    LEMBAGA
                                                                </option>
                                                                <option value="YAYASAN"
                                                                    {{ $s->sumber == 'YAYASAN' ? 'selected' : '' }}>
                                                                    YAYASAN
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Lokasi Lain --}}
                                                    <div class="mb-4">
                                                        <label class="block text-sm font-medium mb-1 text-start">Lokasi
                                                            Lain
                                                            (Opsional)</label>
                                                        <input type="text" name="lokasi_lain"
                                                            class="w-full border rounded px-3 py-2"
                                                            value="{{ $s->lokasi_lain }}">
                                                    </div>

                                                    {{-- 🔹 File Dokumen Saat Ini --}}
                                                    <div
                                                        class="grid w-full max-w-xs items-start gap-1.5 mb-4 text-start">
                                                        <label class="text-sm text-gray-400 font-medium leading-none">
                                                            File Dokumen Saat Ini
                                                        </label>

                                                        @if ($s->file_dokumen)
                                                            <a href="{{ asset('dokumen_sarpras/' . $s->file_dokumen) }}"
                                                                target="_blank" class="text-blue-600 hover:underline">
                                                                {{ $s->file_dokumen }}
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

                                                    {{-- Keterangan --}}
                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium mb-1 text-start">Keterangan</label>
                                                        <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ $s->keterangan }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Tombol --}}
                                            <div class="flex justify-end gap-3 border-t pt-4 mt-4">
                                                <button type="button" @click="openModal = false"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Batal</button>
                                                <button type="submit"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $sarpras->links() }}
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
