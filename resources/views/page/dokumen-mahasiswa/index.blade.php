<x-app-layout>
    <x-slot name="title">Dokumen Mahasiswa</x-slot>

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

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dokumen Mahasiswa</h1>
                    <p class="text-gray-600 mt-1">Kelola dokumen ijazah dan transkrip nilai mahasiswa</p>
                </div>
                <a href="{{ route('dokumen-mahasiswa.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Data
                </a>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('dokumen-mahasiswa.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

                        <!-- Filter Status Verifikasi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi</label>
                            <select name="status_verifikasi" class="w-full border rounded px-3 py-2 text-sm">
                                <option value="">Semua Status</option>
                                <option value="Menunggu"
                                    {{ request('status_verifikasi') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Terverifikasi"
                                    {{ request('status_verifikasi') == 'Terverifikasi' ? 'selected' : '' }}>
                                    Terverifikasi</option>
                                <option value="Ditolak"
                                    {{ request('status_verifikasi') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                                <option value="Drop Out"
                                    {{ request('status_mahasiswa') == 'Drop Out' ? 'selected' : '' }}>Drop Out</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4 space-x-2">
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
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="table-wrapper">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">No</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">NIM</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Nama</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Prodi</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Tahun</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Status</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Dokumen</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Verifikasi</th>
                                <th class="px-4 py-3 text-center font-medium text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($dokumenMahasiswa as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $dokumenMahasiswa->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 font-mono font-medium">{{ $item->nim }}</td>
                                    <td class="px-4 py-3">{{ $item->nama_lengkap }}</td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">
                                            <div class="font-medium">{{ $item->prodi->nama_prodi }}</div>
                                            <div class="text-gray-500 text-xs">
                                                {{ $item->prodi->fakultas->nama_fakultas }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">
                                            <div>Masuk: {{ $item->tahun_masuk }}</div>
                                            @if ($item->tahun_keluar)
                                                <div class="text-green-600">Lulus: {{ $item->tahun_keluar }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
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
                                    <td class="px-4 py-3">
                                        <div class="flex flex-col gap-1 text-xs">
                                            @if ($item->file_ijazah)
                                                <a href="{{ asset('dokumen_mahasiswa/ijazah/' . $item->file_ijazah) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                                    <i class="fas fa-file-pdf"></i>
                                                    Ijazah
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif

                                            @if ($item->file_transkrip)
                                                <a href="{{ asset('dokumen_mahasiswa/transkrip/' . $item->file_transkrip) }}"
                                                    target="_blank"
                                                    class="text-green-600 hover:text-green-800 flex items-center gap-1">
                                                    <i class="fas fa-file-pdf"></i>
                                                    Transkrip
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $verifikasiColor = match ($item->status_verifikasi) {
                                                'Terverifikasi' => 'bg-green-100 text-green-800',
                                                'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                                'Ditolak' => 'bg-red-100 text-red-800',
                                            };
                                        @endphp
                                        <span class="badge {{ $verifikasiColor }}">
                                            {{ $item->status_verifikasi }}
                                        </span>
                                        @if ($item->tanggal_verifikasi)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $item->tanggal_verifikasi->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center gap-1">
                                            <!-- Tombol Verifikasi -->
                                            @if ($item->status_verifikasi == 'Menunggu')
                                                <button onclick="openVerifikasiModal({{ $item->id }})"
                                                    class="btn-action btn-success" title="Verifikasi">
                                                    <i class="fas fa-check w-4 h-4"></i>
                                                </button>
                                            @endif

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('dokumen-mahasiswa.edit', $item->id) }}"
                                                class="btn-action btn-warning" title="Edit">
                                                <i class="fas fa-edit w-4 h-4"></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('dokumen-mahasiswa.destroy', $item->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-action btn-danger delete-btn"
                                                    title="Hapus">
                                                    <i class="fas fa-trash w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                        Tidak ada data dokumen mahasiswa
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($dokumenMahasiswa->hasPages())
                    <div class="px-4 py-3 border-t">
                        {{ $dokumenMahasiswa->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi -->
    <div id="verifikasiModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                <!-- FORM ACTION AKAN DI-SET OLEH JAVASCRIPT -->
                <form id="verifikasiForm" action="" method="POST">
                    @csrf
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Verifikasi Dokumen</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                            <select name="status_verifikasi" id="status_verifikasi"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Terverifikasi">Terverifikasi</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-4 hidden" id="catatanField">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Verifikasi</label>
                            <textarea name="catatan_verifikasi" id="catatan_verifikasi" rows="3"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Berikan catatan jika dokumen ditolak..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 p-6 border-t">
                        <button type="button" onclick="closeVerifikasiModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentDokumenId = null;

        function openVerifikasiModal(id) {
            currentDokumenId = id;
            // Set action form berdasarkan ID
            const form = document.getElementById('verifikasiForm');
            form.action = `/dokumen-mahasiswa/${id}/verifikasi`;
            document.getElementById('verifikasiModal').classList.remove('hidden');
        }

        function closeVerifikasiModal() {
            document.getElementById('verifikasiModal').classList.add('hidden');
            document.getElementById('status_verifikasi').value = '';
            document.getElementById('catatan_verifikasi').value = '';
            document.getElementById('catatanField').classList.add('hidden');
        }

        // Handle status verifikasi change
        document.getElementById('status_verifikasi').addEventListener('change', function() {
            const catatanField = document.getElementById('catatanField');
            if (this.value === 'Ditolak') {
                catatanField.classList.remove('hidden');
            } else {
                catatanField.classList.add('hidden');
            }
        });

        // HAPUS event listener fetch yang lama
        // Biarkan form submit secara normal

        // DELETE
        document.addEventListener('DOMContentLoaded', function() {
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
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
</x-app-layout>
