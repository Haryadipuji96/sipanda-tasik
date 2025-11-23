<x-app-layout>
    <x-slot name="title">Edit Ruangan - {{ $ruangan->nama_ruangan }}</x-slot>

    <style>
        .form-section {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .info-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }
    </style>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-edit text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-semibold">Edit Ruangan</h1>
                                <p class="text-blue-100 text-sm mt-1">
                                    Perbarui informasi ruangan {{ $ruangan->nama_ruangan }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('ruangan.index') }}" 
                           class="text-white hover:text-blue-100 transition flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Informasi Ruangan -->
                <div class="info-box">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-blue-800 mb-1">Informasi Ruangan</h4>
                            <p class="text-blue-700 text-sm">
                                <strong>Tipe:</strong> 
                                @if($ruangan->tipe_ruangan == 'sarana')
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Sarana</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Prasarana</span>
                                @endif
                                | 
                                <strong>Dibuat:</strong> {{ $ruangan->created_at->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('ruangan.update', $ruangan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-body">
                        <!-- Nama Ruangan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ruangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_ruangan" 
                                   value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="Masukkan nama ruangan"
                                   required>
                            @error('nama_ruangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form berdasarkan tipe ruangan -->
                        @if($ruangan->tipe_ruangan == 'sarana')
                            <!-- Form Ruangan Sarana -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Program Studi <span class="text-red-500">*</span>
                                </label>
                                <select name="id_prodi" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($prodi as $p)
                                        <option value="{{ $p->id }}" 
                                            {{ old('id_prodi', $ruangan->id_prodi) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_prodi }} - {{ $p->fakultas->nama_fakultas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_prodi')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <!-- Form Ruangan Prasarana -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Unit Prasarana <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="unit_prasarana" 
                                       value="{{ old('unit_prasarana', $ruangan->unit_prasarana) }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                       placeholder="Contoh: Rektorat, Perpustakaan, Gedung Yayasan"
                                       required>
                                @error('unit_prasarana')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Kondisi Ruangan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kondisi Ruangan <span class="text-red-500">*</span>
                            </label>
                            <select name="kondisi_ruangan" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Baik" {{ old('kondisi_ruangan', $ruangan->kondisi_ruangan) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ old('kondisi_ruangan', $ruangan->kondisi_ruangan) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ old('kondisi_ruangan', $ruangan->kondisi_ruangan) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            @error('kondisi_ruangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- HAPUS BAGIAN KETERANGAN - KARENA KOLOM TIDAK ADA DI DATABASE -->
                        {{--
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan (Opsional)
                            </label>
                            <textarea name="keterangan" 
                                      rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                      placeholder="Tambahkan keterangan tentang ruangan...">{{ old('keterangan', $ruangan->keterangan) }}</textarea>
                            @error('keterangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        --}}

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t">
                            <a href="{{ route('ruangan.index') }}" 
                               class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="btn-primary flex items-center justify-center order-1 sm:order-2">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // NOTIFIKASI ERROR
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    timer: 4000,
                    showConfirmButton: true
                });
            @endif
        });
    </script>
</x-app-layout>