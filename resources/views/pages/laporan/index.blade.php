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
                </div>

                <!-- FILTER -->
                <form method="GET" action="{{ route('laporan') }}" class="bg-white border rounded-xl p-6 shadow mb-6">
                    <h3 class="text-lg font-semibold mb-4">Filter Laporan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">Jenis Laporan</label>
                            <select name="jenis" class="w-full mt-1 px-3 py-2 border rounded-lg text-sm">
                                <option value="semua" {{ request('jenis') == 'semua' ? 'selected' : '' }}>Semua</option>
                                <option value="penjualan" {{ request('jenis') == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                                <option value="pembelian" {{ request('jenis') == 'pembelian' ? 'selected' : '' }}>Pembelian</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Periode</label>
                            <select name="periode" class="w-full mt-1 px-3 py-2 border rounded-lg text-sm">
                                <option value="hari_ini" {{ request('periode', 'hari_ini') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="minggu_ini" {{ request('periode') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="bulan_ini" {{ request('periode') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="tahun_ini" {{ request('periode') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                                <option value="custom" {{ request('periode') == 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Tanggal (Custom)</label>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full mt-1 px-3 py-2 border rounded-lg text-sm" />
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                <i data-feather="filter" class="w-4 inline"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- STATISTIK -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Penjualan</p>
                                <h3 class="text-2xl font-bold mt-1 text-green-600">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="trending-up" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Pembelian</p>
                                <h3 class="text-2xl font-bold mt-1 text-red-600">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-red-50 rounded-lg">
                                <i data-feather="trending-down" class="w-8 h-8 text-red-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Selisih (Penjualan - Pembelian)</p>
                                <h3 class="text-2xl font-bold mt-1 {{ $selisih >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $selisih >= 0 ? '+' : '' }} Rp {{ number_format($selisih, 0, ',', '.') }}
                                </h3>
                            </div>
                            <div class="p-3 {{ $selisih >= 0 ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                                <i data-feather="dollar-sign" class="w-8 h-8 {{ $selisih >= 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Export Buttons --}}
                <div class="flex items-center gap-3 mb-4">
                    {{-- Export Excel --}}
                    <a href="{{ route('laporan.export.excel', request()->all()) }}"
                        class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                        <i data-feather="file-text" class="w-4 h-4"></i>
                        <span>Export Excel</span>
                    </a>

                    {{-- Export PDF --}}
                    <a href="{{ route('laporan.export.pdf', request()->all()) }}" target="_blank"
                        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                        <i data-feather="file" class="w-4 h-4"></i>
                        <span>Export PDF</span>
                    </a>
                </div>

                <!-- TABEL LAPORAN -->
                <div class="bg-white shadow border rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Ringkasan Laporan</h3>
                        <input type="text" id="searchTable" placeholder="Cari..."
                            class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4">No</th>
                                    <th class="py-3 px-4">Kategori</th>
                                    <th class="py-3 px-4">Deskripsi</th>
                                    <th class="py-3 px-4">Nominal</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @forelse($laporanData as $index => $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                {{ $item['type'] == 'penjualan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $item['kategori'] }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-700">{{ $item['deskripsi'] }}</td>
                                        <td class="py-3 px-4 font-semibold {{ $item['type'] == 'penjualan' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $item['type'] == 'penjualan' ? '+' : '-' }} Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-gray-600">{{ $item['tanggal'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500">
                                            <i data-feather="inbox" class="w-12 h-12 mx-auto mb-2 text-gray-400"></i>
                                            <p>Tidak ada data laporan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($laporanData->count() > 0)
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-sm text-gray-600">Total {{ $laporanData->count() }} transaksi</p>
                        </div>
                    @endif
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
        document.getElementById('searchTable').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#tableBody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
@endsection
