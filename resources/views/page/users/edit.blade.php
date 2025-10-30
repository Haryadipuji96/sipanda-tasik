<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Edit Pengguna</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staf" {{ $user->role == 'staf' ? 'selected' : '' }}>Staf</option>
                    <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="dosen" {{ $user->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                </select>
            </div>

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Password Baru (opsional)</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
