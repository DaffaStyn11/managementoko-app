# 🔐 Cara Login ke Sistem ManagemenToko

## Akun Testing

Gunakan salah satu akun berikut untuk login:

### 1. Admin Account
```
Email: admin@managementoko.com
Password: password123
```

### 2. Demo Account
```
Email: demo@managementoko.com
Password: demo123
```

### 3. Test Account
```
Email: test@example.com
Password: test123
```

## Langkah Login

1. Buka browser dan akses: `http://localhost:8000/login`
2. Masukkan email dan password dari salah satu akun di atas
3. Klik tombol "Masuk"
4. Anda akan diarahkan ke dashboard

## Fitur Authentication

✅ Login dengan session-based authentication
✅ Register user baru
✅ Logout dengan session invalidation
✅ Protected routes (harus login untuk akses)
✅ Auto redirect jika sudah login
✅ Error handling untuk kredensial salah

## Troubleshooting

**Tidak bisa login?**
- Pastikan database sudah di-migrate
- Jalankan seeder: `php artisan db:seed --class=UserSeeder`
- Clear cache: `php artisan config:clear`

**Lupa password?**
- Klik "Lupa Password?" di halaman login
- Atau gunakan akun testing di atas

## Logout

Untuk logout, klik tombol "Logout" di navbar atau akses: `http://localhost:8000/logout`
