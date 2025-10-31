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
    </style>

    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Fakultas</h1>
            <button onclick="window.location='{{ route('fakultas.create') }}'" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                </svg>
                <span>Tambah</span>
            </button>
        </div>

        <table class="w-full border text-sm">
            <thead class="bg-gray-600 text-white">
                <tr>
                    <th class="border px-3 py-2 text-left">No</th>
                    <th class="border px-3 py-2 text-left">Nama Fakultas</th>
                    <th class="border px-3 py-2 text-left">Dekan</th>
                    <th class="border px-3 py-2 text-left">Deskripsi</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fakultas as $index => $f)
                    <tr x-data="{ openModal: false }">
                        <td class="border px-3 py-2">{{ $index + $fakultas->firstItem() }}</td>
                        <td class="border px-3 py-2">{{ $f->nama_fakultas }}</td>
                        <td class="border px-3 py-2">{{ $f->dekan }}</td>
                        <td class="border px-3 py-2">{{ $f->deskripsi }}</td>
                        <td class="border px-3 py-2 text-center space-x-2">
                            <div class="flex items-center justify-center gap-2">
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
                                <form action="{{ route('fakultas.destroy', $f->id_fakultas) }}" method="POST"
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

                            <!-- MODAL EDIT -->
                            <div x-show="openModal" x-cloak x-transition.opacity
                                class="!fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm"
                                style="position: fixed !important; inset: 0; margin: 0; padding: 0; width: 100vw; height: 100vh; left: 0; top: 0;">

                                <div @click.away="openModal = false" x-transition.scale
                                    class="relative bg-white rounded-xl shadow-xl w-full max-w-lg p-6 mx-4">

                                    <button @click="openModal = false"
                                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                                        ✕
                                    </button>

                                    <h1 class="text-xl font-semibold mb-5 text-gray-800 border-b pb-2 text-start">Edit Fakultas
                                    </h1>

                                    <form action="{{ route('fakultas.update', $f->id_fakultas) }}" method="POST"
                                        class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1 text-start">Nama
                                                Fakultas</label>
                                            <input type="text" name="nama_fakultas" value="{{ $f->nama_fakultas }}"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1  text-start">Dekan</label>
                                            <input type="text" name="dekan" value="{{ $f->dekan }}"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1 text-start">Deskripsi</label>
                                            <textarea name="deskripsi" rows="3"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ $f->deskripsi }}</textarea>
                                        </div>

                                        <div class="flex justify-end space-x-3 pt-3 border-t">
                                            <button type="button" @click="openModal = false"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END MODAL -->
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3">Belum ada data fakultas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $fakultas->links() }}
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

            // UPDATE / EDIT
            const editForms = document.querySelectorAll('.edit-form');
            editForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // optional: bisa tampil alert sebelum submit, tapi disini kita biar sukses setelah reload
                });
            });

            // Tampilkan SweetAlert untuk CREATE / UPDATE / DELETE sukses
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
