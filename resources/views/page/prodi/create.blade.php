<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Tambah Program Studi</h1>

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
                <input type="text" name="jenjang" class="w-full border rounded px-3 py-2" placeholder="S1, S2, D3, dll">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('prodi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
