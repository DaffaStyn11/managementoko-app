@extends('layouts.app')

@section('content')
    <div class="flex">

        {{-- SIDEBAR --}}
        @include('components.sidebar')

        {{-- MAIN --}}
        <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">

            {{-- HEADER --}}
            @include('components.header')

            {{-- PAGE CONTENT --}}
            <main class="p-6 flex-grow">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Penjualan</h1>
                        <p class="text-gray-500 text-sm mt-1">Catat dan pantau transaksi penjualan setiap hari.</p>
                    </div>

                    <a href="{{ route('penjualan.create') }}"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Penjualan
                    </a>
                </div>

                {{-- Alert Messages --}}
                @if (session('success'))
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow">
                        <span class="text-sm">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                            <i data-feather="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow">
                        <span class="text-sm">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                            <i data-feather="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                @endif

                {{-- Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Penjualan Hari Ini</p>
                                <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="dollar-sign" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Jumlah Transaksi</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $jumlahTransaksi }}</h3>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <i data-feather="shopping-bag" class="w-8 h-8 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Produk Terlaris</p>
                                <h3 class="text-xl font-semibold mt-1">{{ $produkTerlaris->produk->nama_produk ?? '-' }}</h3>
                            </div>
                            <div class="p-3 bg-orange-50 rounded-lg">
                                <i data-feather="award" class="w-8 h-8 text-orange-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABEL PENJUALAN --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Transaksi</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari kode/produk..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Kode</th>
                                <th class="py-3 px-2">Produk</th>
                                <th class="py-3 px-2">Jumlah</th>
                                <th class="py-3 px-2">Harga</th>
                                <th class="py-3 px-2">Total</th>
                                <th class="py-3 px-2">Tanggal</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($penjualans as $penjualan)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-2 font-mono text-xs">{{ $penjualan->kode_penjualan }}</td>
                                    <td class="py-3 px-2 font-medium text-gray-700">{{ $penjualan->produk->nama_produk }}
                                    </td>
                                    <td class="py-3 px-2">{{ $penjualan->jumlah }} {{ $penjualan->produk->satuan }}</td>
                                    <td class="py-3 px-2">Rp {{ number_format($penjualan->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-2 font-semibold">Rp
                                        {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-3 px-2">{{ $penjualan->tanggal_penjualan->format('d/m/Y') }}</td>
                                    <td class="py-3 px-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('penjualan.edit', $penjualan) }}"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                                <i data-feather="edit" class="w-4 h-4"></i>
                                            </a>

                                            <form action="{{ route('penjualan.destroy', $penjualan) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus penjualan ini? Stok produk akan dikembalikan.')">
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
                                            <p>Belum ada transaksi penjualan. Tambahkan penjualan pertama Anda!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </main>

            {{-- FOOTER --}}
            @include('components.footer')
        </div>
    </div>
    {{-- SCRIPT --}}
    @include('components.scripts')

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#tableBody tr:not(#emptyRow)');
            let visibleCount = 0;
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchValue)) {
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
        });
    </script>
@endsection
