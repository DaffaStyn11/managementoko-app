@extends('layouts.app')

@section('content')
    <div class="flex">

        {{-- SIDEBAR --}}
        @include('components.sidebar')

        {{-- MAIN WRAPPER --}}
        <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">

            {{-- HEADER --}}
            @include('components.header')

            {{-- CONTENT --}}
            <main class="p-6 flex-grow">

                {{-- Header --}}
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-gray-500 text-sm mt-1">Selamat datang di Managemen Toko</p>
                </div>

                {{-- Summary Cards Row 1 --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Produk</p>
                                <h3 class="text-2xl font-bold mt-1">{{ number_format($totalProduk) }}</h3>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <i data-feather="package" class="w-6 h-6 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Stok</p>
                                <h3 class="text-2xl font-bold mt-1">{{ number_format($totalStok) }}</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <i data-feather="archive" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Pemasok</p>
                                <h3 class="text-2xl font-bold mt-1">{{ number_format($totalPemasok) }}</h3>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <i data-feather="truck" class="w-6 h-6 text-purple-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Stok Rendah</p>
                                <h3 class="text-2xl font-bold mt-1 text-red-600">{{ number_format($stokRendah) }}</h3>
                            </div>
                            <div class="bg-red-100 p-3 rounded-lg">
                                <i data-feather="alert-triangle" class="w-6 h-6 text-red-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Summary Cards Row 2 --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Penjualan Hari Ini</p>
                                <h3 class="text-xl font-bold mt-1 text-green-600">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <i data-feather="trending-up" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Pembelian Hari Ini</p>
                                <h3 class="text-xl font-bold mt-1 text-red-600">Rp {{ number_format($pembelianHariIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="bg-red-100 p-3 rounded-lg">
                                <i data-feather="trending-down" class="w-6 h-6 text-red-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Penjualan Bulan Ini</p>
                                <h3 class="text-xl font-bold mt-1 text-green-600">Rp {{ number_format($penjualanBulanIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <i data-feather="dollar-sign" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Pembelian Bulan Ini</p>
                                <h3 class="text-xl font-bold mt-1 text-red-600">Rp {{ number_format($pembelianBulanIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="bg-red-100 p-3 rounded-lg">
                                <i data-feather="shopping-cart" class="w-6 h-6 text-red-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Charts --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    {{-- Grafik Penjualan & Pembelian 7 Hari --}}
                    <div class="bg-white rounded-xl shadow border p-6">
                        <h3 class="text-lg font-semibold mb-4">Penjualan & Pembelian (7 Hari Terakhir)</h3>
                        <canvas id="chartTransaksi"></canvas>
                    </div>

                    {{-- Produk Terlaris --}}
                    <div class="bg-white rounded-xl shadow border p-6">
                        <h3 class="text-lg font-semibold mb-4">Produk Terlaris</h3>
                        <canvas id="chartProdukTerlaris"></canvas>
                    </div>
                </div>

                {{-- Tables --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Stok Rendah --}}
                    <div class="bg-white rounded-xl shadow border p-6">
                        <h3 class="text-lg font-semibold mb-4">Produk Stok Rendah</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b bg-gray-50">
                                    <tr>
                                        <th class="py-2 px-3 text-left">Produk</th>
                                        <th class="py-2 px-3 text-left">Stok</th>
                                        <th class="py-2 px-3 text-left">Min</th>
                                        <th class="py-2 px-3 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produkStokRendah as $produk)
                                        <tr class="border-b">
                                            <td class="py-2 px-3">{{ $produk->nama_produk }}</td>
                                            <td class="py-2 px-3 font-semibold text-red-600">{{ $produk->stok }}</td>
                                            <td class="py-2 px-3">{{ $produk->stok_minimum }}</td>
                                            <td class="py-2 px-3">
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Rendah</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-4 text-center text-gray-500">Semua stok aman</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Transaksi Terbaru --}}
                    <div class="bg-white rounded-xl shadow border p-6">
                        <h3 class="text-lg font-semibold mb-4">Transaksi Penjualan Terbaru</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b bg-gray-50">
                                    <tr>
                                        <th class="py-2 px-3 text-left">Kode</th>
                                        <th class="py-2 px-3 text-left">Produk</th>
                                        <th class="py-2 px-3 text-left">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksiTerbaru as $transaksi)
                                        <tr class="border-b">
                                            <td class="py-2 px-3 font-medium">{{ $transaksi->kode_penjualan }}</td>
                                            <td class="py-2 px-3">{{ $transaksi->produk->nama_produk }}</td>
                                            <td class="py-2 px-3 font-semibold text-green-600">
                                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-4 text-center text-gray-500">Belum ada transaksi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>

            {{-- FOOTER --}}
            @include('components.footer')

        </div>
    </div>
    {{-- SCRIPT --}}
    @include('components.scripts')

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Grafik Penjualan & Pembelian 7 Hari
        const ctxTransaksi = document.getElementById('chartTransaksi').getContext('2d');
        new Chart(ctxTransaksi, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels7Hari) !!},
                datasets: [
                    {
                        label: 'Penjualan',
                        data: {!! json_encode($penjualan7Hari) !!},
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pembelian',
                        data: {!! json_encode($pembelian7Hari) !!},
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Grafik Produk Terlaris
        const ctxProdukTerlaris = document.getElementById('chartProdukTerlaris').getContext('2d');
        const produkTerlarisData = {!! json_encode($produkTerlaris) !!};
        
        new Chart(ctxProdukTerlaris, {
            type: 'bar',
            data: {
                labels: produkTerlarisData.map(item => item.produk.nama_produk),
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: produkTerlarisData.map(item => item.total_terjual),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(168, 85, 247)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection
