<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Edit Program Studi</h1>

        <form action="{{ route('prodi.update', $prodi->id_prodi) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Fakultas</label>
                <select name="id_fakultas" class="w-full border rounded px-3 py-2" required>
                    @foreach ($fakultas as $f)
                        <option value="{{ $f->id_fakultas }}" {{ $prodi->id_fakultas == $f->id_fakultas ? 'selected' : '' }}>
                            {{ $f->nama_fakultas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Program Studi</label>
                <input type="text" name="nama_prodi" value="{{ $prodi->nama_prodi }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Jenjang</label>
                <input type="text" name="jenjang" value="{{ $prodi->jenjang }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2">{{ $prodi->deskripsi }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('prodi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
