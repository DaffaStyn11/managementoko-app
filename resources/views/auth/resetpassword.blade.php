<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Sistem Manajemen Toko</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>

<body>

    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="glass-card shadow-2xl rounded-3xl p-8 md:p-10 w-full max-w-md fade-in">

            <!-- Logo -->
            <div class="flex flex-col items-center mb-8">
                <div
                    class="logo-gradient w-20 h-20 rounded-2xl flex items-center justify-center text-white text-3xl font-bold">
                    MT
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mt-5">Reset Password</h1>
                <p class="text-gray-600 text-sm mt-2 text-center">Masukkan email Anda untuk menerima link reset password
                </p>
            </div>

            <!-- Form Reset Password -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
                    <input type="email" name="email"
                        class="input-field w-full px-4 py-3.5 border border-gray-300 rounded-xl text-sm bg-white focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                        placeholder="nama@email.com" required>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Password</label>
                    <input type="password" name="password"
                        class="input-field w-full px-4 py-3.5 border border-gray-300 rounded-xl text-sm bg-white focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                        placeholder="Minimal 8 karakter" required>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="input-field w-full px-4 py-3.5 border border-gray-300 rounded-xl text-sm bg-white focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                        placeholder="Ketik ulang password" required>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-primary w-full py-3.5 text-white font-semibold rounded-xl shadow-lg">
                    Reset Password
                </button>

                <!-- Garis Pemisah -->
                <div class="flex items-center my-6">
                    <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                    <span class="px-4 text-gray-500 text-sm font-medium">atau</span>
                    <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                </div>

                <!-- Link Kembali ke Login -->
                <div class="text-center">
                    <p class="text-gray-600 text-sm">
                        Ingat password Anda?
                        <a href="{{ route('login') }}"
                            class="text-purple-600 font-semibold hover:text-purple-700 hover:underline transition ml-1">
                            Kembali ke Login
                        </a>
                    </p>
                </div>

                <!-- Link Register -->
                <div class="text-center mt-3">
                    <p class="text-gray-600 text-sm">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="text-purple-600 font-semibold hover:text-purple-700 hover:underline transition ml-1">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

            </form>
        </div>
    </div>

</body>

</html>
