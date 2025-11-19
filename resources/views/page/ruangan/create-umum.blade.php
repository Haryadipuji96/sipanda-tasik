<x-app-layout>
    <x-slot name="title">Tambah Ruangan Umum</x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3">
                        <div class="bg-green-100 text-green-600 p-2 rounded-full">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">Tambah Ruangan Umum</h1>
                            <p class="text-gray-600 text-sm">Isi form berikut untuk menambah data ruangan umum</p>
                        </div>
                    </div>
                    <a href="{{ route('ruangan.create') }}"
                        class="text-gray-600 hover:text-gray-800 transition flex items-center space-x-1">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('ruangan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe_ruangan" value="umum">

                    <!-- Unit Umum -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2 text-gray-700">
                            Unit Umum <span class="text-red-500">*</span>
                        </label>
                        <select name="unit_umum" id="unit_umum"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <option value="">-- Pilih Unit --</option>
                            <option value="Gedung Rektorat"
                                {{ old('unit_umum') == 'Gedung Rektorat' ? 'selected' : '' }}>Gedung Rektorat
                            </option>
                            <option value="Gedung Pascasarjana"
                                {{ old('unit_umum') == 'Gedung Pascasarjana' ? 'selected' : '' }}>Gedung
                                Pascasarjana</option>
                            <option value="Gedung Tarbiyah"
                                {{ old('unit_umum') == 'Gedung Tarbiyah' ? 'selected' : '' }}>Gedung Tarbiyah
                            </option>
                            <option value="Gedung Yayasan"
                                {{ old('unit_umum') == 'Gedung Yayasan' ? 'selected' : '' }}>Gedung Yayasan
                            </option>
                            <option value="Lainnya" {{ old('unit_umum') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                        @error('unit_umum')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input untuk Lainnya -->
                    <div id="unit_lainnya_container" class="mb-4 hidden">
                        <label class="block font-medium mb-2 text-gray-700">
                            Nama Unit Lainnya <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="unit_lainnya" id="unit_lainnya"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            value="{{ old('unit_lainnya') }}"
                            placeholder="Masukkan nama unit lainnya">
                        @error('unit_lainnya')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Ruangan -->
                    <div class="mb-6">
                        <label class="block font-medium mb-2 text-gray-700">
                            Nama Ruangan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan') }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Contoh: Ruang Baca Perpustakaan, Aula Utama, Ruang Rapat Rektorat" required>
                        @error('nama_ruangan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div
                        class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 pt-4 border-t">
                        <a href="{{ route('ruangan.create') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Ruangan Umum
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unitUmumSelect = document.getElementById('unit_umum');
            const lainnyaContainer = document.getElementById('unit_lainnya_container');

            // Tampilkan input lainnya ketika pilihan Lainnya dipilih
            unitUmumSelect.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    lainnyaContainer.classList.remove('hidden');
                } else {
                    lainnyaContainer.classList.add('hidden');
                }
            });

            // Trigger change on page load jika Lainnya sudah dipilih
            if (unitUmumSelect.value === 'Lainnya') {
                lainnyaContainer.classList.remove('hidden');
            }

            // Handle form submission untuk unit lainnya
            document.querySelector('form').addEventListener('submit', function(e) {
                const unitUmum = document.getElementById('unit_umum').value;
                const unitLainnya = document.getElementById('unit_lainnya').value;

                if (unitUmum === 'Lainnya' && !unitLainnya) {
                    e.preventDefault();
                    alert('Silakan isi nama unit lainnya');
                    return false;
                }
            });
        });
    </script>
</x-app-layout>