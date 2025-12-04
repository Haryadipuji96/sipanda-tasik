<x-app-layout>
    <x-slot name="title">Detail Ruangan - {{ $ruangan->nama_ruangan }}</x-slot>

    <style>
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* ======================= Zebra Stripe Table ======================= */
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

        .table-custom tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .table-custom tbody tr:nth-child(even) {
            background-color: #e3f4ff;
        }

        .table-custom .action-cell {
            background-color: transparent !important;
        }

        /* ======================= Highlight Animasi ======================= */
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

        /* ======================= Prodi Badge ======================= */
        .prodi-badge-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .prodi-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .digunakan-bersama {
            background-color: #dbeafe;
            color: #1e40af;
            border-color: #93c5fd;
        }
    </style>

    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Title and Prodi Info -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $ruangan->nama_ruangan }}</h1>
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                            @if ($ruangan->tipe_ruangan == 'sarana')
                                <div class="flex flex-wrap gap-2">
                                    @if ($ruangan->prodis->count() > 0)
                                        @foreach ($ruangan->prodis as $prodi)
                                            <span class="badge bg-orange-100 text-orange-800">
                                                🎓 {{ $prodi->nama_prodi }}
                                            </span>
                                        @endforeach
                                        <span class="badge bg-blue-100 text-blue-800">
                                            🏛️ {{ $ruangan->prodis->first()->fakultas->nama_fakultas ?? '-' }}
                                        </span>
                                    @elseif ($ruangan->prodi)
                                        <!-- Fallback untuk data lama -->
                                        <span class="badge bg-orange-100 text-orange-800">
                                            🎓 {{ $ruangan->prodi->nama_prodi ?? '-' }}
                                        </span>
                                        <span class="badge bg-green-100 text-green-800">
                                            🏛️ {{ $ruangan->prodi->fakultas->nama_fakultas ?? '-' }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="badge bg-gray-100 text-gray-800">
                                    🏢 Unit Prasarana - {{ $ruangan->unit_prasarana }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 min-w-max">
                        <a href="{{ route('ruangan.tambah-barang', $ruangan->id) }}"
                           class="btn-action btn-primary gap-2 px-4 py-2">
                            <i class="fas fa-plus w-4 h-4"></i>
                            Tambah Barang
                        </a>
                        <a href="{{ route('ruangan.pdf', $ruangan->id) }}"
                           class="flex-1 sm:flex-none bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm text-center flex items-center justify-center">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Download PDF
                        </a>
                        <a href="{{ route('ruangan.index') }}"
                           class="btn-action btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left w-4 h-4"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $ruangan->sarpras->count() }}</div>
                        <div class="text-sm text-blue-800">Total Barang</div>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $ruangan->sarpras->sum('jumlah') }}</div>
                        <div class="text-sm text-green-800">Total Unit</div>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            Rp {{ number_format($ruangan->sarpras->sum('harga'), 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-purple-800">Total Nilai</div>
                    </div>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-center">
                        @php
                            $kondisiCount = $ruangan->sarpras->groupBy('kondisi')->map->count();
                            $kondisiTerbanyak = $kondisiCount->sortDesc()->keys()->first() ?? '-';
                        @endphp
                        <div class="text-lg font-bold text-orange-600">{{ $kondisiTerbanyak }}</div>
                        <div class="text-sm text-orange-800">Kondisi Terbanyak</div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                <form method="GET" action="{{ route('ruangan.show', $ruangan->id) }}">
                    <!-- Search Bar -->
                    <div class="mb-4">
                        <div class="relative w-full" id="input">
                            <input type="text" name="search" value="{{ request('search') }}" id="floating_outlined"
                                   placeholder="Cari nama barang, kategori, merk, kondisi..."
                                   class="block w-full text-sm h-[50px] px-4 text-blue-900 bg-white rounded-[8px] border border-blue-300 appearance-none 
                                          focus:border-transparent focus:outline focus:outline-2 focus:outline-blue-500 focus:ring-0 
                                          hover:border-blue-400 peer invalid:border-red-500 invalid:focus:border-red-500 
                                          overflow-ellipsis overflow-hidden text-nowrap pr-[48px]" />

                            <label for="floating_outlined"
                                   class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-blue-500 
                                          peer-focus:text-blue-500 peer-invalid:text-red-500 focus:invalid:text-red-500 duration-300 
                                          transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 
                                          peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 
                                          peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem]">
                                Cari Barang
                            </label>

                            <!-- Icon search -->
                            <div class="absolute top-3 right-3 text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" height="24" width="24">
                                    <path d="M10.979 16.8991C11.0591 17.4633 10.6657 17.9926 10.0959 17.9994C8.52021 18.0183 6.96549 17.5712 5.63246 16.7026C4.00976 15.6452 2.82575 14.035 2.30018 12.1709C1.77461 10.3068 1.94315 8.31525 2.77453 6.56596C3.60592 4.81667 5.04368 3.42838 6.82101 2.65875C8.59833 1.88911 10.5945 1.79039 12.4391 2.3809C14.2837 2.97141 15.8514 4.21105 16.8514 5.86977C17.8513 7.52849 18.2155 9.49365 17.8764 11.4005C17.5979 12.967 16.8603 14.4068 15.7684 15.543C15.3736 15.9539 14.7184 15.8787 14.3617 15.4343C14.0051 14.9899 14.0846 14.3455 14.4606 13.9173C15.1719 13.1073 15.6538 12.1134 15.8448 11.0393C16.0964 9.62426 15.8261 8.166 15.0841 6.93513C14.3421 5.70426 13.1788 4.78438 11.81 4.34618C10.4412 3.90799 8.95988 3.98125 7.641 4.55236C6.32213 5.12348 5.25522 6.15367 4.63828 7.45174C4.02135 8.74982 3.89628 10.2276 4.28629 11.6109C4.67629 12.9942 5.55489 14.1891 6.75903 14.9737C7.67308 15.5693 8.72759 15.8979 9.80504 15.9333C10.3746 15.952 10.8989 16.3349 10.979 16.8991Z" />
                                    <rect transform="rotate(-49.6812 12.2469 14.8859)" rx="1" height="10.1881" width="2" y="14.8859" x="12.2469" />
                                </svg>
                            </div>

                            <!-- Reset button -->
                            @if (request('search'))
                                <a href="{{ route('ruangan.show', $ruangan->id) }}"
                                   class="absolute top-3 right-10 bg-blue-100 text-blue-600 p-1.5 rounded-full hover:bg-blue-200 transition flex items-center justify-center"
                                   title="Reset Pencarian">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Active Search Info -->
                    @if (request('search') || request('kategori') || request('kondisi_barang'))
                        <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center flex-wrap gap-2">
                                <i class="fas fa-filter text-blue-500"></i>
                                <span class="text-blue-700 text-sm">Filter aktif:</span>

                                @if (request('search'))
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                        Pencarian: "{{ request('search') }}"
                                    </span>
                                @endif

                                @if (request('kategori'))
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                        Kategori: {{ request('kategori') }}
                                    </span>
                                @endif

                                @if (request('kondisi_barang'))
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                        Kondisi: {{ request('kondisi_barang') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Daftar Barang Section -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Barang dalam Ruangan</h2>
                    <div class="text-sm text-gray-500">
                        Total: <span class="font-bold text-blue-600">
                            @php
                                $filteredBarang = $ruangan->sarpras;
                                if (request('search')) {
                                    $filteredBarang = $filteredBarang->filter(function($item) {
                                        return stripos($item->nama_barang, request('search')) !== false ||
                                               stripos($item->kategori_barang, request('search')) !== false ||
                                               stripos($item->merk_barang, request('search')) !== false ||
                                               stripos($item->kondisi, request('search')) !== false;
                                    });
                                }
                                if (request('kategori')) {
                                    $filteredBarang = $filteredBarang->where('kategori_barang', request('kategori'));
                                }
                                if (request('kondisi_barang')) {
                                    $filteredBarang = $filteredBarang->where('kondisi', request('kondisi_barang'));
                                }
                            @endphp
                            {{ $filteredBarang->count() }}
                        </span> barang
                    </div>
                </div>

                @if ($filteredBarang->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table-custom">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-700">No</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-700">Nama Barang</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-700">Kategori</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-700">Merk</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-700">Jumlah</th>
                                    <th class="px-4 py-3 text-right font-medium text-gray-700">Harga</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-700">Kondisi</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php
                                    function highlight($text, $search) {
                                        if (!$search || !$text) return e($text);
                                        return preg_replace(
                                            '/(' . preg_quote($search, '/') . ')/i',
                                            '<span class="highlight">$1</span>',
                                            e($text)
                                        );
                                    }
                                    $searchTerm = request('search');
                                @endphp
                                
                                @foreach ($filteredBarang as $index => $barang)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium">{!! highlight($barang->nama_barang, $searchTerm) !!}</td>
                                        <td class="px-4 py-3 text-gray-600">{!! highlight($barang->kategori_barang, $searchTerm) !!}</td>
                                        <td class="px-4 py-3 text-gray-600">{!! highlight($barang->merk_barang, $searchTerm) !!}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-blue-100 text-blue-800">
                                                {{ $barang->jumlah }} {{ $barang->satuan }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            @if ($barang->harga)
                                                Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $badgeClass = match ($barang->kondisi) {
                                                    'Baik Sekali', 'Baik' => 'bg-green-100 text-green-800',
                                                    'Cukup', 'Rusak Ringan' => 'bg-yellow-100 text-yellow-800',
                                                    'Rusak Berat' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {!! highlight($barang->kondisi, $searchTerm) !!}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- Tombol Detail -->
                                                <a href="{{ route('ruangan.barang.show', ['ruangan' => $ruangan->id, 'barang' => $barang->id]) }}"
                                                   class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full transition"
                                                   title="Detail Barang">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                         stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                @canCrud('ruangan')
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('ruangan.barang.edit', ['ruangan' => $ruangan->id, 'barang' => $barang->id]) }}"
                                                   class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                                   title="Edit Barang">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                         stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('ruangan.barang.destroy', ['ruangan' => $ruangan->id, 'barang' => $barang->id]) }}"
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="btn-delete p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition delete-btn"
                                                            title="Hapus Barang">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                             stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endcanCrud
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center">
                        <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg mb-4">
                            @if (request('search') || request('kategori') || request('kondisi_barang'))
                                Tidak ditemukan barang dengan filter yang dipilih
                            @else
                                Belum ada barang di ruangan ini
                            @endif
                        </p>
                        @canSuperadmin
                        <a href="{{ route('ruangan.tambah-barang', $ruangan->id) }}"
                           class="btn-action btn-primary gap-2 px-6 py-2">
                            <i class="fas fa-plus w-4 h-4"></i>
                            Tambah Barang Pertama
                        </a>
                        @endcanSuperadmin
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // NOTIFIKASI SUKSES - untuk operasi tambah/edit barang
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // NOTIFIKASI ERROR
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    timer: 5000,
                    showConfirmButton: true
                });
            @endif

            // DELETE BARANG
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Barang yang sudah dihapus tidak bisa dikembalikan!",
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
        });
    </script>
</x-app-layout>