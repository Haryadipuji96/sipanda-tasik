<x-app-layout>
    <x-slot name="title">Tambah Data Dosen</x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Tambah Data Dosen</h1>
                    </div>
                    <a href="{{ route('dosen.index') }}"
                        class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1 self-start sm:self-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>

                <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data"
                    x-data="formDosen()">
                    @csrf

                    <!-- Program Studi -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-sm sm:text-base">Program Studi <span
                                class="text-red-500">*</span></label>
                        <select name="id_prodi" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gelar Depan & Belakang -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Gelar Depan</label>
                            <input type="text" name="gelar_depan"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" placeholder="Dr.">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                        </div>
                    </div>

                    <!-- Gelar Belakang -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-sm sm:text-base">Gelar Belakang</label>
                        <input type="text" name="gelar_belakang"
                            class="w-full border rounded px-3 py-2 text-sm sm:text-base" placeholder="M.Pd., M.Kom.">
                    </div>

                    <!-- Tempat & Tanggal Lahir -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                        </div>
                    </div>

                    <!-- NIK/NIDN & NUPTK -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">NIDN</label>
                            <input type="text" name="nik"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">NUPTK</label>
                            <input type="text" name="nuptk"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                        </div>
                    </div>

                    <!-- Pendidikan Terakhir (Dropdown dengan input lainnya) -->
                    <div class="mb-4" x-data="{ pendidikanLainnya: '{{ $dosen->pendidikan_terakhir ?? '' }}' }">
                        <label class="block font-medium mb-1 text-sm sm:text-base">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" x-model="pendidikanLainnya"
                            class="w-full border rounded px-3 py-2 text-sm sm:text-base mb-2">
                            <option value="">-- Pilih Pendidikan Terakhir --</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                            <option value="Dr">Dr</option>
                            <option value="Prof">Prof</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>

                        <!-- Input untuk pilihan lainnya -->
                        <div x-show="pendidikanLainnya === 'Lainnya'" x-transition>
                            <input type="text" name="pendidikan_lainnya"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                placeholder="Masukkan pendidikan lainnya">
                        </div>
                    </div>

                    <!-- PENDIDIKAN (Dynamic Input) -->
                    <div class="mb-6 border-t pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block font-medium text-sm sm:text-base">Riwayat Pendidikan</label>
                            <button type="button" @click="addPendidikan()"
                                class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                + Tambah Pendidikan
                            </button>
                        </div>

                        <template x-for="(item, index) in pendidikan" :key="index">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3 p-3 bg-gray-50 rounded border">
                                <div>
                                    <label class="text-xs text-gray-600">Jenjang</label>
                                    <select :name="'pendidikan[' + index + '][jenjang]'" x-model="item.jenjang"
                                        class="w-full border rounded px-2 py-1 text-sm">
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
                                        x-model="item.prodi" class="w-full border rounded px-2 py-1 text-sm"
                                        placeholder="PAI">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Tahun Lulus</label>
                                    <input type="text" :name="'pendidikan[' + index + '][tahun_lulus]'"
                                        x-model="item.tahun_lulus" class="w-full border rounded px-2 py-1 text-sm"
                                        placeholder="2015">
                                </div>
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <label class="text-xs text-gray-600">Universitas/PT</label>
                                        <input type="text" :name="'pendidikan[' + index + '][universitas]'"
                                            x-model="item.universitas" class="w-full border rounded px-2 py-1 text-sm"
                                            placeholder="STAI Tasikmalaya">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" @click="removePendidikan(index)"
                                            class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Jabatan -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-sm sm:text-base">Jabatan</label>
                        <input type="text" name="jabatan"
                            class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                    </div>

                    <!-- TMT Kerja -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-sm sm:text-base">TMT Kerja</label>
                        <input type="date" name="tmt_kerja"
                            class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                    </div>

                    <!-- Masa Kerja -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Masa Kerja (Tahun)</label>
                            <input type="number" name="masa_kerja_tahun"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" min="0">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Masa Kerja (Bulan)</label>
                            <input type="number" name="masa_kerja_bulan"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" min="0"
                                max="11">
                        </div>
                    </div>

                    <!-- Pangkat/Golongan & Jabatan Fungsional -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Pangkat/Golongan</label>
                            <input type="text" name="pangkat_golongan"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" placeholder="III/b">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Jabatan Fungsional</label>
                            <input type="text" name="jabatan_fungsional"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" placeholder="Lektor">
                        </div>
                    </div>

                    <!-- Masa Kerja Golongan -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Masa Kerja Golongan
                                (Tahun)</label>
                            <input type="number" name="masa_kerja_golongan_tahun"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" min="0">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Masa Kerja Golongan
                                (Bulan)</label>
                            <input type="number" name="masa_kerja_golongan_bulan"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" min="0"
                                max="11">
                        </div>
                    </div>

                    <!-- No SK & JaFung -->
                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">No SK</label>
                            <input type="text" name="no_sk"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                placeholder="123/SK/2024">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">JaFung</label>
                            <input type="text" name="no_sk_jafung"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" placeholder="Lektor">
                        </div>
                    </div>

                    <!-- Sertifikasi & Inpasing -->
                    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Sertifikasi <span
                                    class="text-red-500">*</span></label>
                            <select name="sertifikasi" x-model="sertifikasi"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                <option value="BELUM">BELUM</option>
                                <option value="SUDAH">SUDAH</option>
                            </select>

                            <!-- Upload Sertifikasi (muncul jika SUDAH) -->
                            <div x-show="sertifikasi === 'SUDAH'" x-transition class="mt-2">
                                <label class="block font-medium mb-1 text-sm text-gray-700">Upload Sertifikasi</label>
                                <input type="file" name="file_sertifikasi"
                                    class="w-full border rounded px-3 py-2 text-sm">
                                <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-sm sm:text-base">Inpasing <span
                                    class="text-red-500">*</span></label>
                            <select name="inpasing" x-model="inpasing"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                <option value="BELUM">BELUM</option>
                                <option value="SUDAH">SUDAH</option>
                            </select>

                            <!-- Upload Inpasing (muncul jika SUDAH) -->
                            <div x-show="inpasing === 'SUDAH'" x-transition class="mt-2">
                                <label class="block font-medium mb-1 text-sm text-gray-700">Upload Inpasing</label>
                                <input type="file" name="file_inpasing"
                                    class="w-full border rounded px-3 py-2 text-sm">
                                <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- UPLOAD BERKAS DOSEN -->
                    <div class="mb-6 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Berkas Dosen</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Kolom 1 -->
                            <div class="space-y-4">
                                <!-- KTP -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload KTP</label>
                                    <input type="file" name="file_ktp"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Ijazah S1 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Ijazah
                                        S1</label>
                                    <input type="file" name="file_ijazah_s1"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Transkrip S1 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Transkrip
                                        S1</label>
                                    <input type="file" name="file_transkrip_s1"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Ijazah S2 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Ijazah
                                        S2</label>
                                    <input type="file" name="file_ijazah_s2"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Transkrip S2 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Transkrip
                                        S2</label>
                                    <input type="file" name="file_transkrip_s2"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Ijazah S3 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Ijazah
                                        S3</label>
                                    <input type="file" name="file_ijazah_s3"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>
                            </div>

                            <!-- Kolom 2 -->
                            <div class="space-y-4">
                                <!-- Transkrip S3 -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Transkrip
                                        S3</label>
                                    <input type="file" name="file_transkrip_s3"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Jafung -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Jafung</label>
                                    <input type="file" name="file_jafung"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- KK -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload KK</label>
                                    <input type="file" name="file_kk"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Perjanjian Kerja -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Perjanjian
                                        Kerja</label>
                                    <input type="file" name="file_perjanjian_kerja"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- SK Pengangkatan -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload SK
                                        Pengangkatan</label>
                                    <input type="file" name="file_sk_pengangkatan"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>

                                <!-- Surat Pernyataan -->
                                <div>
                                    <label class="block font-medium mb-1 text-sm text-gray-700">Upload Surat
                                        Pernyataan</label>
                                    <input type="file" name="file_surat_pernyataan"
                                        class="w-full border rounded px-3 py-2 text-sm">
                                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <!-- SKTP -->
                            <div>
                                <label class="block font-medium mb-1 text-sm text-gray-700">Upload SKTP</label>
                                <input type="file" name="file_sktp"
                                    class="w-full border rounded px-3 py-2 text-sm">
                                <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                            </div>

                            <!-- Surat Tugas -->
                            <div>
                                <label class="block font-medium mb-1 text-sm text-gray-700">Upload Surat Tugas</label>
                                <input type="file" name="file_surat_tugas"
                                    class="w-full border rounded px-3 py-2 text-sm">
                                <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                            </div>

                            <!-- SK Aktif -->
                            <div>
                                <label class="block font-medium mb-1 text-sm text-gray-700">Upload SK Aktif
                                    Tridharma</label>
                                <input type="file" name="file_sk_aktif"
                                    class="w-full border rounded px-3 py-2 text-sm">
                                <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG | Maks: 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                        <a href="{{ route('dosen.index') }}"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-center transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</x-app-layout>
