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

                {{-- Back Button & Header --}}
                <div class="mb-6">
                    <a href="{{ route('pembelian.index') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 mb-4">
                        <i data-feather="arrow-left" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Kembali</span>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Pembelian</h1>
                    <p class="text-gray-500 text-sm mt-1">Perbarui informasi pembelian.</p>
                </div>

                {{-- Form Card --}}
                <div class="max-w-4xl">
                    <div class="bg-white rounded-xl shadow border p-6">
                        <form action="{{ route('pembelian.update', $pembelian) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                {{-- Kode Pembelian --}}
                                <div>
                                    <label for="kode_pembelian" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode Pembelian <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="kode_pembelian" id="kode_pembelian"
                                        value="{{ old('kode_pembelian', $pembelian->kode_pembelian) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('kode_pembelian') border-red-500 @enderror"
                                        placeholder="PBL00001" readonly>
                                    @error('kode_pembelian')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Tanggal Pembelian --}}
                                <div>
                                    <label for="tanggal_pembelian" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Pembelian <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_pembelian" id="tanggal_pembelian"
                                        value="{{ old('tanggal_pembelian', $pembelian->tanggal_pembelian->format('Y-m-d')) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('tanggal_pembelian') border-red-500 @enderror">
                                    @error('tanggal_pembelian')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Pemasok --}}
                                <div>
                                    <label for="pemasok_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pemasok <span class="text-red-500">*</span>
                                    </label>
                                    <select name="pemasok_id" id="pemasok_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('pemasok_id') border-red-500 @enderror"
                                        onchange="loadProdukPemasok(this.value)">
                                        <option value="">Pilih Pemasok</option>
                                        @foreach ($pemasoks as $pemasok)
                                            <option value="{{ $pemasok->id }}" 
                                                data-produk="{{ $pemasok->produk_yang_dipasok }}"
                                                {{ old('pemasok_id', $pembelian->pemasok_id) == $pemasok->id ? 'selected' : '' }}>
                                                {{ $pemasok->nama_pemasok }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pemasok_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Produk (dari Pemasok) --}}
                                <div>
                                    <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                        Produk <span class="text-red-500">*</span>
                                    </label>
                                    <select name="nama_produk" id="nama_produk"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nama_produk') border-red-500 @enderror">
                                        <option value="{{ old('nama_produk', $pembelian->nama_produk) }}">{{ old('nama_produk', $pembelian->nama_produk) }}</option>
                                    </select>
                                    @error('nama_produk')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Jumlah --}}
                                <div>
                                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="jumlah" id="jumlah"
                                        value="{{ old('jumlah', $pembelian->jumlah) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror"
                                        placeholder="10" min="1" onchange="hitungTotal()">
                                    @error('jumlah')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Harga Satuan --}}
                                <div>
                                    <label for="harga_satuan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Harga Satuan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="harga_satuan" id="harga_satuan"
                                        value="{{ old('harga_satuan', $pembelian->harga_satuan) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('harga_satuan') border-red-500 @enderror"
                                        placeholder="50000" step="0.01" onchange="hitungTotal()">
                                    @error('harga_satuan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Total Harga (Read Only) --}}
                                <div>
                                    <label for="total_harga_display" class="block text-sm font-medium text-gray-700 mb-2">
                                        Total Harga
                                    </label>
                                    <input type="text" id="total_harga_display"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                        placeholder="Rp 0" readonly>
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                        <option value="pending" {{ old('status', $pembelian->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="proses" {{ old('status', $pembelian->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="selesai" {{ old('status', $pembelian->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ old('status', $pembelian->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- Keterangan --}}
                            <div class="mt-4">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan (Opsional)
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Catatan pembelian...">{{ old('keterangan', $pembelian->keterangan) }}</textarea>
                            </div>

                            <div class="flex gap-3 mt-6">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
                                    <span class="text-sm font-medium">Perbarui</span>
                                </button>
                                <a href="{{ route('pembelian.index') }}"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl transition">
                                    <span class="text-sm font-medium">Batal</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </main>
            @include('components.footer')

        </div>

    </div>
    
    {{-- SCRIPT --}}
    @include('components.scripts')
    
    <script>
        // Load produk dari pemasok yang dipilih
        function loadProdukPemasok(pemasokId) {
            const select = document.getElementById('nama_produk');
            const currentValue = select.value; // Simpan nilai saat ini
            
            if (!pemasokId) {
                select.innerHTML = '<option value="">Pilih Pemasok Terlebih Dahulu</option>';
                return;
            }
            
            // Ambil data produk dari option yang dipilih
            const pemasokOption = document.querySelector(`#pemasok_id option[value="${pemasokId}"]`);
            const produkString = pemasokOption.getAttribute('data-produk');
            
            if (produkString) {
                const produkList = produkString.split(',').map(p => p.trim());
                select.innerHTML = '<option value="">Pilih Produk</option>';
                
                produkList.forEach(produk => {
                    const option = document.createElement('option');
                    option.value = produk;
                    option.textContent = produk;
                    if (produk === currentValue) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            } else {
                select.innerHTML = '<option value="">Tidak ada produk tersedia</option>';
            }
        }
        
        // Hitung total harga otomatis
        function hitungTotal() {
            const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
            const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
            const total = jumlah * hargaSatuan;
            
            document.getElementById('total_harga_display').value = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // Load produk saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const pemasokId = document.getElementById('pemasok_id').value;
            if (pemasokId) {
                loadProdukPemasok(pemasokId);
            }
            hitungTotal();
        });
    </script>
@endsection
