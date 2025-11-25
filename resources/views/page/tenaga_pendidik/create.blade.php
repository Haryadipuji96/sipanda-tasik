<x-app-layout>
    <x-slot name="title">Tambah Tenaga Pendidik</x-slot>

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

        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
            background-color: #f8fafc;
        }

        .file-upload:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }

        .file-upload.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
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
                                <i class="fas fa-chalkboard-teacher text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Tambah Tenaga Pendidik Baru</h1>
                                <p class="text-blue-100 text-xs sm:text-sm mt-1">
                                    Input data lengkap tenaga pendidik dan upload berkas dokumen
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('tenaga-pendidik.index') }}"
                            class="text-white hover:text-blue-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('tenaga-pendidik.store') }}" method="POST" enctype="multipart/form-data"
                    id="tendikForm" x-data="{ golongan: [{ tahun: '', golongan: '' }] }">
                    @csrf

                    <div class="form-body">
                        <!-- Informasi Utama -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informasi Utama
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
                                <!-- Program Studi & Jabatan Struktural -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Program Studi
                                        </label>
                                        <select name="id_prodi"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="">-- Pilih Prodi (Opsional) --</option>
                                            @foreach ($prodi as $p)
                                                <option value="{{ $p->id }}"
                                                    {{ old('id_prodi') == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama_prodi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_prodi')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Posisi/Jabatan Struktural
                                        </label>
                                        <select name="jabatan_struktural"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="">-- Pilih Posisi --</option>
                                            @foreach ($jabatanOptions as $jabatan)
                                                <option value="{{ $jabatan }}"
                                                    {{ old('jabatan_struktural') == $jabatan ? 'selected' : '' }}>
                                                    {{ $jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jabatan_struktural')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nama & Gelar -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Gelar Depan
                                        </label>
                                        <input type="text" name="gelar_depan" value="{{ old('gelar_depan') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Contoh: Dr." maxlength="50">
                                        @error('gelar_depan')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nama Tenaga Pendidik <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="nama_tendik" value="{{ old('nama_tendik') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Masukkan nama lengkap" required maxlength="255">
                                        @error('nama_tendik')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Gelar Belakang
                                        </label>
                                        <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Contoh: S.Pd, M.Kom" maxlength="50">
                                        @error('gelar_belakang')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status Kepegawaian & Jenis Kelamin -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Status Kepegawaian
                                        </label>
                                        <select name="status_kepegawaian"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="KONTRAK"
                                                {{ old('status_kepegawaian') == 'KONTRAK' ? 'selected' : '' }}>
                                                KONTRAK</option>
                                            <option value="TETAP"
                                                {{ old('status_kepegawaian') == 'TETAP' ? 'selected' : '' }}>
                                                TETAP</option>
                                        </select>
                                        @error('status_kepegawaian')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Jenis Kelamin
                                        </label>
                                        <select name="jenis_kelamin"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="laki-laki"
                                                {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="perempuan"
                                                {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tempat, Tanggal Lahir & TMT Kerja -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tempat Lahir
                                        </label>
                                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Tempat lahir" maxlength="100">
                                        @error('tempat_lahir')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tanggal Lahir
                                        </label>
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        @error('tanggal_lahir')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            TMT Kerja
                                        </label>
                                        <input type="date" name="tmt_kerja" value="{{ old('tmt_kerja') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        @error('tmt_kerja')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Golongan -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-history mr-2 text-purple-500"></i>
                                Riwayat Golongan
                            </h3>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <div class="flex items-start">
                                    <i class="fas fa-lightbulb text-yellow-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <p class="text-yellow-700 text-xs sm:text-sm">
                                            Tambahkan riwayat golongan secara berurutan dari yang terbaru
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <template x-for="(item, index) in golongan" :key="index">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Tahun
                                            </label>
                                            <input type="text" :name="'golongan[' + index + '][tahun]'"
                                                x-model="item.tahun"
                                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                placeholder="Tahun" maxlength="4">
                                        </div>
                                        <div class="flex space-x-2">
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Golongan
                                                </label>
                                                <input type="text" :name="'golongan[' + index + '][golongan]'"
                                                    x-model="item.golongan"
                                                    class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                    placeholder="Golongan" maxlength="50">
                                            </div>
                                            <button type="button" @click="golongan.splice(index,1)"
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition flex items-center justify-center h-10"
                                                x-show="golongan.length > 1" title="Hapus">
                                                <i class="fas fa-times text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>

                                <button type="button" @click="golongan.push({ tahun: '', golongan: '' })"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition flex items-center space-x-2 text-sm">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Riwayat Golongan</span>
                                </button>
                            </div>
                        </div>

                        <!-- Informasi Kontak & Pendidikan -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-address-card mr-2 text-green-500"></i>
                                Informasi Kontak & Pendidikan
                            </h3>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- NIP, No HP, Email, Alamat -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            NIP
                                        </label>
                                        <input type="text" name="nip" value="{{ old('nip') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="NIP" maxlength="50">
                                        @error('nip')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            No HP
                                        </label>
                                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="08xxxx" maxlength="15">
                                        @error('no_hp')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Email
                                        </label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="email@example.com" maxlength="100">
                                        @error('email')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Alamat
                                        </label>
                                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Alamat lengkap" maxlength="255">
                                        @error('alamat')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pendidikan Terakhir -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Pendidikan Terakhir
                                    </label>
                                    <select name="pendidikan_terakhir"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="">-- Pilih Pendidikan Terakhir --</option>
                                        <option value="SMA/Sederajat"
                                            {{ old('pendidikan_terakhir') == 'SMA/Sederajat' ? 'selected' : '' }}>
                                            SMA/Sederajat</option>
                                        <option value="D1"
                                            {{ old('pendidikan_terakhir') == 'D1' ? 'selected' : '' }}>D1</option>
                                        <option value="D2"
                                            {{ old('pendidikan_terakhir') == 'D2' ? 'selected' : '' }}>D2</option>
                                        <option value="D3"
                                            {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="D4"
                                            {{ old('pendidikan_terakhir') == 'D4' ? 'selected' : '' }}>D4</option>
                                        <option value="S1"
                                            {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2"
                                            {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3"
                                            {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                                        <option value="Profesi"
                                            {{ old('pendidikan_terakhir') == 'Profesi' ? 'selected' : '' }}>Profesi
                                        </option>
                                        <option value="Spesialis"
                                            {{ old('pendidikan_terakhir') == 'Spesialis' ? 'selected' : '' }}>Spesialis
                                        </option>
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Keterangan
                                    </label>
                                    <textarea name="keterangan" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                        placeholder="Tambahkan keterangan tambahan tentang tenaga pendidik...">{{ old('keterangan') }}</textarea>
                                    <p class="text-gray-500 text-xs mt-1">
                                        Keterangan opsional untuk informasi tambahan
                                    </p>
                                    @error('keterangan')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Upload Berkas -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-file-upload mr-2 text-orange-500"></i>
                                Upload Berkas Dokumen
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
                                <!-- KTP -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">KTP</label>
                                    <input type="file" name="file_ktp"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- KK -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga
                                        (KK)</label>
                                    <input type="file" name="file_kk"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Ijazah S1 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ijazah S1</label>
                                    <input type="file" name="file_ijazah_s1"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Transkrip S1 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Transkrip Nilai
                                        S1</label>
                                    <input type="file" name="file_transkrip_s1"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Ijazah S2 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ijazah S2</label>
                                    <input type="file" name="file_ijazah_s2"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Transkrip S2 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Transkrip Nilai
                                        S2</label>
                                    <input type="file" name="file_transkrip_s2"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Ijazah S3 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ijazah S3</label>
                                    <input type="file" name="file_ijazah_s3"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Transkrip S3 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Transkrip Nilai
                                        S3</label>
                                    <input type="file" name="file_transkrip_s3"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Perjanjian Kerja -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Perjanjian
                                        Kerja</label>
                                    <input type="file" name="file_perjanjian_kerja"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- SK -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Surat Keputusan
                                        (SK)</label>
                                    <input type="file" name="file_sk"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <!-- Surat Tugas -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Surat Tugas</label>
                                    <input type="file" name="file_surat_tugas"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>

                            <p class="text-gray-500 text-xs mt-3">Format: <b>PDF, JPG, PNG</b> | Maksimal <b>2MB</b>
                                per file</p>
                        </div>

                        <!-- Upload File Lainnya -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-paperclip mr-2 text-gray-500"></i>
                                Upload File Lainnya
                            </h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    File Dokumen Lainnya
                                </label>
                                <input type="file" name="file" id="file"
                                    class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <p class="text-gray-500 text-xs mt-1">
                                    Format: <b>PDF, DOC, DOCX, JPG, PNG</b> | Maksimal <b>2MB</b>
                                </p>
                                @error('file')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
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
                            <a href="{{ route('tenaga-pendidik.index') }}"
                                class="btn-secondary text-center order-2 sm:order-1 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="btn-primary flex items-center justify-center order-1 sm:order-2 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Tenaga Pendidik
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
            // Function untuk validasi file (hanya validasi, tidak tampilkan success)
            function validateFile(input, showSuccess = false) {
                const file = input.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024))
                                .toFixed(2) + 'MB'
                        });
                        input.value = '';
                        return false;
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
                        input.value = '';
                        return false;
                    }

                    // Show success message hanya jika diminta (saat change event)
                    if (showSuccess && input.name === 'file') {
                        Swal.fire({
                            icon: 'success',
                            title: 'File Valid',
                            text: 'File siap diupload: ' + file.name,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }

                    return true;
                }
                return false;
            }

            // Function untuk handle file change (dengan success message)
            function handleFileChange(input) {
                validateFile(input, true); // true untuk show success message
            }

            // Attach event listeners untuk semua file inputs
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    handleFileChange(this);
                });
            });

            // Form validation - BAHASA INDONESIA
            const form = document.getElementById('tendikForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const namaTendik = document.querySelector('input[name="nama_tendik"]');

                    if (!namaTendik || !namaTendik.value.trim()) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Belum Lengkap',
                            text: 'Nama Tenaga Pendidik wajib diisi!'
                        });
                        return;
                    }

                    // Validasi semua file inputs sebelum submit (TANPA success message)
                    let allFilesValid = true;
                    let invalidFiles = [];

                    fileInputs.forEach(input => {
                        if (input.files.length > 0) {
                            if (!validateFile(input, false)) { // false untuk tidak show success
                                allFilesValid = false;
                                invalidFiles.push(input.name);
                            }
                        }
                    });

                    if (!allFilesValid) {
                        e.preventDefault();
                        // Tidak perlu show alert lagi karena sudah ditampilkan di validateFile
                        return;
                    }

                    // Jika semua valid, lanjutkan submit
                    // Tidak perlu show success message di sini
                });
            }

            // Auto-capitalize for names
            const namaTendikInput = document.querySelector('input[name="nama_tendik"]');
            if (namaTendikInput) {
                namaTendikInput.addEventListener('blur', function() {
                    this.value = this.value.replace(/\w\S*/g, function(txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
                });
            }

            // NOTIFIKASI SUKSES - BAHASA INDONESIA
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('tenaga-pendidik.index') }}";
                });
            @endif

            // NOTIFIKASI ERROR VALIDATION - BAHASA INDONESIA
            @if ($errors->any())
                @if (!session('success'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        html: `@foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                       @endforeach`,
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
        // Add resize listener
        window.addEventListener('resize', handleResize);
    </script>
</x-app-layout>
