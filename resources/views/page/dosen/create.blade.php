<x-app-layout>
    <x-slot name="title">Tambah Data Dosen</x-slot>

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

        .section-divider {
            border-top: 2px solid #e5e7eb;
            margin: 2rem 0;
            padding-top: 1.5rem;
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
                                <i class="fas fa-user-graduate text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Tambah Data Dosen Baru</h1>
                                <p class="text-blue-100 text-xs sm:text-sm mt-1">
                                    Input data lengkap dosen dan upload berkas dokumen
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dosen.index') }}"
                            class="text-white hover:text-blue-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data" id="dosenForm"
                    x-data="formDosen()">
                    @csrf

                    <div class="form-body">
                        <!-- Informasi Dasar -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informasi Dasar
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <h4 class="font-medium text-blue-800 mb-1 text-sm sm:text-base">Informasi Input
                                        </h4>
                                        <p class="text-blue-700 text-xs sm:text-sm">
                                            • Isi data dengan lengkap dan benar<br>
                                            • Field bertanda <span class="text-red-500">*</span> wajib diisi<br>
                                            • Format file: <strong>PDF, JPG, PNG</strong> | Maks. <strong>2MB</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- Program Studi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Program Studi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="id_prodi"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        required>
                                        <option value="">-- Pilih Prodi --</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Gelar Depan & Nama -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Gelar Depan
                                        </label>
                                        <input type="text" name="gelar_depan"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Dr.">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="nama"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Masukkan nama lengkap dosen" required>
                                    </div>
                                </div>

                                <!-- Gelar Belakang -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Gelar Belakang
                                    </label>
                                    <input type="text" name="gelar_belakang"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="M.Pd., M.Kom.">
                                </div>

                                <!-- Tempat & Tanggal Lahir -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tempat Lahir
                                        </label>
                                        <input type="text" name="tempat_lahir"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Masukkan tempat lahir">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tanggal Lahir
                                        </label>
                                        <input type="date" name="tanggal_lahir"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    </div>
                                </div>

                                <!-- NIDN & NUPTK -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            NIDN
                                        </label>
                                        <input type="text" name="nik"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Masukkan NIDN">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            NUPTK
                                        </label>
                                        <input type="text" name="nuptk"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Masukkan NUPTK">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pendidikan -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-graduation-cap mr-2 text-green-500"></i>
                                Informasi Pendidikan
                            </h3>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- Pendidikan Terakhir -->
                                <div x-data="{ pendidikanLainnya: '' }">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Pendidikan Terakhir
                                    </label>
                                    <select name="pendidikan_terakhir" x-model="pendidikanLainnya"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="">-- Pilih Pendidikan Terakhir --</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="Dr">Dr</option>
                                        <option value="Prof">Prof</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>

                                    <!-- Input untuk pilihan lainnya -->
                                    <div x-show="pendidikanLainnya === 'Lainnya'" x-transition class="mt-2">
                                        <input type="text" name="pendidikan_lainnya"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Masukkan pendidikan lainnya">
                                    </div>
                                </div>

                                <!-- Riwayat Pendidikan -->
                                <div class="border-t pt-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <label class="block font-medium text-sm sm:text-base">Riwayat
                                            Pendidikan</label>
                                        <button type="button" @click="addPendidikan()"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg transition flex items-center space-x-2 text-sm">
                                            <i class="fas fa-plus"></i>
                                            <span>Tambah Pendidikan</span>
                                        </button>
                                    </div>

                                    <template x-for="(item, index) in pendidikan" :key="index">
                                        <div
                                            class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3 p-3 bg-gray-50 rounded-lg border">
                                            <div>
                                                <label class="text-xs text-gray-600">Jenjang</label>
                                                <select :name="'pendidikan[' + index + '][jenjang]'"
                                                    x-model="item.jenjang"
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                    <option value="">-- Pilih Jenjang --</option>
                                                    <option value="S1">S1</option>
                                                    <option value="S2">S2</option>
                                                    <option value="S3">S3</option>
                                                    <option value="D3">D3</option>
                                                    <option value="D4">D4</option>
                                                    <option value="Prof">Prof</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-xs text-gray-600">Prodi/Jurusan</label>
                                                <input type="text" :name="'pendidikan[' + index + '][prodi]'"
                                                    x-model="item.prodi"
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    placeholder="PAI">
                                            </div>
                                            <div>
                                                <label class="text-xs text-gray-600">Tahun Lulus</label>
                                                <input type="text" :name="'pendidikan[' + index + '][tahun_lulus]'"
                                                    x-model="item.tahun_lulus"
                                                    class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    placeholder="2015">
                                            </div>
                                            <div class="flex gap-2">
                                                <div class="flex-1">
                                                    <label class="text-xs text-gray-600">Universitas/PT</label>
                                                    <input type="text"
                                                        :name="'pendidikan[' + index + '][universitas]'"
                                                        x-model="item.universitas"
                                                        class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                        placeholder="STAI Tasikmalaya">
                                                </div>
                                                <div class="flex items-end">
                                                    <button type="button" @click="removePendidikan(index)"
                                                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition flex items-center justify-center h-10"
                                                        x-show="pendidikan.length > 1" title="Hapus">
                                                        <i class="fas fa-times text-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kepegawaian -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-briefcase mr-2 text-purple-500"></i>
                                Informasi Kepegawaian
                            </h3>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- Jabatan & TMT Kerja -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Jabatan
                                        </label>
                                        <input type="text" name="jabatan"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Masukkan jabatan">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            TMT Kerja
                                        </label>
                                        <input type="date" name="tmt_kerja"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    </div>
                                </div>

                                <!-- Masa Kerja -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Masa Kerja (Tahun)
                                        </label>
                                        <input type="number" name="masa_kerja_tahun"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            min="0" placeholder="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Masa Kerja (Bulan)
                                        </label>
                                        <input type="number" name="masa_kerja_bulan"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            min="0" max="11" placeholder="0">
                                    </div>
                                </div>

                                <!-- Status Dosen -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Status Dosen <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status_dosen"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        required>
                                        <option value="">-- Pilih Status Dosen --</option>
                                        <option value="DOSEN_TETAP">Dosen Tetap</option>
                                        <option value="DOSEN_TIDAK_TETAP">Dosen Tidak Tetap</option>
                                        <option value="PNS">PNS</option>
                                    </select>
                                </div>

                                <!-- Pangkat/Golongan & Jabatan Fungsional -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Pangkat/Golongan
                                        </label>
                                        <input type="text" name="pangkat_golongan"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="III/b">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Jabatan Fungsional
                                        </label>
                                        <input type="text" name="jabatan_fungsional"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Lektor">
                                    </div>
                                </div>

                                <!-- Masa Kerja Golongan -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Masa Kerja Golongan (Tahun)
                                        </label>
                                        <input type="number" name="masa_kerja_golongan_tahun"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            min="0" placeholder="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Masa Kerja Golongan (Bulan)
                                        </label>
                                        <input type="number" name="masa_kerja_golongan_bulan"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            min="0" max="11" placeholder="0">
                                    </div>
                                </div>

                                <!-- No SK & JaFung -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            No SK
                                        </label>
                                        <input type="text" name="no_sk"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="123/SK/2024">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            JaFung
                                        </label>
                                        <input type="text" name="no_sk_jafung"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Lektor">
                                    </div>
                                </div>

                                <!-- Sertifikasi & Inpasing -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Sertifikasi <span class="text-red-500">*</span>
                                        </label>
                                        <select name="sertifikasi" x-model="sertifikasi"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                            <option value="BELUM">BELUM</option>
                                            <option value="SUDAH">SUDAH</option>
                                        </select>

                                        <!-- Upload Sertifikasi -->
                                        <div x-show="sertifikasi === 'SUDAH'" x-transition class="mt-2">
                                            <label class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                Sertifikasi</label>
                                            <input type="file" name="file_sertifikasi"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Inpasing <span class="text-red-500">*</span>
                                        </label>
                                        <select name="inpasing" x-model="inpasing"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                            <option value="BELUM">BELUM</option>
                                            <option value="SUDAH">SUDAH</option>
                                        </select>

                                        <!-- Upload Inpasing -->
                                        <div x-show="inpasing === 'SUDAH'" x-transition class="mt-2">
                                            <label class="block font-medium mb-1 text-sm text-gray-700">Upload
                                                Inpasing</label>
                                            <input type="file" name="file_inpasing"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Berkas Dosen -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-file-upload mr-2 text-orange-500"></i>
                                Upload Berkas Dosen
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <h4 class="font-medium text-blue-800 mb-1 text-sm sm:text-base">Format Berkas
                                        </h4>
                                        <p class="text-blue-700 text-xs sm:text-sm">
                                            • Format file: <strong>PDF, JPG, PNG</strong><br>
                                            • Maksimal ukuran: <strong>2MB</strong> per file<br>
                                            • Upload hanya file yang diperlukan
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Kolom 1 -->
                                <div class="space-y-4">
                                    <!-- KTP -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload KTP</label>
                                        <input type="file" name="file_ktp"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Ijazah S1 -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Ijazah
                                            S1</label>
                                        <input type="file" name="file_ijazah_s1"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Transkrip S1 -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Transkrip
                                            S1</label>
                                        <input type="file" name="file_transkrip_s1"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Ijazah S2 -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Ijazah
                                            S2</label>
                                        <input type="file" name="file_ijazah_s2"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Transkrip S2 -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Transkrip
                                            S2</label>
                                        <input type="file" name="file_transkrip_s2"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Ijazah S3 -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Ijazah
                                            S3</label>
                                        <input type="file" name="file_ijazah_s3"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>
                                </div>

                                <!-- Kolom 2 -->
                                <div class="space-y-4">
                                    <!-- Transkrip S3 -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Transkrip
                                            S3</label>
                                        <input type="file" name="file_transkrip_s3"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Jafung -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload
                                            Jafung</label>
                                        <input type="file" name="file_jafung"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- KK -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload KK</label>
                                        <input type="file" name="file_kk"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Perjanjian Kerja -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Perjanjian
                                            Kerja</label>
                                        <input type="file" name="file_perjanjian_kerja"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- SK Pengangkatan -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload SK
                                            Pengangkatan</label>
                                        <input type="file" name="file_sk_pengangkatan"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>

                                    <!-- Surat Pernyataan -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Surat
                                            Pernyataan</label>
                                        <input type="file" name="file_surat_pernyataan"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 2 -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <!-- SKTP -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload SKTP</label>
                                    <input type="file" name="file_sktp"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Surat Tugas -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Surat
                                        Tugas</label>
                                    <input type="file" name="file_surat_tugas"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- SK Aktif -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload SK Aktif
                                        Tridharma</label>
                                    <input type="file" name="file_sk_aktif"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="mb-6 sm:mb-8">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                    <i class="fas fa-cogs mr-2 text-green-500"></i>
                                    Informasi Tambahan
                                </h3>

                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-blue-500 mr-2 text-sm"></i>
                                            <span class="text-gray-600">Dibuat pada:</span>
                                            <span class="ml-2 font-medium">{{ now()->format('d/m/Y') }}</span>
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
                                <a href="{{ route('dosen.index') }}"
                                    class="btn-secondary text-center order-2 sm:order-1 px-4 py-2 text-sm sm:text-base">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </a>
                                <button type="submit"
                                    class="btn-primary flex items-center justify-center order-1 sm:order-2 px-4 py-2 text-sm sm:text-base">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Data Dosen
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
        // Fungsi Alpine.js untuk form create
        function formDosen() {
            return {
                pendidikan: [{
                    jenjang: '',
                    prodi: '',
                    tahun_lulus: '',
                    universitas: ''
                }],
                sertifikasi: 'BELUM',
                inpasing: 'BELUM',
                addPendidikan() {
                    this.pendidikan.push({
                        jenjang: '',
                        prodi: '',
                        tahun_lulus: '',
                        universitas: ''
                    });
                },
                removePendidikan(index) {
                    if (this.pendidikan.length > 1) {
                        this.pendidikan.splice(index, 1);
                    }
                }
            }
        }

        // Fungsi Alpine.js untuk form edit
        function formDosenEdit(pendidikanData = [], sertifikasi = 'BELUM', inpasing = 'BELUM') {
            return {
                pendidikan: pendidikanData.length > 0 ? pendidikanData : [{
                    jenjang: '',
                    prodi: '',
                    tahun_lulus: '',
                    universitas: ''
                }],
                sertifikasi: sertifikasi,
                inpasing: inpasing,
                addPendidikan() {
                    this.pendidikan.push({
                        jenjang: '',
                        prodi: '',
                        tahun_lulus: '',
                        universitas: ''
                    });
                },
                removePendidikan(index) {
                    if (this.pendidikan.length > 1) {
                        this.pendidikan.splice(index, 1);
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Variabel untuk menyimpan status validasi file
            let fileValidationState = {
                validFiles: [],
                invalidFiles: []
            };

            // Fungsi untuk validasi file (tanpa show success notification)
            function validateFile(file, inputElement) {
                if (file) {
                    // Validasi ukuran file (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        fileValidationState.invalidFiles.push({
                            name: file.name,
                            size: (file.size / (1024 * 1024)).toFixed(2),
                            error: 'size'
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024))
                                .toFixed(2) + 'MB',
                            confirmButtonColor: '#3b82f6'
                        });
                        inputElement.value = '';
                        return false;
                    }

                    // Validasi tipe file
                    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        fileValidationState.invalidFiles.push({
                            name: file.name,
                            type: file.type,
                            error: 'type'
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Didukung',
                            text: 'Hanya file PDF, JPG, dan PNG yang diizinkan.',
                            confirmButtonColor: '#3b82f6'
                        });
                        inputElement.value = '';
                        return false;
                    }

                    // File valid - tambahkan ke list valid files
                    fileValidationState.validFiles.push({
                        name: file.name,
                        size: (file.size / (1024 * 1024)).toFixed(2),
                        input: inputElement.name
                    });

                    return true;
                }
                return false;
            }

            // Fungsi untuk reset status validasi file
            function resetFileValidation() {
                fileValidationState = {
                    validFiles: [],
                    invalidFiles: []
                };
            }

            // Fungsi untuk menampilkan summary file yang valid saat submit
            function showFileValidationSummary() {
                if (fileValidationState.validFiles.length > 0) {
                    let successMessage = 'File berikut siap diupload:\n';
                    fileValidationState.validFiles.forEach(file => {
                        successMessage += `• ${file.name} (${file.size}MB)\n`;
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'File Valid',
                        text: successMessage,
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            }

            // Validasi semua file input untuk form create
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Reset validation state untuk file ini
                        fileValidationState.validFiles = fileValidationState.validFiles.filter(f =>
                            f.input !== this.name);
                        fileValidationState.invalidFiles = fileValidationState.invalidFiles.filter(
                            f => f.input !== this.name);

                        validateFile(file, this);
                    } else {
                        // Jika file dihapus, hapus dari state
                        fileValidationState.validFiles = fileValidationState.validFiles.filter(f =>
                            f.input !== this.name);
                        fileValidationState.invalidFiles = fileValidationState.invalidFiles.filter(
                            f => f.input !== this.name);
                    }
                });
            });

            // Validasi form submit untuk form create
            const form = document.getElementById('dosenForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    let errorMessages = [];

                    // Reset validation state
                    resetFileValidation();

                    // Validasi field required
                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500');
                            errorMessages.push(`Field ${field.name} wajib diisi`);
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    // Validasi semua file sebelum submit
                    const fileInputs = form.querySelectorAll('input[type="file"]');
                    fileInputs.forEach(input => {
                        if (input.files.length > 0) {
                            const file = input.files[0];
                            const fileIsValid = validateFile(file, input);
                            if (!fileIsValid) {
                                isValid = false;
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();

                        // Tampilkan error messages
                        if (fileValidationState.invalidFiles.length > 0) {
                            let fileErrorMessage = 'Masalah dengan file upload:\n';
                            fileValidationState.invalidFiles.forEach(file => {
                                if (file.error === 'size') {
                                    fileErrorMessage +=
                                        `• ${file.name} - Ukuran file terlalu besar (${file.size}MB)\n`;
                                } else if (file.error === 'type') {
                                    fileErrorMessage +=
                                        `• ${file.name} - Format file tidak didukung\n`;
                                }
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                html: `
                                <div class="text-left">
                                    <p class="mb-2">${errorMessages.join('<br>')}</p>
                                    <p class="mt-3">${fileErrorMessage}</p>
                                </div>
                            `,
                                confirmButtonColor: '#3b82f6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Belum Lengkap',
                                text: errorMessages.join('\n'),
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    } else {
                        // Jika semua valid, tampilkan summary file yang akan diupload
                        if (fileValidationState.validFiles.length > 0) {
                            e.preventDefault(); // Prevent immediate submit

                            let successMessage = 'Data siap disimpan!\n\nFile berikut akan diupload:\n';
                            fileValidationState.validFiles.forEach(file => {
                                successMessage += `• ${file.name} (${file.size}MB)\n`;
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Konfirmasi Simpan',
                                text: successMessage,
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Simpan Data',
                                cancelButtonText: 'Periksa Kembali',
                                confirmButtonColor: '#3b82f6',
                                cancelButtonColor: '#6b7280'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Jika dikonfirmasi, submit form
                                    form.submit();
                                }
                            });
                        }
                        // Jika tidak ada file yang diupload, lanjutkan submit normal
                    }
                });
            }

            // Validasi form edit saat submit (delegasi event)
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form && form.getAttribute('action')?.includes('/dosen/') && form.id !== 'dosenForm') {
                    let isValid = true;
                    let errorMessages = [];

                    // Reset validation state
                    resetFileValidation();

                    // Validasi field required
                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500');
                            errorMessages.push(`Field ${field.name} wajib diisi`);
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    // Validasi file upload
                    const fileInputs = form.querySelectorAll('input[type="file"]');
                    fileInputs.forEach(input => {
                        if (input.files.length > 0) {
                            const file = input.files[0];
                            const fileIsValid = validateFile(file, input);
                            if (!fileIsValid) {
                                isValid = false;
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();

                        if (fileValidationState.invalidFiles.length > 0) {
                            let fileErrorMessage = 'Masalah dengan file upload:\n';
                            fileValidationState.invalidFiles.forEach(file => {
                                if (file.error === 'size') {
                                    fileErrorMessage +=
                                        `• ${file.name} - Ukuran file terlalu besar (${file.size}MB)\n`;
                                } else if (file.error === 'type') {
                                    fileErrorMessage +=
                                        `• ${file.name} - Format file tidak didukung\n`;
                                }
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                html: `
                                <div class="text-left">
                                    <p class="mb-2">${errorMessages.join('<br>')}</p>
                                    <p class="mt-3">${fileErrorMessage}</p>
                                </div>
                            `,
                                confirmButtonColor: '#3b82f6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Belum Lengkap',
                                text: errorMessages.join('\n'),
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    } else {
                        // Jika semua valid, tampilkan konfirmasi untuk edit
                        if (fileValidationState.validFiles.length > 0) {
                            e.preventDefault();

                            let successMessage = 'Data siap diupdate!\n\nFile berikut akan diupload:\n';
                            fileValidationState.validFiles.forEach(file => {
                                successMessage += `• ${file.name} (${file.size}MB)\n`;
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Konfirmasi Update',
                                text: successMessage,
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Update Data',
                                cancelButtonText: 'Periksa Kembali',
                                confirmButtonColor: '#3b82f6',
                                cancelButtonColor: '#6b7280'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        }
                        // Jika tidak ada file baru yang diupload, lanjutkan submit normal
                    }
                }
            });

            // NOTIFIKASI SUKSES
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('dosen.index') }}";
                });
            @endif

            // NOTIFIKASI ERROR VALIDATION
            @if ($errors->any())
                @if (!session('success'))
                    let errorMessage = '';
                    @foreach ($errors->all() as $error)
                        errorMessage += '• {{ $error }}\n';
                    @endforeach

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: errorMessage,
                        timer: 5000,
                        showConfirmButton: true
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
        window.addEventListener('resize', handleResize);
    </script>
</x-app-layout>
