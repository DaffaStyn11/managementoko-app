# Setup Fitur Produk

## Langkah-langkah Setup

### 1. Jalankan Migration
```bash
php artisan migrate:fresh
```

### 2. Jalankan Seeder
```bash
php artisan db:seed
```

Atau jalankan seeder spesifik:
```bash
php artisan db:seed --class=KategoriSeeder
php artisan db:seed --class=ProdukSeeder
```

### 3. Akses Halaman Produk
Buka browser dan akses: `http://localhost:8000/produk`

## Fitur yang Tersedia

✅ **CRUD Lengkap**
- Tambah produk baru dengan auto-generate kode produk
- Edit produk
- Hapus produk
- Lihat daftar produk dengan relasi kategori

✅ **Field Produk**
- Kode Produk (auto-generate: PRD00001, PRD00002, dst)
- Nama Produk
- Kategori (relasi dengan tabel kategoris)
- Deskripsi
- Harga Beli & Harga Jual
- Stok & Stok Minimum
- Satuan (pcs, kg, liter, box, pack, lusin)
- Barcode
- Status Aktif/Nonaktif

✅ **Fitur Tambahan**
- Indikator stok rendah (merah jika stok <= stok minimum)
- Status aktif/nonaktif produk
- Validasi form lengkap
- Alert notifikasi
- Statistik: Total Produk, Total Stok, Total Kategori
- Tombol Export Excel & PDF (UI ready)

✅ **Data Default**
10 produk sample dari berbagai kategori:
1. Smartphone Samsung Galaxy A54
2. Laptop ASUS VivoBook 14
3. Kaos Polos Cotton Combed
4. Celana Jeans Pria
5. Beras Premium 5kg
6. Minyak Goreng 2 Liter
7. Shampoo Anti Ketombe 200ml
8. Sabun Mandi Cair 500ml
9. Panci Set Stainless Steel
10. Bola Sepak Size 5

## Route yang Tersedia

- `GET /produk` - Daftar produk
- `GET /produk/create` - Form tambah produk
- `POST /produk` - Simpan produk baru
- `GET /produk/{id}/edit` - Form edit produk
- `PUT /produk/{id}` - Update produk
- `DELETE /produk/{id}` - Hapus produk

## Model Features

- Relasi `belongsTo` dengan Kategori
- Method `isStokRendah()` untuk cek stok rendah
- Accessor `margin` untuk hitung margin keuntungan
- Accessor `marginPersen` untuk hitung persentase margin
- Cast otomatis untuk harga (decimal) dan status (boolean)
