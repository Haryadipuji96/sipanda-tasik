<x-app-layout>
    <x-slot name="title">Data Sarpras</x-slot>

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

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .btn-view {
            background-color: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background-color: #2563eb;
        }

        .btn-add {
            background-color: #10b981;
            color: white;
        }

        .btn-add:hover {
            background-color: #059669;
        }

        .btn-edit {
            background-color: #f59e0b;
            color: white;
        }

        .btn-edit:hover {
            background-color: #d97706;
        }

        .btn-delete {
            background-color: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background-color: #dc2626;
        }
    </style>

    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Sarpras</h1>
            <button onclick="window.location='{{ route('ruangan.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                </svg>
                <span>Tambah</span>
            </button>
        </div>

        {{-- <!-- Alert Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif --}}

        <!-- Filter Section -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
            <form method="GET" action="{{ route('ruangan.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full border rounded px-3 py-2 text-sm" placeholder="Cari ruangan...">
                    </div>

                    <!-- Filter Tipe Ruangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Ruangan</label>
                        <select name="tipe_ruangan" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Semua Tipe</option>
                            <option value="akademik" {{ request('tipe_ruangan') == 'akademik' ? 'selected' : '' }}>
                                Akademik</option>
                            <option value="umum" {{ request('tipe_ruangan') == 'umum' ? 'selected' : '' }}>Umum
                            </option>
                        </select>
                    </div>

                    {{-- <!-- Filter Prodi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <select name="prodi" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Semua Prodi</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->id }}" {{ request('prodi') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>

                <div class="flex mt-4 space-x-2">
                    <a href="{{ route('ruangan.index') }}"
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
            </form>
        </div>

        <!-- Table -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border px-3 py-2 text-left">No</th>
                        <th class="border px-3 py-2 text-left">Nama Ruangan</th>
                        <th class="border px-3 py-2 text-left">Tipe</th>
                        <th class="border px-3 py-2 text-left">Lokasi</th>
                        <th class="border px-3 py-2 text-left">Kondisi</th>
                        <th class="border px-3 py-2 text-left">Tanggal Dibuat</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ruangan as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">{{ $ruangan->firstItem() + $index }}</td>
                            <td class="border px-3 py-2 font-medium">{{ $item->nama_ruangan }}</td>

                            <!-- Tipe Ruangan -->
                            <td class="border px-3 py-2">
                                @if ($item->tipe_ruangan == 'akademik')
                                    <span
                                        class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Akademik</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Umum</span>
                                @endif
                            </td>

                            <!-- Lokasi -->
                            <td class="border px-3 py-2">
                                @if ($item->tipe_ruangan == 'akademik')
                                    <div class="text-sm">
                                        <div class="font-medium">{{ $item->prodi->nama_prodi ?? 'N/A' }}</div>
                                        <div class="text-gray-600 text-xs">
                                            {{ $item->prodi->fakultas->nama_fakultas ?? 'N/A' }}</div>
                                    </div>
                                @else
                                    <div class="text-sm font-medium text-green-700">{{ $item->unit_umum }}</div>
                                @endif
                            </td>

                            <!-- Kondisi -->
                            <td class="border px-3 py-2">
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                                    {{ $item->kondisi_ruangan == 'Baik' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $item->kondisi_ruangan == 'Rusak Ringan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $item->kondisi_ruangan == 'Rusak Berat' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $item->kondisi_ruangan }}
                                </span>
                            </td>

                            <td class="border px-3 py-2">{{ $item->created_at->format('d/m/Y') }}</td>
                            <td class="border px-3 py-2">
                                <div class="flex flex-col gap-2">
                                    <!-- Tombol Lihat Barang & Tambah Barang -->
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('ruangan.show', $item->id) }}" class="btn-action btn-view"
                                            title="Lihat Barang">
                                            <i class="fas fa-list w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('ruangan.tambah-barang', $item->id) }}"
                                            class="btn-action btn-add" title="Tambah Barang">
                                            <i class="fas fa-plus w-4 h-4"></i>
                                        </a>
                                    </div>

                                    <!-- Tombol Edit & Hapus -->
                                    <div class="flex gap-2 justify-center">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('ruangan.edit', $item->id) }}" class="btn-action btn-edit"
                                            title="Edit Ruangan">
                                            <i class="fas fa-edit w-4 h-4"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-action btn-delete delete-btn"
                                                title="Hapus">
                                                <i class="fas fa-trash w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">Belum ada data ruangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $ruangan->links() }}</div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DELETE
            const deleteButtons = document.querySelectorAll('.delete-btn');
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
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
</x-app-layout>
