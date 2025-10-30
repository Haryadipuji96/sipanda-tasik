<x-app-layout>
<div class="py-8 px-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Tambah Tenaga Pendidik</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tenaga-pendidik.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Prodi -->
        <div>
            <label class="block font-medium mb-1">Program Studi</label>
            <select name="id_prodi" class="border p-2 rounded w-full">
                <option value="">-- Pilih Prodi --</option>
                @foreach($prodi as $p)
                    <option value="{{ $p->id_prodi }}" {{ old('id_prodi') == $p->id_prodi ? 'selected' : '' }}>
                        {{ $p->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nama -->
        <div>
            <label class="block font-medium mb-1">Nama Tenaga Pendidik</label>
            <input type="text" name="nama_tendik" value="{{ old('nama_tendik') }}" class="border p-2 rounded w-full">
        </div>

        <!-- NIP -->
        <div>
            <label class="block font-medium mb-1">NIP</label>
            <input type="text" name="nip" value="{{ old('nip') }}" class="border p-2 rounded w-full">
        </div>

        <!-- Jabatan -->
        <div>
            <label class="block font-medium mb-1">Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="border p-2 rounded w-full">
        </div>

        <!-- Status Kepegawaian -->
        <div>
            <label class="block font-medium mb-1">Status Kepegawaian</label>
            <select name="status_kepegawaian" class="border p-2 rounded w-full">
                <option value="">-- Pilih Status --</option>
                @foreach(['PNS','Honorer','Kontrak'] as $status)
                    <option value="{{ $status }}" {{ old('status_kepegawaian')==$status?'selected':'' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Pendidikan Terakhir -->
        <div>
            <label class="block font-medium mb-1">Pendidikan Terakhir</label>
            <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" class="border p-2 rounded w-full">
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label class="block font-medium mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="border p-2 rounded w-full">
                <option value="">-- Pilih Jenis Kelamin --</option>
                @foreach(['laki-laki','perempuan'] as $jk)
                    <option value="{{ $jk }}" {{ old('jenis_kelamin')==$jk?'selected':'' }}>{{ $jk }}</option>
                @endforeach
            </select>
        </div>

        <!-- No HP -->
        <div>
            <label class="block font-medium mb-1">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="border p-2 rounded w-full">
        </div>

        <!-- Email -->
        <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="border p-2 rounded w-full">
        </div>

        <!-- Alamat -->
        <div>
            <label class="block font-medium mb-1">Alamat</label>
            <textarea name="alamat" class="border p-2 rounded w-full">{{ old('alamat') }}</textarea>
        </div>

        <!-- Keterangan -->
        <div>
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea name="keterangan" class="border p-2 rounded w-full">{{ old('keterangan') }}</textarea>
        </div>

        <!-- File -->
        <div>
            <label class="block font-medium mb-1">File (Foto / PDF)</label>
            <input type="file" name="file" class="border p-2 rounded w-full">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('tenaga-pendidik.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
</x-app-layout>
