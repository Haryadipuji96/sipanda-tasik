<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Tambah Pengguna</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2" required>
                    <option value="admin">Admin</option>
                    <option value="staf">Staf</option>
                    <option value="operator">Operator</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Password</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
