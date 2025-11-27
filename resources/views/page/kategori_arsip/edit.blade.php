<x-app-layout>
    <x-slot name="title">Edit Kategori Arsip</x-slot>

    <style>
        .form-section {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .info-box {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
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
            background-color: #ff0000;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #cc0000;
        }

        @media (max-width: 768px) {
            .form-body {
                padding: 1rem;
            }

            .form-header {
                padding: 1rem;
            }
        }
    </style>

    <div class="p-4 sm:p-6">
        <div class="max-w-3xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-edit text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Edit Kategori Arsip</h1>
                                <p class="text-orange-100 text-xs sm:text-sm mt-1">
                                    Perbarui data kategori untuk mengorganisir arsip dokumen
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('kategori-arsip.index') }}"
                            class="text-white hover:text-orange-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('kategori-arsip.update', $kategori->id) }}" method="POST" id="kategoriForm">
                    @csrf
                    @method('PUT')

                    <div class="form-body">
                        <!-- Informasi Kategori -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informasi Kategori
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-amber-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <h4 class="font-medium text-amber-800 mb-1 text-sm sm:text-base">Informasi Edit
                                        </h4>
                                        <p class="text-amber-700 text-xs sm:text-sm">
                                            • Perbarui data kategori dengan informasi yang valid<br>
                                            • Field bertanda <span class="text-red-500">*</span> wajib diisi<br>
                                            • Perubahan akan langsung tersimpan di database
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- Nama Kategori -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_kategori"
                                        value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="Contoh: Dokumen Akademik, Surat Menyurat, Laporan" required
                                        maxlength="255">
                                    @error('nama_kategori')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Deskripsi Kategori
                                    </label>
                                    <textarea name="deskripsi" rows="4"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                        placeholder="Masukkan deskripsi tentang kategori arsip ini...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                    <p class="text-gray-500 text-xs mt-1">
                                        Deskripsi opsional tentang tujuan dan penggunaan kategori ini
                                    </p>
                                    @error('deskripsi')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Sistem -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-cogs mr-2 text-green-500"></i>
                                Informasi Sistem
                            </h3>

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-blue-500 mr-2 text-sm"></i>
                                        <span class="text-gray-600">Terakhir diupdate:</span>
                                        <span
                                            class="ml-2 font-medium">{{ $kategori->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-database text-green-500 mr-2 text-sm"></i>
                                        <span class="text-gray-600">Status:</span>
                                        <span class="ml-2 font-medium text-green-600">Aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 sm:pt-6 border-t">
                            <a href="{{ route('kategori-arsip.index') }}"
                                class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn-primary flex items-center justify-center order-1 sm:order-2 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Update Kategori
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
            // Form validation
            const form = document.getElementById('kategoriForm');
            form.addEventListener('submit', function(e) {
                const namaKategori = document.querySelector('input[name="nama_kategori"]').value.trim();

                if (!namaKategori) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Data belum lengkap',
                        text: 'Nama Kategori wajib diisi!',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }
            });

            // Auto-capitalize first letter of each word for nama_kategori
            const namaKategoriInput = document.querySelector('input[name="nama_kategori"]');
            namaKategoriInput.addEventListener('blur', function() {
                this.value = this.value.replace(/\w\S*/g, function(txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            });

            // NOTIFIKASI SUKSES UPDATE
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Diupdate!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            @endif

            // NOTIFIKASI ERROR VALIDATION
            @if ($errors->any())
                @if (!session('success'))
                    let errorMessage = '';
                    @foreach ($errors->all() as $error)
                        errorMessage += `• {{ $error }}<br>`;
                    @endforeach

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        html: errorMessage,
                        confirmButtonColor: '#3b82f6'
                    });
                @endif
            @endif
        });

        // Responsive behavior
        function handleResize() {
            const formBody = document.querySelector('.form-body');
            if (window.innerWidth < 640) {
                formBody.classList.add('px-2');
            } else {
                formBody.classList.remove('px-2');
            }
        }

        // Initial call
        handleResize();
        // Add resize listener
        window.addEventListener('resize', handleResize);
    </script>
</x-app-layout>
