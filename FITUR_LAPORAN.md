# FITUR LAPORAN - COMPLETED ✅

## Overview
Halaman Laporan menampilkan ringkasan transaksi penjualan dan pembelian dengan perhitungan selisih otomatis.

## Formula Perhitungan
```
Selisih = Total Penjualan - Total Pembelian
```

## Fitur Utama

### 1. Statistik Real-Time
- **Total Penjualan**: Sum dari semua transaksi penjualan (warna hijau)
- **Total Pembelian**: Sum dari semua transaksi pembelian dengan status "selesai" (warna merah)
- **Selisih**: Penjualan - Pembelian (hijau jika positif, merah jika negatif)

### 2. Filter Laporan
- **Jenis Laporan**: Semua / Penjualan / Pembelian
- **Periode**:
  - Hari Ini (default)
  - Minggu Ini
  - Bulan Ini
  - Tahun Ini
  - Custom (pilih tanggal manual)

### 3. Tabel Ringkasan
Menampilkan data transaksi dengan kolom:
- No
- Kategori (badge: hijau untuk penjualan, merah untuk pembelian)
- Deskripsi (nama produk + detail)
- Nominal (+ untuk penjualan, - untuk pembelian)
- Tanggal

### 4. Fitur Tambahan
- Search real-time pada tabel
- Export Excel & PDF (tombol sudah tersedia)
- Total transaksi di footer tabel
- Empty state jika tidak ada data

## Files Created/Modified

### Controller
- `app/Http/Controllers/LaporanController.php`
  - Method `index()`: Menampilkan laporan dengan filter
  - Method `getQueryByPeriode()`: Generate query berdasarkan periode
  - Method `getLaporanData()`: Ambil data penjualan & pembelian

### Routes
- `routes/web.php`: Route laporan menggunakan LaporanController

### View
- `resources/views/pages/laporan/index.blade.php`: UI laporan dengan filter dan tabel dinamis

## Logika Data

### Data Penjualan
```php
Penjualan::sum('total_harga') // Total penjualan
```

### Data Pembelian
```php
Pembelian::where('status', 'selesai')->sum('total_harga') // Total pembelian
```

### Selisih
```php
$selisih = $totalPenjualan - $totalPembelian;
```

## Cara Penggunaan

1. Akses halaman: `/laporan`
2. Pilih filter yang diinginkan (jenis, periode, tanggal)
3. Klik tombol "Filter"
4. Lihat statistik dan tabel ringkasan
5. Gunakan search untuk mencari transaksi tertentu

## Status
✅ Controller created
✅ Routes registered
✅ View updated with dynamic data
✅ Filter functionality working
✅ Search functionality added
✅ No diagnostics errors
