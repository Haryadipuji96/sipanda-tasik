<x-app-layout>
    <x-slot name="title">Profile pengguna</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Upload Foto Profil -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Profil</h3>

                    @if (session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update-photo') }}" enctype="multipart/form-data" id="photo-form">
                        @csrf
                        @method('PATCH')
                        
                        <div class="flex items-center space-x-4 mb-4">
                            @php
                                $user = Auth::user();
                                $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=047857&color=fff';
                                $photoUrl = $user->profile_photo ? asset('storage/' . $user->profile_photo) : $avatar;
                            @endphp
                            
                            <img src="{{ $photoUrl }}"
                                class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 shadow"
                                id="profile-photo-preview"
                                onerror="this.src='{{ $avatar }}'">

                            <div class="flex-1">
                                <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg"
                                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    id="profile_photo_input">
                                <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG | Maks: 2MB</p>
                            </div>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            💾 Simpan Foto
                        </button>
                    </form>
                </div>
            </div>

            <!-- ✅ Update Info -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- ✅ Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- ✅ Delete User -->
            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}

        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                // Validasi ukuran file
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    input.value = '';
                    return;
                }
                
                // Validasi tipe file
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPEG, PNG, atau JPG.');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('profile_photo_input').addEventListener('change', function() {
            previewImage(this);
        });

        document.getElementById('photo-form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('profile_photo_input');
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Pilih file foto terlebih dahulu.');
                return;
            }
        });
    </script>
</x-app-layout>
