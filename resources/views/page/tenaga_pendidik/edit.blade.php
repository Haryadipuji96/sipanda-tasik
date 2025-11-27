<x-app-layout>
    <x-slot name="title">Edit Tenaga Pendidik - {{ $tendik->nama_tendik }}</x-slot>

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
        <div class="max-w-6xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-edit text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Edit Tenaga Pendidik</h1>
                                <p class="text-orange-100 text-xs sm:text-sm mt-1">
                                    Perbarui data {{ $tendik->nama_tendik }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('tenaga-pendidik.index') }}"
                            class="text-white hover:text-orange-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('tenaga-pendidik.update', $tendik->id) }}" method="POST"
                    enctype="multipart/form-data" id="tendikForm" x-data="{ golongan: {{ json_encode($tendik->golongan_array) }} }">
                    @csrf
                    @method('PUT')

                    <div class="form-body">
                        <!-- Informasi Utama -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informasi Utama
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-amber-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <h4 class="font-medium text-amber-800 mb-1 text-sm sm:text-base">Informasi Edit
                                        </h4>
                                        <p class="text-amber-700 text-xs sm:text-sm">
                                            • Perbarui data dengan informasi yang valid<br>
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
                                                    {{ old('id_prodi', $tendik->id_prodi) == $p->id ? 'selected' : '' }}>
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
                                                    {{ old('jabatan_struktural', $tendik->jabatan_struktural) == $jabatan ? 'selected' : '' }}>
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
                                        <input type="text" name="gelar_depan"
                                            value="{{ old('gelar_depan', $tendik->gelar_depan) }}"
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
                                        <input type="text" name="nama_tendik"
                                            value="{{ old('nama_tendik', $tendik->nama_tendik) }}"
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
                                        <input type="text" name="gelar_belakang"
                                            value="{{ old('gelar_belakang', $tendik->gelar_belakang) }}"
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
                                                {{ old('status_kepegawaian', $tendik->status_kepegawaian) == 'KONTRAK' ? 'selected' : '' }}>
                                                KONTRAK</option>
                                            <option value="TETAP"
                                                {{ old('status_kepegawaian', $tendik->status_kepegawaian) == 'TETAP' ? 'selected' : '' }}>
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
                                                {{ old('jenis_kelamin', $tendik->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                                Laki-laki
                                            </option>
                                            <option value="perempuan"
                                                {{ old('jenis_kelamin', $tendik->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                                Perempuan
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
                                        <input type="text" name="tempat_lahir"
                                            value="{{ old('tempat_lahir', $tendik->tempat_lahir) }}"
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
                                        <input type="date" name="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $tendik->tanggal_lahir ? $tendik->tanggal_lahir->format('Y-m-d') : '') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        @error('tanggal_lahir')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            TMT Kerja
                                        </label>
                                        <input type="date" name="tmt_kerja"
                                            value="{{ old('tmt_kerja', $tendik->tmt_kerja ? $tendik->tmt_kerja->format('Y-m-d') : '') }}"
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
                                        <input type="text" name="nip" value="{{ old('nip', $tendik->nip) }}"
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
                                        <input type="text" name="no_hp"
                                            value="{{ old('no_hp', $tendik->no_hp) }}"
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
                                        <input type="email" name="email"
                                            value="{{ old('email', $tendik->email) }}"
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
                                        <input type="text" name="alamat"
                                            value="{{ old('alamat', $tendik->alamat) }}"
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
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'SMA/Sederajat' ? 'selected' : '' }}>
                                            SMA/Sederajat</option>
                                        <option value="D1"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'D1' ? 'selected' : '' }}>
                                            D1</option>
                                        <option value="D2"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'D2' ? 'selected' : '' }}>
                                            D2</option>
                                        <option value="D3"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>
                                            D3</option>
                                        <option value="D4"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'D4' ? 'selected' : '' }}>
                                            D4</option>
                                        <option value="S1"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>
                                            S1</option>
                                        <option value="S2"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>
                                            S2</option>
                                        <option value="S3"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>
                                            S3</option>
                                        <option value="Profesi"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'Profesi' ? 'selected' : '' }}>
                                            Profesi
                                        </option>
                                        <option value="Spesialis"
                                            {{ old('pendidikan_terakhir', $tendik->pendidikan_terakhir) == 'Spesialis' ? 'selected' : '' }}>
                                            Spesialis
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
                                        placeholder="Tambahkan keterangan tambahan tentang tenaga pendidik...">{{ old('keterangan', $tendik->keterangan) }}</textarea>
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
                                            • Upload file baru untuk mengganti yang lama
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @php
                                    $berkasFields = [
                                        'file_ktp' => 'KTP',
                                        'file_kk' => 'Kartu Keluarga (KK)',
                                        'file_ijazah_s1' => 'Ijazah S1',
                                        'file_transkrip_s1' => 'Transkrip Nilai S1',
                                        'file_ijazah_s2' => 'Ijazah S2',
                                        'file_transkrip_s2' => 'Transkrip Nilai S2',
                                        'file_ijazah_s3' => 'Ijazah S3',
                                        'file_transkrip_s3' => 'Transkrip Nilai S3',
                                        'file_perjanjian_kerja' => 'Perjanjian Kerja',
                                        'file_sk' => 'Surat Keputusan (SK)',
                                        'file_surat_tugas' => 'Surat Tugas',
                                    ];
                                @endphp

                                @foreach ($berkasFields as $field => $label)
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                                        @if ($tendik->$field)
                                            <div class="mb-2">
                                                <a href="{{ asset('dokumen_tendik/' . $tendik->$field) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:underline text-sm inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat file saat ini
                                                </a>
                                                <p class="text-gray-500 text-xs mt-1">
                                                    Upload file baru untuk mengganti.
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-gray-500 italic text-sm mb-2">Belum ada file.</p>
                                        @endif
                                        <input type="file" name="{{ $field }}"
                                            class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                @endforeach
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
                                @if ($tendik->file)
                                    <div class="mb-2">
                                        <a href="{{ asset('dokumen_tendik/' . $tendik->file) }}" target="_blank"
                                            class="text-blue-600 hover:underline text-sm inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ $tendik->file }}
                                        </a>
                                        <p class="text-gray-500 text-xs mt-1">
                                            Upload file baru untuk mengganti yang lama.
                                        </p>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic text-sm mb-2">Belum ada file.</p>
                                @endif
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
                                            class="ml-2 font-medium">{{ $tendik->updated_at->format('d/m/Y H:i') }}</span>
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
                                class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn-primary flex items-center justify-center order-1 sm:order-2 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Update Tenaga Pendidik
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
            // Function untuk validasi file
            function validateFile(input, showSuccess = false) {
                const file = input.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024))
                                .toFixed(2) + 'MB',
                            confirmButtonColor: '#3b82f6'
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
                            text: 'Hanya file PDF, DOC, DOCX, JPG, dan PNG yang diizinkan.',
                            confirmButtonColor: '#3b82f6'
                        });
                        input.value = '';
                        return false;
                    }

                    // Show success message jika diminta
                    if (showSuccess) {
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



            // Form validation
            const form = document.getElementById('tendikForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const namaTendik = document.querySelector('input[name="nama_tendik"]');

                    if (!namaTendik || !namaTendik.value.trim()) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Belum Lengkap',
                            text: 'Nama Tenaga Pendidik wajib diisi!',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }

                    // Validasi semua file inputs sebelum submit
                    let allFilesValid = true;
                    fileInputs.forEach(input => {
                        if (input.files.length > 0) {
                            if (!validateFile(input, false)) {
                                allFilesValid = false;
                            }
                        }
                    });

                    if (!allFilesValid) {
                        e.preventDefault();
                        return;
                    }

                    // Konfirmasi update
                    e.preventDefault();
                    Swal.fire({
                        title: 'Update Data?',
                        html: `Apakah Anda yakin ingin mengupdate data <strong>${namaTendik.value}</strong>?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Update!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
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

            // NOTIFIKASI ERROR VALIDATION
            @if ($errors->any())
                @if (!session('success'))
                    let errorMessage = '';
                    @foreach ($errors->all() as $error)
                        errorMessage += `• {{ $error }}\n`;
                    @endforeach

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: errorMessage,
                        confirmButtonColor: '#3b82f6'
                    });
                @endif
            @endif
        });
    </script>
</x-app-layout>
