<x-app-layout>
    <x-slot name="title">Tambah Ruangan</x-slot>

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

        .card-hover {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
        <div class="max-w-6xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-door-open text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Tambah Ruangan Baru</h1>
                                <p class="text-blue-100 text-xs sm:text-sm mt-1">
                                    Pilih jenis ruangan yang ingin ditambahkan
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('ruangan.index') }}"
                            class="text-white hover:text-blue-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="form-body">
                    <!-- Informasi -->
                    <div class="info-box">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3 text-sm"></i>
                            <div>
                                <h4 class="font-medium text-blue-800 mb-1 text-sm sm:text-base">Informasi Pilihan Ruangan</h4>
                                <p class="text-blue-700 text-xs sm:text-sm">
                                    • Pilih jenis ruangan sesuai dengan kebutuhan<br>
                                    • Ruangan Sarana terkait dengan fakultas dan program studi<br>
                                    • Ruangan Prasarana digunakan bersama oleh seluruh civitas akademika
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Tipe Ruangan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Ruangan Sarana -->
                        <a href="{{ route('ruangan.create.sarana') }}"
                            class="card-hover flex flex-col items-center p-8 border-2 border-orange-200 rounded-xl cursor-pointer hover:bg-orange-50 transition bg-orange-50 hover:border-orange-300">
                            <div class="bg-orange-100 text-orange-600 p-4 rounded-full mb-4">
                                <i class="fas fa-graduation-cap text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-orange-700 mb-2">Ruangan Sarana</h3>
                            <p class="text-orange-600 text-center text-sm mb-4">
                                Ruangan terkait fakultas dan program studi<br>
                                (Kelas, Laboratorium, Ruang Dosen, dll)
                            </p>
                            <div class="flex items-center text-orange-600 font-medium">
                                <span class="mr-2">Pilih</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </a>

                        <!-- Ruangan Prasarana -->
                        <a href="{{ route('ruangan.create.prasarana') }}"
                            class="card-hover flex flex-col items-center p-8 border-2 border-green-200 rounded-xl cursor-pointer hover:bg-green-50 transition bg-green-50 hover:border-green-300">
                            <div class="bg-green-100 text-green-600 p-4 rounded-full mb-4">
                                <i class="fas fa-building text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-green-700 mb-2">Ruangan Prasarana</h3>
                            <p class="text-green-600 text-center text-sm mb-4">
                                Ruangan umum institusi<br>
                                (Gedung Rektorat, Perpustakaan, Gedung Yayasan, dll)
                            </p>
                            <div class="flex items-center text-green-600 font-medium">
                                <span class="mr-2">Pilih</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </a>
                    </div>

                    <!-- Perbedaan Detail -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-compress-alt mr-2 text-purple-500"></i>
                            Perbedaan Ruangan Sarana dan Prasarana
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Sarana -->
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="bg-orange-100 text-orange-600 p-2 rounded-full mr-3">
                                        <i class="fas fa-graduation-cap text-sm"></i>
                                    </div>
                                    <h4 class="font-semibold text-orange-700">Ruangan Sarana</h4>
                                </div>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                                        <span>Terkait dengan fakultas dan program studi tertentu</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                                        <span>Digunakan untuk kegiatan akademik spesifik</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                                        <span>Contoh: Ruang Kelas, Laboratorium, Ruang Dosen Prodi</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Prasarana -->
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="bg-green-100 text-green-600 p-2 rounded-full mr-3">
                                        <i class="fas fa-building text-sm"></i>
                                    </div>
                                    <h4 class="font-semibold text-green-700">Ruangan Prasarana</h4>
                                </div>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                                        <span>Digunakan bersama oleh seluruh civitas akademika</span>
                                    </li>
                                    <li class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                                        <span>Bersifat umum dan mendukung kegiatan institusi</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                                        <span>Contoh: Rektorat, Perpustakaan, Aula, Gedung Yayasan</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>