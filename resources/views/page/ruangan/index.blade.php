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

        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .clickable-row:hover {
            background-color: #f3f4f6;
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
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Sarpras</h1>
            @canCrud('ruangan')
            <button onclick="window.location='{{ route('ruangan.create') }}'" class="cssbuttons-io-button">
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
            <form method="GET" action="{{ route('ruangan.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full border rounded px-3 py-2 text-sm" placeholder="Cari ruangan...">
                    </div>

                    <!-- Filter Tipe Ruangan - DIUBAH -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Ruangan</label>
                        <select name="tipe_ruangan" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Semua Tipe</option>
                            <option value="sarana" {{ request('tipe_ruangan') == 'sarana' ? 'selected' : '' }}>
                                Sarana</option>
                            <option value="prasarana" {{ request('tipe_ruangan') == 'prasarana' ? 'selected' : '' }}>
                                Prasarana
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

                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                    <div class="flex gap-2 order-2 sm:order-1">
                        <a href="{{ route('ruangan.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm flex items-center transition duration-200">
                            <i class="fas fa-refresh mr-2"></i>
                            Reset
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center transition duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                    </div>

                   
                    <!-- Button Hapus Terpilih -->
                    <button id="delete-selected"
                        class="order-1 sm:order-2 px-4 py-2 text-sm rounded-lg font-medium text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition duration-200 flex items-center justify-center"
                        disabled>
                        <i class="fas fa-trash mr-2"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                    
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        @canCrud('ruangan')
                        <th rowspan="2" class="px-4 py-2 border text-center w-12">
                            <input type="checkbox" id="select-all">
                        </th>
                        @endcanCrud
                        <th class="border px-3 py-2 text-left">No</th>
                        <th class="border px-3 py-2 text-left">Tipe</th>
                        <th class="border px-3 py-2 text-left">Lokasi</th>
                        <th class="border px-3 py-2 text-left">Nama Ruangan</th>
                        <th class="border px-3 py-2 text-left">Kondisi</th>
                        <th class="border px-3 py-2 text-left">Tanggal Dibuat</th>
                        @canCrud('ruangan')
                        <th class="border px-3 py-2 text-center">Aksi</th>
                        @endcanCrud
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
                    @forelse($ruangan as $index => $item)
                        <tr class="clickable-row" onclick="window.location='{{ route('ruangan.show', $item->id) }}'">
                            @canCrud('ruangan')
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" class="select-item" name="selected_ruangan[]"
                                    value="{{ $item->id }}">
                            </td>
                            @endcanCrud
                            <td class="border px-3 py-2">{{ $ruangan->firstItem() + $index }}</td>

                            <!-- Tipe Ruangan - DIUBAH -->
                            <td class="border px-3 py-2">
                                @if ($item->tipe_ruangan == 'sarana')
                                    <span class="px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded-full">
                                        {!! highlight('Sarana', request('search')) !!}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                        {!! highlight('Prasarana', request('search')) !!}
                                    </span>
                                @endif
                            </td>

                            <!-- Lokasi - DIUBAH -->
                            <td class="border px-3 py-2">
                                @if ($item->tipe_ruangan == 'sarana')
                                    <div class="text-sm">
                                        <div class="font-medium">
                                            {!! highlight($item->prodi->nama_prodi ?? 'N/A', request('search')) !!}
                                        </div>
                                        <div class="text-gray-600 text-xs">
                                            {!! highlight($item->prodi->fakultas->nama_fakultas ?? 'N/A', request('search')) !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-sm font-medium text-green-700">
                                        {!! highlight($item->unit_prasarana, request('search')) !!}
                                    </div>
                                @endif
                            </td>

                            <td class="border px-3 py-2 font-medium">
                                {!! highlight($item->nama_ruangan, request('search')) !!}
                            </td>

                            <!-- Kondisi -->
                            <td class="border px-3 py-2">
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                                    {{ $item->kondisi_ruangan == 'Baik' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $item->kondisi_ruangan == 'Rusak Ringan' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $item->kondisi_ruangan == 'Rusak Berat' ? 'bg-red-100 text-red-800' : '' }}">
                                    {!! highlight($item->kondisi_ruangan, request('search')) !!}
                                </span>
                            </td>

                            <td class="border px-3 py-2">{{ $item->created_at->format('d/m/Y') }}</td>
                            <td class="border px-3 py-2">
                                <div class="flex gap-2 justify-center">
                                   @canCrud('ruangan')
                                    <!-- Tombol Tambah Barang -->
                                    <a href="{{ route('ruangan.tambah-barang', $item->id) }}"
                                        class="p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-full transition"
                                        title="Tambah Barang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('ruangan.edit', $item->id) }}"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                        title="Edit Ruangan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition delete-btn"
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endcanCrud
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
            // SELECT ALL CHECKBOX
            const selectAll = document.getElementById('select-all');
            const selectItems = document.querySelectorAll('.select-item');
            const deleteSelectedBtn = document.getElementById('delete-selected');

            // Select All functionality
            // Delete Selected functionality
            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const selectedIds = [];
                    document.querySelectorAll('.select-item:checked').forEach(checkbox => {
                        selectedIds.push(checkbox.value);
                    });

                    if (selectedIds.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Pilih setidaknya satu ruangan untuk dihapus!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    // Cek dulu apakah ada ruangan yang punya barang
                    fetch('{{ route('ruangan.checkUsedRooms') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                room_ids: selectedIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.has_used_rooms) {
                                // Kasih opsi force delete
                                Swal.fire({
                                    title: 'Ruangan Memiliki Barang',
                                    html: `Beberapa ruangan memiliki data barang:<br>
                           <strong>${data.used_rooms.join(', ')}</strong><br><br>
                           Total: <strong>${data.total_items} barang</strong><br><br>
                           Apa yang ingin dilakukan?`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    showDenyButton: true,
                                    confirmButtonText: 'Hapus Paksa (Semua Barang)',
                                    denyButtonText: 'Hapus Yang Bisa Saja',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        submitDelete(selectedIds, true);
                                    } else if (result.isDenied) {
                                        submitDelete(selectedIds, false);
                                    }
                                });
                            } else {
                                // Langsung hapus kalo ga ada barang
                                Swal.fire({
                                    title: 'Apakah anda yakin?',
                                    text: `Anda akan menghapus ${selectedIds.length} ruangan terpilih!`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#16a34a',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        submitDelete(selectedIds, false);
                                    }
                                });
                            }
                        });
                });
            }

            function submitDelete(selectedIds, forceDelete) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('ruangan.deleteSelected') }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                if (forceDelete) {
                    const forceInput = document.createElement('input');
                    forceInput.type = 'hidden';
                    forceInput.name = 'force_delete';
                    forceInput.value = '1';
                    form.appendChild(forceInput);
                }

                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_ruangan[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }

            // Individual checkbox functionality
            selectItems.forEach(checkbox => {
                checkbox.addEventListener('change', updateDeleteButton);

                // Prevent event bubbling ketika klik checkbox
                checkbox.addEventListener('click', function(e) {
                    e.stopPropagation(); // Mencegah event bubbling ke row
                });
            });

            // Update delete button state
            function updateDeleteButton() {
                const checkedCount = document.querySelectorAll('.select-item:checked').length;
                if (deleteSelectedBtn) {
                    deleteSelectedBtn.disabled = checkedCount === 0;
                }
            }

            // Delete Selected functionality
            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const selectedIds = [];
                    document.querySelectorAll('.select-item:checked').forEach(checkbox => {
                        selectedIds.push(checkbox.value);
                    });

                    if (selectedIds.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Pilih setidaknya satu ruangan untuk dihapus!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: `Anda akan menghapus ${selectedIds.length} ruangan terpilih!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create form untuk submit
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('ruangan.deleteSelected') }}';

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            form.appendChild(csrfToken);

                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            selectedIds.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'selected_ruangan[]';
                                input.value = id;
                                form.appendChild(input);
                            });

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            // DELETE INDIVIDUAL
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation(); // Mencegah event bubbling ke row
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
    </script>
</x-app-layout>
