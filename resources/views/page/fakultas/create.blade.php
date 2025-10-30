<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Tambah Fakultas</h1>

        <form action="{{ route('fakultas.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Fakultas</label>
                <input type="text" name="nama_fakultas" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Dekan</label>
                <input type="text" name="dekan" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('fakultas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
