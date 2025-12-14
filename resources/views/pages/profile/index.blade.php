    @extends('layouts.app')

    @section('content')
        <div class="flex">

            {{-- =============== SIDEBAR =============== --}}
            @include('components.sidebar')

            {{-- =============== MAIN CONTENT WRAPPER =============== --}}
            <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">

                {{-- HEADER --}}
                @include('components.header')

                {{-- =============== PAGE CONTENT START =============== --}}
                <main class="p-6 flex-grow">

                    {{-- Header Produk --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Profile Saya</h1>
                            <p class="text-gray-500 text-sm mt-1">Kelola Profil Anda</p>
                        </div>
                    </div>

                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow">
                            <span class="text-sm">{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                                <i data-feather="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow">
                            <span class="text-sm">{{ session('error') }}</span>
                            <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                                <i data-feather="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <!-- Profile Card -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                <div class="text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white text-3xl font-bold mb-4">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                                    <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>
                                    <div class="mt-4 pt-4 border-t">
                                        <div class="text-xs text-gray-500">
                                            <p>Bergabung sejak</p>
                                            <p class="font-semibold text-gray-700 mt-1">
                                                {{ $user->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Forms -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Update Profile Form -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                                        <i data-feather="user" class="w-5 h-5 text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Informasi Profil</h3>
                                        <p class="text-sm text-gray-500">Update nama dan email Anda</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-4">
                                        <!-- Name -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none @error('name') border-red-500 @enderror"
                                                required>
                                            @error('name')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none @error('email') border-red-500 @enderror"
                                                required>
                                            @error('email')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="flex justify-end pt-2">
                                            <button type="submit"
                                                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Update Password Form -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                                        <i data-feather="lock" class="w-5 h-5 text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Ubah Password</h3>
                                        <p class="text-sm text-gray-500">Pastikan password Anda aman</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('profile.password') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-4">
                                        <!-- Current Password -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat
                                                Ini</label>
                                            <input type="password" name="current_password"
                                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none @error('current_password') border-red-500 @enderror"
                                                required>
                                            @error('current_password')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- New Password -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Password
                                                Baru</label>
                                            <input type="password" name="password"
                                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none @error('password') border-red-500 @enderror"
                                                required>
                                            @error('password')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password
                                                Baru</label>
                                            <input type="password" name="password_confirmation"
                                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                                                required>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="flex justify-end pt-2">
                                            <button type="submit"
                                                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                                                Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </main>
                @include('components.footer')

            </div>

        </div>
        {{-- SCRIPT --}}
        @include('components.scripts')
    @endsection
