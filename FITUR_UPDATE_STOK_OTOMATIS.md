# 📦 FITUR UPDATE STOK OTOMATIS - PEMBELIAN KE PRODUK

## ✅ FITUR SUDAH AKTIF!

Saat melakukan pembelian di **Halaman Pembelian**, stok produk di **Halaman Produk** akan **otomatis bertambah**.

---

## 🎯 CARA KERJA

### 1. CREATE PEMBELIAN (Tambah Pembelian Baru)

**Kondisi:** Status pembelian = "Selesai"

**Proses:**
```
User buat pembelian → Status "Selesai" → Stok produk bertambah otomatis
```

**Kode:**
```php
// File: PembelianController.php - Method: store()

if ($validated['status'] === 'selesai') {
    $this->updateStokProduk($validated['nama_produk'], $validated['jumlah'], 'tambah');
}
```

**Contoh:**
```
Pembelian:
- Produk: Beras
- Jumlah: 100
- Status: Selesai

Hasil di Tabel Produk:
- Stok Beras: +100 ✅
```

---

### 2. UPDATE PEMBELIAN (Edit Pembelian)

**Proses:**
```
1. Jika pembelian lama status "Selesai" → Kurangi stok lama
2. Jika pembelian baru status "Selesai" → Tambah stok baru
```

**Kode:**
```php
// File: PembelianController.php - Method: update()

// Kurangi stok lama jika status lama = selesai
if ($pembelian->status === 'selesai') {
    $this->updateStokProduk($pembelian->nama_produk, $pembelian->jumlah, 'kurang');
}

// Tambah stok baru jika status baru = selesai
if ($validated['status'] === 'selesai') {
    $this->updateStokProduk($validated['nama_produk'], $validated['jumlah'], 'tambah');
}
```

**Contoh Skenario:**

#### Skenario A: Update Jumlah (Status tetap Selesai)
```
Pembelian Lama:
- Produk: Beras
- Jumlah: 100
- Status: Selesai
- Stok Beras saat ini: 500

Pembelian Baru:
- Produk: Beras
- Jumlah: 150
- Status: Selesai

Proses:
1. Kurangi stok lama: 500 - 100 = 400
2. Tambah stok baru: 400 + 150 = 550

Hasil: Stok Beras = 550 ✅
```

#### Skenario B: Update Status (Pending → Selesai)
```
Pembelian Lama:
- Produk: Gula
- Jumlah: 50
- Status: Pending
- Stok Gula saat ini: 200

Pembelian Baru:
- Produk: Gula
- Jumlah: 50
- Status: Selesai

Proses:
1. Tidak kurangi stok lama (status lama bukan selesai)
2. Tambah stok baru: 200 + 50 = 250

Hasil: Stok Gula = 250 ✅
```

#### Skenario C: Update Status (Selesai → Dibatalkan)
```
Pembelian Lama:
- Produk: Minyak
- Jumlah: 30
- Status: Selesai
- Stok Minyak saat ini: 100

Pembelian Baru:
- Produk: Minyak
- Jumlah: 30
- Status: Dibatalkan

Proses:
1. Kurangi stok lama: 100 - 30 = 70
2. Tidak tambah stok baru (status baru bukan selesai)

Hasil: Stok Minyak = 70 ✅
```

---

### 3. DELETE PEMBELIAN (Hapus Pembelian)

**Kondisi:** Status pembelian = "Selesai"

**Proses:**
```
Hapus pembelian → Jika status "Selesai" → Stok produk berkurang
```

**Kode:**
```php
// File: PembelianController.php - Method: destroy()

if ($pembelian->status === 'selesai') {
    $this->updateStokProduk($pembelian->nama_produk, $pembelian->jumlah, 'kurang');
}
```

**Contoh:**
```
Pembelian yang dihapus:
- Produk: Beras
- Jumlah: 100
- Status: Selesai
- Stok Beras saat ini: 550

Hasil: Stok Beras = 550 - 100 = 450 ✅
```

---

## 🔍 METHOD `updateStokProduk()` - DETAIL

### Fungsi Utama:
1. **Cari produk** berdasarkan nama (case insensitive)
2. **Jika produk ada** → Update stok
3. **Jika produk tidak ada** → Buat produk baru otomatis

### Kode Lengkap:
```php
private function updateStokProduk($namaProduk, $jumlah, $operasi = 'tambah')
{
    // 1. Cari produk berdasarkan nama (case insensitive)
    $produk = Produk::whereRaw('LOWER(nama_produk) = ?', [strtolower($namaProduk)])->first();
    
    if ($produk) {
        // 2. Produk sudah ada, update stok
        if ($operasi === 'tambah') {
            $produk->stok += $jumlah;
        } else {
            $produk->stok -= $jumlah;
        }
        $produk->save();
    } else {
        // 3. Produk belum ada, buat produk baru (hanya jika operasi tambah)
        if ($operasi === 'tambah') {
            try {
                $kode_produk = $this->generateKodeProduk();
                
                // Double check: pastikan kode produk belum ada
                $maxAttempts = 10;
                $attempt = 0;
                while (Produk::where('kode_produk', $kode_produk)->exists() && $attempt < $maxAttempts) {
                    $kode_produk = $this->generateKodeProduk();
                    $attempt++;
                }
                
                Produk::create([
                    'kode_produk' => $kode_produk,
                    'nama_produk' => $namaProduk,
                    'kategori_id' => 1, // Default kategori
                    'harga_beli' => 0,
                    'harga_jual' => 0,
                    'stok' => $jumlah,
                    'stok_minimum' => 10,
                    'satuan' => 'pcs',
                    'is_active' => true
                ]);
            } catch (\Exception $e) {
                \Log::error('Error creating product: ' . $e->getMessage());
            }
        }
    }
}
```

### Fitur Keamanan:
- ✅ **Case Insensitive**: "Beras" = "beras" = "BERAS"
- ✅ **Auto Create**: Produk baru dibuat otomatis jika belum ada
- ✅ **Double Check**: Cek duplikasi kode produk (max 10 attempts)
- ✅ **Error Handling**: Try-catch untuk mencegah crash
- ✅ **Logging**: Error dicatat di log file

---

## 📊 FLOW DIAGRAM

```
┌─────────────────────────────────────────────────────────────┐
│                    USER BUAT PEMBELIAN                      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
                ┌───────────────────────┐
                │  Status = "Selesai"?  │
                └───────────────────────┘
                    │               │
                   YES             NO
                    │               │
                    ▼               ▼
        ┌──────────────────┐   ┌──────────────┐
        │ Update Stok      │   │ Tidak Update │
        │ Produk           │   │ Stok         │
        └──────────────────┘   └──────────────┘
                    │
                    ▼
        ┌──────────────────────┐
        │ Cari Produk di DB    │
        └──────────────────────┘
                    │
        ┌───────────┴───────────┐
        │                       │
    Produk Ada           Produk Tidak Ada
        │                       │
        ▼                       ▼
┌──────────────┐      ┌──────────────────┐
│ Update Stok  │      │ Buat Produk Baru │
│ stok += qty  │      │ stok = qty       │
└──────────────┘      └──────────────────┘
        │                       │
        └───────────┬───────────┘
                    ▼
        ┌──────────────────────┐
        │ Stok Berhasil Update │
        └──────────────────────┘
```

---

## 🎯 CONTOH LENGKAP

### Skenario: Pembelian Beras dari PT Sumber Makmur

#### Step 1: Buat Pembelian
```
Form Pembelian:
- Pemasok: PT Sumber Makmur
- Produk: Beras
- Jumlah: 100
- Harga Satuan: 10000
- Total: Rp 1.000.000
- Status: Selesai
- Tanggal: 08/12/2025
```

#### Step 2: Submit Form
```
Controller: PembelianController@store()
1. Validasi data ✅
2. Hitung total_harga: 100 × 10000 = 1.000.000 ✅
3. Simpan pembelian ke database ✅
4. Cek status = "Selesai" → YES ✅
5. Panggil updateStokProduk('Beras', 100, 'tambah') ✅
```

#### Step 3: Update Stok Produk
```
Method: updateStokProduk()
1. Cari produk "Beras" di database
   
   Kasus A: Produk "Beras" sudah ada (stok = 50)
   → Update: stok = 50 + 100 = 150 ✅
   
   Kasus B: Produk "Beras" belum ada
   → Buat produk baru:
     - Kode: PRD00001
     - Nama: Beras
     - Stok: 100
     - Kategori: Default (ID 1)
     - Harga Beli: 0
     - Harga Jual: 0
     - Satuan: pcs
     - Status: Aktif ✅
```

#### Step 4: Hasil
```
Tabel Pembelian:
┌──────┬────────────┬─────────────────┬────────┬────────┬─────────┐
│ Kode │ Tanggal    │ Pemasok         │ Produk │ Jumlah │ Status  │
├──────┼────────────┼─────────────────┼────────┼────────┼─────────┤
│ PBL1 │ 08/12/2025 │ PT Sumber Makmur│ Beras  │ 100    │ Selesai │
└──────┴────────────┴─────────────────┴────────┴────────┴─────────┘

Tabel Produk:
┌──────────┬────────────┬──────┬────────────┬────────────┬──────┐
│ Kode     │ Nama       │ Stok │ Harga Beli │ Harga Jual │ Stat │
├──────────┼────────────┼──────┼────────────┼────────────┼──────┤
│ PRD00001 │ Beras      │ 150  │ 0          │ 0          │ Aktif│
└──────────┴────────────┴──────┴────────────┴────────────┴──────┘
                         ↑
                    Stok bertambah 100! ✅
```

---

## 📋 CHECKLIST FITUR

### CREATE Pembelian
- ✅ Status "Selesai" → Stok bertambah
- ✅ Status "Pending/Proses/Dibatalkan" → Stok tidak berubah
- ✅ Produk sudah ada → Update stok
- ✅ Produk belum ada → Buat produk baru + set stok

### UPDATE Pembelian
- ✅ Status lama "Selesai" → Kurangi stok lama
- ✅ Status baru "Selesai" → Tambah stok baru
- ✅ Update jumlah → Stok disesuaikan
- ✅ Update produk → Stok disesuaikan

### DELETE Pembelian
- ✅ Status "Selesai" → Stok berkurang
- ✅ Status "Pending/Proses/Dibatalkan" → Stok tidak berubah

### Keamanan
- ✅ Case insensitive search
- ✅ Auto create produk baru
- ✅ Double check kode produk
- ✅ Error handling
- ✅ Logging

---

## 🚀 CARA TESTING

### Test 1: Buat Pembelian Baru (Status Selesai)
1. Buka halaman Pembelian
2. Klik "Tambah Pembelian"
3. Pilih Pemasok: "PT Sumber Makmur"
4. Pilih Produk: "Beras"
5. Isi Jumlah: 100
6. Isi Harga Satuan: 10000
7. Pilih Status: "Selesai"
8. Submit
9. **Cek Halaman Produk** → Stok Beras bertambah 100 ✅

### Test 2: Buat Pembelian Baru (Status Pending)
1. Buat pembelian dengan status "Pending"
2. **Cek Halaman Produk** → Stok tidak berubah ✅

### Test 3: Update Pembelian (Pending → Selesai)
1. Edit pembelian yang status "Pending"
2. Ubah status menjadi "Selesai"
3. Submit
4. **Cek Halaman Produk** → Stok bertambah ✅

### Test 4: Update Pembelian (Selesai → Dibatalkan)
1. Edit pembelian yang status "Selesai"
2. Ubah status menjadi "Dibatalkan"
3. Submit
4. **Cek Halaman Produk** → Stok berkurang ✅

### Test 5: Hapus Pembelian (Status Selesai)
1. Hapus pembelian yang status "Selesai"
2. **Cek Halaman Produk** → Stok berkurang ✅

---

## ✅ FITUR SUDAH AKTIF DAN SIAP DIGUNAKAN!

**Tidak perlu konfigurasi tambahan, fitur sudah otomatis berjalan!** 🎉

**File yang Mengatur:**
- ✅ `app/Http/Controllers/PembelianController.php`

**Setiap kali pembelian dengan status "Selesai":**
- ✅ Stok produk di tabel Produk otomatis bertambah
- ✅ Jika produk belum ada, otomatis dibuat
- ✅ Semua operasi CRUD (Create, Update, Delete) sudah terintegrasi

**Silakan dicoba!** 🚀
