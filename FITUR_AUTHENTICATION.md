# Fitur Authentication dengan Laravel Sanctum

## 📋 Overview
Implementasi sistem authentication lengkap menggunakan Laravel Sanctum untuk aplikasi ManagemenToko.

## ✅ Fitur yang Diimplementasikan

### 1. **Login System**
- Form login dengan validasi
- Session-based authentication
- Error handling untuk kredensial salah
- Auto redirect ke dashboard setelah login
- Session regeneration untuk keamanan

### 2. **Register System**
- Form registrasi user baru
- Validasi email unique
- Password confirmation
- Auto login setelah registrasi berhasil

### 3. **Logout System**
- Logout dengan session invalidation
- CSRF token regeneration
- Redirect ke halaman login

### 4. **Protected Routes**
- Middleware `auth` untuk route yang memerlukan login
- Middleware `guest` untuk route authentication (login/register)
- Auto redirect jika sudah login

## 📁 File yang Dibuat/Dimodifikasi

### Controllers
- `app/Http/Controllers/AuthController.php` - Handle semua proses authentication

### Models
- `app/Models/User.php` - Ditambahkan trait `HasApiTokens` untuk Sanctum

### Middleware
- `app/Http/Middleware/RedirectIfAuthenticated.php` - Redirect user yang sudah login
- `app/Http/Middleware/EncryptCookies.php` - Encrypt cookies
- `bootstrap/app.php` - Konfigurasi middleware

### Views
- `resources/views/auth/login.blade.php` - Halaman login (updated)
- `resources/views/auth/register.blade.php` - Halaman registrasi (new)
- `resources/views/auth/reset-password.blade.php` - Halaman reset password (new)

### Routes
- `routes/web.php` - Route authentication dan protected routes

### Database
- `database/seeders/UserSeeder.php` - Seeder untuk user testing
- `database/seeders/DatabaseSeeder.php` - Updated untuk call UserSeeder

## 🔐 User Testing (Seeder)

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin Account
- **Email:** admin@managementoko.com
- **Password:** password123

### Demo Account
- **Email:** demo@managementoko.com
- **Password:** demo123

### Test Account
- **Email:** test@example.com
- **Password:** test123

## 🚀 Cara Menggunakan

### 1. Jalankan Migration (jika belum)
```bash
php artisan migrate
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=UserSeeder
```

Atau jalankan semua seeder:
```bash
php artisan db:seed
```

### 3. Akses Aplikasi
- Login: `http://localhost:8000/login`
- Register: `http://localhost:8000/register`
- Dashboard: `http://localhost:8000/dashboard` (protected)

## 🔒 Route Protection

### Guest Routes (hanya untuk yang belum login)
```php
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm']);
    Route::post('/register', [AuthController::class, 'register']);
});
```

### Protected Routes (harus login)
```php
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('produk', ProdukController::class);
    // ... semua route lainnya
});
```

## 🎨 UI Features

### Login Page
- Modern design dengan Tailwind CSS
- Form validation dengan error messages
- Link ke register dan reset password
- Responsive design

### Register Page
- Form lengkap (name, email, password, password confirmation)
- Real-time validation
- Auto login setelah registrasi

### Reset Password Page
- Form untuk request reset password link
- Link kembali ke login

## 🔧 Konfigurasi

### Auth Guard (config/auth.php)
```php
'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],
```

### Sanctum (untuk API - opsional)
Jika ingin menggunakan API authentication:
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

## 📝 Catatan Penting

1. **Session-based Authentication**: Menggunakan session Laravel standar, bukan token API
2. **CSRF Protection**: Semua form POST dilindungi dengan CSRF token
3. **Password Hashing**: Password di-hash menggunakan bcrypt
4. **Validation**: Semua input divalidasi sebelum diproses
5. **Security**: Session regeneration setelah login untuk mencegah session fixation

## 🔄 Flow Authentication

### Login Flow
1. User mengakses `/login`
2. User memasukkan email & password
3. System validasi kredensial
4. Jika valid: login user, regenerate session, redirect ke dashboard
5. Jika invalid: tampilkan error message

### Register Flow
1. User mengakses `/register`
2. User mengisi form (name, email, password, password confirmation)
3. System validasi input (email unique, password min 8 karakter)
4. Jika valid: buat user baru, auto login, redirect ke dashboard
5. Jika invalid: tampilkan error message

### Logout Flow
1. User klik logout
2. System hapus session
3. Invalidate session & regenerate token
4. Redirect ke login page

## 🛠️ Troubleshooting

### Error: "Session store not set"
```bash
php artisan config:clear
php artisan cache:clear
```

### Error: "CSRF token mismatch"
- Pastikan form memiliki `@csrf`
- Clear browser cache
- Regenerate app key: `php artisan key:generate`

### User tidak bisa login
- Cek database apakah user sudah ada
- Cek password sudah di-hash dengan benar
- Jalankan seeder ulang jika perlu

## 📚 Referensi
- [Laravel Authentication](https://laravel.com/docs/12.x/authentication)
- [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
- [Laravel Session](https://laravel.com/docs/12.x/session)
