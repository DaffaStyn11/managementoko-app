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
                            <h1 class="text-2xl font-bold text-gray-800">Produk</h1>
                            <p class="text-gray-500 text-sm mt-1">Kelola semua produk di toko Anda.</p>
                        </div>

                        <a href="{{ route('produk.create') }}"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                            <i data-feather="plus" class="w-4"></i>
                            Tambah Produk
                        </a>
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

                    {{-- Card Statistik --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                        <div class="bg-white rounded-xl shadow border p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Total Produk</p>
                                    <h3 class="text-2xl font-bold mt-1">{{ $totalProduk }}</h3>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-lg">
                                    <i data-feather="package" class="w-8 h-8 text-blue-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow border p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Total Stok</p>
                                    <h3 class="text-2xl font-bold mt-1">{{ number_format($totalStok) }}</h3>
                                </div>
                                <div class="p-3 bg-green-50 rounded-lg">
                                    <i data-feather="layers" class="w-8 h-8 text-green-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow border p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Kategori</p>
                                    <h3 class="text-2xl font-bold mt-1">{{ $totalKategori }}</h3>
                                </div>
                                <div class="p-3 bg-purple-50 rounded-lg">
                                    <i data-feather="grid" class="w-8 h-8 text-purple-600"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Tabel Produk --}}
                    <div class="bg-white shadow border rounded-xl p-6">

                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Daftar Produk</h3>

                            <div class="flex items-center gap-2">
                                <input type="text" id="searchInput" placeholder="Cari produk..."
                                    class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                                <select id="filterKategori" class="px-3 py-2 text-sm border rounded-lg focus:outline-none">
                                    <option value="">Semua Kategori</option>
                                    @foreach($produks->pluck('kategori.nama_kategori')->unique()->filter() as $kategori)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table class="w-full text-left text-sm">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="py-3 px-2">Kode</th>
                                    <th class="py-3 px-2">Nama Produk</th>
                                    <th class="py-3 px-2">Kategori</th>
                                    <th class="py-3 px-2">Harga Jual</th>
                                    <th class="py-3 px-2">Stok</th>
                                    <th class="py-3 px-2">Status</th>
                                    <th class="py-3 px-2 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="tableBody">
                                @forelse ($produks as $produk)
                                    <tr class="border-b hover:bg-gray-50" data-kategori="{{ $produk->kategori->nama_kategori ?? '' }}">
                                        <td class="py-3 px-2 font-mono text-xs">{{ $produk->kode_produk }}</td>
                                        <td class="py-3 px-2 font-medium text-gray-900">{{ $produk->nama_produk }}</td>
                                        <td class="py-3 px-2 text-gray-600">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                                        <td class="py-3 px-2 text-gray-900">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 rounded text-xs {{ $produk->isStokRendah() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $produk->stok }} {{ $produk->satuan }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2">
                                            <span class="px-2 py-1 rounded text-xs {{ $produk->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                {{ $produk->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('produk.edit', $produk) }}"
                                                    class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                                    <i data-feather="edit" class="w-4 h-4"></i>
                                                </a>

                                                <form action="{{ route('produk.destroy', $produk) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyRow">
                                        <td colspan="7" class="py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i data-feather="inbox" class="w-12 h-12 mb-2 text-gray-400"></i>
                                                <p>Belum ada produk. Tambahkan produk pertama Anda!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </main>
                @include('components.footer')

            </div>

        </div>
        {{-- SCRIPT --}}
        @include('components.scripts')

        <script>
            const searchInput = document.getElementById('searchInput');
            const filterKategori = document.getElementById('filterKategori');
            const tableBody = document.getElementById('tableBody');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const kategoriValue = filterKategori.value.toLowerCase();
                const rows = tableBody.querySelectorAll('tr:not(#emptyRow)');
                let visibleCount = 0;

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const kategori = row.getAttribute('data-kategori').toLowerCase();
                    
                    const matchSearch = text.includes(searchValue);
                    const matchKategori = kategoriValue === '' || kategori === kategoriValue;

                    if (matchSearch && matchKategori) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide empty state
                const emptyRow = document.getElementById('emptyRow');
                if (emptyRow) {
                    emptyRow.style.display = visibleCount === 0 ? '' : 'none';
                }
            }

            searchInput.addEventListener('keyup', filterTable);
            filterKategori.addEventListener('change', filterTable);
        </script>
    @endsection
