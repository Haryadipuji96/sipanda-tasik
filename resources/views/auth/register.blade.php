<x-app-layout>
    <x-slot name="title">Daftar pengguna</x-slot>
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

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            margin: 0.1rem;
        }

        .badge-superadmin {
            background-color: #dc2626;
            color: white;
        }

        .badge-admin {
            background-color: #2563eb;
            color: white;
        }

        .badge-user {
            background-color: #059669;
            color: white;
        }

        .menu-tag {
            display: inline-block;
            background-color: #f3f4f6;
            color: #374151;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.7rem;
            margin: 0.1rem;
            border: 1px solid #d1d5db;
        }

        .menu-tag-all {
            background-color: #10b981;
            color: white;
        }
    </style>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        <th class="border px-3 py-2 text-left">Menu Access</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                @php
                    function highlight($text, $search)
                    {
                        if (!$search) {
                            return e($text);
                        }
                        return preg_replace(
                            '/(' . preg_quote($search, '/') . ')/i',
                            '<span class="highlight">$1</span>',
                            e($text),
                        );
                    }
                    
                    // Function untuk menampilkan menu access
                    function displayMenuAccess($user)
                    {
                        if ($user->role === 'superadmin') {
                            return '<span class="menu-tag menu-tag-all">All Access</span>';
                        }
                        
                        if ($user->role === 'user') {
                            return '<span class="text-gray-500 text-sm">Limited Access</span>';
                        }
                        
                        // Untuk admin, tampilkan permissions
                        if ($user->permissions->count() > 0) {
                            $menuTags = '';
                            foreach ($user->permissions as $permission) {
                                $menuTags .= '<span class="menu-tag" title="' . e($permission->description) . '">' . e($permission->name) . '</span>';
                            }
                            return $menuTags;
                        }
                        
                        return '<span class="text-gray-500 text-sm">No specific access</span>';
                    }
                    
                    // Function untuk badge role
                    function displayRoleBadge($role)
                    {
                        $badgeClass = match($role) {
                            'superadmin' => 'badge-superadmin',
                            'admin' => 'badge-admin',
                            'user' => 'badge-user',
                            default => 'badge-user'
                        };
                        
                        return '<span class="badge ' . $badgeClass . '">' . ucfirst($role) . '</span>';
                    }
                @endphp
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">{{ $index + $users->firstItem() }}</td>
                            <td class="border px-3 py-2 font-medium">{!! highlight($user->name, request('search')) !!}</td>
                            <td class="border px-3 py-2">{!! highlight($user->email, request('search')) !!}</td>
                            <td class="border px-3 py-2">{!! displayRoleBadge($user->role) !!}</td>
                            <td class="border px-3 py-2">
                                <div class="flex flex-wrap gap-1">
                                    {!! displayMenuAccess($user) !!}
                                </div>
                            </td>
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
                                    @if (Auth::id() !== $user->id)
                                        <form action="{{ route('register.destroy', $user->id) }}" method="POST"
                                            class="inline" id="delete-form-{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition btn-delete"
                                                title="Hapus"
                                                onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">
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
                                        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 p-4">
                                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
                                            <!-- Header -->
                                            <div
                                                class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 rounded-t-xl sticky top-0 z-10">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                                            <i class="fas fa-edit text-white text-sm"></i>
                                                        </div>
                                                        <div>
                                                            <h2 class="text-xl font-semibold text-white">Edit Pengguna
                                                            </h2>
                                                            <p class="text-blue-100 text-sm">Perbarui data pengguna</p>
                                                        </div>
                                                    </div>
                                                    <button @click="openEditModal = false"
                                                        class="text-white hover:text-blue-200 transition">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Form -->
                                            <form action="{{ route('register.update', $user->id) }}" method="POST"
                                                id="edit-form-{{ $user->id }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="p-6 space-y-4">
                                                    <!-- Current Role Info -->
                                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                                        <h4 class="text-sm font-medium text-blue-800 mb-2">Informasi Saat Ini</h4>
                                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                                            <div>
                                                                <span class="text-gray-600">Role:</span>
                                                                <div class="mt-1">{!! displayRoleBadge($user->role) !!}</div>
                                                            </div>
                                                            <div>
                                                                <span class="text-gray-600">Menu Access:</span>
                                                                <div class="mt-1 flex flex-wrap gap-1">
                                                                    {!! displayMenuAccess($user) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nama -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                                            <i class="fas fa-user mr-1 text-blue-500"></i>Nama <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="text" name="name"
                                                            value="{{ old('name', $user->name) }}"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                            placeholder="Masukkan nama lengkap" required>
                                                        @error('name')
                                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Email -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                                            <i class="fas fa-envelope mr-1 text-blue-500"></i>Email <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="email" name="email"
                                                            value="{{ old('email', $user->email) }}"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                            placeholder="contoh@email.com" required>
                                                        @error('email')
                                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Role -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                                            <i class="fas fa-user-tag mr-1 text-blue-500"></i>Role <span class="text-red-500">*</span>
                                                        </label>
                                                        <select name="role" id="editRoleSelect-{{ $user->id }}"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                            required>
                                                            <option value="">-- Pilih Role --</option>
                                                            <option value="superadmin"
                                                                {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>
                                                                Super Admin (All Access)
                                                            </option>
                                                            <option value="admin"
                                                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                                Admin (Custom Access)
                                                            </option>
                                                            <option value="user"
                                                                {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                                                User (Limited Access)
                                                            </option>
                                                        </select>
                                                        @error('role')
                                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Permissions Section (hanya tampil untuk role admin) -->
                                                    <div id="editPermissionsSection-{{ $user->id }}" class="hidden">
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                                            <i class="fas fa-list-alt mr-1 text-blue-500"></i>Hak Akses Menu
                                                        </label>
                                                        <div class="text-xs text-gray-500 mb-2">
                                                            Pilih menu yang dapat diakses oleh admin ini
                                                        </div>
                                                        <div
                                                            class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-4 bg-gray-50">
                                                            @foreach ($permissions as $permission)
                                                                @php
                                                                    $userPermissionIds = $user->permissions
                                                                        ->pluck('id')
                                                                        ->toArray();
                                                                    $isChecked = in_array(
                                                                        $permission->id,
                                                                        old('permissions', $userPermissionIds),
                                                                    );
                                                                @endphp
                                                                <label
                                                                    class="flex items-start mb-3 p-2 hover:bg-white rounded transition border border-gray-200">
                                                                    <input type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3 mt-1"
                                                                        {{ $isChecked ? 'checked' : '' }}>
                                                                    <span class="text-sm flex-1">
                                                                        <strong
                                                                            class="text-gray-800 block">{{ $permission->name }}</strong>
                                                                        <span
                                                                            class="text-gray-600 text-xs block mt-1">{{ $permission->description }}</span>
                                                                        <span class="text-blue-500 text-xs block mt-1">
                                                                            <i class="fas fa-key mr-1"></i>Key: {{ $permission->menu_key }}
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                        @error('permissions')
                                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Password Section -->
                                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                                        <h4
                                                            class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                                            <i class="fas fa-key mr-2 text-gray-500"></i>
                                                            Password Baru (Opsional)
                                                        </h4>

                                                        <div class="space-y-3">
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-medium text-gray-600 mb-1">
                                                                    Password Baru
                                                                </label>
                                                                <input type="password" name="password"
                                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                                    placeholder="Kosongkan jika tidak ingin mengubah">
                                                                @error('password')
                                                                    <p class="text-red-500 text-sm mt-1">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-medium text-gray-600 mb-1">
                                                                    Konfirmasi Password
                                                                </label>
                                                                <input type="password" name="password_confirmation"
                                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                                    placeholder="Konfirmasi password baru">
                                                            </div>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-2">
                                                            Biarkan kosong jika tidak ingin mengubah password
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Footer -->
                                                <div
                                                    class="flex justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl sticky bottom-0">
                                                    <button type="button" @click="openEditModal = false"
                                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                                                        <i class="fas fa-times"></i>
                                                        Batal
                                                    </button>
                                                    <button type="button" onclick="confirmEdit({{ $user->id }})"
                                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                                        <i class="fas fa-save"></i>
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
                            <td colspan="6" class="text-center py-3">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>

        <!-- Modal Tambah Pengguna -->
        <div x-show="openAddModal" x-cloak class="fixed inset-0 modal-backdrop flex items-center justify-center z-50"
            @click.self="openAddModal = false">
            <div class="bg-white rounded-lg w-full max-w-md p-6 mx-4 max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-semibold mb-4">Tambah Pengguna Baru</h2>

                <form method="POST" action="{{ route('register') }}" id="add-user-form">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            <i class="fas fa-user mr-1 text-blue-500"></i>Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2"
                            required placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            <i class="fas fa-envelope mr-1 text-blue-500"></i>Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2"
                            required placeholder="nama@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            <i class="fas fa-user-tag mr-1 text-blue-500"></i>Role
                        </label>
                        <select name="role" id="roleSelect"
                            class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2"
                            required>
                            <option value="">-- Pilih Role --</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>
                                Super Admin (All Access)
                            </option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                Admin (Custom Access)
                            </option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                User (Limited Access)
                            </option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Permissions Section (hanya tampil untuk role admin) -->
                    <div id="permissionsSection" class="mb-4 hidden">
                        <label class="block font-medium mb-2">
                            <i class="fas fa-list-alt mr-1 text-blue-500"></i>Hak Akses Menu
                        </label>
                        <div class="text-xs text-gray-500 mb-2">
                            Pilih menu yang dapat diakses oleh admin ini
                        </div>
                        <div class="max-h-48 overflow-y-auto border border-gray-300 rounded p-3">
                            @foreach ($permissions as $permission)
                                <label class="flex items-center mb-2 p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2"
                                        {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <span class="text-sm flex-1">
                                        <strong>{{ $permission->name }}</strong>
                                        <br>
                                        <span class="text-gray-600 text-xs">{{ $permission->description }}</span>
                                        <br>
                                        <span class="text-blue-500 text-xs">
                                            <i class="fas fa-key mr-1"></i>Key: {{ $permission->menu_key }}
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('permissions')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">
                                <i class="fas fa-lock mr-1 text-blue-500"></i>Password
                            </label>
                            <input type="password" name="password"
                                class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2"
                                required placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-medium mb-1">
                                <i class="fas fa-lock mr-1 text-blue-500"></i>Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation"
                                class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded px-3 py-2"
                                required placeholder="Ketik ulang password">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" @click="openAddModal = false"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition flex items-center gap-2">
                            <i class="fas fa-times"></i>Batal
                        </button>
                        <button type="button" onclick="confirmAdd()"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition flex items-center gap-2">
                            <i class="fas fa-save"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle role change untuk edit modal
        document.addEventListener('DOMContentLoaded', function() {
            // Untuk modal edit yang dinamis
            document.addEventListener('alpine:init', () => {
                Alpine.data('editModal', (userId) => ({
                    openEditModal: false,
                    init() {
                        // Setup role change listener untuk modal ini
                        const editRoleSelect = document.getElementById(`editRoleSelect-${userId}`);
                        const editPermissionsSection = document.getElementById(`editPermissionsSection-${userId}`);

                        if (editRoleSelect && editPermissionsSection) {
                            // Set initial state
                            this.toggleEditPermissions(editRoleSelect.value, editPermissionsSection);

                            editRoleSelect.addEventListener('change', (e) => {
                                this.toggleEditPermissions(e.target.value, editPermissionsSection);
                            });
                        }
                    },
                    toggleEditPermissions(role, permissionsSection) {
                        if (role === 'admin') {
                            permissionsSection.classList.remove('hidden');
                        } else {
                            permissionsSection.classList.add('hidden');
                        }
                    }
                }));
            });

            // Untuk modal tambah
            const roleSelect = document.getElementById('roleSelect');
            const permissionsSection = document.getElementById('permissionsSection');

            function togglePermissions() {
                if (roleSelect.value === 'admin') {
                    permissionsSection.classList.remove('hidden');
                } else {
                    permissionsSection.classList.add('hidden');
                }
            }

            if (roleSelect) {
                roleSelect.addEventListener('change', togglePermissions);
                // Trigger on load
                togglePermissions();
            }
        });
    </script>

    <script>
        // SweetAlert Functions
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                html: `Apakah Anda yakin ingin menghapus pengguna <strong>${userName}</strong>?<br><br>Data yang sudah dihapus tidak bisa dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${userId}`).submit();
                }
            });
        }

        function confirmEdit(userId) {
            Swal.fire({
                title: 'Update Pengguna?',
                text: 'Apakah Anda yakin ingin memperbarui data pengguna ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`edit-form-${userId}`).submit();
                }
            });
        }

        function confirmAdd() {
            Swal.fire({
                title: 'Tambah Pengguna?',
                text: 'Apakah Anda yakin ingin menambahkan pengguna baru?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('add-user-form').submit();
                }
            });
        }

        // SweetAlert Notifications
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    timer: 4000,
                    showConfirmButton: true
                });
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: '{{ $error }}',
                        timer: 4000,
                        showConfirmButton: true
                    });
                @endforeach
            @endif
        });
    </script>
</x-app-layout>