<x-app-layout>
    <x-slot name="title">Tambah Ruangan</x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">Tambah Ruangan Baru</h1>
                            <p class="text-gray-600 text-sm">Pilih jenis ruangan yang ingin ditambahkan</p>
                        </div>
                    </div>
                    <a href="{{ route('ruangan.index') }}"
                        class="text-gray-600 hover:text-gray-800 transition flex items-center space-x-1">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- Pilihan Tipe Ruangan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ruangan Akademik -->
                    <a href="{{ route('ruangan.create.akademik') }}"
                        class="flex flex-col items-center p-8 border-2 border-blue-200 rounded-xl cursor-pointer hover:bg-blue-50 transition bg-blue-50 hover:border-blue-300">
                        <div class="bg-blue-100 text-blue-600 p-4 rounded-full mb-4">
                            <i class="fas fa-graduation-cap text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-blue-700 mb-2">Ruangan Akademik</h3>
                        <p class="text-blue-600 text-center text-sm">
                            Ruangan terkait fakultas dan program studi<br>
                            (Kelas, Laboratorium, Ruang Dosen, dll)
                        </p>
                        <div class="mt-4 text-blue-600">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <!-- Ruangan Umum -->
                    <a href="{{ route('ruangan.create.umum') }}"
                        class="flex flex-col items-center p-8 border-2 border-green-200 rounded-xl cursor-pointer hover:bg-green-50 transition bg-green-50 hover:border-green-300">
                        <div class="bg-green-100 text-green-600 p-4 rounded-full mb-4">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-green-700 mb-2">Ruangan Umum</h3>
                        <p class="text-green-600 text-center text-sm">
                            Ruangan umum institusi<br>
                            (Rektorat, Perpustakaan, Gedung Yayasan, dll)
                        </p>
                        <div class="mt-4 text-green-600">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Informasi -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-800 mb-1">Perbedaan Ruangan Akademik dan Umum</h4>
                            <p class="text-gray-600 text-sm">
                                • <strong>Ruangan Akademik</strong>: Terkait dengan fakultas dan program studi tertentu<br>
                                • <strong>Ruangan Umum</strong>: Digunakan bersama oleh seluruh civitas akademika
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>