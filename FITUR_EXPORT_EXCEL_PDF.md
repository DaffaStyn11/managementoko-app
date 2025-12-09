# FITUR EXPORT EXCEL & PDF - IMPLEMENTATION GUIDE

## Overview
Menambahkan fitur export Excel (CSV) dan PDF (HTML) pada semua halaman kecuali Dashboard.

## Halaman yang Mendapat Fitur Export
1. Kategori
2. Produk
3. Pemasok
4. Stok
5. Penjualan
6. Pembelian
7. Laporan

## Implementasi Sederhana (Tanpa Library Eksternal)

### Metode Export

#### 1. Export Excel (CSV Format)
- Format: CSV dengan UTF-8 BOM
- Kompatibel dengan Microsoft Excel
- Tidak memerlukan library eksternal
- Response type: `text/csv`

#### 2. Export PDF (HTML Format)
- Format: HTML yang bisa di-print sebagai PDF
- Menggunakan browser's print to PDF
- Tidak memerlukan library eksternal
- Response type: `text/html`

## Langkah Implementasi

### Step 1: Tambahkan Method di Controller

Contoh untuk KategoriController:

```php
public function exportExcel()
{
    $kategoris = Kategori::latest()->get();
    
    $filename = 'kategori_' . date('YmdHis') . '.csv';
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function() use ($kategoris) {
        $file = fopen('php://output', 'w');
        
        // UTF-8 BOM for Excel
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($file, ['No', 'Nama Kategori', 'Deskripsi', 'Tanggal Dibuat']);
        
        // Data
        foreach ($kategoris as $index => $kategori) {
            fputcsv($file, [
                $index + 1,
                $kategori->nama_kategori,
                $kategori->deskripsi ?? '-',
                $kategori->created_at->format('d/m/Y H:i')
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function exportPdf()
{
    $kategoris = Kategori::latest()->get();
    
    $html = view('exports.kategori-pdf', compact('kategoris'))->render();
    
    return response($html)
        ->header('Content-Type', 'text/html')
        ->header('Content-Disposition', 'inline; filename="kategori_' . date('YmdHis') . '.html"');
}
```

### Step 2: Tambahkan Routes

```php
// Kategori Export
Route::get('/kategori/export-excel', [KategoriController::class, 'exportExcel'])->name('kategori.export.excel');
Route::get('/kategori/export-pdf', [KategoriController::class, 'exportPdf'])->name('kategori.export.pdf');

// Produk Export
Route::get('/produk/export-excel', [ProdukController::class, 'exportExcel'])->name('produk.export.excel');
Route::get('/produk/export-pdf', [ProdukController::class, 'exportPdf'])->name('produk.export.pdf');

// Dan seterusnya untuk controller lainnya...
```

### Step 3: Update Button di View

Ganti button static dengan link ke route export:

```blade
{{-- Export Excel --}}
<a href="{{ route('kategori.export.excel') }}"
    class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm shadow">
    <i data-feather="file-text" class="w-4 h-4"></i>
    <span>Export Excel</span>
</a>

{{-- Export PDF --}}
<a href="{{ route('kategori.export.pdf') }}" target="_blank"
    class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm shadow">
    <i data-feather="file" class="w-4 h-4"></i>
    <span>Export PDF</span>
</a>
```

### Step 4: Buat View Template PDF

Buat folder `resources/views/exports/` dan file template untuk setiap halaman.

Contoh `kategori-pdf.blade.php`:

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Kategori</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .date { text-align: right; color: #666; }
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Data Kategori</h1>
        <p class="date">Dicetak: {{ date('d/m/Y H:i') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $index => $kategori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>{{ $kategori->deskripsi ?? '-' }}</td>
                <td>{{ $kategori->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <button onclick="window.print()" style="margin-top: 20px; padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer;">
        Print / Save as PDF
    </button>
</body>
</html>
```

## Keuntungan Metode Ini

1. **Tidak Perlu Library Eksternal** - Menggunakan fitur native PHP dan Laravel
2. **Ringan** - Tidak menambah dependencies
3. **Mudah Maintain** - Code sederhana dan mudah dipahami
4. **Kompatibel** - CSV bisa dibuka di Excel, HTML bisa di-print ke PDF
5. **Cepat** - Tidak ada overhead dari library besar

## Kekurangan

1. **Format Terbatas** - CSV tidak support formatting, HTML perlu di-print manual
2. **Tidak Ada Styling Excel** - Tidak bisa membuat Excel dengan warna/formula
3. **PDF Manual** - User harus print to PDF sendiri dari browser

## Alternatif (Jika Ingin Library)

Jika ingin menggunakan library setelah fix PHP extensions:

```bash
# Install extensions yang dibutuhkan
# Aktifkan di php.ini:
# extension=gd
# extension=zip

# Kemudian install
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf
```

## Status Implementasi

### PERUBAHAN: Export Hanya di Halaman Laporan

Berdasarkan permintaan user, fitur export Excel dan PDF **HANYA** tersedia di halaman Laporan.

Halaman lain (Kategori, Produk, Pemasok, Stok, Penjualan, Pembelian) **TIDAK** memiliki tombol export.

### Implementasi Final

✅ **Laporan** - Export Excel & PDF (AKTIF)
- Route: `/laporan/export-excel` dan `/laporan/export-pdf`
- Controller: `ExportController@laporanExcel` dan `ExportController@laporanPdf`
- View: Tombol export tersedia di `resources/views/pages/laporan/index.blade.php`

❌ **Kategori** - Export dihapus
❌ **Produk** - Export dihapus
❌ **Pemasok** - Export dihapus
❌ **Stok** - Export dihapus
❌ **Penjualan** - Export dihapus
❌ **Pembelian** - Export dihapus

## Next Steps

1. Tambahkan method export di semua controller
2. Update semua routes
3. Buat template PDF untuk setiap halaman
4. Update button di semua view
5. Test export functionality
