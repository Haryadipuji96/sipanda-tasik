-- Backup Database: db_sipanda

CREATE TABLE `arsip` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_kategori` bigint(20) unsigned NOT NULL,
  `id_prodi` bigint(20) unsigned DEFAULT NULL,
  `judul_dokumen` varchar(255) NOT NULL,
  `nomor_dokumen` varchar(255) DEFAULT NULL,
  `tanggal_dokumen` date DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `file_dokumen` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `arsip_id_kategori_foreign` (`id_kategori`),
  KEY `arsip_id_prodi_foreign` (`id_prodi`),
  CONSTRAINT `arsip_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_arsip` (`id`) ON DELETE CASCADE,
  CONSTRAINT `arsip_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `arsip` (`id`, `id_kategori`, `id_prodi`, `judul_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `tahun`, `file_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES ('1', '1', '', 'Sk Pemberian Hadiah', 'PR-015/2027', '2025-11-23', '2025', '20251127023100-Arsip.pdf', '', '2025-11-22 18:36:25', '2025-11-27 02:31:00');
INSERT INTO `arsip` (`id`, `id_kategori`, `id_prodi`, `judul_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `tahun`, `file_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES ('2', '1', '', 'Peraturan Kampus', 'MOU-015/2025', '2025-11-23', '2025', '20251122190751-Arsip.pdf', '', '2025-11-22 19:07:52', '2025-11-22 19:07:52');
INSERT INTO `arsip` (`id`, `id_kategori`, `id_prodi`, `judul_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `tahun`, `file_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES ('5', '1', '', 'Sk Pemberian jabatan', 'SK-015/2025', '2025-11-25', '2025', '20251125051854-Arsip.pdf', '', '2025-11-25 05:17:59', '2025-11-25 05:18:54');
INSERT INTO `arsip` (`id`, `id_kategori`, `id_prodi`, `judul_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `tahun`, `file_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES ('7', '1', '', 'Asdf', 'PR-015/2027', '2025-11-25', '2025', '20251125052159-Arsip.pdf', '', '2025-11-25 05:21:59', '2025-11-25 05:21:59');
INSERT INTO `arsip` (`id`, `id_kategori`, `id_prodi`, `judul_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `tahun`, `file_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES ('8', '1', '', 'Puji', 'PR-015/2027', '2025-11-25', '2025', '20251125052256-Arsip.pdf', '', '2025-11-25 05:22:56', '2025-11-25 05:22:56');
INSERT INTO `arsip` (`id`, `id_kategori`, `id_prodi`, `judul_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `tahun`, `file_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES ('9', '1', '', 'MoU asdf', 'asdf001', '2025-11-26', '2025', '20251126030959-Arsip.pdf', '', '2025-11-26 03:09:59', '2025-11-26 03:09:59');
INSERT INTO `arsip` (`id`, `id_kategori`, `id_prodi`, `judul_dokumen`, `nomor_dokumen`, `tanggal_dokumen`, `tahun`, `file_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES ('10', '1', '', 'Sk Pemberian jabatan Fungsional', 'SK-012/2025', '2025-11-13', '2025', '20251126034554-Arsip.pdf', '', '2025-11-26 03:45:54', '2025-11-26 03:45:54');

CREATE TABLE `backup_ketua_prodi` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `ketua_prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `backup_ketua_prodi` (`id`, `ketua_prodi`) VALUES ('1', 'Saepul');
INSERT INTO `backup_ketua_prodi` (`id`, `ketua_prodi`) VALUES ('2', 'Bambang');
INSERT INTO `backup_ketua_prodi` (`id`, `ketua_prodi`) VALUES ('3', 'Sheli');
INSERT INTO `backup_ketua_prodi` (`id`, `ketua_prodi`) VALUES ('4', 'Jajang Kurniawan');
INSERT INTO `backup_ketua_prodi` (`id`, `ketua_prodi`) VALUES ('5', 'Puji');

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `data_sarpras` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi` bigint(20) unsigned DEFAULT NULL,
  `ruangan_id` bigint(20) unsigned DEFAULT NULL,
  `nama_ruangan` varchar(255) NOT NULL DEFAULT 'Ruangan Default',
  `kategori_ruangan` varchar(100) NOT NULL DEFAULT 'ruang_kelas',
  `nama_barang` varchar(255) NOT NULL,
  `merk_barang` varchar(100) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL DEFAULT 'unit',
  `harga` decimal(15,2) DEFAULT NULL,
  `kategori_barang` varchar(100) NOT NULL DEFAULT 'Umum',
  `kondisi` varchar(50) NOT NULL,
  `tanggal_pengadaan` date DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `spesifikasi` text NOT NULL,
  `kode_seri` varchar(100) NOT NULL,
  `sumber` enum('HIBAH','LEMBAGA','YAYASAN') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `file_dokumen` varchar(255) DEFAULT NULL,
  `lokasi_lain` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `data_sarpras_id_prodi_foreign` (`id_prodi`),
  KEY `data_sarpras_ruangan_id_foreign` (`ruangan_id`),
  CONSTRAINT `data_sarpras_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE SET NULL,
  CONSTRAINT `data_sarpras_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('35', '', '12', 'Ruangan Default', 'ruang_kelas', 'Kursi Kantor', 'IKEA', '2', 'unit', '500000.00', 'PERABOTAN & FURNITURE', 'Baik', '2024-01-15', '', 'Kursi kantor ergonomis', 'KRS-001', 'LEMBAGA', 'Untuk ruang staff', '', '', '2025-11-26 03:00:26', '2025-11-26 03:00:26');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('36', '', '12', 'Ruangan Default', 'ruang_kelas', 'Laptop ASUS', '', '1', 'unit', '8000000.00', 'ELEKTRONIK & TEKNOLOGI', 'Baik Sekali', '', '', 'ASUS Vivobook 15, Intel i5, 8GB RAM', 'LAP-001', 'HIBAH', '', '', 'Gedung B Lantai 2', '2025-11-26 03:00:26', '2025-11-26 03:00:26');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('37', '', '12', 'Ruangan Default', 'ruang_kelas', 'Meja Kayu', '', '5', 'buah', '', 'PERABOTAN & FURNITURE', 'Baik', '2024-03-10', '', 'Meja kayu jati ukuran 120x60cm', 'MEJA-001', 'YAYASAN', '', '', '', '2025-11-26 03:00:26', '2025-11-26 03:00:26');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('38', '', '12', 'Ruangan Default', 'ruang_kelas', 'Proyektor', 'Epson', '2', 'unit', '3500000.00', 'ELEKTRONIK & TEKNOLOGI', 'Cukup', '', '', 'Proyektor LCD 3000 lumens', 'PROJ-001', 'LEMBAGA', 'Perlu perawatan', '', '', '2025-11-26 03:00:26', '2025-11-26 03:00:26');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('39', '', '12', 'Ruangan Default', 'ruang_kelas', 'Headset Gaming', 'Rexus', '15', 'unit', '300000.00', 'ELEKTRONIK & TEKNOLOGI', 'Baik Sekali', '', '', '\"-\"', '\"-\"', 'YAYASAN', '', '', '', '2025-11-26 03:00:26', '2025-11-26 03:00:26');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('40', '', '11', 'Ruangan Default', 'ruang_kelas', 'Kursi Kantor', 'IKEA', '2', 'unit', '500000.00', 'PERABOTAN & FURNITURE', 'Baik', '2024-01-15', '', 'Kursi kantor ergonomis', 'KRS-001', 'LEMBAGA', 'Untuk ruang staff', '', '', '2025-11-26 03:02:14', '2025-11-26 03:02:14');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('41', '', '11', 'Ruangan Default', 'ruang_kelas', 'Laptop ASUS', '', '1', 'unit', '8000000.00', 'ELEKTRONIK & TEKNOLOGI', 'Baik Sekali', '', '', 'ASUS Vivobook 15, Intel i5, 8GB RAM', 'LAP-001', 'HIBAH', '', '', 'Gedung B Lantai 2', '2025-11-26 03:02:14', '2025-11-26 03:02:14');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('42', '', '11', 'Ruangan Default', 'ruang_kelas', 'Meja Kayu', '', '5', 'buah', '', 'PERABOTAN & FURNITURE', 'Baik', '2024-03-10', '', 'Meja kayu jati ukuran 120x60cm', 'MEJA-001', 'YAYASAN', '', '', '', '2025-11-26 03:02:14', '2025-11-26 03:02:14');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('43', '', '11', 'Ruangan Default', 'ruang_kelas', 'Proyektor', 'Epson', '2', 'unit', '3500000.00', 'ELEKTRONIK & TEKNOLOGI', 'Cukup', '', '', 'Proyektor LCD 3000 lumens', 'PROJ-001', 'LEMBAGA', 'Perlu perawatan', '', '', '2025-11-26 03:02:14', '2025-11-26 03:02:14');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('44', '', '11', 'Ruangan Default', 'ruang_kelas', 'Headset Gaming', 'Rexus', '15', 'unit', '300000.00', 'ELEKTRONIK & TEKNOLOGI', 'Baik Sekali', '', '', 'Tidak ada', 'Tidak ada', 'YAYASAN', '', '', '', '2025-11-26 03:02:14', '2025-11-26 03:02:14');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('45', '', '7', 'Ruangan Default', 'ruang_kelas', 'Kursi Kantor Gaming', 'IKEA', '2', 'unit', '500000.00', 'PERABOTAN & FURNITURE', 'Baik', '2024-01-15', '', 'Kursi kantor ergonomis', 'KRS-001', 'HIBAH', 'Untuk ruang staff', '', '', '2025-11-26 03:37:27', '2025-11-27 03:07:59');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('46', '', '7', 'Ruangan Default', 'ruang_kelas', 'Laptop ASUS', '', '1', 'unit', '8000000.00', 'ELEKTRONIK & TEKNOLOGI', 'Baik Sekali', '', '', 'ASUS Vivobook 15, Intel i5, 8GB RAM', 'LAP-001', 'HIBAH', '', '', 'Gedung B Lantai 2', '2025-11-26 03:37:27', '2025-11-26 03:37:27');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('47', '', '7', 'Ruangan Default', 'ruang_kelas', 'Kursi Tamu', '', '3', 'unit', '1000000.00', 'PERABOTAN & FURNITURE', 'Baik', '2024-03-10', '', 'Tidak ada', 'Tidak ada', 'YAYASAN', '', '', '', '2025-11-26 03:37:27', '2025-11-26 03:37:27');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('48', '', '7', 'Ruangan Default', 'ruang_kelas', 'Meja Tamu', '', '1', 'unit', '3500000.00', 'PERABOTAN & FURNITURE', 'Baik', '', '', 'Tidak ada', 'Tidak ada', 'LEMBAGA', 'Perlu perawatan', '', '', '2025-11-26 03:37:27', '2025-11-26 03:37:27');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('49', '', '7', 'Ruangan Default', 'ruang_kelas', 'Meja Dosen Ketua', '', '1', 'unit', '1000000.00', 'PERABOTAN & FURNITURE', 'Cukup', '', '', 'asdf', 'EPSN-PRJ-005', 'LEMBAGA', '', '1764212241_istockphoto-1207703936-612x612.jpg', '', '2025-11-27 02:57:21', '2025-11-27 02:57:21');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('50', '', '7', 'Ruangan Default', 'ruang_kelas', 'Buku', '', '7', 'lusin', '850000.00', 'PERALATAN KANTOR', 'Baik Sekali', '', '', 'asdf', 'ASUS-ROG-0034', 'HIBAH', '', '1764212652_istockphoto-1207703936-612x612.jpg', '', '2025-11-27 03:04:12', '2025-11-27 03:04:12');
INSERT INTO `data_sarpras` (`id`, `id_prodi`, `ruangan_id`, `nama_ruangan`, `kategori_ruangan`, `nama_barang`, `merk_barang`, `jumlah`, `satuan`, `harga`, `kategori_barang`, `kondisi`, `tanggal_pengadaan`, `tahun`, `spesifikasi`, `kode_seri`, `sumber`, `keterangan`, `file_dokumen`, `lokasi_lain`, `created_at`, `updated_at`) VALUES ('51', '', '7', 'Ruangan Default', 'ruang_kelas', 'Pulpen', '', '30', 'lusin', '12000000.00', 'PERALATAN KANTOR', 'Baik', '', '', 'asdf', 'KOM-001', 'LEMBAGA', '', '1764212834_istockphoto-1207703936-612x612.jpg', '', '2025-11-27 03:07:14', '2025-11-27 03:42:34');

CREATE TABLE `dokumen_mahasiswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `prodi_id` bigint(20) unsigned NOT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `tahun_keluar` year(4) DEFAULT NULL,
  `status_mahasiswa` enum('Aktif','Lulus','Cuti','Drop Out') NOT NULL DEFAULT 'Aktif',
  `file_ijazah` varchar(255) DEFAULT NULL,
  `file_transkrip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dokumen_mahasiswa_nim_unique` (`nim`),
  KEY `dokumen_mahasiswa_prodi_id_foreign` (`prodi_id`),
  CONSTRAINT `dokumen_mahasiswa_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('13', '202301001', 'Ahmad Fauzi', '1', '2023', '', 'Aktif', '', '', '2025-11-24 01:50:21', '2025-11-24 01:50:21');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('14', '202301002', 'Siti Rahayu', '1', '2020', '2025', 'Lulus', '', '', '2025-11-24 01:50:21', '2025-11-24 01:50:21');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('15', '202302094', 'Puji Haryadi', '1', '2019', '2024', 'Lulus', '', '', '2025-11-24 01:50:21', '2025-11-24 01:50:21');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('16', '202302095', 'Adrian', '1', '2022', '', 'Aktif', '', '', '2025-11-24 01:50:21', '2025-11-24 01:50:21');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('17', '202302096', 'Sheli', '1', '2023', '2026', 'Lulus', '', '', '2025-11-24 01:50:21', '2025-11-24 01:50:21');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('25', '202302099', 'Ahmad Fauzi', '1', '2025', '', 'Aktif', 'ijazah_202302099_1763956935.pdf', 'transkrip_202302099_1763956935.pdf', '2025-11-24 02:18:00', '2025-11-24 04:02:15');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('26', '202302098', 'Siti Rahayu', '1', '2020', '2024', 'Lulus', '', '', '2025-11-24 02:18:00', '2025-11-24 02:18:00');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('27', '202302077', 'Kelvin', '2', '2020', '2024', 'Lulus', '', '', '2025-11-24 02:18:00', '2025-11-24 02:18:00');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('28', '202302092', 'Rizky', '3', '2025', '', 'Aktif', '', '', '2025-11-24 02:18:00', '2025-11-24 02:18:00');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('29', '202302088', 'Syahroni', '2', '2024', '', 'Aktif', '', '', '2025-11-24 02:18:00', '2025-11-24 02:18:00');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('32', '202301000', 'Ahmad Fauzi', '2', '2025', '', 'Aktif', '', '', '2025-11-25 02:00:43', '2025-11-25 02:00:43');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('33', '202302011', 'Siti Rahayu', '4', '2025', '2025', 'Lulus', '', '', '2025-11-25 02:00:43', '2025-11-25 02:00:43');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('34', '202408551', 'Aisyah', '2', '2025', '', 'Aktif', '', '', '2025-11-25 02:00:43', '2025-11-25 02:00:43');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('35', '202301034', 'Ali Akbar', '1', '2025', '', 'Aktif', '', '', '2025-11-25 02:00:43', '2025-11-25 02:00:43');
INSERT INTO `dokumen_mahasiswa` (`id`, `nim`, `nama_lengkap`, `prodi_id`, `tahun_masuk`, `tahun_keluar`, `status_mahasiswa`, `file_ijazah`, `file_transkrip`, `created_at`, `updated_at`) VALUES ('36', '202302083', 'Aceng', '3', '2022', '2026', 'Lulus', '', '', '2025-11-25 02:00:43', '2025-11-25 02:00:43');

CREATE TABLE `dosen` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi` bigint(20) unsigned NOT NULL,
  `gelar_depan` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `gelar_belakang` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nuptk` varchar(255) DEFAULT NULL,
  `pendidikan_terakhir` varchar(255) DEFAULT NULL,
  `pendidikan_data` text DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `tmt_kerja` varchar(255) DEFAULT NULL,
  `masa_kerja_tahun` int(11) DEFAULT NULL,
  `masa_kerja_bulan` int(11) DEFAULT NULL,
  `golongan` varchar(255) DEFAULT NULL,
  `masa_kerja_golongan_tahun` int(11) DEFAULT NULL,
  `masa_kerja_golongan_bulan` int(11) DEFAULT NULL,
  `file_dokumen` varchar(255) DEFAULT NULL,
  `sertifikasi` enum('SUDAH','BELUM') NOT NULL DEFAULT 'BELUM',
  `inpasing` enum('SUDAH','BELUM') NOT NULL DEFAULT 'BELUM',
  `status_dosen` enum('DOSEN_TETAP','DOSEN_TIDAK_TETAP','PNS') NOT NULL DEFAULT 'DOSEN_TETAP',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pangkat_golongan` varchar(255) DEFAULT NULL,
  `jabatan_fungsional` varchar(255) DEFAULT NULL,
  `no_sk` varchar(255) DEFAULT NULL,
  `no_sk_jafung` varchar(255) DEFAULT NULL,
  `file_sertifikasi` varchar(255) DEFAULT NULL,
  `file_inpasing` varchar(255) DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `file_ijazah_s1` varchar(255) DEFAULT NULL,
  `file_transkrip_s1` varchar(255) DEFAULT NULL,
  `file_ijazah_s2` varchar(255) DEFAULT NULL,
  `file_transkrip_s2` varchar(255) DEFAULT NULL,
  `file_ijazah_s3` varchar(255) DEFAULT NULL,
  `file_transkrip_s3` varchar(255) DEFAULT NULL,
  `file_jafung` varchar(255) DEFAULT NULL,
  `file_kk` varchar(255) DEFAULT NULL,
  `file_perjanjian_kerja` varchar(255) DEFAULT NULL,
  `file_sk_pengangkatan` varchar(255) DEFAULT NULL,
  `file_surat_pernyataan` varchar(255) DEFAULT NULL,
  `file_sktp` varchar(255) DEFAULT NULL,
  `file_surat_tugas` varchar(255) DEFAULT NULL,
  `file_sk_aktif` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dosen_id_prodi_foreign` (`id_prodi`),
  CONSTRAINT `dosen_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dosen` (`id`, `id_prodi`, `gelar_depan`, `nama`, `gelar_belakang`, `tempat_lahir`, `tanggal_lahir`, `nik`, `nuptk`, `pendidikan_terakhir`, `pendidikan_data`, `jabatan`, `tmt_kerja`, `masa_kerja_tahun`, `masa_kerja_bulan`, `golongan`, `masa_kerja_golongan_tahun`, `masa_kerja_golongan_bulan`, `file_dokumen`, `sertifikasi`, `inpasing`, `status_dosen`, `created_at`, `updated_at`, `pangkat_golongan`, `jabatan_fungsional`, `no_sk`, `no_sk_jafung`, `file_sertifikasi`, `file_inpasing`, `file_ktp`, `file_ijazah_s1`, `file_transkrip_s1`, `file_ijazah_s2`, `file_transkrip_s2`, `file_ijazah_s3`, `file_transkrip_s3`, `file_jafung`, `file_kk`, `file_perjanjian_kerja`, `file_sk_pengangkatan`, `file_surat_pernyataan`, `file_sktp`, `file_surat_tugas`, `file_sk_aktif`) VALUES ('7', '1', 'Dr', 'Puji Haryadi', 'S.Kom', 'Banjar', '', '123456789012345', '', 'S3', '[{\"jenjang\":\"S1\",\"prodi\":\"PAI\",\"tahun_lulus\":\"2023\",\"universitas\":\"UNSIL\"},{\"jenjang\":\"S2\",\"prodi\":\"Ekonomi\",\"tahun_lulus\":\"2022\",\"universitas\":\"UNPER\"},{\"jenjang\":\"S3\",\"prodi\":\"Informatika\",\"tahun_lulus\":\"2027\",\"universitas\":\"Telkom University\"}]', 'Jafung', '', '12', '2', '', '1', '1', '', 'BELUM', 'BELUM', 'DOSEN_TETAP', '2025-11-26 05:51:43', '2025-11-27 05:32:33', 'III/a', 'Warek', '124/SK/2023', 'Warek II', '', '', '20251127053233_file_ktp.pdf', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `dosen` (`id`, `id_prodi`, `gelar_depan`, `nama`, `gelar_belakang`, `tempat_lahir`, `tanggal_lahir`, `nik`, `nuptk`, `pendidikan_terakhir`, `pendidikan_data`, `jabatan`, `tmt_kerja`, `masa_kerja_tahun`, `masa_kerja_bulan`, `golongan`, `masa_kerja_golongan_tahun`, `masa_kerja_golongan_bulan`, `file_dokumen`, `sertifikasi`, `inpasing`, `status_dosen`, `created_at`, `updated_at`, `pangkat_golongan`, `jabatan_fungsional`, `no_sk`, `no_sk_jafung`, `file_sertifikasi`, `file_inpasing`, `file_ktp`, `file_ijazah_s1`, `file_transkrip_s1`, `file_ijazah_s2`, `file_transkrip_s2`, `file_ijazah_s3`, `file_transkrip_s3`, `file_jafung`, `file_kk`, `file_perjanjian_kerja`, `file_sk_pengangkatan`, `file_surat_pernyataan`, `file_sktp`, `file_surat_tugas`, `file_sk_aktif`) VALUES ('8', '3', 'Dr', 'Rahmat', 'S.Kom', 'Banjar', '2025-11-13', '2974638307434', '', 'S3', '[{\"jenjang\":\"S1\",\"prodi\":\"Akuntansi\",\"tahun_lulus\":\"2023\",\"universitas\":\"UNSIL\"},{\"jenjang\":\"S2\",\"prodi\":\"Hukum\",\"tahun_lulus\":\"2022\",\"universitas\":\"UNPER\"},{\"jenjang\":\"S3\",\"prodi\":\"Jaringan\",\"tahun_lulus\":\"2022\",\"universitas\":\"Poltekes\"}]', 'Jafung', '2025-11-27 00:00:00', '8', '5', '', '5', '4', '', 'SUDAH', 'SUDAH', 'DOSEN_TIDAK_TETAP', '2025-11-27 05:34:29', '2025-11-27 05:34:29', 'III/a', 'Warek', '124/SK/2023', 'Warek II', '20251127053429_file_sertifikasi.pdf', '20251127053429_file_inpasing.pdf', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `fakultas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_fakultas` varchar(255) NOT NULL,
  `dekan` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `fakultas` (`id`, `nama_fakultas`, `dekan`, `deskripsi`, `created_at`, `updated_at`) VALUES ('1', 'Fakultas Tarbiyah', 'Pak Cecep Rizki', '', '2025-11-22 18:20:14', '2025-11-26 11:27:46');
INSERT INTO `fakultas` (`id`, `nama_fakultas`, `dekan`, `deskripsi`, `created_at`, `updated_at`) VALUES ('2', 'Fakultas Syariah', 'Pak Ceri', '', '2025-11-26 11:37:45', '2025-11-26 11:37:45');
INSERT INTO `fakultas` (`id`, `nama_fakultas`, `dekan`, `deskripsi`, `created_at`, `updated_at`) VALUES ('3', 'Fakultas Ekonomi Dan Bisnis', 'Pak Rizal', '', '2025-11-27 02:03:41', '2025-11-27 02:03:41');
INSERT INTO `fakultas` (`id`, `nama_fakultas`, `dekan`, `deskripsi`, `created_at`, `updated_at`) VALUES ('4', 'Fakultas Pertanian', 'Pak Rifki', '', '2025-11-27 02:04:10', '2025-11-27 02:04:10');

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kategori_arsip` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kategori_arsip` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES ('1', 'Dokumen Mou Dosen', '', '2025-11-22 18:35:32', '2025-11-26 17:02:35');
INSERT INTO `kategori_arsip` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES ('2', 'Dokumen Mou Dosen', '', '2025-11-27 02:08:54', '2025-11-27 02:08:54');

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2025_10_30_034522_create_fakultas_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2025_10_30_040430_create_prodi_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2025_10_30_043716_create_kategori_arsip_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2025_10_30_044311_create_dosen_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2025_10_30_050432_add_role_to_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2025_10_30_051120_create_arsip_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2025_10_30_121739_create_sarpras_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2025_10_30_160406_create_tenaga_pendidik_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2025_10_30_162147_create_userlogin_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2025_10_31_040307_add_profile_photo_to_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2025_11_07_085555_add_new_columns_to_dosen_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('15', '2025_11_12_040251_add_new_fields_to_dosen_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('16', '2025_11_17_025828_update_tenaga_pendidik_table_add_fields', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('17', '2025_11_17_081835_alter_data_sarpras_table_add_new_columns', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('18', '2025_11_17_162924_create_ruangan_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('19', '2025_11_18_022956_add_ruangan_id_to_data_sarpras_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('20', '2025_11_19_022636_add_tipe_ruangan_to_ruangan_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('21', '2025_11_19_140434_create_dokumen_mahasiswa_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('22', '2025_11_19_150111_rename_admin_to_superadmin_in_dokumen_mahasiswa_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('23', '2025_11_22_170557_create_permissions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('24', '2025_11_22_170613_create_user_permissions_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('25', '2025_11_22_193651_update_ruangan_table_add_missing_columns', '2');

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `menu_key` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_menu_key_unique` (`menu_key`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('1', 'Manage Dosen', 'Mengelola data dosen', 'dosen', '2025-11-22 18:13:55', '2025-11-22 18:13:55');
INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('2', 'Manage Tenaga Pendidik', 'Mengelola data tenaga pendidik', 'tenaga-pendidik', '2025-11-22 18:13:55', '2025-11-22 18:13:55');
INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('3', 'Manage Sarpras', 'Mengelola data ruangan', 'ruangan', '2025-11-22 18:13:55', '2025-11-22 18:13:55');
INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('4', 'Manage Arsip', 'Mengelola data arsip', 'arsip', '2025-11-22 18:13:55', '2025-11-22 18:13:55');
INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('5', 'Manage Fakultas', 'Mengelola data fakultas', 'fakultas', '2025-11-22 18:13:55', '2025-11-22 18:13:55');
INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('6', 'Manage Prodi', 'Mengelola data program studi', 'prodi', '2025-11-22 18:13:55', '2025-11-22 18:13:55');
INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('7', 'Manage Users', 'Mengelola data pengguna', 'users', '2025-11-22 18:13:55', '2025-11-22 18:13:55');
INSERT INTO `permissions` (`id`, `name`, `description`, `menu_key`, `created_at`, `updated_at`) VALUES ('8', 'View Log Aktivitas', 'Melihat log aktivitas pengguna', 'userlogin', '2025-11-22 18:13:55', '2025-11-22 18:13:55');

CREATE TABLE `prodi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_fakultas` bigint(20) unsigned NOT NULL,
  `nama_prodi` varchar(255) NOT NULL,
  `jenjang` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `ketua_prodi` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prodi_id_fakultas_foreign` (`id_fakultas`),
  KEY `prodi_ketua_prodi_foreign` (`ketua_prodi`),
  CONSTRAINT `prodi_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prodi_ketua_prodi_foreign` FOREIGN KEY (`ketua_prodi`) REFERENCES `dosen` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `prodi` (`id`, `id_fakultas`, `nama_prodi`, `jenjang`, `deskripsi`, `ketua_prodi`, `created_at`, `updated_at`) VALUES ('1', '1', 'BKPI', 'S1', '', '', '2025-11-22 18:20:29', '2025-11-25 09:22:08');
INSERT INTO `prodi` (`id`, `id_fakultas`, `nama_prodi`, `jenjang`, `deskripsi`, `ketua_prodi`, `created_at`, `updated_at`) VALUES ('2', '1', 'MPI', 'S1', '', '', '2025-11-24 02:03:38', '2025-11-25 09:21:57');
INSERT INTO `prodi` (`id`, `id_fakultas`, `nama_prodi`, `jenjang`, `deskripsi`, `ketua_prodi`, `created_at`, `updated_at`) VALUES ('3', '1', 'PGMI', 'S1', '', '', '2025-11-24 02:03:56', '2025-11-25 09:21:49');
INSERT INTO `prodi` (`id`, `id_fakultas`, `nama_prodi`, `jenjang`, `deskripsi`, `ketua_prodi`, `created_at`, `updated_at`) VALUES ('4', '1', 'PIAUD', 'S2', '', '', '2025-11-24 02:04:08', '2025-11-25 09:21:31');
INSERT INTO `prodi` (`id`, `id_fakultas`, `nama_prodi`, `jenjang`, `deskripsi`, `ketua_prodi`, `created_at`, `updated_at`) VALUES ('5', '1', 'Htn', 'S1', '', '', '2025-11-25 09:22:33', '2025-11-25 09:22:33');
INSERT INTO `prodi` (`id`, `id_fakultas`, `nama_prodi`, `jenjang`, `deskripsi`, `ketua_prodi`, `created_at`, `updated_at`) VALUES ('6', '2', 'Hki', 'S2', '', '7', '2025-11-26 06:10:17', '2025-11-26 16:54:46');

CREATE TABLE `ruangan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi` bigint(20) unsigned DEFAULT NULL,
  `tipe_ruangan` enum('sarana','prasarana') DEFAULT 'sarana',
  `unit_prasarana` varchar(255) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `fasilitas` text DEFAULT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `kondisi_ruangan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ruangan_id_prodi_foreign` (`id_prodi`),
  CONSTRAINT `ruangan_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ruangan` (`id`, `id_prodi`, `tipe_ruangan`, `unit_prasarana`, `kapasitas`, `fasilitas`, `nama_ruangan`, `kondisi_ruangan`, `created_at`, `updated_at`) VALUES ('7', '3', 'sarana', '', '', '', 'Kelas A.III', 'Rusak Ringan', '2025-11-26 02:18:54', '2025-11-26 02:18:54');
INSERT INTO `ruangan` (`id`, `id_prodi`, `tipe_ruangan`, `unit_prasarana`, `kapasitas`, `fasilitas`, `nama_ruangan`, `kondisi_ruangan`, `created_at`, `updated_at`) VALUES ('8', '', 'prasarana', 'Rektorat', '', '', 'Perpustakaan', 'Baik', '2025-11-26 02:19:20', '2025-11-26 02:19:20');
INSERT INTO `ruangan` (`id`, `id_prodi`, `tipe_ruangan`, `unit_prasarana`, `kapasitas`, `fasilitas`, `nama_ruangan`, `kondisi_ruangan`, `created_at`, `updated_at`) VALUES ('9', '1', 'sarana', '', '', '', 'Kelas B.II', 'Rusak Berat', '2025-11-26 02:33:03', '2025-11-26 02:33:03');
INSERT INTO `ruangan` (`id`, `id_prodi`, `tipe_ruangan`, `unit_prasarana`, `kapasitas`, `fasilitas`, `nama_ruangan`, `kondisi_ruangan`, `created_at`, `updated_at`) VALUES ('10', '', 'prasarana', 'Gedung Yayasan', '', '', 'Ruang Ketua Yayasan', 'Rusak Ringan', '2025-11-26 02:37:33', '2025-11-26 02:37:33');
INSERT INTO `ruangan` (`id`, `id_prodi`, `tipe_ruangan`, `unit_prasarana`, `kapasitas`, `fasilitas`, `nama_ruangan`, `kondisi_ruangan`, `created_at`, `updated_at`) VALUES ('11', '', 'prasarana', 'Rektorat', '', '', 'Ruang Warek II', 'Baik', '2025-11-26 02:39:41', '2025-11-26 02:39:41');
INSERT INTO `ruangan` (`id`, `id_prodi`, `tipe_ruangan`, `unit_prasarana`, `kapasitas`, `fasilitas`, `nama_ruangan`, `kondisi_ruangan`, `created_at`, `updated_at`) VALUES ('12', '', 'prasarana', 'Auditorium', '', '', 'Lab', 'Rusak Berat', '2025-11-26 02:40:28', '2025-11-26 02:40:28');
INSERT INTO `ruangan` (`id`, `id_prodi`, `tipe_ruangan`, `unit_prasarana`, `kapasitas`, `fasilitas`, `nama_ruangan`, `kondisi_ruangan`, `created_at`, `updated_at`) VALUES ('13', '', 'prasarana', 'Rektorat', '', '', 'Warek II', 'Rusak Ringan', '2025-11-26 03:11:41', '2025-11-26 03:11:41');

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('lVbhOo9buy1qbiGI1Skg2zib1ZDJWTlMfi0VwcUt', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTTEyd1h2c0psSm9TUlNGNXVnclNyeUlRR0pDc3FqaDE0YU5WVE5zZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ydWFuZ2FuIjtzOjU6InJvdXRlIjtzOjEzOiJydWFuZ2FuLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', '1764247097');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('tXHKHWPb9XdMqRu2tkYtrg6IPgrH9Zy7Th0Ggjqz', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSXBTT2pzNkViRlBXV3lXb3pHcmZ0Z3V1akJvTmY5MkxLYVV4VXczTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ydWFuZ2FuIjtzOjU6InJvdXRlIjtzOjEzOiJydWFuZ2FuLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', '1764225970');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('wL9kLTGO1uti73B4oHmRvhidNiFhgxtq7VjNVfD3', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnhJRWx3TnpaNm44V3VFbzNCSVFMZDlGWHpDYnJHa09ndkhZWkIyRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ydWFuZ2FuIjtzOjU6InJvdXRlIjtzOjEzOiJydWFuZ2FuLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1764246351');

CREATE TABLE `tenaga_pendidik` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_prodi` bigint(20) unsigned DEFAULT NULL,
  `nama_tendik` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `status_kepegawaian` varchar(50) DEFAULT NULL,
  `pendidikan_terakhir` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `gelar_depan` varchar(255) DEFAULT NULL,
  `gelar_belakang` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tmt_kerja` date DEFAULT NULL,
  `golongan_history` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jabatan_struktural` varchar(255) DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `file_ijazah_s1` varchar(255) DEFAULT NULL,
  `file_transkrip_s1` varchar(255) DEFAULT NULL,
  `file_ijazah_s2` varchar(255) DEFAULT NULL,
  `file_transkrip_s2` varchar(255) DEFAULT NULL,
  `file_ijazah_s3` varchar(255) DEFAULT NULL,
  `file_transkrip_s3` varchar(255) DEFAULT NULL,
  `file_kk` varchar(255) DEFAULT NULL,
  `file_perjanjian_kerja` varchar(255) DEFAULT NULL,
  `file_sk` varchar(255) DEFAULT NULL,
  `file_surat_tugas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenaga_pendidik_no_hp_unique` (`no_hp`),
  UNIQUE KEY `tenaga_pendidik_email_unique` (`email`),
  KEY `tenaga_pendidik_id_prodi_foreign` (`id_prodi`),
  CONSTRAINT `tenaga_pendidik_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tenaga_pendidik` (`id`, `id_prodi`, `nama_tendik`, `nip`, `status_kepegawaian`, `pendidikan_terakhir`, `jenis_kelamin`, `no_hp`, `email`, `alamat`, `keterangan`, `gelar_depan`, `gelar_belakang`, `tempat_lahir`, `tanggal_lahir`, `tmt_kerja`, `golongan_history`, `file`, `created_at`, `updated_at`, `jabatan_struktural`, `file_ktp`, `file_ijazah_s1`, `file_transkrip_s1`, `file_ijazah_s2`, `file_transkrip_s2`, `file_ijazah_s3`, `file_transkrip_s3`, `file_kk`, `file_perjanjian_kerja`, `file_sk`, `file_surat_tugas`) VALUES ('5', '2', 'Dewi Kartika', '12345667577', 'TETAP', 'S2', 'laki-laki', '085794586558', 'dewi.kartika@example.com', 'Jl. Cicurug, Desa. Indrajaya, Kec. Sukaratu, Kab.Tasikmalaya', '', '', 'S.Ag', 'Banjar', '2025-11-06', '2025-11-04', '\"[{\\\"tahun\\\":\\\"1992\\\",\\\"golongan\\\":\\\"2A\\\"},{\\\"tahun\\\":\\\"1994\\\",\\\"golongan\\\":\\\"2B\\\"},{\\\"tahun\\\":\\\"1777\\\",\\\"golongan\\\":\\\"2C\\\"}]\"', '20251125054120-Tendik.pdf', '2025-11-25 05:41:20', '2025-11-27 04:49:55', 'Ketua Prodi MPI', '20251127044955-file_ktp.pdf', '20251125054120-file_ijazah_s1.pdf', '20251125054120-file_transkrip_s1.pdf', '20251125054120-file_ijazah_s2.pdf', '20251125054120-file_transkrip_s2.pdf', '20251125054120-file_ijazah_s3.pdf', '20251125054120-file_transkrip_s3.pdf', '20251127044734-file_kk.pdf', '20251125054120-file_perjanjian_kerja.pdf', '20251125054120-file_sk.pdf', '20251125054120-file_surat_tugas.pdf');
INSERT INTO `tenaga_pendidik` (`id`, `id_prodi`, `nama_tendik`, `nip`, `status_kepegawaian`, `pendidikan_terakhir`, `jenis_kelamin`, `no_hp`, `email`, `alamat`, `keterangan`, `gelar_depan`, `gelar_belakang`, `tempat_lahir`, `tanggal_lahir`, `tmt_kerja`, `golongan_history`, `file`, `created_at`, `updated_at`, `jabatan_struktural`, `file_ktp`, `file_ijazah_s1`, `file_transkrip_s1`, `file_ijazah_s2`, `file_transkrip_s2`, `file_ijazah_s3`, `file_transkrip_s3`, `file_kk`, `file_perjanjian_kerja`, `file_sk`, `file_surat_tugas`) VALUES ('6', '5', 'Budi', '2023020999', 'TETAP', 'S3', 'laki-laki', '085765347664', 'budi@gmail.com', 'Jl. Cicurug, Desa. Indrajaya, Kec. Sukaratu, Kab.Tasikmalaya', '', '', 'S.Kom', 'Bandung', '2025-11-13', '2025-11-08', '\"[{\\\"tahun\\\":\\\"1992\\\",\\\"golongan\\\":\\\"2A\\\"},{\\\"tahun\\\":\\\"1994\\\",\\\"golongan\\\":\\\"2B\\\"},{\\\"tahun\\\":\\\"1777\\\",\\\"golongan\\\":\\\"2C\\\"}]\"', '', '2025-11-25 09:56:06', '2025-11-27 05:22:07', 'Ketua Prodi HTN', '', '', '', '', '', '', '', '', '', '', '');

CREATE TABLE `user_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permissions_user_id_permission_id_unique` (`user_id`,`permission_id`),
  KEY `user_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `user_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_permissions` (`id`, `user_id`, `permission_id`, `created_at`, `updated_at`) VALUES ('3', '4', '4', '', '');
INSERT INTO `user_permissions` (`id`, `user_id`, `permission_id`, `created_at`, `updated_at`) VALUES ('4', '5', '3', '', '');
INSERT INTO `user_permissions` (`id`, `user_id`, `permission_id`, `created_at`, `updated_at`) VALUES ('5', '6', '2', '', '');
INSERT INTO `user_permissions` (`id`, `user_id`, `permission_id`, `created_at`, `updated_at`) VALUES ('6', '7', '1', '', '');

CREATE TABLE `userlogin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `logged_in_at` datetime DEFAULT NULL,
  `logged_out_at` datetime DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userlogin_id_user_foreign` (`id_user`),
  CONSTRAINT `userlogin_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('1', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-22 18:15:08', '', '2025-11-22 20:01:31', '2025-11-22 18:15:08', '2025-11-22 20:01:31');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('5', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 08:54:15', '2025-11-23 11:11:14', '2025-11-23 11:11:14', '2025-11-23 08:54:15', '2025-11-23 11:11:14');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('6', '4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 10:34:20', '2025-11-23 11:11:37', '2025-11-23 11:11:37', '2025-11-23 10:34:20', '2025-11-23 11:11:37');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('7', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 11:11:22', '2025-11-23 14:46:42', '2025-11-23 14:46:42', '2025-11-23 11:11:22', '2025-11-23 14:46:42');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('8', '5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 11:12:53', '2025-11-23 11:18:22', '2025-11-23 11:18:22', '2025-11-23 11:12:53', '2025-11-23 11:18:22');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('9', '6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 11:19:33', '2025-11-23 13:06:15', '2025-11-23 13:06:15', '2025-11-23 11:19:33', '2025-11-23 13:06:15');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('10', '7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 13:06:25', '2025-11-23 13:11:39', '2025-11-23 13:11:39', '2025-11-23 13:06:25', '2025-11-23 13:11:39');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('11', '8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 13:11:56', '2025-11-23 14:34:55', '2025-11-23 14:34:55', '2025-11-23 13:11:56', '2025-11-23 14:34:55');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('12', '4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 14:35:29', '2025-11-23 14:38:51', '2025-11-23 14:38:51', '2025-11-23 14:35:29', '2025-11-23 14:38:51');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('13', '5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 14:39:09', '2025-11-23 14:41:07', '2025-11-23 14:41:07', '2025-11-23 14:39:09', '2025-11-23 14:41:07');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('14', '6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 14:41:18', '2025-11-23 14:45:19', '2025-11-23 14:45:19', '2025-11-23 14:41:18', '2025-11-23 14:45:19');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('15', '7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 14:45:29', '2025-11-23 14:46:10', '2025-11-23 14:46:10', '2025-11-23 14:45:29', '2025-11-23 14:46:10');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('16', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 14:46:53', '', '2025-11-23 15:20:49', '2025-11-23 14:46:53', '2025-11-23 15:20:49');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('17', '8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 14:47:13', '2025-11-23 14:53:38', '2025-11-23 14:53:38', '2025-11-23 14:47:13', '2025-11-23 14:53:38');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('18', '5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 14:53:56', '2025-11-23 14:55:12', '2025-11-23 14:55:12', '2025-11-23 14:53:56', '2025-11-23 14:55:12');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('19', '8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-23 14:55:25', '2025-11-23 14:57:44', '2025-11-23 14:57:44', '2025-11-23 14:55:25', '2025-11-23 14:57:44');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('20', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-23 19:18:54', '', '2025-11-23 20:13:47', '2025-11-23 19:18:54', '2025-11-23 20:13:47');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('21', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-24 01:38:14', '', '2025-11-24 10:03:27', '2025-11-24 01:38:14', '2025-11-24 10:03:27');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('22', '7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-24 03:10:09', '2025-11-24 03:15:55', '2025-11-24 03:15:55', '2025-11-24 03:10:09', '2025-11-24 03:15:55');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('23', '8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-24 03:16:33', '2025-11-24 03:18:01', '2025-11-24 03:18:01', '2025-11-24 03:16:33', '2025-11-24 03:18:01');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('24', '8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-24 06:21:02', '2025-11-24 06:21:14', '2025-11-24 06:21:14', '2025-11-24 06:21:02', '2025-11-24 06:21:14');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('25', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-25 01:31:00', '', '2025-11-25 12:44:07', '2025-11-25 01:31:00', '2025-11-25 12:44:07');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('26', '8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-25 02:36:59', '2025-11-25 02:37:53', '2025-11-25 02:37:53', '2025-11-25 02:36:59', '2025-11-25 02:37:53');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('27', '4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-25 02:38:04', '2025-11-25 02:39:42', '2025-11-25 02:39:42', '2025-11-25 02:38:04', '2025-11-25 02:39:42');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('28', '5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-25 02:39:52', '2025-11-25 02:46:26', '2025-11-25 02:46:26', '2025-11-25 02:39:52', '2025-11-25 02:46:26');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('29', '6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-25 02:46:38', '2025-11-25 02:50:36', '2025-11-25 02:50:36', '2025-11-25 02:46:38', '2025-11-25 02:50:36');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('30', '7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-25 02:50:46', '2025-11-25 02:56:18', '2025-11-25 02:56:18', '2025-11-25 02:50:46', '2025-11-25 02:56:18');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('31', '8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-25 08:52:25', '', '2025-11-25 09:30:23', '2025-11-25 08:52:25', '2025-11-25 09:30:23');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('32', '1', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2025-11-26 01:34:28', '', '2025-11-26 06:47:21', '2025-11-26 01:34:28', '2025-11-26 06:47:21');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('33', '4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', '2025-11-26 03:44:10', '', '2025-11-26 04:32:18', '2025-11-26 03:44:10', '2025-11-26 04:32:18');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('34', '1', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2025-11-26 11:07:32', '', '2025-11-26 11:37:45', '2025-11-26 11:07:32', '2025-11-26 11:37:45');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('35', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-26 16:43:48', '', '2025-11-26 17:15:17', '2025-11-26 16:43:48', '2025-11-26 17:15:17');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('36', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-27 01:46:20', '', '2025-11-27 06:46:03', '2025-11-27 01:46:20', '2025-11-27 06:46:03');
INSERT INTO `userlogin` (`id`, `id_user`, `ip_address`, `user_agent`, `logged_in_at`, `logged_out_at`, `last_activity`, `created_at`, `updated_at`) VALUES ('37', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-27 12:27:58', '', '2025-11-27 12:38:17', '2025-11-27 12:27:58', '2025-11-27 12:38:17');

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'staf',
  `menu_key` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `role`, `menu_key`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Superadmin', 'superadmin@gmail.com', '', 'superadmin', 'all', '', '$2y$12$PQzm46YyN.F.lQAFcZpN0.G4adB6PJv8VGbi2FsO9DCfBU1rIqICS', 'QGOzX441tWoutwoxMqTfZRliLn6F7enr5ZyNUdoH03uwxI7jEb8RzrxziDBk', '2025-11-22 18:14:53', '2025-11-24 06:28:27');
INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `role`, `menu_key`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'Puji Haryadi', 'puji@gmail.com', '', 'admin', '', '', '$2y$12$da/.PO2QBqaa9R9zBgk41efBm1l2muFJ1qn0T9qPy7q9W9.4/zTdi', '', '2025-11-23 10:33:47', '2025-11-23 10:33:47');
INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `role`, `menu_key`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('5', 'Asep', 'asep@gmail.com', '', 'admin', '', '', '$2y$12$4lefi43YZ6lz5Iyb1vTc3uqQ.9wyRwcWXCFhTbh7l2YjJxJ3M53Hy', '', '2025-11-23 11:12:39', '2025-11-23 11:12:39');
INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `role`, `menu_key`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('6', 'Nurtia', 'nurtia@gmail.com', '', 'admin', '', '', '$2y$12$bA3jUVaAD4jUS6PtA3yfhecxA21m4EIyUde5aHFA4RkAg6El6WTGC', '', '2025-11-23 11:19:15', '2025-11-23 11:19:15');
INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `role`, `menu_key`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('7', 'Dimas', 'dimas@gmail.com', '', 'admin', '', '', '$2y$12$DAqTELi1bPrMXXb3oV85Bu147s79YAUHFTz9.sB2.XSr6STGWjpFK', '', '2025-11-23 13:06:05', '2025-11-23 13:06:05');
INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `role`, `menu_key`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('8', 'Arafian', 'arafian@gmail.com', '', 'user', '', '', '$2y$12$3JYRjpM7kpkjrcG80t3kQOLDSCD.P7Ab8T/n4WKZd3gFAncC4dILK', '', '2025-11-23 13:11:31', '2025-11-23 13:11:31');

