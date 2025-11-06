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


        <!-- Table -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border px-3 py-2 text-left">No</th>
                        <th class="border px-3 py-2 text-left">Nama Kategori</th>
                        <th class="border px-3 py-2 text-left">Deskripsi</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $k)
                        <tr x-data="{ openModal: false }">
                            <td class="border px-3 py-2">{{ $index + $kategori->firstItem() }}</td>
                            <td class="border px-3 py-2">{{ $k->nama_kategori }}</td>
                            <td class="border px-3 py-2">{{ $k->deskripsi }}</td>
                            <td class="border px-3 py-2 text-center flex justify-center gap-2">
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

                                <!-- Modal Edit -->
                                <div x-show="openModal" x-cloak x-transition.opacity
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                    <div @click.away="openModal = false" x-transition.scale
                                        class="relative bg-white rounded-xl shadow-xl w-full max-w-lg p-6 mx-4">

                                        <button @click="openModal = false"
                                            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                                            ✕
                                        </button>

                                        <h1 class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2 text-start">
                                            Edit Kategori Arsip
                                        </h1>

                                        <form action="{{ route('kategori-arsip.update', $k->id) }}" method="POST"
                                            class="edit-form">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4">
                                                <label class="block font-medium mb-1">Nama Kategori</label>
                                                <input type="text" name="nama_kategori"
                                                    value="{{ $k->nama_kategori }}"
                                                    class="w-full border rounded px-3 py-2" required>
                                            </div>

                                            <div class="mb-4">
                                                <label class="block font-medium mb-1">Deskripsi</label>
                                                <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2">{{ $k->deskripsi }}</textarea>
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
                                <!-- End Modal -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3">Belum ada data kategori arsip.</td>
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
