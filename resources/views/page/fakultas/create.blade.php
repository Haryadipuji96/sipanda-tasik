<x-app-layout>
    <div class="py-10 px-6 flex justify-center">
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
                    <h1 class="text-2xl font-semibold text-gray-800">Tambah Fakultas</h1>
                </div>
                <a href="{{ route('fakultas.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Form -->
            <form action="{{ route('fakultas.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Nama Fakultas</label>
                    <input type="text" name="nama_fakultas"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                           placeholder="Masukkan nama fakultas..." required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Dekan</label>
                    <input type="text" name="dekan"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                           placeholder="Masukkan nama dekan...">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                              placeholder="Masukkan deskripsi fakultas..."></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end pt-4 space-x-3">
                    <a href="{{ route('fakultas.index') }}"
                       class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg shadow transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
