@extends('layouts.app')

@section('content')
    <div class="flex">

        <!-- SIDEBAR -->
        @include('components.sidebar')

        <!-- MAIN -->
        <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">

            <!-- HEADER -->
            @include('components.header')

            <!-- PAGE CONTENT -->
            <main class="p-6 flex-grow">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Laporan</h1>
                        <p class="text-gray-500 text-sm mt-1">Pantau performa penjualan, pembelian, dan stok secara
                            keseluruhan.</p>
                    </div>
                    <button
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="download" class="w-4"></i> Export PDF
                    </button>
                </div>

                <!-- FILTER -->
                <div class="bg-white border rounded-xl p-6 shadow mb-6">
                    <h3 class="text-lg font-semibold mb-4">Filter Laporan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">Jenis Laporan</label>
                            <select class="w-full mt-1 px-3 py-2 border rounded-lg text-sm">
                                <option>Semua</option>
                                <option>Penjualan</option>
                                <option>Pembelian</option>
                                <option>Stok</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Periode</label>
                            <select class="w-full mt-1 px-3 py-2 border rounded-lg text-sm">
                                <option>Hari Ini</option>
                                <option>Minggu Ini</option>
                                <option>Bulan Ini</option>
                                <option>Tahun Ini</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Tanggal</label>
                            <input type="date" class="w-full mt-1 px-3 py-2 border rounded-lg text-sm" />
                        </div>
                    </div>
                </div>

                <!-- STATISTIK -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Total Penjualan</p>
                        <h3 class="text-2xl font-bold mt-1">Rp 12.450.000</h3>
                    </div>
                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Total Pembelian</p>
                        <h3 class="text-2xl font-bold mt-1">Rp 8.320.000</h3>
                    </div>
                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Selisih</p>
                        <h3 class="text-2xl font-bold mt-1 text-green-600">+ Rp 4.130.000</h3>
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

                <!-- TABEL LAPORAN -->
                <div class="bg-white shadow border rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Ringkasan Laporan</h3>
                        <input type="text" placeholder="Cari..."
                            class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Kategori</th>
                                <th class="py-3 px-2">Deskripsi</th>
                                <th class="py-3 px-2">Nominal</th>
                                <th class="py-3 px-2">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="py-3 px-2 font-medium text-gray-700">Penjualan</td>
                                <td class="py-3 px-2">Transaksi Harian</td>
                                <td class="py-3 px-2 font-semibold text-green-600">Rp 4.600.000</td>
                                <td class="py-3 px-2">2025-12-06</td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 px-2 font-medium text-gray-700">Pembelian</td>
                                <td class="py-3 px-2">Pembelian Stok Supplier</td>
                                <td class="py-3 px-2 font-semibold text-red-600">Rp 2.150.000</td>
                                <td class="py-3 px-2">2025-12-06</td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 px-2 font-medium text-gray-700">Penyesuaian Stok</td>
                                <td class="py-3 px-2">Opname Bulanan</td>
                                <td class="py-3 px-2 font-semibold text-yellow-600">-</td>
                                <td class="py-3 px-2">2025-12-05</td>
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
