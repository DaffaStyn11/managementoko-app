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

                {{-- Header Pembelian --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Pembelian</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola semua transaksi pembelian.</p>
                    </div>

                    <a href="{{ route('pembelian.create') }}"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Pembelian
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
                                <p class="text-gray-600 text-sm">Total Pembelian</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $totalPembelian }}</h3>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <i data-feather="shopping-cart" class="w-8 h-8 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Nilai</p>
                                <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalNilai, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="dollar-sign" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Pembelian Pending</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $pembelianPending }}</h3>
                            </div>
                            <div class="p-3 bg-yellow-50 rounded-lg">
                                <i data-feather="clock" class="w-8 h-8 text-yellow-600"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Tabel Pembelian --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Pembelian</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari pembelian..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                            <select id="filterStatus" class="px-3 py-2 text-sm border rounded-lg focus:outline-none">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Kode</th>
                                <th class="py-3 px-2">Tanggal</th>
                                <th class="py-3 px-2">Pemasok</th>
                                <th class="py-3 px-2">Produk</th>
                                <th class="py-3 px-2">Jumlah</th>
                                <th class="py-3 px-2">Total Harga</th>
                                <th class="py-3 px-2">Status</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            @forelse ($pembelians as $pembelian)
                                <tr class="border-b hover:bg-gray-50" data-status="{{ $pembelian->status }}">
                                    <td class="py-3 px-2 font-mono text-xs">{{ $pembelian->kode_pembelian }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ $pembelian->tanggal_pembelian->format('d/m/Y') }}</td>
                                    <td class="py-3 px-2 font-medium text-gray-900">{{ $pembelian->pemasok->nama_pemasok }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ $pembelian->nama_produk }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ $pembelian->jumlah }}</td>
                                    <td class="py-3 px-2 text-gray-900">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-3 px-2">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'proses' => 'bg-blue-100 text-blue-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'dibatalkan' => 'bg-red-100 text-red-700'
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $statusColors[$pembelian->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($pembelian->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pembelian.edit', $pembelian) }}"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                                <i data-feather="edit" class="w-4 h-4"></i>
                                            </a>

                                            <form action="{{ route('pembelian.destroy', $pembelian) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembelian ini?')">
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
                                    <td colspan="8" class="py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="inbox" class="w-12 h-12 mb-2 text-gray-400"></i>
                                            <p>Belum ada pembelian. Tambahkan pembelian pertama Anda!</p>
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
        const filterStatus = document.getElementById('filterStatus');
        const tableBody = document.getElementById('tableBody');

        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const statusValue = filterStatus.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr:not(#emptyRow)');
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const status = row.getAttribute('data-status').toLowerCase();
                
                const matchSearch = text.includes(searchValue);
                const matchStatus = statusValue === '' || status === statusValue;

                if (matchSearch && matchStatus) {
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
        filterStatus.addEventListener('change', filterTable);
    </script>
@endsection
