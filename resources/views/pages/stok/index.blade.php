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

                    <a href="#"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Stok
                    </a>
                </div>

                {{-- Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Total Produk</p>
                        <h3 class="text-2xl font-bold mt-1">230</h3>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Stok Rendah</p>
                        <h3 class="text-2xl font-bold mt-1 text-red-600">12</h3>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Kategori Produk</p>
                        <h3 class="text-2xl font-bold mt-1">16</h3>
                    </div>

                </div>

                {{-- Export Buttons --}}
                <div class="flex items-center gap-3 mb-4">

                    {{-- Export Excel --}}
                    <button
                        class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                        <i data-feather="file-text" class="w-4 h-4"></i>
                        <span>Export Excel</span>
                    </button>

                    {{-- Export PDF --}}
                    <button
                        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                        <i data-feather="file" class="w-4 h-4"></i>
                        <span>Export PDF</span>
                    </button>

                </div>

                {{-- Tabel Stok --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Stok Produk</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Cari produk..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">

                            <select class="px-3 py-2 text-sm border rounded-lg">
                                <option>Semua Kategori</option>
                                <option>Sembako</option>
                                <option>Minuman</option>
                                <option>Camilan</option>
                                <option>Peralatan</option>
                            </select>
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Produk</th>
                                <th class="py-3 px-2">Kategori</th>
                                <th class="py-3 px-2">Stok</th>
                                <th class="py-3 px-2">Satuan</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr class="border-b">
                                <td class="py-3 px-2 font-medium text-gray-700">Beras Premium 5kg</td>
                                <td class="py-3 px-2">Sembako</td>
                                <td class="py-3 px-2">42</td>
                                <td class="py-3 px-2">Karung</td>
                                <td class="py-3 px-2 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Edit --}}
                                        <button class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>

                                        {{-- Delete --}}
                                        <button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 px-2 font-medium text-gray-700">Teh Botol Sosro 350ml</td>
                                <td class="py-3 px-2">Minuman</td>
                                <td class="py-3 px-2 text-red-600 font-semibold">5</td>
                                <td class="py-3 px-2">Botol</td>
                                <td class="py-3 px-2 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Edit --}}
                                        <button class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>

                                        {{-- Delete --}}
                                        <button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>

            </main>
            @include('components.footer')
        </div>

    </div>

    {{-- SCRIPT --}}
    @include('components.scripts')
@endsection
