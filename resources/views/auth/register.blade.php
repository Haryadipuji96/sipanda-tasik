<x-app-layout>
    <style>
        .cssbuttons-io-button {
            display: flex;
            align-items: center;
            font-family: inherit;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            padding: 0.4em 0.8em;
            color: white;
            background: #2563eb;
            border: none;
            letter-spacing: 0.05em;
            border-radius: 15em;
            transition: all 0.2s;
        }

        .cssbuttons-io-button svg {
            margin-right: 4px;
            fill: white;
        }

        .cssbuttons-io-button:hover {
            box-shadow: 0 0.4em 1em -0.3em #0740bb;
        }

        .cssbuttons-io-button:active {
            box-shadow: 0 0.2em 0.7em -0.3em #0740bb;
            transform: translateY(1px);
        }

        [x-cloak] {
            display: none !important;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .highlight {
            background-color: #fde68a;
            font-weight: 600;
            border-radius: 4px;
            padding: 0 2px;
            animation: fadeGlow 1.2s ease-out;
        }

        @keyframes fadeGlow {
            0% {
                background-color: #facc15;
                box-shadow: 0 0 8px #facc15;
            }
            50% {
                background-color: #fde68a;
                box-shadow: 0 0 5px #fde68a;
            }
            100% {
                background-color: #fde68a;
                box-shadow: none;
            }
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>

    <div class="p-6" x-data="{ openAddModal: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Data Pengguna</h1>
            <button @click="openAddModal = true" class="cssbuttons-io-button">
                <svg height="18" width="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor" />
                </svg>
                <span>Tambah Pengguna</span>
            </button>
        </div>

        <x-search-bar route="register" placeholder="Cari nama pengguna..." />

        <div class="table-wrapper border border-gray-200 rounded-lg">
            <table class="w-full border text-sm bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border px-3 py-2 text-left">No</th>
                        <th class="border px-3 py-2 text-left">Nama</th>
                        <th class="border px-3 py-2 text-left">Email</th>
                        <th class="border px-3 py-2 text-left">Role</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                 @php
                    function highlight($text, $search)
                    {
                        if (!$search) {
                            return e($text);
                        }
                        // Hanya ini yang diganti:
                        return preg_replace(
                            '/(' . preg_quote($search, '/') . ')/i',
                            '<span class="highlight">$1</span>',
                            e($text),
                        );
                    }
                @endphp
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td class="border px-3 py-2">{{ $index + $users->firstItem() }}</td>
                             <td class="border px-3 py-2">{!! highlight($user->name, request('search')) !!}</td>
                             <td class="border px-3 py-2">{!! highlight($user->email, request('search')) !!}</td>
                            <td class="border px-3 py-2 capitalize">{{ $user->role }}</td>
                            <td class="border px-3 py-2">
                                <div class="flex items-center justify-center gap-2" x-data="{ openEditModal: false }">
                                    <!-- Tombol Edit -->
                                    <button @click="openEditModal = true"
                                        class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    @if(Auth::id() !== $user->id)
                                        <form action="{{ route('register.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition btn-delete"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" disabled
                                            class="p-2 bg-gray-100 text-gray-400 rounded-full cursor-not-allowed"
                                            title="Tidak dapat menghapus akun sendiri">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Modal Edit -->
                                    <div x-show="openEditModal" x-cloak
                                        class="fixed inset-0 modal-backdrop flex items-center justify-center z-50"
                                        @click.self="openEditModal = false">
                                        <div class="bg-white rounded-lg w-full max-w-md p-6 mx-4">
                                            <h2 class="text-lg font-semibold mb-4">Edit Pengguna</h2>
                                            <form action="{{ route('register.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-4">
                                                    <label class="block font-medium mb-1">Nama</label>
                                                    <input type="text" name="name" value="{{ $user->name }}"
                                                        class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block font-medium mb-1">Email</label>
                                                    <input type="email" name="email" value="{{ $user->email }}"
                                                        class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block font-medium mb-1">Role</label>
                                                    <select name="role" class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" required>
                                                        <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4 grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block font-medium mb-1">Password Baru (opsional)</label>
                                                        <input type="password" name="password"
                                                            class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2">
                                                    </div>
                                                    <div>
                                                        <label class="block font-medium mb-1">Konfirmasi Password</label>
                                                        <input type="password" name="password_confirmation"
                                                            class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2">
                                                    </div>
                                                </div>

                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" @click="openEditModal = false"
                                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                                        Batal
                                                    </button>
                                                    <button type="submit"
                                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                                        Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>

        <!-- Modal Tambah Pengguna -->
        <div x-show="openAddModal" x-cloak
            class="fixed inset-0 modal-backdrop flex items-center justify-center z-50"
            @click.self="openAddModal = false">
            <div class="bg-white rounded-lg w-full max-w-md p-6 mx-4 max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-semibold mb-4">Tambah Pengguna Baru</h2>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" 
                            required placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" 
                            required placeholder="nama@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Role</label>
                        <select name="role" class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">Password</label>
                            <input type="password" name="password"
                                class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" 
                                required placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2" 
                                required placeholder="Ketik ulang password">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" @click="openAddModal = false"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini? Data yang sudah dihapus tidak bisa dikembalikan!')) {
                        form.submit();
                    }
                });
            });

            @if (session('success'))
                alert('{{ session('success') }}');
            @endif

            @if (session('error'))
                alert('{{ session('error') }}');
            @endif
        });
    </script>
</x-app-layout>