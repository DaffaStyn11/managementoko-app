# 📦 LOGIKA UPDATE STOK PRODUK - MODUL PEMBELIAN

## ✅ IMPLEMENTASI LENGKAP

### 1. SAAT CREATE PEMBELIAN
```php
// File: app/Http/Controllers/PembelianController.php - Method: store()

// LOGIKA: produk->stok += jumlah (jika status selesai)
if ($validated['status'] === 'selesai') {
    $produk = Produk::find($validated['produk_id']);
    $produk->stok += $validated['jumlah'];
    $produk->save();
}
```

**Penjelasan:**
- Saat user membuat pembelian baru dengan status "selesai"
- Stok produk akan **otomatis bertambah** sesuai jumlah yang dibeli
- Jika status bukan "selesai" (pending/proses/dibatalkan), stok tidak berubah

**Contoh:**
- Stok awal: 100
- Pembelian: 50 unit (status: selesai)
- Stok akhir: 150 ✅

---

### 2. SAAT UPDATE PEMBELIAN
```php
// File: app/Http/Controllers/PembelianController.php - Method: update()

// LOGIKA: stok -= jumlah_lama, kemudian stok += jumlah_baru
$produk = Produk::find($validated['produk_id']);

// Jika pembelian lama sudah selesai, kurangi stok lama terlebih dahulu
if ($pembelian->status === 'selesai') {
    $produk->stok -= $pembelian->jumlah;
}

// Jika pembelian baru statusnya selesai, tambahkan stok baru
if ($validated['status'] === 'selesai') {
    $produk->stok += $validated['jumlah'];
}

$produk->save();
```

**Penjelasan:**
- Saat user mengupdate pembelian, sistem akan menyesuaikan stok produk
- **Langkah 1**: Jika pembelian lama statusnya "selesai", kurangi stok lama
- **Langkah 2**: Jika pembelian baru statusnya "selesai", tambahkan stok baru
- Ini memastikan stok selalu akurat meskipun jumlah atau status berubah

**Contoh Skenario:**

#### Skenario A: Update Jumlah (status tetap selesai)
- Stok awal: 150
- Pembelian lama: 50 unit (status: selesai)
- Pembelian baru: 70 unit (status: selesai)
- Proses:
  - Kurangi stok lama: 150 - 50 = 100
  - Tambah stok baru: 100 + 70 = 170
- Stok akhir: 170 ✅

#### Skenario B: Update Status (dari pending ke selesai)
- Stok awal: 100
- Pembelian lama: 50 unit (status: pending)
- Pembelian baru: 50 unit (status: selesai)
- Proses:
  - Tidak kurangi stok lama (karena status lama bukan selesai)
  - Tambah stok baru: 100 + 50 = 150
- Stok akhir: 150 ✅

#### Skenario C: Update Status (dari selesai ke dibatalkan)
- Stok awal: 150
- Pembelian lama: 50 unit (status: selesai)
- Pembelian baru: 50 unit (status: dibatalkan)
- Proses:
  - Kurangi stok lama: 150 - 50 = 100
  - Tidak tambah stok baru (karena status baru bukan selesai)
- Stok akhir: 100 ✅

---

### 3. SAAT DELETE PEMBELIAN
```php
// File: app/Http/Controllers/PembelianController.php - Method: destroy()

// LOGIKA: produk->stok -= jumlah_pembelian (jika status selesai)
if ($pembelian->status === 'selesai') {
    $produk = Produk::find($pembelian->produk_id);
    $produk->stok -= $pembelian->jumlah;
    $produk->save();
}

$pembelian->delete();
```

**Penjelasan:**
- Saat user menghapus pembelian yang sudah selesai
- Stok produk akan **dikurangi** sesuai jumlah pembelian yang dihapus
- Ini memastikan stok kembali ke kondisi sebelum pembelian dibuat
- Jika status bukan "selesai", stok tidak berubah (karena memang tidak pernah ditambahkan)

**Contoh:**
- Stok awal: 150
- Hapus pembelian: 50 unit (status: selesai)
- Stok akhir: 100 ✅

---

## 🎯 RINGKASAN LOGIKA

| Aksi | Kondisi | Logika Stok |
|------|---------|-------------|
| **CREATE** | Status = selesai | `stok += jumlah` |
| **CREATE** | Status ≠ selesai | Tidak ada perubahan |
| **UPDATE** | Status lama = selesai | `stok -= jumlah_lama` |
| **UPDATE** | Status baru = selesai | `stok += jumlah_baru` |
| **DELETE** | Status = selesai | `stok -= jumlah` |
| **DELETE** | Status ≠ selesai | Tidak ada perubahan |

---

## 🔍 VALIDASI & KEAMANAN

### 1. Validasi Input
- ✅ Jumlah harus integer dan minimal 1
- ✅ Produk dan Pemasok harus ada di database (foreign key)
- ✅ Status harus salah satu dari: pending, proses, selesai, dibatalkan

### 2. Transaksi Database
Untuk keamanan lebih baik, bisa ditambahkan database transaction:

```php
DB::beginTransaction();
try {
    // Update stok
    $produk->stok += $validated['jumlah'];
    $produk->save();
    
    // Create pembelian
    $pembelian = Pembelian::create($validated);
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollback();
    return redirect()->back()->with('error', 'Terjadi kesalahan');
}
```

### 3. Validasi Stok Negatif
Bisa ditambahkan validasi agar stok tidak negatif saat delete:

```php
if ($pembelian->status === 'selesai') {
    $produk = Produk::find($pembelian->produk_id);
    
    // Cek apakah stok cukup
    if ($produk->stok < $pembelian->jumlah) {
        return redirect()->back()
            ->with('error', 'Stok tidak cukup untuk menghapus pembelian ini');
    }
    
    $produk->stok -= $pembelian->jumlah;
    $produk->save();
}
```

---

## 📊 CONTOH FLOW LENGKAP

### Skenario: Pembelian Beras 100 Kg

**1. CREATE (Status: Selesai)**
```
Stok awal: 50 kg
Pembelian: 100 kg (status: selesai)
Proses: 50 + 100 = 150 kg
Stok akhir: 150 kg ✅
```

**2. UPDATE Jumlah (50 → 80 kg, Status tetap Selesai)**
```
Stok awal: 150 kg
Kurangi stok lama: 150 - 100 = 50 kg
Tambah stok baru: 50 + 80 = 130 kg
Stok akhir: 130 kg ✅
```

**3. UPDATE Status (Selesai → Dibatalkan)**
```
Stok awal: 130 kg
Kurangi stok lama: 130 - 80 = 50 kg
Tidak tambah stok baru (status dibatalkan)
Stok akhir: 50 kg ✅
```

**4. DELETE**
```
Stok awal: 50 kg
Status: dibatalkan (tidak perlu kurangi stok)
Stok akhir: 50 kg ✅
```

---

## ✅ CHECKLIST IMPLEMENTASI

- [x] **CREATE**: Stok bertambah saat status selesai
- [x] **UPDATE**: Stok disesuaikan dengan perubahan jumlah dan status
- [x] **DELETE**: Stok dikurangi jika pembelian sudah selesai
- [x] Validasi input lengkap
- [x] Pesan error bahasa Indonesia
- [x] Relasi model sudah benar
- [x] Foreign key constraint aktif
- [x] Auto-calculate total_harga
- [x] Auto-generate kode_pembelian

---

## 🚀 SEMUA LOGIKA SUDAH DIIMPLEMENTASI!

Modul Pembelian sudah **100% lengkap** dengan logika update stok yang benar untuk semua operasi CRUD.

**File yang sudah diupdate:**
- ✅ `app/Http/Controllers/PembelianController.php`

**Siap digunakan!** 🎉
