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

                {{-- Header Kategori --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Kategori</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola kategori produk toko Anda.</p>
                    </div>

                    <a href="{{ route('kategori.create') }}"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Kategori
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

                {{-- Card Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Kategori</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $kategoris->count() }}</h3>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <i data-feather="folder" class="w-8 h-8 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Kategori Aktif</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $kategoris->count() }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="check-circle" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Ditambahkan Bulan Ini</p>
                                <h3 class="text-2xl font-bold mt-1">
                                    {{ $kategoris->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            </div>
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <i data-feather="calendar" class="w-8 h-8 text-purple-600"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Tabel Kategori --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Kategori</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari kategori..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">No</th>
                                <th class="py-3 px-2">Nama Kategori</th>
                                <th class="py-3 px-2">Deskripsi</th>
                                <th class="py-3 px-2">Tanggal Pembuatan</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            @forelse ($kategoris as $index => $kategori)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-2">{{ $index + 1 }}</td>
                                    <td class="py-3 px-2 font-medium text-gray-900">{{ $kategori->nama_kategori }}</td>
                                    <td class="py-3 px-2 text-gray-600">
                                        {{ $kategori->deskripsi ? Str::limit($kategori->deskripsi, 50) : '-' }}
                                    </td>
                                    <td class="py-3 px-2 text-gray-600">{{ $kategori->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3 px-2 text-center">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Edit --}}
                                            <a href="{{ route('kategori.edit', $kategori) }}"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                                <i data-feather="edit" class="w-4 h-4"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                                    <td colspan="5" class="py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="inbox" class="w-12 h-12 mb-2 text-gray-400"></i>
                                            <p>Belum ada kategori. Tambahkan kategori pertama Anda!</p>
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
