@extends('layouts.app')

@section('content')
    <div class="flex">

        {{-- SIDEBAR --}}
        @include('components.sidebar')

        {{-- MAIN CONTENT --}}
        <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">

            {{-- HEADER --}}
            @include('components.header')

            {{-- PAGE CONTENT --}}
            <main class="p-6 flex-grow">

                {{-- Header Stok --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Stok Produk</h1>
                        <p class="text-gray-500 text-sm mt-1">Pantau jumlah stok setiap produk secara real-time.</p>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Produk</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $totalProduk }}</h3>
                            </div>
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <i data-feather="package" class="w-6 h-6 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Stok Rendah</p>
                                <h3 class="text-2xl font-bold mt-1 text-red-600">{{ $stokRendah }}</h3>
                            </div>
                            <div class="bg-red-50 p-3 rounded-lg">
                                <i data-feather="alert-triangle" class="w-6 h-6 text-red-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Kategori Produk</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $totalKategori }}</h3>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <i data-feather="grid" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Tabel Stok --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Stok Produk</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari produk..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                onkeyup="searchTable()">

                            <select id="filterKategori" class="px-3 py-2 text-sm border rounded-lg focus:outline-none" onchange="filterTable()">
                                <option value="">Semua Kategori</option>
                                @foreach($produks->pluck('kategori.nama_kategori')->unique()->filter() as $kategori)
                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm" id="stokTable">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Kode</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Produk</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Kategori</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Stok Saat Ini</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Stok Minimum</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Terakhir Update</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($produks as $produk)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $produk->kode_produk }}</td>
                                        <td class="py-3 px-4">
                                            <div class="font-medium text-gray-900">{{ $produk->nama_produk }}</div>
                                            <div class="text-xs text-gray-500">{{ $produk->satuan }}</div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="px-2 py-1 rounded-lg text-xs bg-blue-50 text-blue-700 font-medium">
                                                {{ $produk->kategori->nama_kategori ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="px-3 py-1 rounded-lg text-sm font-semibold {{ $produk->isStokRendah() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ number_format($produk->stok) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-600">
                                            {{ number_format($produk->stok_minimum) }}
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($produk->isStokRendah())
                                                <div class="flex items-center gap-1 text-red-600">
                                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                                    <span class="text-xs font-medium">Stok Rendah</span>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1 text-green-600">
                                                    <i data-feather="check-circle" class="w-4 h-4"></i>
                                                    <span class="text-xs font-medium">Stok Aman</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-gray-500 text-xs">
                                            <div>{{ $produk->updated_at->format('d/m/Y') }}</div>
                                            <div class="text-gray-400">{{ $produk->updated_at->format('H:i') }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i data-feather="inbox" class="w-16 h-16 mb-3 text-gray-300"></i>
                                                <p class="text-lg font-medium">Belum ada data stok produk</p>
                                                <p class="text-sm text-gray-400 mt-1">Data akan muncul setelah produk ditambahkan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Summary Footer --}}
                    @if($produks->count() > 0)
                        <div class="mt-4 pt-4 border-t flex items-center justify-between text-sm text-gray-600">
                            <div>
                                Menampilkan <span class="font-semibold text-gray-900">{{ $produks->count() }}</span> produk
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span>Stok Aman: {{ $produks->count() - $stokRendah }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <span>Stok Rendah: {{ $stokRendah }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </main>
            @include('components.footer')
        </div>

    </div>

    {{-- SCRIPT --}}
    @include('components.scripts')
    
    <script>
        // Search Table
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('stokTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const textValue = cell.textContent || cell.innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                rows[i].style.display = found ? '' : 'none';
            }
        }

        // Filter by Category
        function filterTable() {
            const select = document.getElementById('filterKategori');
            const filter = select.value.toLowerCase();
            const table = document.getElementById('stokTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const kategoriCell = rows[i].getElementsByTagName('td')[2];
                
                if (kategoriCell) {
                    const textValue = kategoriCell.textContent || kategoriCell.innerText;
                    
                    if (filter === '' || textValue.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
@endsection
