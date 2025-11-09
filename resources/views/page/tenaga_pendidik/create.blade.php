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
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <i class="fas fa-chalkboard-teacher text-blue-600 text-xl mr-2"></i>
                            <span class="font-semibold text-xl text-gray-800">Sistem Akademik</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-bell"></i>
                                </a>
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                        U
                                    </div>
                                    <span class="ml-2 text-gray-700 hidden sm:block">User</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="py-6">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
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

                        <!-- Program Studi -->
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Program Studi</label>
                            <select name="id_prodi" class="border p-2 rounded w-full text-sm sm:text-base">
                                <option value="">-- Pilih Prodi --</option>
                                @foreach ($prodi as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('id_prodi') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
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
                                <select name="status_kepegawaian" class="border p-2 rounded w-full text-sm sm:text-base">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="PNS" {{ old('status_kepegawaian')=='PNS' ? 'selected':'' }}>PNS</option>
                                    <option value="Honorer" {{ old('status_kepegawaian')=='Honorer' ? 'selected':'' }}>Honorer</option>
                                    <option value="Kontrak" {{ old('status_kepegawaian')=='Kontrak' ? 'selected':'' }}>Kontrak</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="border p-2 rounded w-full text-sm sm:text-base">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="laki-laki" {{ old('jenis_kelamin')=='laki-laki' ? 'selected':'' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin')=='perempuan' ? 'selected':'' }}>Perempuan</option>
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
                                        <input type="text" :name="'golongan['+index+'][tahun]'" x-model="item.tahun"
                                            class="border p-2 rounded w-full text-sm sm:text-base" placeholder="Tahun">
                                    </div>
                                    <div class="flex space-x-2">
                                        <input type="text" :name="'golongan['+index+'][golongan]'" x-model="item.golongan"
                                            class="border p-2 rounded w-full text-sm sm:text-base" placeholder="Golongan">
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
                                    class="border p-2 rounded w-full text-sm sm:text-base" placeholder="email@example.com">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat') }}"
                                    class="border p-2 rounded w-full text-sm sm:text-base" placeholder="Alamat lengkap">
                            </div>
                        </div>

                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Keterangan</label>
                            <textarea name="keterangan" class="border p-2 rounded w-full text-sm sm:text-base" rows="2"
                                placeholder="Tambahkan keterangan">{{ old('keterangan') }}</textarea>
                        </div>

                        <!-- Upload File -->
                        <div class="mb-4">
                            <label for="file" class="block font-medium mb-1 text-sm sm:text-base">Upload File Dokumen</label>
                            <div class="flex flex-col w-full">
                                <input type="file" name="file" id="file"
                                    class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                    accept=".pdf,.doc,.docx,.jpg,.png" />
                                <p class="text-gray-500 text-xs mt-1">Format: <b>PDF, DOC, DOCX, JPG, PNG</b> | Max 5MB</p>
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
