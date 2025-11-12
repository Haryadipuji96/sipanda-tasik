<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $id_kategori
 * @property int|null $id_prodi
 * @property string $judul_dokumen
 * @property string|null $nomor_dokumen
 * @property string|null $tanggal_dokumen
 * @property string|null $tahun
 * @property string|null $file_dokumen
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KategoriArsip $kategori
 * @property-read \App\Models\Prodi|null $prodi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereFileDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereIdKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereIdProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereJudulDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereNomorDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereTanggalDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Arsip whereUpdatedAt($value)
 */
	class Arsip extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_prodi
 * @property string $nama_barang
 * @property string $kategori
 * @property int $jumlah
 * @property string $kondisi
 * @property string $tanggal_pengadaan
 * @property string $spesifikasi
 * @property string $kode_seri
 * @property string $sumber
 * @property string|null $keterangan
 * @property string|null $file_dokumen
 * @property string|null $lokasi_lain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Prodi|null $prodi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereFileDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereIdProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereKodeSeri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereLokasiLain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereSpesifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereSumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereTanggalPengadaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSarpras whereUpdatedAt($value)
 */
	class DataSarpras extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_prodi
 * @property string|null $gelar_depan
 * @property string $nama
 * @property string|null $gelar_belakang
 * @property string|null $tempat_lahir
 * @property \Illuminate\Support\Carbon|null $tanggal_lahir
 * @property string|null $nik
 * @property string|null $nuptk
 * @property string|null $pendidikan_terakhir
 * @property string|null $pendidikan_data
 * @property string|null $jabatan
 * @property string|null $tmt_kerja
 * @property int|null $masa_kerja_tahun
 * @property int|null $masa_kerja_bulan
 * @property int|null $masa_kerja_golongan_tahun
 * @property int|null $masa_kerja_golongan_bulan
 * @property string|null $file_dokumen
 * @property string $sertifikasi
 * @property string $inpasing
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $pangkat_golongan
 * @property string|null $jabatan_fungsional
 * @property string|null $no_sk
 * @property string|null $no_sk_jafung
 * @property string|null $file_sertifikasi
 * @property string|null $file_inpasing
 * @property string|null $file_ktp
 * @property string|null $file_ijazah_s1
 * @property string|null $file_transkrip_s1
 * @property string|null $file_ijazah_s2
 * @property string|null $file_transkrip_s2
 * @property string|null $file_ijazah_s3
 * @property string|null $file_transkrip_s3
 * @property string|null $file_jafung
 * @property string|null $file_kk
 * @property string|null $file_perjanjian_kerja
 * @property string|null $file_sk_pengangkatan
 * @property string|null $file_surat_pernyataan
 * @property string|null $file_sktp
 * @property string|null $file_surat_tugas
 * @property string|null $file_sk_aktif
 * @property-read mixed $nama_lengkap
 * @property-read mixed $pendidikan_array
 * @property-read mixed $tempat_tanggal_lahir
 * @property-read \App\Models\Prodi $prodi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileIjazahS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileIjazahS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileIjazahS3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileInpasing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileJafung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileKk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileKtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFilePerjanjianKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileSertifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileSkAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileSkPengangkatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileSktp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileSuratPernyataan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileSuratTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileTranskripS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileTranskripS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereFileTranskripS3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereGelarBelakang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereGelarDepan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereIdProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereInpasing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereJabatanFungsional($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereMasaKerjaBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereMasaKerjaGolonganBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereMasaKerjaGolonganTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereMasaKerjaTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereNoSk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereNoSkJafung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereNuptk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen wherePangkatGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen wherePendidikanData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen wherePendidikanTerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereSertifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereTmtKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dosen whereUpdatedAt($value)
 */
	class Dosen extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_fakultas
 * @property string|null $dekan
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas whereDekan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas whereNamaFakultas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fakultas whereUpdatedAt($value)
 */
	class Fakultas extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_kategori
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Arsip> $arsip
 * @property-read int|null $arsip_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip whereNamaKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriArsip whereUpdatedAt($value)
 */
	class KategoriArsip extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_fakultas
 * @property string $nama_prodi
 * @property string|null $jenjang
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Fakultas $fakultas
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi whereIdFakultas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi whereJenjang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi whereNamaProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prodi whereUpdatedAt($value)
 */
	class Prodi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_prodi
 * @property string $nama_tendik
 * @property string|null $nip
 * @property string $status_kepegawaian
 * @property string|null $pendidikan_terakhir
 * @property string|null $jenis_kelamin
 * @property string|null $no_hp
 * @property string|null $email
 * @property string|null $alamat
 * @property string|null $keterangan
 * @property string|null $gelar_depan
 * @property string|null $gelar_belakang
 * @property string|null $tempat_lahir
 * @property \Illuminate\Support\Carbon|null $tanggal_lahir
 * @property \Illuminate\Support\Carbon|null $tmt_kerja
 * @property array<array-key, mixed>|null $golongan_history
 * @property string|null $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $golongan_array
 * @property-read mixed $golongan_terakhir
 * @property-read mixed $jenis_kelamin_label
 * @property-read mixed $nama_lengkap
 * @property-read mixed $status_kepegawaian_label
 * @property-read mixed $tempat_tanggal_lahir
 * @property-read \App\Models\Prodi $prodi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereGelarBelakang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereGelarDepan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereGolonganHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereIdProdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereNamaTendik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik wherePendidikanTerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereStatusKepegawaian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereTmtKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenagaPendidik whereUpdatedAt($value)
 */
	class TenagaPendidik extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $profile_photo
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserLogin> $logins
 * @property-read int|null $logins_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_user
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $logged_in_at
 * @property \Illuminate\Support\Carbon|null $logged_out_at
 * @property \Illuminate\Support\Carbon|null $last_activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereLoggedInAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereLoggedOutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserLogin whereUserAgent($value)
 */
	class UserLogin extends \Eloquent {}
}

