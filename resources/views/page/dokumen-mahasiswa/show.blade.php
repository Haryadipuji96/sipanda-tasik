<x-app-layout>
    <x-slot name="title">Detail Mahasiswa - {{ $dokumenMahasiswa->nama_lengkap }}</x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3 mb-3 md:mb-0">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                            <i class="fas fa-user-graduate text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Detail Mahasiswa</h1>
                            <p class="text-sm text-gray-500">{{ $dokumenMahasiswa->nama_lengkap }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('dokumen-mahasiswa.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Data Mahasiswa -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Informasi Pribadi -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Informasi Pribadi</h3>
                        
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">NIM</span>
                            <span class="font-medium">{{ $dokumenMahasiswa->nim }}</span>
                        </div>
                        
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Nama Lengkap</span>
                            <span class="font-medium">{{ $dokumenMahasiswa->nama_lengkap }}</span>
                        </div>
                        
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Program Studi</span>
                            <span class="font-medium text-right">
                                {{ $dokumenMahasiswa->prodi->nama_prodi }}<br>
                                <small class="text-gray-500">{{ $dokumenMahasiswa->prodi->fakultas->nama_fakultas }}</small>
                            </span>
                        </div>
                    </div>

                    <!-- Informasi Akademik -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Informasi Akademik</h3>
                        
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Tahun Masuk</span>
                            <span class="font-medium">{{ $dokumenMahasiswa->tahun_masuk }}</span>
                        </div>
                        
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Tahun Keluar</span>
                            <span class="font-medium">{{ $dokumenMahasiswa->tahun_keluar ?? '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-600">Status</span>
                            @php
                                $statusColor = match ($dokumenMahasiswa->status_mahasiswa) {
                                    'Aktif' => 'bg-blue-100 text-blue-800',
                                    'Lulus' => 'bg-green-100 text-green-800',
                                    'Cuti' => 'bg-yellow-100 text-yellow-800',
                                    'Drop Out' => 'bg-red-100 text-red-800',
                                };
                            @endphp
                            <span class="badge {{ $statusColor }}">
                                {{ $dokumenMahasiswa->status_mahasiswa }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Dokumen -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Dokumen</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- File Ijazah -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                    <div>
                                        <p class="font-medium text-gray-800">Ijazah</p>
                                        <p class="text-sm text-gray-600">
                                            @if($dokumenMahasiswa->file_ijazah)
                                                {{ $dokumenMahasiswa->file_ijazah }}
                                            @else
                                                <span class="text-gray-400">Belum diupload</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if($dokumenMahasiswa->file_ijazah)
                                <a href="{{ asset('dokumen_mahasiswa/ijazah/' . $dokumenMahasiswa->file_ijazah) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition">
                                    Lihat
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- File Transkrip -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-alt text-green-500 text-xl"></i>
                                    <div>
                                        <p class="font-medium text-gray-800">Transkrip Nilai</p>
                                        <p class="text-sm text-gray-600">
                                            @if($dokumenMahasiswa->file_transkrip)
                                                {{ $dokumenMahasiswa->file_transkrip }}
                                            @else
                                                <span class="text-gray-400">Belum diupload</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if($dokumenMahasiswa->file_transkrip)
                                <a href="{{ asset('dokumen_mahasiswa/transkrip/' . $dokumenMahasiswa->file_transkrip) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                                    Lihat
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>