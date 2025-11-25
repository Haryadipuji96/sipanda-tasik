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
    </style>

    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $ruangan->nama_ruangan }}</h1>
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                            @if ($ruangan->tipe_ruangan == 'sarana')
                                <!-- DIUBAH -->
                                <span class="badge bg-orange-100 text-orange-800"> <!-- DIUBAH -->
                                    🎓 {{ $ruangan->prodi->nama_prodi ?? '-' }}
                                </span>
                                <span class="badge bg-green-100 text-green-800">
                                    🏛️ {{ $ruangan->prodi->fakultas->nama_fakultas ?? '-' }}
                                </span>
                            @else
                                <span class="badge bg-gray-100 text-gray-800">
                                    🏢 Unit Prasarana - {{ $ruangan->unit_prasarana }} <!-- DIUBAH -->
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4 md:mt-0">
                        <!-- Tombol Tambah Barang -->
                        <a href="{{ route('ruangan.tambah-barang', $ruangan->id) }}"
                            class="btn-action btn-primary gap-2 px-4 py-2">
                            <i class="fas fa-plus w-4 h-4"></i>
                            Tambah Barang
                        </a>

                        <!-- Tombol Download PDF -->
                        <a href="{{ route('ruangan.pdf', $ruangan->id) }}"
                            class="btn-action btn-warning gap-2 px-4 py-2">
                            <i class="fas fa-file-pdf w-4 h-4"></i>
                            Download PDF
                        </a>

                        <!-- Tombol Kembali -->
                        <a href="{{ route('ruangan.index') }}" class="btn-action btn-secondary px-4 py-2">
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

            <!-- Daftar Barang -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="p-6 border-b flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Barang dalam Ruangan</h2>
                    <div class="text-sm text-gray-500">
                        Total: <span class="font-bold text-blue-600">{{ $ruangan->sarpras->count() }}</span> barang
                    </div>
                </div>

                @if ($ruangan->sarpras->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
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
                                @foreach ($ruangan->sarpras as $index => $barang)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $barang->nama_barang }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $barang->kategori_barang }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $barang->merk_barang ?? '-' }}</td>
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
                                                {{ $barang->kondisi }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center gap-1">
                                                <a href="{{ route('ruangan.barang.show', ['ruangan' => $ruangan->id, 'barang' => $barang->id]) }}"
                                                    class="btn-action btn-primary" title="Detail Barang">
                                                    <i class="fas fa-eye w-4 h-4"></i>
                                                </a>
                                                @canCrud('ruangan')
                                                <!-- TAMBAH TOMBOL EDIT BARANG DI SINI -->
                                                <a href="{{ route('ruangan.barang.edit', ['ruangan' => $ruangan->id, 'barang' => $barang->id]) }}"
                                                    class="btn-action btn-warning" title="Edit Barang">
                                                    <i class="fas fa-edit w-4 h-4"></i>
                                                </a>
                                                <!-- TOMBOL DELETE -->
                                                <form
                                                    action="{{ route('ruangan.barang.destroy', ['ruangan' => $ruangan->id, 'barang' => $barang->id]) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-action btn-danger delete-btn"
                                                        title="Hapus Barang">
                                                        <i class="fas fa-trash w-4 h-4"></i>
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
                        <p class="text-gray-500 text-lg mb-4">Belum ada barang di ruangan ini</p>
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
        // Untuk modal edit ruangan
        document.addEventListener('DOMContentLoaded', function() {
            const editFileInput = document.querySelector('#editModal input[name="file_dokumen"]');
            if (editFileInput) {
                editFileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validate file size (2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Terlalu Besar',
                                text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 *
                                    1024)).toFixed(2) + 'MB'
                            });
                            this.value = '';
                            return;
                        }

                        // Validate file type
                        const allowedTypes = ['application/pdf', 'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'image/jpeg', 'image/jpg', 'image/png'
                        ];
                        if (!allowedTypes.includes(file.type)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Format File Tidak Didukung',
                                text: 'Hanya file PDF, DOC, DOCX, JPG, dan PNG yang diizinkan.'
                            });
                            this.value = '';
                            return;
                        }

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'File Valid',
                            text: 'File siap diupload: ' + file.name,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DELETE BARANG
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
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
