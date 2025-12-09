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

                {{-- Header Pemasok --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Pemasok</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola semua pemasok di toko Anda.</p>
                    </div>

                    <a href="{{ route('pemasok.create') }}"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Pemasok
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
                                <p class="text-gray-600 text-sm">Total Pemasok</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $totalPemasok }}</h3>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <i data-feather="users" class="w-8 h-8 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Kategori Pemasok</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $totalKategori }}</h3>
                            </div>
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <i data-feather="tag" class="w-8 h-8 text-purple-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Transaksi Aktif</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $transaksiAktif }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="activity" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Tabel Pemasok --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Pemasok</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari pemasok..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                            <select id="filterKategori" class="px-3 py-2 text-sm border rounded-lg focus:outline-none">
                                <option value="">Semua Kategori</option>
                                @foreach($pemasoks->pluck('kategori_pemasok')->unique()->filter() as $kategori)
                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Nama Pemasok</th>
                                <th class="py-3 px-2">Produk Dipasok</th>
                                <th class="py-3 px-2">Kontak</th>
                                <th class="py-3 px-2">Alamat</th>
                                <th class="py-3 px-2">Kategori</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            @forelse ($pemasoks as $pemasok)
                                <tr class="border-b hover:bg-gray-50" data-kategori="{{ $pemasok->kategori_pemasok ?? '' }}">
                                    <td class="py-3 px-2 font-medium text-gray-900">{{ $pemasok->nama_pemasok }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ $pemasok->produk_yang_dipasok }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ $pemasok->kontak }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ Str::limit($pemasok->alamat, 30) }}</td>
                                    <td class="py-3 px-2">
                                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                            {{ $pemasok->kategori_pemasok ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pemasok.edit', $pemasok) }}"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                                <i data-feather="edit" class="w-4 h-4"></i>
                                            </a>

                                            <form action="{{ route('pemasok.destroy', $pemasok) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemasok ini?')">
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
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="inbox" class="w-12 h-12 mb-2 text-gray-400"></i>
                                            <p>Belum ada pemasok. Tambahkan pemasok pertama Anda!</p>
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
