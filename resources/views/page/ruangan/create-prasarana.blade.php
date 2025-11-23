<x-app-layout>
    <x-slot name="title">Tambah Ruangan Prasarana</x-slot>

    <style>
        .form-section {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .info-box {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #059669;
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
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-semibold">Tambah Ruangan Prasarana</h1>
                                <p class="text-green-100 text-sm mt-1">
                                    Tambah ruangan umum untuk keperluan institusi
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('ruangan.create') }}" 
                           class="text-white hover:text-green-100 transition flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Informasi Tipe Ruangan -->
                <div class="info-box">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-green-800 mb-1">Ruangan Prasarana</h4>
                            <p class="text-green-700 text-sm">
                                Ruangan prasarana digunakan untuk keperluan umum institusi seperti rektorat, perpustakaan, gedung yayasan, dll.
                                Ruangan ini tidak terkait dengan Program Studi tertentu.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('ruangan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe_ruangan" value="prasarana">

                    <div class="form-body">
                        <!-- Unit Prasarana -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Unit Prasarana <span class="text-red-500">*</span>
                            </label>
                            <select name="unit_prasarana" id="unit_prasarana"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                    required>
                                <option value="">-- Pilih Unit Prasarana --</option>
                                <option value="Rektorat" {{ old('unit_prasarana') == 'Rektorat' ? 'selected' : '' }}>Rektorat</option>
                                <option value="Perpustakaan" {{ old('unit_prasarana') == 'Perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                                <option value="Gedung Yayasan" {{ old('unit_prasarana') == 'Gedung Yayasan' ? 'selected' : '' }}>Gedung Yayasan</option>
                                <option value="Masjid" {{ old('unit_prasarana') == 'Masjid' ? 'selected' : '' }}>Masjid</option>
                                <option value="Auditorium" {{ old('unit_prasarana') == 'Auditorium' ? 'selected' : '' }}>Auditorium</option>
                                <option value="Gedung Serba Guna" {{ old('unit_prasarana') == 'Gedung Serba Guna' ? 'selected' : '' }}>Gedung Serba Guna</option>
                                <option value="Lainnya" {{ old('unit_prasarana') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('unit_prasarana')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Lainnya (muncul jika memilih Lainnya) -->
                        <div class="mb-6" id="unit_lainnya_container" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Unit Lainnya <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="unit_lainnya" 
                                   id="unit_lainnya"
                                   value="{{ old('unit_lainnya') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                   placeholder="Masukkan nama unit prasarana">
                            @error('unit_lainnya')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Ruangan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ruangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_ruangan" 
                                   value="{{ old('nama_ruangan') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                   placeholder="Contoh: Ruang Rektor, Perpustakaan Lantai 1, Aula Utama"
                                   required>
                            @error('nama_ruangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t">
                            <a href="{{ route('ruangan.create') }}" 
                               class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="btn-primary flex items-center justify-center order-1 sm:order-2">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Ruangan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

            // Handle pilihan unit prasarana
            $('#unit_prasarana').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'Lainnya') {
                    $('#unit_lainnya_container').show();
                    $('#unit_lainnya').prop('required', true);
                } else {
                    $('#unit_lainnya_container').hide();
                    $('#unit_lainnya').prop('required', false);
                    $('#unit_lainnya').val('');
                }
            });

            // Trigger change on page load jika ada old value
            @if (old('unit_prasarana') == 'Lainnya')
                $('#unit_prasarana').trigger('change');
            @endif
        });
    </script>
</x-app-layout>