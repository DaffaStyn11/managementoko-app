# TROUBLESHOOTING - Halaman Kategori

## MASALAH
Button "Tambah Kategori" dan "Edit" tidak berfungsi / tidak bisa mengambil data

---

## DIAGNOSIS

### ✅ Yang Sudah Dicek:
1. **Routes** - ✅ Terdaftar dengan benar
   ```
   GET /kategori/create → kategori.create
   GET /kategori/{id}/edit → kategori.edit
   ```

2. **Files** - ✅ Semua ada
   - `resources/views/pages/kategori/create.blade.php` ✅
   - `resources/views/pages/kategori/edit.blade.php` ✅
   - `resources/views/pages/kategori/index.blade.php` ✅

3. **Controller** - ✅ Methods ada
   - `create()` ✅
   - `edit()` ✅
   - `store()` ✅
   - `update()` ✅

---

## KEMUNGKINAN PENYEBAB

### 1. Server Laravel Tidak Running
**Gejala**: Button tidak redirect, halaman tidak berubah

**Solusi**:
```bash
# Start Laravel server
php artisan serve
```

Akses: `http://localhost:8000/kategori`

---

### 2. Error 404 Not Found
**Gejala**: Klik button muncul error 404

**Solusi**:
```bash
# Clear route cache
php artisan route:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear

# Restart server
php artisan serve
```

---

### 3. JavaScript Error
**Gejala**: Button tidak respond sama sekali

**Solusi**:
1. Buka browser Developer Tools (F12)
2. Check tab Console untuk error
3. Pastikan Feather Icons loaded:
   ```javascript
   // Di console browser, test:
   feather.replace()
   ```

---

### 4. CSRF Token Missing
**Gejala**: Form submit error 419

**Solusi**:
Pastikan di `create.blade.php` dan `edit.blade.php` ada:
```blade
@csrf
```

---

### 5. Database Connection Error
**Gejala**: Error saat load halaman

**Solusi**:
```bash
# Check database connection
php artisan migrate:status

# Jika error, check .env file:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

## TESTING MANUAL

### Test Button "Tambah Kategori"
1. Buka browser: `http://localhost:8000/kategori`
2. Klik button "Tambah Kategori"
3. **Expected**: Redirect ke `/kategori/create`
4. **Actual**: ?

### Test Button "Edit"
1. Buka browser: `http://localhost:8000/kategori`
2. Klik icon edit (pensil) di salah satu row
3. **Expected**: Redirect ke `/kategori/{id}/edit`
4. **Actual**: ?

### Test Form Submit
1. Buka `/kategori/create`
2. Isi form:
   - Nama Kategori: "Test"
   - Deskripsi: "Test deskripsi"
3. Klik "Simpan"
4. **Expected**: Redirect ke `/kategori` dengan success message
5. **Actual**: ?

---

## QUICK FIX

### Jika Button Tidak Berfungsi Sama Sekali:

1. **Restart Everything**:
```bash
# Stop server (Ctrl+C)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan serve
```

2. **Hard Refresh Browser**:
   - Windows: `Ctrl + Shift + R`
   - Mac: `Cmd + Shift + R`

3. **Check Browser Console**:
   - Press `F12`
   - Go to Console tab
   - Look for errors (red text)

---

## VERIFICATION CHECKLIST

### Server Side:
- [ ] Laravel server running (`php artisan serve`)
- [ ] Routes registered (`php artisan route:list --name=kategori`)
- [ ] Database connected (`php artisan migrate:status`)
- [ ] No errors in `storage/logs/laravel.log`

### Client Side:
- [ ] No JavaScript errors in browser console
- [ ] Feather icons loaded (icons visible)
- [ ] Links have correct href attribute
- [ ] CSRF token present in forms

### Files:
- [ ] `resources/views/pages/kategori/index.blade.php` exists
- [ ] `resources/views/pages/kategori/create.blade.php` exists
- [ ] `resources/views/pages/kategori/edit.blade.php` exists
- [ ] `app/Http/Controllers/KategoriController.php` exists

---

## EXPECTED BEHAVIOR

### Button "Tambah Kategori":
```html
<a href="{{ route('kategori.create') }}" ...>
```
- Should redirect to: `/kategori/create`
- Should show: Create form page

### Button "Edit":
```html
<a href="{{ route('kategori.edit', $kategori) }}" ...>
```
- Should redirect to: `/kategori/{id}/edit`
- Should show: Edit form page with data pre-filled

### Form Submit:
- Create: POST to `/kategori`
- Update: PUT to `/kategori/{id}`
- Should redirect back to `/kategori` with success message

---

## DEBUGGING STEPS

### Step 1: Check URL
Saat klik button, perhatikan URL di address bar:
- Apakah URL berubah?
- Apakah URL benar? (misal: `/kategori/create`)

### Step 2: Check Network Tab
1. Buka Developer Tools (F12)
2. Go to Network tab
3. Klik button
4. Lihat request yang dikirim:
   - Status code: 200 (OK), 404 (Not Found), 500 (Server Error)?
   - Response: HTML page atau error message?

### Step 3: Check Laravel Log
```bash
# View last 50 lines of log
tail -n 50 storage/logs/laravel.log
```

Look for errors related to:
- Route not found
- Controller method not found
- Database errors
- Validation errors

---

## COMMON ERRORS & SOLUTIONS

### Error: "Route [kategori.create] not defined"
**Solution**:
```bash
php artisan route:clear
php artisan config:clear
```

### Error: "Class 'App\Http\Controllers\KategoriController' not found"
**Solution**:
```bash
composer dump-autoload
```

### Error: "View [pages.kategori.create] not found"
**Solution**:
Check file exists: `resources/views/pages/kategori/create.blade.php`

### Error: "SQLSTATE[HY000] [2002] Connection refused"
**Solution**:
1. Start MySQL/MariaDB service
2. Check `.env` database credentials

---

## CONTACT INFORMATION

Jika masalah masih berlanjut, berikan informasi berikut:

1. **Error Message** (screenshot atau copy-paste)
2. **Browser Console Errors** (F12 → Console tab)
3. **Laravel Log** (last 20 lines dari `storage/logs/laravel.log`)
4. **URL** yang diakses
5. **Expected behavior** vs **Actual behavior**

---

**Created**: 9 Desember 2025
**Status**: Troubleshooting Guide
