{{-- <x-app-layout>
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

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.375rem;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
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

        <x-search-bar route="sarpras.index" placeholder="Cari nama ruangan / prodi / fakultas..." />

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-2 mb-4">
            <!-- Export Buttons -->
            <div class="flex gap-2">
                <!-- Button Preview PDF -->
                <a href="{{ route('sarpras.laporan.preview', [
                    'search' => request('search'),
                    'kondisi' => request('kondisi'),
                    'fakultas' => request('fakultas'),
                    'unit_umum' => request('unit_umum'),
                    'tipe_ruangan' => request('tipe_ruangan'),
                ]) }}"
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
                <a href="{{ route('sarpras.export.excel', [
                    'search' => request('search'),
                    'kondisi' => request('kondisi'),
                    'fakultas' => request('fakultas'),
                    'unit_umum' => request('unit_umum'),
                    'tipe_ruangan' => request('tipe_ruangan'),
                ]) }}"
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

        <!-- Filter Section -->
        <form method="GET" action="{{ route('sarpras.index') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <!-- Filter Kondisi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Barang</label>
                    <select name="kondisi" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Semua Kondisi --</option>
                        <option value="Baik Sekali" {{ request('kondisi') == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali</option>
                        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup" {{ request('kondisi') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                        <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <!-- Filter Fakultas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                    <select name="fakultas" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Semua Fakultas --</option>
                        @foreach ($fakultas as $f)
                            <option value="{{ $f->id }}" {{ request('fakultas') == $f->id ? 'selected' : '' }}>
                                {{ $f->nama_fakultas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Unit Umum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Umum</label>
                    <select name="unit_umum" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Semua Unit --</option>
                        <option value="Gedung Rektorat" {{ request('unit_umum') == 'Gedung Rektorat' ? 'selected' : '' }}>Gedung Rektorat</option>
                        <option value="Gedung Pascasarjana" {{ request('unit_umum') == 'Gedung Pascasarjana' ? 'selected' : '' }}>Gedung Pascasarjana</option>
                        <option value="Gedung Tarbiyah" {{ request('unit_umum') == 'Gedung Tarbiyah' ? 'selected' : '' }}>Gedung Tarbiyah</option>
                        <option value="Gedung Yayasan" {{ request('unit_umum') == 'Gedung Yayasan' ? 'selected' : '' }}>Gedung Yayasan</option>
                        <option value="Lainnya" {{ request('unit_umum') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Filter Tipe Ruangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Ruangan</label>
                    <select name="tipe_ruangan" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- Semua Tipe --</option>
                        <option value="akademik" {{ request('tipe_ruangan') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="umum" {{ request('tipe_ruangan') == 'umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                </div>
            </div>

            <div class="flex space-x-2">
                <a href="{{ route('sarpras.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
                    Reset
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    Filter
                </button>
            </div>
        </form>

        <!-- Table Summary Ruangan -->
        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Ruangan</th>
                        <th class="border px-3 py-2">Lokasi</th>
                        <th class="border px-3 py-2 text-center">Jumlah Barang</th>
                        <th class="border px-3 py-2 text-center">Total Unit</th>
                        <th class="border px-3 py-2 text-right">Total Nilai (Rp)</th>
                        <th class="border px-3 py-2 text-center">Kondisi Terbanyak</th>
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
                    @forelse ($ruangan as $index => $r)
                        @php
                            // Hitung kondisi terbanyak
                            $kondisiCount = $r->sarpras->groupBy('kondisi')->map->count();
                            $kondisiTerbanyak = $kondisiCount->sortDesc()->keys()->first() ?? '-';
                            $jumlahKondisiTerbanyak = $kondisiCount->sortDesc()->first() ?? 0;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $index + $ruangan->firstItem() }}</td>
                            
                            <!-- Kolom Ruangan -->
                            <td class="border px-3 py-2">
                                <div class="font-medium">{!! highlight($r->nama_ruangan, request('search')) !!}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    @if($r->id_prodi)
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Akademik</span>
                                    @else
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Umum</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kolom Lokasi -->
                            <td class="border px-3 py-2">
                                @if ($r->prodi && $r->prodi->fakultas)
                                    <div class="text-sm">
                                        <div class="font-medium">{!! highlight($r->prodi->nama_prodi, request('search')) !!}</div>
                                        <div class="text-xs text-gray-500">{!! highlight($r->prodi->fakultas->nama_fakultas, request('search')) !!}</div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">Unit Umum</span>
                                    @if($r->unit_umum)
                                        <div class="text-xs text-gray-600 mt-1">{{ $r->unit_umum }}</div>
                                    @endif
                                @endif
                            </td>

                            <!-- Jumlah Barang -->
                            <td class="border px-3 py-2 text-center">
                                <span class="stat-badge bg-blue-100 text-blue-800">
                                    {{ $r->total_barang }} barang
                                </span>
                            </td>

                            <!-- Total Unit -->
                            <td class="border px-3 py-2 text-center">
                                <span class="stat-badge bg-green-100 text-green-800">
                                    {{ $r->total_unit }} unit
                                </span>
                            </td>

                            <!-- Total Nilai -->
                            <td class="border px-3 py-2 text-right">
                                <span class="stat-badge bg-purple-100 text-purple-800">
                                    @if($r->total_nilai)
                                        Rp {{ number_format($r->total_nilai, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </td>

                            <!-- Kondisi Terbanyak -->
                            <td class="border px-3 py-2 text-center">
                                @if($kondisiTerbanyak != '-')
                                    @php
                                        $badgeClass = match ($kondisiTerbanyak) {
                                            'Baik Sekali', 'Baik' => 'badge-success',
                                            'Cukup', 'Rusak Ringan' => 'badge-warning',
                                            'Rusak Berat' => 'badge-danger',
                                            default => 'badge-warning',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}" title="{{ $jumlahKondisiTerbanyak }} barang">
                                        {{ $kondisiTerbanyak }}
                                    </span>
                                    <div class="text-xs text-gray-500 mt-1">{{ $jumlahKondisiTerbanyak }} barang</div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="border px-3 py-2">
                                <div class="flex flex-col gap-2">
                                    <!-- Tombol Lihat Barang & Tambah Barang -->
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ route('ruangan.show', $r->id) }}" 
                                           class="bg-blue-500 text-white px-3 py-1 rounded text-sm text-center hover:bg-blue-600 transition">
                                           📋 Lihat Barang
                                        </a>
                                        <a href="{{ route('ruangan.tambah-barang', $r->id) }}" 
                                           class="bg-green-500 text-white px-3 py-1 rounded text-sm text-center hover:bg-green-600 transition">
                                           ➕ Tambah Barang
                                        </a>
                                    </div>
                                    
                                    <!-- Tombol Export -->
                                    <div class="flex justify-center gap-1 pt-1 border-t">
                                        <a href="{{ route('sarpras.ruangan.pdf', $r->id) }}" 
                                           class="bg-purple-500 text-white px-2 py-1 rounded text-xs text-center hover:bg-purple-600 transition"
                                           title="Download PDF Ruangan">
                                           📄 PDF
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-500 mb-2">Belum ada data ruangan</p>
                                    <p class="text-gray-400 text-sm">Data ruangan akan muncul setelah Anda menambahkan barang</p>
                                    <a href="{{ route('sarpras.create') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                                        Tambah Barang Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $ruangan->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
</x-app-layout> --}}