<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-3xl border border-gray-100">
             <!-- Header -->
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 text-blue-600 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-semibold text-gray-800">Tambah Prodi</h1>
                </div>
                <a href="{{ route('prodi.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
            <form action="{{ route('prodi.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium mb-1">Fakultas</label>
                    <select name="id_fakultas" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach ($fakultas as $f)
                            <option value="{{ $f->id_fakultas }}">{{ $f->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Program Studi</label>
                    <input type="text" name="nama_prodi" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Jenjang</label>
                    <input type="text" name="jenjang" class="w-full border rounded px-3 py-2"
                        placeholder="S1, S2, D3, dll">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('prodi.index') }}" class="bg-red-500 text-white px-4 py-2 rounded">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
