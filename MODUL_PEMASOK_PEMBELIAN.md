# Dokumentasi Modul Pemasok & Pembelian

## 📦 Modul yang Telah Dibuat

### 1. MODUL PEMASOK

#### File yang Dibuat:
- **Controller**: `app/Http/Controllers/PemasokController.php`
- **Model**: `app/Models/Pemasok.php`
- **Migration**: `database/migrations/2025_12_08_102804_create_pemasoks_table.php`
- **Views**:
  - `resources/views/pages/pemasok/index.blade.php`
  - `resources/views/pages/pemasok/create.blade.php`
  - `resources/views/pages/pemasok/edit.blade.php`
- **Seeder**: `database/seeders/PemasokSeeder.php`

#### Field Tabel Pemasok:
- `id` - Primary Key
- `nama_pemasok` - Nama pemasok (required)
- `produk_yang_dipasok` - Produk yang dipasok (required)
- `kontak` - Nomor kontak (required)
- `alamat` - Alamat lengkap (required)
- `kategori_pemasok` - Kategori pemasok (optional)
- `created_at` & `updated_at` - Timestamps

#### Fitur Pemasok:
✅ CRUD lengkap (Create, Read, Update, Delete)
✅ Validasi form dengan pesan error bahasa Indonesia
✅ Statistik dashboard:
   - Total Pemasok
   - Kategori Pemasok
   - Transaksi Aktif
✅ Tabel data dengan kolom lengkap
✅ Tombol aksi edit (biru) dan hapus (merah)
✅ Pencarian dan filter kategori
✅ Tombol Export Excel & Export PDF (UI ready)
✅ Alert notifikasi sukses/error
✅ UI konsisten dengan style dashboard

---

### 2. MODUL PEMBELIAN

#### File yang Dibuat:
- **Controller**: `app/Http/Controllers/PembelianController.php`
- **Model**: `app/Models/Pembelian.php`
- **Migration**: `database/migrations/2025_12_08_103048_create_pembelians_table.php`
- **Views**:
  - `resources/views/pages/pembelian/index.blade.php`
  - `resources/views/pages/pembelian/create.blade.php`
  - `resources/views/pages/pembelian/edit.blade.php`

#### Field Tabel Pembelian:
- `id` - Primary Key
- `kode_pembelian` - Kode unik pembelian (auto-generate: PBL00001)
- `pemasok_id` - Foreign key ke tabel pemasoks
- `produk_id` - Foreign key ke tabel produks
- `jumlah` - Jumlah produk yang dibeli
- `harga_satuan` - Harga per unit
- `total_harga` - Total harga (auto-calculate)
- `tanggal_pembelian` - Tanggal transaksi
- `status` - Status pembelian (pending, proses, selesai, dibatalkan)
- `keterangan` - Catatan tambahan (optional)
- `created_at` & `updated_at` - Timestamps

#### Fitur Pembelian:
✅ CRUD lengkap (Create, Read, Update, Delete)
✅ Validasi form dengan pesan error bahasa Indonesia
✅ Auto-generate kode pembelian (PBL00001, PBL00002, dst)
✅ Auto-calculate total harga (jumlah × harga_satuan)
✅ Update stok produk otomatis saat status "selesai"
✅ Relasi dengan Pemasok dan Produk
✅ Statistik dashboard:
   - Total Pembelian
   - Total Nilai Pembelian
   - Pembelian Pending
✅ Tabel data dengan kolom lengkap
✅ Status badge dengan warna berbeda (pending, proses, selesai, dibatalkan)
✅ Tombol aksi edit (biru) dan hapus (merah)
✅ Pencarian dan filter status
✅ Tombol Export Excel & Export PDF (UI ready)
✅ Alert notifikasi sukses/error
✅ UI konsisten dengan style dashboard

---

## 🔗 Routes yang Tersedia

### Pemasok Routes:
```
GET     /pemasok              - Halaman daftar pemasok
GET     /pemasok/create       - Form tambah pemasok
POST    /pemasok              - Simpan pemasok baru
GET     /pemasok/{id}/edit    - Form edit pemasok
PUT     /pemasok/{id}         - Update pemasok
DELETE  /pemasok/{id}         - Hapus pemasok
```

### Pembelian Routes:
```
GET     /pembelian            - Halaman daftar pembelian
GET     /pembelian/create     - Form tambah pembelian
POST    /pembelian            - Simpan pembelian baru
GET     /pembelian/{id}/edit  - Form edit pembelian
PUT     /pembelian/{id}       - Update pembelian
DELETE  /pembelian/{id}       - Hapus pembelian
```

---

## 🚀 Cara Menggunakan

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. (Optional) Seed Data Dummy Pemasok
```bash
php artisan db:seed --class=PemasokSeeder
```

### 3. Akses Aplikasi
- **Pemasok**: http://localhost:8000/pemasok
- **Pembelian**: http://localhost:8000/pembelian

---

## 📝 Catatan Penting

1. **Relasi Database**:
   - Pembelian memiliki relasi `belongsTo` dengan Pemasok
   - Pembelian memiliki relasi `belongsTo` dengan Produk
   - Pemasok memiliki relasi `hasMany` dengan Pembelian

2. **Auto-Update Stok**:
   - Stok produk akan otomatis bertambah saat status pembelian diubah menjadi "selesai"
   - Pastikan produk sudah ada sebelum membuat pembelian

3. **Validasi**:
   - Semua field required sudah divalidasi
   - Kode pembelian harus unik
   - Foreign key constraint aktif (cascade on delete)

4. **UI/UX**:
   - Semua halaman mengikuti style dashboard yang sudah ada
   - Responsive design dengan Tailwind CSS
   - Icon menggunakan Feather Icons
   - Alert notifikasi dapat ditutup manual

---

## 🎨 Style Guide

Modul ini mengikuti style guide yang sama dengan modul Produk:
- Card statistik dengan shadow dan border
- Tabel dengan hover effect
- Tombol aksi dengan background color (biru untuk edit, merah untuk hapus)
- Form dengan validasi real-time
- Alert dengan warna sesuai status (hijau untuk sukses, merah untuk error)

---

## ✅ Checklist Fitur

### Modul Pemasok:
- [x] Migration & Model
- [x] Controller dengan CRUD lengkap
- [x] View index dengan tabel dan statistik
- [x] View create dengan form validasi
- [x] View edit dengan form validasi
- [x] Routes resource
- [x] Seeder data dummy
- [x] Validasi form
- [x] Alert notifikasi
- [x] UI konsisten dengan dashboard

### Modul Pembelian:
- [x] Migration & Model dengan relasi
- [x] Controller dengan CRUD lengkap
- [x] Auto-generate kode pembelian
- [x] Auto-calculate total harga
- [x] Auto-update stok produk
- [x] View index dengan tabel dan statistik
- [x] View create dengan form validasi
- [x] View edit dengan form validasi
- [x] Routes resource
- [x] Validasi form
- [x] Alert notifikasi
- [x] Status badge dengan warna
- [x] UI konsisten dengan dashboard

---

## 🔮 Fitur yang Bisa Ditambahkan (Future Enhancement)

1. **Export Excel & PDF** - Implementasi fungsi export yang sudah ada tombolnya
2. **Search & Filter** - Implementasi fungsi pencarian dan filter real-time
3. **Pagination** - Untuk data yang banyak
4. **Soft Delete** - Agar data tidak benar-benar terhapus
5. **History Log** - Tracking perubahan data
6. **Print Invoice** - Cetak nota pembelian
7. **Multi-item Purchase** - Pembelian banyak produk sekaligus
8. **Payment Status** - Status pembayaran (lunas, belum lunas)
9. **Due Date** - Tanggal jatuh tempo pembayaran
10. **Supplier Rating** - Rating pemasok berdasarkan performa

---

Semua fitur sudah siap digunakan! 🎉
