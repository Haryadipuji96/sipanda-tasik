<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header/Navbar -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <i class="fas fa-users text-blue-600 text-xl mr-2"></i>
                            <span class="font-semibold text-xl text-gray-800">Manajemen Pengguna</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-bell"></i>
                                </a>
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                        U
                                    </div>
                                    <span class="ml-2 text-gray-700 hidden sm:block">Admin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="py-6">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-2xl p-4 sm:p-6 md:p-8 w-full border border-gray-100">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-4 border-b">
                        <div class="flex items-center space-x-3 mb-3 sm:mb-0">
                            <div class="bg-green-100 text-blue-600 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Tambah Pengguna</h1>
                        </div>
                        <a href="{{ route('users.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1 self-start sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Nama</label>
                            <input type="text" name="name" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Email</label>
                            <input type="email" name="email" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                placeholder="Masukkan alamat email">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Role</label>
                            <select name="role" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="superadmin">Super Admin</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Password</label>
                                <input type="password" name="password" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                    placeholder="Masukkan password">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                    placeholder="Konfirmasi password">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route('users.index') }}" 
                               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-center transition">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>