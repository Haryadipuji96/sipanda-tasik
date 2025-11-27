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
                                ruang kelas, ruang dosen, dll. Ruangan ini terkait langsung dengan Program Studi tertentu.
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
                            </label>
                            <select name="id_prodi" id="id_prodi"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                required disabled>
                                <option value="">-- Pilih Prodi --</option>
                            </select>
                            @error('id_prodi')
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
                                <option value="Baik" {{ old('kondisi_ruangan') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ old('kondisi_ruangan') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ old('kondisi_ruangan') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
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

            // Form submission confirmation
            const form = document.getElementById('createForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const namaRuangan = document.querySelector('input[name="nama_ruangan"]').value;
                    const fakultas = document.querySelector('select[name="id_fakultas"]');
                    const prodi = document.querySelector('select[name="id_prodi"]');
                    const kondisi = document.querySelector('select[name="kondisi_ruangan"]');
                    
                    const fakultasText = fakultas.options[fakultas.selectedIndex]?.text || '-';
                    const prodiText = prodi.options[prodi.selectedIndex]?.text || '-';
                    const kondisiText = kondisi.options[kondisi.selectedIndex]?.text || '-';

                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Simpan Ruangan Sarana?',
                        html: `
                            <div class="text-left text-sm">
                                <p><strong>Nama Ruangan:</strong> ${namaRuangan}</p>
                                <p><strong>Fakultas:</strong> ${fakultasText}</p>
                                <p><strong>Program Studi:</strong> ${prodiText}</p>
                                <p><strong>Kondisi:</strong> ${kondisiText}</p>
                            </div>
                        `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#f97316',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }

            // AJAX untuk load prodi berdasarkan fakultas
            $('#id_fakultas').change(function() {
                var idFakultas = $(this).val();

                if (idFakultas) {
                    $('#id_prodi').prop('disabled', false);
                    $('#id_prodi').html('<option value="">-- Loading... --</option>');

                    var url = '{{ route("get.prodi.by.fakultas", ":id") }}'.replace(':id', idFakultas);

                    $.get(url)
                        .done(function(data) {
                            $('#id_prodi').html('<option value="">-- Pilih Prodi --</option>');
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#id_prodi').append('<option value="' + value.id + '">' +
                                        value.nama_prodi + ' (' + (value.jenjang || '-') + ')' +
                                        '</option>');
                                });
                            } else {
                                $('#id_prodi').append('<option value="">-- Tidak ada prodi --</option>');
                            }
                        })
                        .fail(function(xhr) {
                            console.error('Error loading prodi:', xhr);
                            $('#id_prodi').html('<option value="">-- Error loading prodi --</option>');
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data program studi',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        });
                } else {
                    $('#id_prodi').prop('disabled', true);
                    $('#id_prodi').html('<option value="">-- Pilih Prodi --</option>');
                }
            });

            // Handle old input on page load
            @if (old('id_fakultas'))
                $('#id_fakultas').trigger('change');
                setTimeout(function() {
                    $('#id_prodi').val('{{ old('id_prodi') }}');
                }, 1000);
            @endif
        });
    </script>
</x-app-layout>