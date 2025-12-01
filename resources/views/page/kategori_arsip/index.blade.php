<x-app-layout>
    <x-slot name="title">Kategori arsip</x-slot>
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
        }

        .table-custom tbody tr:nth-child(even) {
            background-color: #e3f4ff;
        }

        /* Styling untuk sel aksi */
        .table-custom .action-cell {
            background-color: transparent !important;
        }
    </style>

    <div class="p-6">
        <!-- Header & Tambah -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Kategori Arsip</h1>
            <button onclick="window.location='{{ route('kategori-arsip.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                </svg>
                <span>Tambah</span>
            </button>
        </div>

        <!-- Search Bar Component -->
        <x-search-bar route="kategori-arsip.index" placeholder="Cari nama kategori atau deskripsi..." />

        <!-- Info Pencarian Aktif -->
        @if (request('search'))
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-search text-blue-500 mr-2"></i>
                        <span class="text-blue-700 text-sm">
                            Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                        </span>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                        {{ $kategori->total() }} hasil ditemukan
                    </span>
                </div>
            </div>
        @endif

        <!-- Table -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="table-custom">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border px-3 py-2 text-left">No</th>
                        <th class="border px-3 py-2 text-left">Nama Kategori</th>
                        <th class="border px-3 py-2 text-left">Deskripsi</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
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

                    @forelse($kategori as $index => $k)
                        <tr x-data="{ openModal: false }">
                            <td class="border px-3 py-2">{{ $index + $kategori->firstItem() }}</td>
                            <td class="border px-3 py-2 font-medium">
                                {!! highlight($k->nama_kategori, request('search')) !!}
                            </td>
                            <td class="border px-3 py-2">
                                @if ($k->deskripsi)
                                    {!! highlight($k->deskripsi, request('search')) !!}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="border px-3 py-2 text-center flex justify-center gap-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('kategori-arsip.edit', $k->id) }}"
                                    class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition duration-200 shadow-sm"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('kategori-arsip.destroy', $k->id) }}" method="POST"
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8">
                                @if (request('search'))
                                    <div class="text-gray-500">
                                        <i class="fas fa-search fa-2x mb-2"></i>
                                        <p>Tidak ditemukan kategori arsip dengan kata kunci "{{ request('search') }}"</p>
                                        <a href="{{ route('kategori-arsip.index') }}" class="text-blue-500 hover:text-blue-700 text-sm mt-2 inline-block">
                                            Tampilkan semua data
                                        </a>
                                    </div>
                                @else
                                    <div class="text-gray-500">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Belum ada data kategori arsip.</p>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $kategori->links() }}
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
                        title: 'Apakah anda yakin??',
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

            // SweetAlert untuk sukses CREATE / UPDATE / DELETE
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

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>