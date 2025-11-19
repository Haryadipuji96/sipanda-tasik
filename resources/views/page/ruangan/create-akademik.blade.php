<x-app-layout>
    <x-slot name="title">Tambah Ruangan Akademik</x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">Tambah Ruangan Akademik</h1>
                            <p class="text-gray-600 text-sm">Isi form berikut untuk menambah data ruangan akademik</p>
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
                    <input type="hidden" name="tipe_ruangan" value="akademik">

                    <!-- Fakultas -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2 text-gray-700">
                            Fakultas <span class="text-red-500">*</span>
                        </label>
                        <select name="id_fakultas" id="id_fakultas"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach ($fakultas as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_fakultas') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_fakultas }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_fakultas')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Program Studi -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2 text-gray-700">
                            Program Studi <span class="text-red-500">*</span>
                        </label>
                        <select name="id_prodi" id="id_prodi"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required disabled>
                            <option value="">-- Pilih Prodi --</option>
                        </select>
                        @error('id_prodi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Ruangan -->
                    <div class="mb-6">
                        <label class="block font-medium mb-2 text-gray-700">
                            Nama Ruangan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan') }}"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: Lab Komputer, Ruang Kelas 101, Ruang Dosen A" required>
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
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Ruangan Akademik
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // When fakultas changes
            $('#id_fakultas').change(function() {
                var idFakultas = $(this).val();

                if (idFakultas) {
                    $('#id_prodi').prop('disabled', false);
                    $('#id_prodi').html('<option value="">-- Loading... --</option>');

                    var url = '{{ route("get.prodi.by.fakultas", ":id") }}'.replace(':id', idFakultas);

                    $.get(url)
                        .done(function(data) {
                            $('#id_prodi').html('<option value="">-- Pilih Prodi --</option>');
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#id_prodi').append('<option value="' + value.id + '">' +
                                        value.nama_prodi + ' (' + (value.jenjang || '-') + ')' +
                                        '</option>');
                                });
                            } else {
                                $('#id_prodi').append('<option value="">-- Tidak ada prodi --</option>');
                            }
                        })
                        .fail(function(xhr) {
                            console.error('Error loading prodi:', xhr);
                            $('#id_prodi').html('<option value="">-- Error loading prodi --</option>');
                        });
                } else {
                    $('#id_prodi').prop('disabled', true);
                    $('#id_prodi').html('<option value="">-- Pilih Prodi --</option>');
                }
            });

            // Handle old input on page load
            @if (old('id_fakultas'))
                $('#id_fakultas').trigger('change');
                setTimeout(function() {
                    $('#id_prodi').val('{{ old('id_prodi') }}');
                }, 1000);
            @endif
        });
    </script>
</x-app-layout>