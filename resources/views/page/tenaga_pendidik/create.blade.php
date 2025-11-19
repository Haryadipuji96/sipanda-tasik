<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tenaga Pendidik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header/Navbar -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    {{-- Header content --}}
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> <!-- UBAH MAX-WIDTH MENJADI 4xl -->
                <div class="bg-white shadow-xl rounded-2xl p-4 sm:p-6 md:p-8 w-full border border-gray-100">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-4 border-b">
                        <div class="flex items-center space-x-3 mb-3 sm:mb-0">
                            <div class="bg-green-100 text-blue-600 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Tambah Tenaga Pendidik</h1>
                        </div>
                        <a href="{{ route('tenaga-pendidik.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1 self-start sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tenaga-pendidik.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4" x-data="{ golongan: [{ tahun: '', golongan: '' }] }">
                        @csrf

                        <!-- Program Studi & Jabatan Struktural -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Program Studi</label>
                                <select name="id_prodi" class="border p-2 rounded w-full text-sm sm:text-base">
                                    <option value="">-- Pilih Prodi (Opsional) --</option>
                                    @foreach ($prodi as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('id_prodi') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_prodi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Posisi/Jabatan
                                    Struktural</label>
                                <select name="jabatan_struktural"
                                    class="border p-2 rounded w-full text-sm sm:text-base">
                                    <option value="">-- Pilih Posisi --</option>
                                    @foreach ($jabatanOptions as $jabatan)
                                        <option value="{{ $jabatan }}"
                                            {{ old('jabatan_struktural') == $jabatan ? 'selected' : '' }}>
                                            {{ $jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Nama & Gelar -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Gelar Depan</label>
                                <input type="text" name="gelar_depan" value="{{ old('gelar_depan') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base" placeholder="Contoh: Dr.">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Nama Tenaga Pendidik</label>
                                <input type="text" name="nama_tendik" value="{{ old('nama_tendik') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Gelar Belakang</label>
                                <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base" placeholder="Contoh: S.Pd">
                            </div>
                        </div>

                        <!-- Status Kepegawaian & Jenis Kelamin -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Status Kepegawaian</label>
                                <select name="status_kepegawaian"
                                    class="border p-2 rounded w-full text-sm sm:text-base">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="PNS" {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS
                                    </option>
                                    <option value="Non PNS Tetap"
                                        {{ old('status_kepegawaian') == 'Non PNS Tetap' ? 'selected' : '' }}>Non PNS Tetap
                                    </option>
                                    <option value="Non PNS Tidak Tetap"
                                        {{ old('status_kepegawaian') == 'Non PNS Tidak Tetap' ? 'selected' : '' }}>Non PNS
                                        Tidak Tetap</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="border p-2 rounded w-full text-sm sm:text-base">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tempat, Tanggal Lahir & TMT Kerja -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base" placeholder="Tempat lahir">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">TMT Kerja</label>
                                <input type="date" name="tmt_kerja" value="{{ old('tmt_kerja') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base">
                            </div>
                        </div>

                        <!-- Riwayat Golongan -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block font-medium text-sm sm:text-base">Riwayat Golongan</label>
                                <button type="button" @click="golongan.push({ tahun: '', golongan: '' })"
                                    class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition">
                                    + Tambah Riwayat
                                </button>
                            </div>
                            <template x-for="(item, index) in golongan" :key="index">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <input type="text" :name="'golongan[' + index + '][tahun]'"
                                            x-model="item.tahun"
                                            class="border p-2 rounded w-full text-sm sm:text-base"
                                            placeholder="Tahun">
                                    </div>
                                    <div class="flex space-x-2">
                                        <input type="text" :name="'golongan[' + index + '][golongan]'"
                                            x-model="item.golongan"
                                            class="border p-2 rounded w-full text-sm sm:text-base"
                                            placeholder="Golongan">
                                        <button type="button" @click="golongan.splice(index,1)"
                                            class="bg-red-500 text-white px-2 rounded hover:bg-red-600 transition"
                                            x-show="golongan.length > 1">×</button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- NIP, No HP, Email, Alamat, Keterangan -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">NIP</label>
                                <input type="text" name="nip" value="{{ old('nip') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base" placeholder="NIP">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">No HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base" placeholder="08xxxx">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base"
                                    placeholder="email@example.com">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base"
                                    placeholder="Alamat lengkap">
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="border p-2 rounded w-full text-sm sm:text-base">
                                <option value="">-- Pilih Pendidikan Terakhir --</option>
                                <option value="SMA/Sederajat"
                                    {{ old('pendidikan_terakhir') == 'SMA/Sederajat' ? 'selected' : '' }}>SMA/Sederajat
                                </option>
                                <option value="D1" {{ old('pendidikan_terakhir') == 'D1' ? 'selected' : '' }}>D1
                                </option>
                                <option value="D2" {{ old('pendidikan_terakhir') == 'D2' ? 'selected' : '' }}>D2
                                </option>
                                <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3
                                </option>
                                <option value="D4" {{ old('pendidikan_terakhir') == 'D4' ? 'selected' : '' }}>D4
                                </option>
                                <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1
                                </option>
                                <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2
                                </option>
                                <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3
                                </option>
                                <option value="Profesi"
                                    {{ old('pendidikan_terakhir') == 'Profesi' ? 'selected' : '' }}>Profesi</option>
                                <option value="Spesialis"
                                    {{ old('pendidikan_terakhir') == 'Spesialis' ? 'selected' : '' }}>Spesialis
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Keterangan</label>
                            <textarea name="keterangan" class="border p-2 rounded w-full text-sm sm:text-base" rows="2"
                                placeholder="Tambahkan keterangan">{{ old('keterangan') }}</textarea>
                        </div>

                        <!-- UPLOAD BERKAS BARU -->
                        <div class="border-t pt-6 mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">📎 Upload Berkas</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- KTP -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">KTP</label>
                                    <input type="file" name="file_ktp"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- KK -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Kartu Keluarga (KK)</label>
                                    <input type="file" name="file_kk"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Ijazah S1 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Ijazah S1</label>
                                    <input type="file" name="file_ijazah_s1"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Transkrip S1 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Transkrip Nilai S1</label>
                                    <input type="file" name="file_transkrip_s1"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Ijazah S2 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Ijazah S2</label>
                                    <input type="file" name="file_ijazah_s2"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Transkrip S2 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Transkrip Nilai S2</label>
                                    <input type="file" name="file_transkrip_s2"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Ijazah S3 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Ijazah S3</label>
                                    <input type="file" name="file_ijazah_s3"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Transkrip S3 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Transkrip Nilai S3</label>
                                    <input type="file" name="file_transkrip_s3"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Perjanjian Kerja -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Perjanjian Kerja</label>
                                    <input type="file" name="file_perjanjian_kerja"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- SK -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Surat Keputusan (SK)</label>
                                    <input type="file" name="file_sk"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>

                                <!-- Surat Tugas -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm">Surat Tugas</label>
                                    <input type="file" name="file_surat_tugas"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.jpg,.png">
                                </div>
                            </div>
                            <p class="text-gray-500 text-xs mt-3">Format: <b>PDF, JPG, PNG</b> | Maksimal <b>2MB</b>
                                per file</p>
                        </div>

                        <!-- Upload File Utama (Lama) -->
                        <div class="mb-4 border-t pt-6">
                            <label for="file" class="block font-medium mb-1 text-sm sm:text-base">Upload File
                                Dokumen Lainnya</label>
                            <div class="flex flex-col w-full">
                                <input type="file" name="file" id="file"
                                    class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                    accept=".pdf,.doc,.docx,.jpg,.png" />
                                <p class="text-gray-500 text-xs mt-1">Format: <b>PDF, DOC, DOCX, JPG, PNG</b> | Max 2MB
                                </p>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 pt-4">
                            <a href="{{ route('tenaga-pendidik.index') }}"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-center transition">Batal</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
