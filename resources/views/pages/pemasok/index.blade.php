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

                {{-- Header Pemasok --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Pemasok</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola semua pemasok yang bekerja sama dengan toko Anda.
                        </p>
                    </div>

                    <a href="#"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Pemasok
                    </a>
                </div>

                {{-- Card Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Total Pemasok</p>
                        <h3 class="text-2xl font-bold mt-1">35</h3>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Kategori Pemasok</p>
                        <h3 class="text-2xl font-bold mt-1">8</h3>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Transaksi Aktif</p>
                        <h3 class="text-2xl font-bold mt-1">120</h3>
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

                {{-- Tabel Pemasok --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Pemasok</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Cari pemasok..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">

                            <select class="px-3 py-2 text-sm border rounded-lg">
                                <option>Semua Kategori</option>
                                <option>Sembako</option>
                                <option>Minuman</option>
                                <option>Camilan</option>
                                <option>Peralatan Rumah</option>
                            </select>
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Nama Pemasok</th>
                                <th class="py-3 px-2">Kategori</th>
                                <th class="py-3 px-2">Kontak</th>
                                <th class="py-3 px-2">Alamat</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr class="border-b">
                                <td class="py-3 px-2">PT Sembako Jaya</td>
                                <td class="py-3 px-2">Sembako</td>
                                <td class="py-3 px-2">0812-3333-4444</td>
                                <td class="py-3 px-2">Jl. Raya Surabaya No. 12</td>
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
                                <td class="py-3 px-2">CV Minuman Segar Makmur</td>
                                <td class="py-3 px-2">Minuman</td>
                                <td class="py-3 px-2">0821-5566-7788</td>
                                <td class="py-3 px-2">Jl. Kenanga Selatan No. 5</td>
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
            {{-- FOOTER --}}
            @include('components.footer')
        </div>

    </div>
    {{-- SCRIPT --}}
    @include('components.scripts')
@endsection
