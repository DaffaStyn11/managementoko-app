# IMPLEMENTASI LARAVEL EXCEL - EXPORT LAPORAN

## STATUS: ✅ SELESAI

## OVERVIEW
Implementasi export Excel menggunakan **Maatwebsite Laravel Excel** package dengan format XLSX profesional, styling lengkap, dan structure yang proper.

---

## PACKAGE INSTALLATION

### Install via Composer
```bash
composer require maatwebsite/excel
```

### Publish Config (Optional)
```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

**Config File**: `config/excel.php`

---

## EXPORT CLASS

### File: `app/Exports/LaporanExport.php`

#### Implements
- `FromArray` - Data source dari array
- `WithHeadings` - Header kolom tabel
- `WithMapping` - Format data per row
- `WithStyles` - Styling cell (warna, border, font)
- `WithColumnWidths` - Lebar kolom
- `WithTitle` - Nama sheet Excel

#### Constructor
```php
public function __construct(array $laporanData, $totalPenjualan, $totalPembelian, $selisih)
{
    $this->laporanData = $laporanData;
    $this->totalPenjualan = $totalPenjualan;
    $this->totalPembelian = $totalPembelian;
    $this->selisih = $selisih;
}
```

#### Methods

**1. array(): array**
- Return data yang akan di-export
- Data dari `$this->laporanData`

**2. headings(): array**
- Return header kolom
- ['No', 'Kategori', 'Deskripsi', 'Nominal', 'Tanggal']

**3. map($row): array**
- Format setiap row data
- Auto-increment nomor
- Format nominal dengan "Rp" dan thousand separator

**4. styles(Worksheet $sheet)**
- Styling header: Background biru, text putih, bold, center
- Border pada semua cell
- Alignment: Center untuk No, Right untuk Nominal
- Summary section di bawah tabel dengan warna

**5. columnWidths(): array**
- A: 8 (No)
- B: 15 (Kategori)
- C: 45 (Deskripsi)
- D: 20 (Nominal)
- E: 15 (Tanggal)

**6. title(): string**
- Return "Laporan Keuangan"
- Nama sheet di Excel

---

## CONTROLLER

### File: `app/Http/Controllers/ExportController.php`

#### Method: laporanExcel()

```php
public function laporanExcel(Request $request)
{
    // Get data dari LaporanController
    $controller = app(LaporanController::class);
    $data = $controller->index($request);
    $viewData = $data->getData();
    
    // Extract data
    $laporanData = $viewData['laporanData']->toArray();
    $totalPenjualan = $viewData['totalPenjualan'];
    $totalPembelian = $viewData['totalPembelian'];
    $selisih = $viewData['selisih'];
    
    // Generate filename
    $filename = 'laporan_' . date('YmdHis') . '.xlsx';
    
    // Download Excel
    return Excel::download(
        new LaporanExport($laporanData, $totalPenjualan, $totalPembelian, $selisih),
        $filename
    );
}
```

#### Import Required
```php
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
```

---

## STYLING DETAILS

### Header Row (Row 1)
- **Background**: #4F46E5 (Indigo)
- **Text Color**: #FFFFFF (White)
- **Font**: Bold, Size 12
- **Alignment**: Center (Horizontal & Vertical)
- **Border**: Thin border semua sisi

### Data Rows (Row 2+)
- **Border**: Thin border semua sisi, warna #CCCCCC
- **Alignment**: 
  - Kolom A (No): Center
  - Kolom D (Nominal): Right
  - Lainnya: Default (Left)

### Summary Section (Di bawah tabel)
- **Header "RINGKASAN"**:
  - Merged cells A-E
  - Background: #E5E7EB (Gray)
  - Font: Bold, Size 14
  - Alignment: Center

- **Total Penjualan**:
  - Label: Bold
  - Value: Bold, Color #10B981 (Green), Right align

- **Total Pembelian**:
  - Label: Bold
  - Value: Bold, Color #EF4444 (Red), Right align

- **Selisih**:
  - Label: Bold
  - Value: Bold, Color dinamis (Green jika positif, Red jika negatif), Right align

---

## VIEW INTEGRATION

### File: `resources/views/pages/laporan/index.blade.php`

#### Tombol Export Excel
```blade
<a href="{{ route('laporan.export.excel', request()->all()) }}"
    class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm shadow">
    <i data-feather="file-text" class="w-4 h-4"></i>
    <span>Export Excel</span>
</a>
```

**Note**: `request()->all()` akan pass semua filter (jenis, periode, tanggal) ke export

---

## ROUTES

### File: `routes/web.php`

```php
Route::get('/laporan/export-excel', [ExportController::class, 'laporanExcel'])
    ->name('laporan.export.excel');
```

---

## WORKFLOW

### 1. User Click Export Button
- User di halaman `/laporan`
- (Optional) User pilih filter
- User klik tombol "Export Excel"

### 2. Request ke Controller
- Request dikirim ke `ExportController@laporanExcel`
- Query string filter ikut dikirim

### 3. Get Data
- Controller call `LaporanController@index` dengan request
- Extract data: laporanData, totalPenjualan, totalPembelian, selisih

### 4. Create Export Instance
- Instantiate `LaporanExport` dengan data
- Pass ke `Excel::download()`

### 5. Generate Excel
- Laravel Excel generate file XLSX
- Apply styling dari `styles()` method
- Set column widths dari `columnWidths()` method
- Set sheet title dari `title()` method

### 6. Download File
- Browser download file `laporan_YmdHis.xlsx`
- User bisa langsung buka dengan Excel

---

## FEATURES

### ✅ Data Features
- Auto-increment nomor
- Format nominal dengan "Rp" dan thousand separator
- Format tanggal dari database
- Summary section dengan total penjualan, pembelian, selisih

### ✅ Styling Features
- Header berwarna dengan text putih
- Border pada semua cell
- Alignment otomatis (center, right)
- Column width auto-adjusted
- Warna dinamis untuk summary (hijau/merah)

### ✅ Technical Features
- Class-based export (maintainable)
- Implements multiple concerns (modular)
- Filter support (periode, jenis)
- Native XLSX format (no conversion needed)
- PhpSpreadsheet under the hood (powerful)

---

## TESTING

### Manual Test
1. Buka browser: `http://localhost:8000/laporan`
2. (Optional) Pilih filter:
   - Jenis: Penjualan
   - Periode: Bulan Ini
3. Klik tombol "Export Excel"
4. File `laporan_20251209HHMMSS.xlsx` akan ter-download
5. Buka dengan Microsoft Excel atau Google Sheets
6. Verify:
   - ✅ Header berwarna biru dengan text putih
   - ✅ Border pada semua cell
   - ✅ Nomor center aligned
   - ✅ Nominal right aligned dengan format Rp
   - ✅ Summary section di bawah dengan warna
   - ✅ Sheet name "Laporan Keuangan"

### Test dengan Filter
```
URL: /laporan/export-excel?jenis=penjualan&periode=bulan_ini
```

### Test tanpa Filter
```
URL: /laporan/export-excel
```

---

## COMPARISON: CSV vs XLSX

### CSV (Old)
- ❌ Format plain text
- ❌ No styling
- ❌ No colors
- ❌ No borders
- ❌ Manual column width adjustment
- ✅ Lightweight
- ✅ Universal compatibility

### XLSX (New)
- ✅ Native Excel format
- ✅ Full styling support
- ✅ Colors, borders, fonts
- ✅ Auto column width
- ✅ Multiple sheets support
- ✅ Professional appearance
- ✅ No conversion needed
- ⚠️ Slightly larger file size

---

## DEPENDENCIES

### Composer Packages
```json
{
    "require": {
        "maatwebsite/excel": "^3.1"
    }
}
```

### Sub-dependencies (Auto-installed)
- `phpoffice/phpspreadsheet`: ^1.30
- `maennchen/zipstream-php`: ^3.1
- `markbaker/complex`: ^3.0
- `markbaker/matrix`: ^3.0
- `ezyang/htmlpurifier`: ^4.19

---

## CONFIGURATION

### File: `config/excel.php`

#### Key Configs
```php
'exports' => [
    'chunk_size' => 1000,
    'pre_calculate_formulas' => false,
    'strict_null_comparison' => false,
],

'extension_detector' => [
    'xlsx' => Excel::XLSX,
    'xlsm' => Excel::XLSX,
    'xltx' => Excel::XLSX,
    'xltm' => Excel::XLSX,
    'xls' => Excel::XLS,
    'csv' => Excel::CSV,
],
```

---

## TROUBLESHOOTING

### Issue: "Class 'Excel' not found"
**Solution**: Import facade
```php
use Maatwebsite\Excel\Facades\Excel;
```

### Issue: "Call to undefined method toArray()"
**Solution**: Convert collection to array
```php
$laporanData = $viewData['laporanData']->toArray();
```

### Issue: Styling tidak muncul
**Solution**: Pastikan return empty array di akhir `styles()` method
```php
public function styles(Worksheet $sheet)
{
    // ... styling code ...
    return [];
}
```

### Issue: Column width tidak berubah
**Solution**: Pastikan return array dengan key kolom (A, B, C, dst)
```php
public function columnWidths(): array
{
    return [
        'A' => 8,
        'B' => 15,
        // ...
    ];
}
```

---

## BEST PRACTICES

### 1. Separate Export Logic
✅ Create dedicated Export class
❌ Don't put export logic in Controller

### 2. Use Concerns
✅ Implement multiple concerns for modularity
❌ Don't create monolithic export class

### 3. Format Data in map()
✅ Format data in `map()` method
❌ Don't format in view or controller

### 4. Apply Styles in styles()
✅ Apply all styling in `styles()` method
❌ Don't mix styling with data logic

### 5. Pass Filter to Export
✅ Pass request to controller, let it handle filter
❌ Don't duplicate filter logic in export

---

## FUTURE ENHANCEMENTS

### Possible Improvements
- [ ] Add charts to Excel
- [ ] Multiple sheets (Penjualan, Pembelian separate)
- [ ] Add formulas (SUM, AVERAGE)
- [ ] Add conditional formatting
- [ ] Add data validation
- [ ] Export to PDF via Excel
- [ ] Schedule automatic export
- [ ] Email export hasil

---

## DOCUMENTATION LINKS

### Official Docs
- Laravel Excel: https://docs.laravel-excel.com/
- PhpSpreadsheet: https://phpspreadsheet.readthedocs.io/

### Package Repository
- GitHub: https://github.com/SpartnerNL/Laravel-Excel

---

## CONCLUSION

✅ Export Excel berhasil diimplementasikan dengan Maatwebsite Laravel Excel
✅ Format XLSX dengan styling profesional
✅ Class-based structure yang maintainable
✅ Filter support untuk periode dan jenis laporan
✅ Summary section dengan warna dinamis
✅ Ready for production use

---

**Created**: 9 Desember 2025
**Package Version**: Maatwebsite Laravel Excel v3.1.67
**Status**: PRODUCTION READY ✅
