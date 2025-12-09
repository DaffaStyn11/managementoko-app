# Contoh Implementasi Logout Button

## Di Navbar/Header

Tambahkan kode berikut di navbar atau header layout Anda:

```blade
<!-- Contoh 1: Simple Logout Button -->
<form method="POST" action="{{ route('logout') }}" class="inline">
    @csrf
    <button type="submit" class="text-red-600 hover:text-red-700">
        Logout
    </button>
</form>

<!-- Contoh 2: Logout dengan Icon -->
<form method="POST" action="{{ route('logout') }}" class="inline">
    @csrf
    <button type="submit" class="flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Logout
    </button>
</form>

<!-- Contoh 3: Dropdown Menu dengan User Info -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100">
        <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
        <span>{{ auth()->user()->name }}</span>
    </button>
    
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
        <div class="px-4 py-2 border-b">
            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                Logout
            </button>
        </form>
    </div>
</div>
```

## Di Sidebar

```blade
<!-- Logout di bagian bawah sidebar -->
<div class="mt-auto pt-4 border-t">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>Logout</span>
        </button>
    </form>
</div>
```

## Menampilkan User yang Login

```blade
<!-- Di mana saja di view -->
@auth
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <p>Email: {{ auth()->user()->email }}</p>
@endauth

<!-- Atau menggunakan helper -->
<p>Logged in as: {{ Auth::user()->name }}</p>
```

## Proteksi View

```blade
<!-- Hanya tampil jika user sudah login -->
@auth
    <div>Konten untuk user yang sudah login</div>
@endauth

<!-- Hanya tampil jika user belum login -->
@guest
    <a href="{{ route('login') }}">Login</a>
@endguest

<!-- Kombinasi -->
@auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@else
    <a href="{{ route('login') }}">Login</a>
@endauth
```

## JavaScript Confirmation (Opsional)

```blade
<form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
    @csrf
    <button type="submit">Logout</button>
</form>
```

## Catatan Penting

1. **Selalu gunakan POST method** untuk logout (bukan GET)
2. **Jangan lupa @csrf** di dalam form
3. **Gunakan route('logout')** untuk URL yang konsisten
4. **Test logout** untuk memastikan session benar-benar dihapus
