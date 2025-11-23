<x-app-layout>
    <x-slot name="title">Dokumen Ijazah & Transkip Nilai Mahasiswa</x-slot>

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

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* =======================
           Highlight Animasi
        ======================= */
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

    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Dokumen Ijazah & Transkip Nilai Mahasiswa</h1>
            @canCrud('dokumen-mahasiswa')
            <button onclick="window.location='{{ route('dokumen-mahasiswa.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                </svg>
                <span>Tambah</span>
            </button>
            @endcanCrud
        </div>

        <!-- Filter Section -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
            <form method="GET" action="{{ route('dokumen-mahasiswa.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full border rounded px-3 py-2 text-sm" placeholder="Cari NIM atau nama...">
                    </div>

                    <!-- Filter Prodi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <select name="prodi_id" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Semua Prodi</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->id }}"
                                    {{ request('prodi_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Status Mahasiswa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Mahasiswa</label>
                        <select name="status_mahasiswa" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status_mahasiswa') == 'Aktif' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="Lulus" {{ request('status_mahasiswa') == 'Lulus' ? 'selected' : '' }}>
                                Lulus</option>
                            <option value="Cuti" {{ request('status_mahasiswa') == 'Cuti' ? 'selected' : '' }}>
                                Cuti</option>
                            <option value="Drop Out" {{ request('status_mahasiswa') == 'Drop Out' ? 'selected' : '' }}>
                                Drop Out</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                    <div class="flex gap-2 order-2 sm:order-1">
                        <a href="{{ route('dokumen-mahasiswa.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm flex items-center">
                            <i class="fas fa-refresh mr-2"></i>
                            Reset
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm flex items-center">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                    </div>
                    
                    <!-- Tombol Import -->
                    @canCrud('dokumen-mahasiswa')
                    <div class="order-1 sm:order-2">
                        <button type="button" onclick="window.location='{{ route('dokumen-mahasiswa.import-form') }}'"
                            class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm flex items-center justify-center">
                            <i class="fas fa-file-import mr-2"></i>
                            Import Excel
                        </button>
                    </div>
                    @endcanCrud
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border px-3 py-2 text-center w-12">No</th>
                        <th class="border px-3 py-2 text-left">NIM</th>
                        <th class="border px-3 py-2 text-left">Nama</th>
                        <th class="border px-3 py-2 text-left">Prodi</th>
                        <th class="border px-3 py-2 text-left">Tahun</th>
                        <th class="border px-3 py-2 text-left">Status</th>
                        <th class="border px-3 py-2 text-left">Dokumen</th>
                        <th class="border px-3 py-2 text-center w-32">Aksi</th>
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
                    @forelse($dokumenMahasiswa as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $dokumenMahasiswa->firstItem() + $index }}</td>
                            <td class="border px-3 py-2 font-mono font-medium">{{ $item->nim }}</td>
                            <td class="border px-3 py-2">{!! highlight($item->nama_lengkap, request('search')) !!}</td>
                            <td class="border px-3 py-2">
                                <div class="text-sm">
                                    <div class="font-medium">{!! highlight($item->prodi->nama_prodi, request('search')) !!}</div>
                                    <div class="text-gray-500 text-xs">
                                        {{ $item->prodi->fakultas->nama_fakultas }}
                                    </div>
                                </div>
                            </td>
                            <td class="border px-3 py-2">
                                <div class="text-sm">
                                    <div>Masuk: {{ $item->tahun_masuk }}</div>
                                    @if ($item->tahun_keluar)
                                        <div class="text-green-600">Lulus: {{ $item->tahun_keluar }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="border px-3 py-2">
                                @php
                                    $statusColor = match ($item->status_mahasiswa) {
                                        'Aktif' => 'bg-blue-100 text-blue-800',
                                        'Lulus' => 'bg-green-100 text-green-800',
                                        'Cuti' => 'bg-yellow-100 text-yellow-800',
                                        'Drop Out' => 'bg-red-100 text-red-800',
                                    };
                                @endphp
                                <span class="badge {{ $statusColor }}">
                                    {{ $item->status_mahasiswa }}
                                </span>
                            </td>
                            <td class="border px-3 py-2">
                                <div class="flex flex-col gap-1 text-xs">
                                    @if ($item->file_ijazah)
                                        <a href="{{ asset('dokumen_mahasiswa/ijazah/' . $item->file_ijazah) }}"
                                            target="_blank"
                                            class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Ijazah
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif

                                    @if ($item->file_transkrip)
                                        <a href="{{ asset('dokumen_mahasiswa/transkrip/' . $item->file_transkrip) }}"
                                            target="_blank"
                                            class="text-green-600 hover:text-green-800 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Transkrip
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="border px-3 py-2 text-center">
                                @canCrud('dokumen-mahasiswa')
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('dokumen-mahasiswa.edit', $item->id) }}"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('dokumen-mahasiswa.destroy', $item->id) }}" method="POST"
                                        class="inline">
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
                                @endcanCrud
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-600">Belum ada data dokumen
                                mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $dokumenMahasiswa->links() }}
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DELETE
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

            // NOTIFIKASI SUKSES
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
</x-app-layout>