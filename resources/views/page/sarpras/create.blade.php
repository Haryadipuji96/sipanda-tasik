{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Sarpras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Main Content -->
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Tambah Data Sarpras</h1>
                        </div>
                        <a href="{{ route('sarpras.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1 self-start sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>

                    <form action="{{ route('sarpras.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- LEVEL 1: Data Ruangan -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">🏢 Data Ruangan</h3>

                            <!-- Pilihan: Ruangan Existing atau Baru -->
                            <div class="mb-6">
                                <label class="block font-medium mb-3 text-sm sm:text-base">Pilih Sumber Ruangan</label>
                                <div class="flex space-x-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="ruangan_source" value="existing" checked
                                            class="ruangan-source" onchange="toggleRuanganSource()">
                                        <span class="ml-2">Pilih Ruangan Existing</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="ruangan_source" value="new"
                                            class="ruangan-source" onchange="toggleRuanganSource()">
                                        <span class="ml-2">Buat Ruangan Baru</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Container untuk Ruangan Existing -->
                            <div id="existing-ruangan-container">
                                <div class="mb-4">
                                    <label class="block font-medium mb-1 text-sm sm:text-base">
                                        Pilih Ruangan Existing <span class="text-red-500">*</span>
                                    </label>
                                    <select name="id_ruangan" id="id_ruangan"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                        <option value="">-- Pilih Ruangan --</option>

                                        <!-- Group Ruangan Akademik -->
                                        <optgroup label="🏫 Ruangan Akademik">
                                            @foreach ($ruanganAkademik as $ruangan)
                                                <option value="{{ $ruangan->id }}"
                                                    data-nama="{{ $ruangan->nama_ruangan }}"
                                                    data-kategori="{{ $ruangan->kategori_ruangan }}"
                                                    data-prodi="{{ $ruangan->id_prodi }}">
                                                    {{ $ruangan->nama_ruangan }}
                                                    @if ($ruangan->prodi && $ruangan->prodi->fakultas)
                                                        - {{ $ruangan->prodi->nama_prodi }}
                                                        ({{ $ruangan->prodi->fakultas->nama_fakultas }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        <!-- Group Ruangan Umum -->
                                        <optgroup label="🏢 Ruangan Umum">
                                            @foreach ($ruanganUmum as $ruangan)
                                                <option value="{{ $ruangan->id }}"
                                                    data-nama="{{ $ruangan->nama_ruangan }}"
                                                    data-kategori="{{ $ruangan->kategori_ruangan }}" data-prodi="">
                                                    {{ $ruangan->nama_ruangan }} - Unit Umum
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <small class="text-gray-500">Pilih ruangan yang sudah ada dari daftar</small>
                                </div>
                            </div>

                            <!-- Container untuk Ruangan Baru -->
                            <div id="new-ruangan-container" class="hidden">
                                <div class="border-t my-4 pt-4">
                                    <h4 class="font-medium text-gray-700 mb-3">Tambah Ruangan Baru</h4>

                                    <!-- Fakultas untuk ruangan baru -->
                                    <div class="mb-4">
                                        <label class="block font-medium mb-1 text-sm sm:text-base">Fakultas</label>
                                        <select name="id_fakultas_new" id="id_fakultas_new"
                                            class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                                            <option value="">-- Pilih Fakultas --</option>
                                            @foreach ($fakultas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_fakultas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Prodi untuk ruangan baru -->
                                    <div class="mb-4">
                                        <label class="block font-medium mb-1 text-sm sm:text-base">Prodi</label>
                                        <select name="id_prodi_new" id="id_prodi_new"
                                            class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                                            <option value="">-- Pilih Prodi --</option>
                                            @foreach ($prodi as $item)
                                                <option value="{{ $item->id }}"
                                                    data-fakultas="{{ $item->id_fakultas }}">
                                                    {{ $item->nama_prodi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Nama Ruangan Baru -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block font-medium mb-1 text-sm sm:text-base">Nama Ruangan Baru
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="nama_ruangan_new" id="nama_ruangan_new"
                                                class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                                placeholder="Masukkan nama ruangan baru">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LEVEL 2: Barang dalam Ruangan -->
                        <div class="mb-6 p-4 bg-green-50 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-4">📦 Data Barang dalam Ruangan</h3>

                            Nama Barang
                            <div class="mb-4">
                                <label class="block font-medium mb-1 text-sm sm:text-base">Nama Barang <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama_barang"
                                    class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                    placeholder="Masukkan nama barang">
                            </div>

                            {{-- Harga Barang --}}
                            {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Harga Barang
                                        (Rp)</label>
                                    <input type="number" name="harga"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" min="0"
                                        step="0.01" placeholder="0">
                                </div>
                            </div> --}}

                            {{-- Merk & Kategori Barang --}}
                            {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Merk Barang</label>
                                    <input type="text" name="merk_barang"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                        placeholder="Masukkan merk barang">
                                </div>
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Kategori Barang <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="kategori_barang"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                        placeholder="Contoh: Elektronik, Furniture">
                                </div>
                            </div> --}}

                            {{-- Jumlah & Satuan --}}
                            {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Jumlah Barang <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="jumlah"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" min="1"
                                        required placeholder="0">
                                </div>
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Satuan <span
                                            class="text-red-500">*</span></label>
                                    <select name="satuan"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                        <option value="unit">Unit</option>
                                        <option value="buah">Buah</option>
                                        <option value="set">Set</option>
                                        <option value="lusin">Lusin</option>
                                        <option value="paket">Paket</option>
                                    </select>
                                </div>
                            </div> --}}

                            {{-- Kondisi & Tanggal Pengadaan --}}
                            {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Kondisi <span
                                            class="text-red-500">*</span></label>
                                    <select name="kondisi"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                        <option value="">-- Pilih Kondisi Barang --</option>
                                        <option value="Baik Sekali">Baik Sekali</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Cukup">Cukup</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Tanggal Pengadaan <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_pengadaan"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                </div>
                            </div> --}}

                            {{-- Spesifikasi --}}
                            {{-- <div class="mb-4">
                                <label class="block font-medium mb-1 text-sm sm:text-base">Spesifikasi Barang <span
                                        class="text-red-500">*</span></label>
                                <textarea name="spesifikasi" rows="3" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                    placeholder="Masukkan spesifikasi barang"></textarea>
                            </div> --}}

                            {{-- Kode Seri & Sumber --}}
                            {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Kode / Seri Barang <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="kode_seri"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                        placeholder="Masukkan kode/seri barang">
                                </div>
                                <div>
                                    <label class="block font-medium mb-1 text-sm sm:text-base">Sumber Barang <span
                                            class="text-red-500">*</span></label>
                                    <select name="sumber"
                                        class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                        <option value="">-- Pilih Sumber --</option>
                                        <option value="HIBAH">HIBAH</option>
                                        <option value="LEMBAGA">LEMBAGA</option>
                                        <option value="YAYASAN">YAYASAN</option>
                                    </select>
                                </div>
                            </div> --}}

                            {{-- Lokasi Lain --}}
                            {{-- <div class="mb-4">
                                <label class="block font-medium mb-1 text-sm sm:text-base">Lokasi Lain
                                    (Opsional)</label>
                                <input type="text" name="lokasi_lain"
                                    class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                    placeholder="Misal: Gedung C Lantai 2">
                            </div> --}}

                            {{-- Upload File Dokumen --}}
                            {{-- <div class="mb-4">
                                <label for="file_dokumen" class="block font-medium mb-1 text-sm sm:text-base">
                                    Upload File Dokumen
                                </label>
                                <div class="flex flex-col w-full">
                                    <input type="file" name="file_dokumen" id="file_dokumen"
                                        class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.doc,.docx,.jpg,.png" />
                                    <p class="text-gray-500 text-xs mt-1">
                                        Format diizinkan: <b>PDF, DOC, DOCX, JPG, PNG</b> | Maksimal <b>5MB</b>
                                    </p>
                                </div>
                                @error('file_dokumen')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            {{-- Keterangan --}}
                            {{-- <div class="mb-6">
                                <label class="block font-medium mb-1 text-sm sm:text-base">Keterangan
                                    (Opsional)</label>
                                <textarea name="keterangan" rows="2" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                    placeholder="Tambahkan keterangan tambahan..."></textarea>
                            </div>
                        </div> --}}

                        {{-- Tombol --}}
                        {{-- <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route('sarpras.index') }}"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-center transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <script>
        // Toggle between existing and new ruangan
        function toggleRuanganSource() {
            const existingContainer = document.getElementById('existing-ruangan-container');
            const newContainer = document.getElementById('new-ruangan-container');
            const ruanganSource = document.querySelector('input[name="ruangan_source"]:checked').value;

            if (ruanganSource === 'existing') {
                existingContainer.classList.remove('hidden');
                newContainer.classList.add('hidden');
                // Set required attribute
                document.getElementById('id_ruangan').required = true;
                document.getElementById('nama_ruangan_new').required = false;
                document.querySelector('select[name="kategori_ruangan_new"]').required = false;
            } else {
                existingContainer.classList.add('hidden');
                newContainer.classList.remove('hidden');
                // Set required attribute
                document.getElementById('id_ruangan').required = false;
                document.getElementById('nama_ruangan_new').required = true;
                document.querySelector('select[name="kategori_ruangan_new"]').required = true;
            }
        }

        // Filter prodi berdasarkan fakultas untuk ruangan baru
        document.addEventListener('DOMContentLoaded', function() {
            const fakultasSelect = document.getElementById('id_fakultas_new');
            const prodiSelect = document.getElementById('id_prodi_new');

            if (fakultasSelect && prodiSelect) {
                fakultasSelect.addEventListener('change', function() {
                    const selectedFakultas = this.value;
                    const options = prodiSelect.getElementsByTagName('option');

                    // Reset dan tampilkan semua option terlebih dahulu
                    for (let i = 0; i < options.length; i++) {
                        options[i].style.display = '';
                    }

                    // Sembunyikan option yang tidak sesuai dengan fakultas terpilih
                    if (selectedFakultas) {
                        for (let i = 0; i < options.length; i++) {
                            const optionFakultas = options[i].getAttribute('data-fakultas');
                            if (optionFakultas && optionFakultas !== selectedFakultas) {
                                options[i].style.display = 'none';
                            }
                        }
                    }

                    // Reset prodi selection
                    prodiSelect.value = '';
                });
            }
        }); --}}

        {{-- // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const ruanganSource = document.querySelector('input[name="ruangan_source"]:checked').value;

            if (ruanganSource === 'existing') {
                const selectedRuangan = document.getElementById('id_ruangan').value;
                if (!selectedRuangan) {
                    e.preventDefault();
                    alert('Silakan pilih ruangan existing terlebih dahulu');
                    return false;
                }
            } else {
                const namaRuanganNew = document.getElementById('nama_ruangan_new').value;
                const kategoriRuanganNew = document.querySelector('select[name="kategori_ruangan_new"]').value;

                if (!namaRuanganNew || !kategoriRuanganNew) {
                    e.preventDefault();
                    alert('Silakan lengkapi data ruangan baru');
                    return false;
                }
            }
        });
    </script>
</body>

</html> --}} 
