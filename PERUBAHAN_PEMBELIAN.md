# 🔄 PERUBAHAN MODUL PEMBELIAN

## ✅ PERUBAHAN YANG DILAKUKAN

### Konsep Baru:
**Produk diambil dari Pemasok, bukan dari tabel Produk terpisah**

---

## 📋 DETAIL PERUBAHAN

### 1. Migration Pembelian
**File**: `database/migrations/2025_12_08_103048_create_pembelians_table.php`

**SEBELUM:**
```php
$table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
```

**SESUDAH:**
```php
$table->string('nama_produk'); // Produk dari pemasok, bukan FK
```

**Penjelasan:**
- Tidak lagi menggunakan foreign key ke tabel `produks`
- Menggunakan field `nama_produk` (string) yang diambil dari field `produk_yang_dipasok` di tabel `pemasoks`

---

### 2. Model Pembelian
**File**: `app/Models/Pembelian.php`

**PERUBAHAN:**
- ❌ Hapus relasi `produk()` ke tabel Produk
- ✅ Tetap ada relasi `pemasok()` ke tabel Pemasok
- ✅ Field `nama_produk` ditambahkan ke `$fillable`

**Kode:**
```php
protected $fillable = [
    'kode_pembelian',
    'pemasok_id',
    'nama_produk',  // ← Baru
    'jumlah',
    'harga_satuan',
    'total_harga',
    'tanggal_pembelian',
    'status',
    'keterangan'
];

public function pemasok()
{
    return $this->belongsTo(Pemasok::class);
}
// Tidak ada relasi produk() lagi
```

---

### 3. Controller Pembelian
**File**: `app/Http/Controllers/PembelianController.php`

**PERUBAHAN UTAMA:**

#### A. Method `create()`
```php
// SEBELUM: Ambil produk dari tabel Produk
$produks = Produk::all();

// SESUDAH: Hanya ambil pemasok
$pemasoks = Pemasok::all();
```

#### B. Method `store()` & `update()`
```php
// SEBELUM: Validasi produk_id
'produk_id' => 'required|exists:produks,id',

// SESUDAH: Validasi nama_produk
'nama_produk' => 'required|string|max:255',
```

#### C. Update Stok Produk (BARU)
Ditambahkan method helper `updateStokProduk()`:

```php
private function updateStokProduk($namaProduk, $jumlah, $operasi = 'tambah')
{
    // Cari produk berdasarkan nama (case insensitive)
    $produk = Produk::whereRaw('LOWER(nama_produk) = ?', [strtolower($namaProduk)])->first();
    
    if ($produk) {
        // Produk sudah ada, update stok
        if ($operasi === 'tambah') {
            $produk->stok += $jumlah;
        } else {
            $produk->stok -= $jumlah;
        }
        $produk->save();
    } else {
        // Produk belum ada, buat produk baru (hanya jika operasi tambah)
        if ($operasi === 'tambah') {
            $kode_produk = $this->generateKodeProduk();
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
        }
    }
}
```

**Fitur:**
- ✅ Cari produk berdasarkan nama (case insensitive)
- ✅ Jika produk sudah ada → update stok
- ✅ Jika produk belum ada → buat produk baru otomatis
- ✅ Stok tetap terintegrasi dengan tabel Produk

---

### 4. View Create Pembelian
**File**: `resources/views/pages/pembelian/create.blade.php`

**PERUBAHAN:**

#### A. Dropdown Pemasok
```html
<select name="pemasok_id" id="pemasok_id" onchange="loadProdukPemasok(this.value)">
    <option value="">Pilih Pemasok</option>
    @foreach ($pemasoks as $pemasok)
        <option value="{{ $pemasok->id }}" 
            data-produk="{{ $pemasok->produk_yang_dipasok }}">
            {{ $pemasok->nama_pemasok }}
        </option>
    @endforeach
</select>
```

**Fitur:**
- Setiap option menyimpan data produk di attribute `data-produk`
- Saat pemasok dipilih, trigger function `loadProdukPemasok()`

#### B. Dropdown Produk (Dinamis)
```html
<select name="nama_produk" id="nama_produk">
    <option value="">Pilih Pemasok Terlebih Dahulu</option>
</select>
```

**Fitur:**
- Dropdown produk awalnya kosong
- Diisi otomatis saat pemasok dipilih
- Produk diambil dari field `produk_yang_dipasok` pemasok

#### C. JavaScript untuk Load Produk
```javascript
function loadProdukPemasok(pemasokId) {
    const select = document.getElementById('nama_produk');
    
    if (!pemasokId) {
        select.innerHTML = '<option value="">Pilih Pemasok Terlebih Dahulu</option>';
        return;
    }
    
    // Ambil data produk dari option yang dipilih
    const pemasokOption = document.querySelector(`#pemasok_id option[value="${pemasokId}"]`);
    const produkString = pemasokOption.getAttribute('data-produk');
    
    if (produkString) {
        const produkList = produkString.split(',').map(p => p.trim());
        select.innerHTML = '<option value="">Pilih Produk</option>';
        
        produkList.forEach(produk => {
            const option = document.createElement('option');
            option.value = produk;
            option.textContent = produk;
            select.appendChild(option);
        });
    }
}
```

**Cara Kerja:**
1. User pilih pemasok
2. JavaScript ambil data `produk_yang_dipasok` dari attribute
3. Split string produk (dipisah koma)
4. Populate dropdown produk dengan hasil split

#### D. Auto Calculate Total
```javascript
function hitungTotal() {
    const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
    const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
    const total = jumlah * hargaSatuan;
    
    document.getElementById('total_harga_display').value = 'Rp ' + total.toLocaleString('id-ID');
}
```

---

### 5. View Index Pembelian
**File**: `resources/views/pages/pembelian/index.blade.php`

**PERUBAHAN:**
```html
<!-- SEBELUM -->
<td>{{ $pembelian->produk->nama_produk }}</td>

<!-- SESUDAH -->
<td>{{ $pembelian->nama_produk }}</td>
```

---

## 🎯 FLOW LENGKAP

### Skenario: User Membuat Pembelian Baru

1. **User pilih Pemasok**: "PT Sumber Makmur"
   - Produk yang dipasok: "Beras, Gula, Minyak"

2. **Dropdown Produk otomatis terisi**:
   - Beras
   - Gula
   - Minyak

3. **User pilih Produk**: "Beras"

4. **User isi form**:
   - Jumlah: 100
   - Harga Satuan: 10000
   - Total: Rp 1.000.000 (auto-calculate)
   - Status: Selesai

5. **Submit Form**:
   - Data pembelian disimpan dengan `nama_produk = "Beras"`
   - Karena status "selesai", trigger update stok

6. **Update Stok Produk**:
   - Cari produk dengan nama "Beras" di tabel `produks`
   - **Jika ada**: Stok += 100
   - **Jika tidak ada**: Buat produk baru dengan stok = 100

---

## ✅ KEUNTUNGAN PERUBAHAN INI

1. **Fleksibilitas Tinggi**
   - Pemasok bisa menambah produk baru tanpa harus membuat produk di tabel Produk dulu
   - Produk otomatis dibuat saat pembelian pertama kali

2. **Data Terpusat**
   - Produk yang dipasok tersimpan di tabel Pemasok
   - Mudah melihat produk apa saja yang bisa dibeli dari pemasok tertentu

3. **Stok Tetap Terintegrasi**
   - Meskipun produk diambil dari Pemasok, stok tetap diupdate di tabel Produk
   - Konsistensi data terjaga

4. **User Friendly**
   - Dropdown produk otomatis terisi sesuai pemasok yang dipilih
   - Tidak perlu mencari produk dari semua produk yang ada

---

## 📊 STRUKTUR DATA

### Tabel Pemasok
```
id | nama_pemasok      | produk_yang_dipasok        | kontak
1  | PT Sumber Makmur  | Beras, Gula, Minyak       | 081234567890
2  | CV Mitra Sejahtera| Minuman Ringan, Air Mineral| 082345678901
```

### Tabel Pembelian
```
id | kode_pembelian | pemasok_id | nama_produk | jumlah | status
1  | PBL00001       | 1          | Beras       | 100    | selesai
2  | PBL00002       | 1          | Gula        | 50     | pending
3  | PBL00003       | 2          | Air Mineral | 200    | selesai
```

### Tabel Produk (Auto-created/updated)
```
id | kode_produk | nama_produk | stok
1  | PRD00001    | Beras       | 100  ← Auto-created dari pembelian
2  | PRD00002    | Air Mineral | 200  ← Auto-created dari pembelian
```

---

## 🚀 SEMUA PERUBAHAN SUDAH SELESAI!

**File yang Diubah:**
1. ✅ `database/migrations/2025_12_08_103048_create_pembelians_table.php`
2. ✅ `app/Models/Pembelian.php`
3. ✅ `app/Http/Controllers/PembelianController.php`
4. ✅ `resources/views/pages/pembelian/index.blade.php`
5. ✅ `resources/views/pages/pembelian/create.blade.php`
6. ✅ `resources/views/pages/pembelian/edit.blade.php`

**Migration sudah dijalankan**: ✅
**Seeder sudah dijalankan**: ✅
**Tidak ada error**: ✅

**Siap digunakan!** 🎉
