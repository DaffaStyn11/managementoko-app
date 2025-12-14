# Fitur Halaman Profil

## 📋 Overview
Halaman profil lengkap yang memungkinkan user untuk mengelola informasi akun dan keamanan mereka.

## ✅ Fitur yang Diimplementasikan

### 1. **Tampilan Profil**
- Avatar dengan inisial nama
- Informasi nama dan email
- Tanggal bergabung
- Design modern dengan Tailwind CSS

### 2. **Update Informasi Profil**
- Edit nama lengkap
- Edit email (dengan validasi unique)
- Validasi form
- Success message setelah update

### 3. **Ubah Password**
- Verifikasi password lama
- Input password baru
- Konfirmasi password baru
- Validasi minimal 8 karakter
- Success message setelah update

### 4. **Header Update**
- Menampilkan nama user yang login
- Menampilkan email di dropdown
- Link ke halaman profil
- Logout button dengan POST method

## 📁 File yang Dibuat/Dimodifikasi

### Controller
```
app/Http/Controllers/ProfileController.php
```
- `index()` - Tampilkan halaman profil
- `update()` - Update nama dan email
- `updatePassword()` - Update password

### Views
```
resources/views/profile/index.blade.php
```
Halaman profil dengan:
- Card profil user
- Form update informasi
- Form ubah password
- Success/error messages

### Routes
```
routes/web.php
```
```php
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
```

### Header Component
```
resources/views/components/header.blade.php
```
- Menampilkan nama user dinamis
- Link ke halaman profil
- Dropdown dengan info user

## 🎨 Tampilan Halaman Profil

### Layout
```
┌─────────────────────────────────────────────┐
│  Profil Saya                                │
├─────────────┬───────────────────────────────┤
│             │                               │
│  [Avatar]   │  Informasi Profil             │
│   Nama      │  ┌─────────────────────────┐  │
│   Email     │  │ Nama: [input]           │  │
│   Joined    │  │ Email: [input]          │  │
│             │  │ [Simpan Perubahan]      │  │
│             │  └─────────────────────────┘  │
│             │                               │
│             │  Ubah Password                │
│             │  ┌─────────────────────────┐  │
│             │  │ Password Lama: [input]  │  │
│             │  │ Password Baru: [input]  │  │
│             │  │ Konfirmasi: [input]     │  │
│             │  │ [Update Password]       │  │
│             │  └─────────────────────────┘  │
└─────────────┴───────────────────────────────┘
```

## 🚀 Cara Menggunakan

### 1. Akses Halaman Profil
- Klik avatar/nama di header
- Pilih "Profil Saya"
- Atau akses: `http://localhost:8000/profile`

### 2. Update Informasi Profil
1. Edit nama atau email
2. Klik "Simpan Perubahan"
3. Akan muncul notifikasi sukses

### 3. Ubah Password
1. Masukkan password saat ini
2. Masukkan password baru (min 8 karakter)
3. Konfirmasi password baru
4. Klik "Update Password"
5. Akan muncul notifikasi sukses

## 🔒 Validasi

### Update Profil
- **Nama**: Required, max 255 karakter
- **Email**: Required, valid email, unique (kecuali email sendiri)

### Update Password
- **Password Lama**: Required, harus sesuai dengan password saat ini
- **Password Baru**: Required, minimal 8 karakter, harus dikonfirmasi
- **Konfirmasi Password**: Required, harus sama dengan password baru

## 💡 Fitur Keamanan

1. **Protected Route**: Hanya user yang login bisa akses
2. **CSRF Protection**: Semua form dilindungi CSRF token
3. **Password Verification**: Verifikasi password lama sebelum update
4. **Password Hashing**: Password di-hash dengan bcrypt
5. **Email Unique**: Validasi email tidak boleh duplikat

## 📝 Error Handling

### Update Profil
```blade
@error('name')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
@enderror

@error('email')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
@enderror
```

### Update Password
```blade
@error('current_password')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
@enderror

@error('password')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
@enderror
```

## 🎯 Success Messages

Setelah berhasil update, akan muncul notifikasi:
```blade
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
@endif
```

## 🔧 Kustomisasi

### Menambah Field Baru
Edit `ProfileController.php` dan `profile/index.blade.php`:

```php
// Controller
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email,' . $user->id,
    'phone' => 'nullable|string|max:20', // Field baru
]);

$user->update([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone, // Field baru
]);
```

```blade
<!-- View -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
</div>
```

## 📱 Responsive Design

Halaman profil responsive untuk semua ukuran layar:
- **Desktop**: 2 kolom (profil card + forms)
- **Tablet**: 2 kolom dengan spacing lebih kecil
- **Mobile**: 1 kolom, stack vertical

## 🎨 UI Components

### Avatar
```blade
<div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white text-3xl font-bold">
    {{ substr($user->name, 0, 1) }}
</div>
```

### Form Input
```blade
<input type="text" name="name" value="{{ old('name', $user->name) }}"
    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
```

### Submit Button
```blade
<button type="submit"
    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
    Simpan Perubahan
</button>
```

## 🐛 Troubleshooting

### Error: "Email sudah digunakan"
- Email yang Anda masukkan sudah terdaftar oleh user lain
- Gunakan email yang berbeda

### Error: "Password saat ini tidak sesuai"
- Password lama yang Anda masukkan salah
- Pastikan memasukkan password yang benar

### Error: "Password confirmation tidak cocok"
- Password baru dan konfirmasi password tidak sama
- Pastikan kedua field diisi dengan password yang sama

## 📚 Referensi
- [Laravel Validation](https://laravel.com/docs/12.x/validation)
- [Laravel Hashing](https://laravel.com/docs/12.x/hashing)
- [Tailwind CSS](https://tailwindcss.com)
