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

        /* Styling untuk info barang - DIPERBAIKI */
        .barang-container {
            max-width: 300px;
        }

        .barang-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            margin-top: 4px;
        }

        .barang-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
        }

        .barang-count {
            font-size: 0.75rem;
            font-weight: 600;
            color: #374151;
        }

        .search-result-badge {
            background: #10b981;
            color: white;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 0.7rem;
            margin-left: 8px;
        }

        .barang-list {
            max-height: 120px;
            overflow-y: auto;
        }

        .barang-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .barang-item:last-child {
            border-bottom: none;
        }

        .barang-details {
            flex: 1;
        }

        .barang-name {
            font-weight: 500;
            color: #1e293b;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }

        .barang-specs {
            font-size: 0.7rem;
            color: #64748b;
            display: flex;
            gap: 8px;
        }

        .barang-kondisi {
            font-size: 0.7rem;
            padding: 1px 6px;
            border-radius: 10px;
            font-weight: 500;
        }

        .kondisi-baik {
            background: #dcfce7;
            color: #166534;
        }

        .kondisi-ringan {
            background: #fef9c3;
            color: #854d0e;
        }

        .kondisi-berat {
            background: #fee2e2;
            color: #991b1b;
        }

        .barang-more {
            text-align: center;
            padding-top: 6px;
            font-size: 0.75rem;
            color: #3b82f6;
        }

        /* Scrollbar styling untuk barang list */
        .barang-list::-webkit-scrollbar {
            width: 4px;
        }

        .barang-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 2px;
        }

        .barang-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .barang-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Action buttons styling */
        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 6px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-detail {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .btn-detail:hover {
            background-color: #bfdbfe;
            transform: scale(1.05);
        }

        .btn-add-item {
            background-color: #dcfce7;
            color: #166534;
        }

        .btn-add-item:hover {
            background-color: #bbf7d0;
            transform: scale(1.05);
        }

        .btn-edit {
            background-color: #fef3c7;
            color: #92400e;
        }

        .btn-edit:hover {
            background-color: #fde68a;
            transform: scale(1.05);
        }

        .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background-color: #fecaca;
            transform: scale(1.05);
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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Ruangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian Ruangan</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full border rounded px-3 py-2 text-sm" placeholder="Cari nama ruangan...">
                    </div>

                    <!-- Search Barang -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian Barang</label>
                        <input type="text" name="search_barang" value="{{ request('search_barang') }}"
                            class="w-full border rounded px-3 py-2 text-sm" placeholder="Cari nama barang...">
                    </div>

                    <!-- Filter Tipe Ruangan -->
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

                    <!-- Filter Kondisi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Ruangan</label>
                        <select name="kondisi" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Semua Kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>
                                Rusak Ringan</option>
                            <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>
                                Rusak Berat</option>
                        </select>
                    </div>
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

                <!-- Info Pencarian Barang -->
                @if (request('search_barang'))
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            <span class="text-blue-700 text-sm">
                                Menampilkan ruangan yang memiliki barang dengan kata kunci:
                                <strong>"{{ request('search_barang') }}"</strong>
                            </span>
                        </div>
                    </div>
                @endif
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
                        <th class="border px-3 py-2 text-left">Barang</th>
                        <th class="border px-3 py-2 text-left">Tanggal Dibuat</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
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
                        <tr>
                            @canCrud('ruangan')
                            <td class="border px-3 py-2 text-center">
                                <input type="checkbox" class="select-item" name="selected_ruangan[]"
                                    value="{{ $item->id }}">
                            </td>
                            @endcanCrud
                            <td class="border px-3 py-2">{{ $ruangan->firstItem() + $index }}</td>

                            <!-- Tipe Ruangan -->
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

                            <!-- Lokasi -->
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

                            <!-- Kolom Barang - DIPERBAIKI -->
                            <td class="border px-3 py-2">
                                <div class="barang-container">
                                    @if ($item->sarpras->count() > 0)
                                        @php
                                            $barangCount = $item->sarpras->count();
                                            $filteredBarang = $item->sarpras;

                                            // Filter barang berdasarkan pencarian
                                            if (request('search_barang')) {
                                                $filteredBarang = $item->sarpras->filter(function ($barang) {
                                                    return stripos($barang->nama_barang, request('search_barang')) !== false;
                                                });
                                            }
                                        @endphp

                                        <div class="barang-info">
                                            <div class="barang-header">
                                                <span class="barang-count">
                                                    Total: {{ $barangCount }} barang
                                                </span>
                                                @if (request('search_barang') && $filteredBarang->count() > 0)
                                                    <span class="search-result-badge">
                                                        {{ $filteredBarang->count() }} cocok
                                                    </span>
                                                @endif
                                            </div>

                                            @if ($filteredBarang->count() > 0)
                                                <div class="barang-list">
                                                    @foreach ($filteredBarang->take(3) as $barang)
                                                        <div class="barang-item">
                                                            <div class="barang-details">
                                                                <div class="barang-name">
                                                                    {!! highlight($barang->nama_barang, request('search_barang')) !!}
                                                                </div>
                                                                <div class="barang-specs">
                                                                    <span>{{ $barang->jumlah }} unit</span>
                                                                    <span>•</span>
                                                                    <span class="barang-kondisi 
                                                                        {{ $barang->kondisi == 'Baik' ? 'kondisi-baik' : '' }}
                                                                        {{ $barang->kondisi == 'Rusak Ringan' ? 'kondisi-ringan' : '' }}
                                                                        {{ $barang->kondisi == 'Rusak Berat' ? 'kondisi-berat' : '' }}">
                                                                        {{ $barang->kondisi }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if ($filteredBarang->count() > 3)
                                                    <div class="barang-more">
                                                        +{{ $filteredBarang->count() - 3 }} barang lainnya...
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-gray-400 text-sm text-center py-2">
                                                    Tidak ada barang yang cocok
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">Tidak ada barang</span>
                                    @endif
                                </div>
                            </td>

                            <td class="border px-3 py-2">{{ $item->created_at->format('d/m/Y') }}</td>
                            
                            <!-- Kolom Aksi - DITAMBAH ICON DETAIL -->
                            <td class="border px-3 py-2">
                                <div class="action-buttons">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('ruangan.show', $item->id) }}"
                                        class="btn-action btn-detail"
                                        title="Detail Ruangan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @canCrud('ruangan')
                                    <!-- Tombol Tambah Barang -->
                                    <a href="{{ route('ruangan.tambah-barang', $item->id) }}"
                                        class="btn-action btn-add-item"
                                        title="Tambah Barang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('ruangan.edit', $item->id) }}"
                                        class="btn-action btn-edit"
                                        title="Edit Ruangan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
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
                                            class="btn-action btn-delete delete-btn"
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
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
                            <td colspan="{{ canCrud('ruangan') ? 9 : 8 }}" class="text-center py-3">
                                @if (request('search_barang'))
                                    Tidak ditemukan ruangan dengan barang "{{ request('search_barang') }}"
                                @else
                                    Belum ada data ruangan.
                                @endif
                            </td>
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

            // Flag untuk mencegah multiple execution
            let isProcessing = false;

            // Select All functionality
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    selectItems.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateDeleteButton();
                });
            }

            // Individual checkbox functionality
            selectItems.forEach(checkbox => {
                checkbox.addEventListener('change', updateDeleteButton);
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

                    if (isProcessing) return;
                    isProcessing = true;

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
                        isProcessing = false;
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
                                    cancelButtonText: 'Batal',
                                    confirmButtonColor: '#dc2626',
                                    denyButtonColor: '#16a34a',
                                    cancelButtonColor: '#6b7280'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        submitDelete(selectedIds, true);
                                    } else if (result.isDenied) {
                                        submitDelete(selectedIds, false);
                                    } else {
                                        isProcessing = false;
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Apakah anda yakin?',
                                    html: `Anda akan menghapus <strong>${selectedIds.length} ruangan</strong> terpilih!`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#16a34a',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        submitDelete(selectedIds, false);
                                    } else {
                                        isProcessing = false;
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat memeriksa data ruangan.'
                            });
                            isProcessing = false;
                        });
                });
            }

            function submitDelete(selectedIds, forceDelete) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('ruangan.deleteSelected') }}';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

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
                setTimeout(() => {
                    isProcessing = false;
                }, 1000);
            }

            // DELETE INDIVIDUAL
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();

                    if (isProcessing) return;
                    isProcessing = true;

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
                        isProcessing = false;
                    });
                });
            });

            // NOTIFIKASI SUKSES
            const showSuccessNotification = sessionStorage.getItem('showRuanganSuccess');

            @if (session('success'))
                if (!showSuccessNotification) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        sessionStorage.setItem('showRuanganSuccess', 'true');
                    });
                }
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

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    html: `{!! session('warning') !!}`,
                    showConfirmButton: true,
                    confirmButtonText: 'Mengerti'
                });
            @endif

            // Reset session storage ketika halaman dimuat
            sessionStorage.removeItem('showRuanganSuccess');
        });
    </script>
</x-app-layout>