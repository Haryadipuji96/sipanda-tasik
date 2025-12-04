<x-app-layout>
    <x-slot name="title">Tambah Ruangan Sarana</x-slot>

    <style>
        .form-section {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .info-box {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #f97316;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #ea580c;
        }

        .btn-secondary {
            background-color: #ff0000;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #cc0000;
        }
    </style>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-semibold">Tambah Ruangan Sarana</h1>
                                <p class="text-orange-100 text-sm mt-1">
                                    Tambah ruangan untuk keperluan Program Studi
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('ruangan.create') }}"
                            class="text-white hover:text-orange-100 transition flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Informasi Tipe Ruangan -->
                <div class="info-box">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-orange-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-orange-800 mb-1">Ruangan Sarana</h4>
                            <p class="text-orange-700 text-sm">
                                Ruangan sarana digunakan untuk keperluan akademik Program Studi seperti laboratorium,
                                ruang kelas, ruang dosen, dll. Ruangan ini terkait langsung dengan Program Studi
                                tertentu.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('ruangan.store') }}" method="POST" id="createForm">
                    @csrf
                    <input type="hidden" name="tipe_ruangan" value="sarana">

                    <div class="form-body">
                        <!-- Fakultas -->
                        <div class="mb-4">
                            <label class="block font-medium mb-2 text-gray-700">
                                Fakultas <span class="text-red-500">*</span>
                            </label>
                            <select name="id_fakultas" id="id_fakultas"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                required>
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach ($fakultas as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('id_fakultas') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_fakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_fakultas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Program Studi -->
                        <div class="mb-4">
                            <label class="block font-medium mb-2 text-gray-700">
                                Program Studi <span class="text-red-500">*</span>
                                <span class="text-sm text-gray-500 font-normal">(Bisa pilih lebih dari satu)</span>
                            </label>
                            <select name="prodi_ids[]" id="prodi_ids" multiple
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                required>
                                <option value="">-- Pilih Prodi --</option>
                            </select>
                            <p class="text-gray-500 text-sm mt-1">
                                Gunakan <kbd class="px-1 py-0.5 bg-gray-100 border rounded">Ctrl</kbd> + <kbd
                                    class="px-1 py-0.5 bg-gray-100 border rounded">Click</kbd>
                                untuk memilih lebih dari satu prodi
                            </p>
                            @error('prodi_ids')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @error('prodi_ids.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kondisi Ruangan -->
                        <div class="mb-4">
                            <label class="block font-medium mb-2 text-gray-700">
                                Kondisi Ruangan <span class="text-red-500">*</span>
                            </label>
                            <select name="kondisi_ruangan"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                required>
                                <option value="Baik" {{ old('kondisi_ruangan') == 'Baik' ? 'selected' : '' }}>Baik
                                </option>
                                <option value="Rusak Ringan"
                                    {{ old('kondisi_ruangan') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan
                                </option>
                                <option value="Rusak Berat"
                                    {{ old('kondisi_ruangan') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat
                                </option>
                            </select>
                            @error('kondisi_ruangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Ruangan -->
                        <div class="mb-6">
                            <label class="block font-medium mb-2 text-gray-700">
                                Nama Ruangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                placeholder="Contoh: Lab Komputer, Ruang Kelas 101, Ruang Dosen A" required>
                            @error('nama_ruangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t">
                            <a href="{{ route('ruangan.create') }}"
                                class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn-primary flex items-center justify-center order-1 sm:order-2">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Ruangan Sarana
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // NOTIFIKASI SUKSES
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // NOTIFIKASI ERROR
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    timer: 4000,
                    showConfirmButton: true
                });
            @endif

            // NOTIFIKASI VALIDATION ERRORS
            @if ($errors->any())
                @if (!session('success') && !session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        html: `
                        <div class="text-left">
                            <p class="mb-2">Mohon perbaiki kesalahan berikut:</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    `,
                        showConfirmButton: true,
                        confirmButtonText: 'Mengerti'
                    });
                @endif
            @endif

            // Form submission confirmation dengan validasi manual
            const form = document.getElementById('createForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Mencegah submit langsung

                    // Ambil nilai form
                    const namaRuangan = document.querySelector('input[name="nama_ruangan"]').value;
                    const fakultasSelect = document.querySelector('select[name="id_fakultas"]');
                    const prodiSelect = document.querySelector('select[name="prodi_ids[]"]');
                    const kondisiSelect = document.querySelector('select[name="kondisi_ruangan"]');

                    // Validasi manual sebelum menampilkan SweetAlert
                    let isValid = true;
                    let errorMessage = '';

                    // Validasi Nama Ruangan
                    if (!namaRuangan.trim()) {
                        isValid = false;
                        errorMessage += '• Nama Ruangan wajib diisi<br>';
                    }

                    // Validasi Fakultas
                    if (!fakultasSelect.value) {
                        isValid = false;
                        errorMessage += '• Fakultas wajib dipilih<br>';
                    }

                    // Validasi Program Studi
                    const selectedProdi = Array.from(prodiSelect.selectedOptions).map(option => option
                        .value);
                    if (selectedProdi.length === 0) {
                        isValid = false;
                        errorMessage += '• Program Studi wajib dipilih (minimal 1)<br>';
                    }

                    // Validasi Kondisi Ruangan
                    if (!kondisiSelect.value) {
                        isValid = false;
                        errorMessage += '• Kondisi Ruangan wajib dipilih<br>';
                    }

                    // Jika validasi gagal, tampilkan error
                    if (!isValid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal!',
                            html: `
                            <div class="text-left">
                                <p class="mb-2">Silakan lengkapi data berikut:</p>
                                ${errorMessage}
                            </div>
                        `,
                            showConfirmButton: true,
                            confirmButtonText: 'Mengerti'
                        });
                        return false; // Hentikan proses
                    }

                    // Jika semua validasi berhasil, tampilkan konfirmasi
                    const fakultasText = fakultasSelect.options[fakultasSelect.selectedIndex]?.text || '-';
                    const kondisiText = kondisiSelect.options[kondisiSelect.selectedIndex]?.text || '-';
                    const prodiText = Array.from(prodiSelect.selectedOptions)
                        .map(option => option.text)
                        .join(', ');

                    Swal.fire({
                        title: 'Simpan Ruangan Sarana?',
                        html: `
                        <div class="text-left text-sm">
                            <p class="mb-1"><strong>Nama Ruangan:</strong> ${namaRuangan}</p>
                            <p class="mb-1"><strong>Fakultas:</strong> ${fakultasText}</p>
                            <p class="mb-1"><strong>Program Studi:</strong> ${prodiText}</p>
                            <p class="mb-1"><strong>Kondisi:</strong> ${kondisiText}</p>
                            <p class="mb-1"><strong>Tipe:</strong> Sarana</p>
                        </div>
                    `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#f97316',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Hapus event listener untuk mencegah loop infinity
                            form.removeEventListener('submit', arguments.callee);
                            // Submit form secara manual
                            form.submit();
                        }
                    });
                });
            }

            // AJAX untuk load prodi berdasarkan fakultas
            $('#id_fakultas').change(function() {
                var idFakultas = $(this).val();

                if (idFakultas) {
                    $('#prodi_ids').prop('disabled', false);
                    $('#prodi_ids').html('<option value="">-- Loading... --</option>');

                    var url = '{{ route('get.prodi.by.fakultas', ':id') }}'.replace(':id', idFakultas);

                    $.get(url)
                        .done(function(data) {
                            $('#prodi_ids').html('');
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#prodi_ids').append('<option value="' + value.id + '">' +
                                        value.nama_prodi + ' (' + (value.jenjang || '-') +
                                        ')' +
                                        '</option>');
                                });
                            } else {
                                $('#prodi_ids').append(
                                    '<option value="">-- Tidak ada prodi --</option>');
                            }
                        })
                        .fail(function(xhr) {
                            console.error('Error loading prodi:', xhr);
                            $('#prodi_ids').html('<option value="">-- Error loading prodi --</option>');

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data program studi',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        });
                } else {
                    $('#prodi_ids').prop('disabled', true);
                    $('#prodi_ids').html('<option value="">-- Pilih Prodi --</option>');
                }
            });

            // Handle old input on page load
            @if (old('id_fakultas'))
                $('#id_fakultas').trigger('change');
                setTimeout(function() {
                    // Untuk multiple select, perlu set array
                    var oldProdiIds = @json(old('prodi_ids', []));
                    $('#prodi_ids').val(oldProdiIds);
                }, 1000);
            @endif
        });
    </script>
</x-app-layout>
