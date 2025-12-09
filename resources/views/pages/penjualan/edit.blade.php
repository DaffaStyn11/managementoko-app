@extends('layouts.app')

@section('content')
    <div class="flex">

        @include('components.sidebar')

        <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">

            @include('components.header')

            <main class="p-6 flex-grow">

                <div class="mb-6">
                    <a href="{{ route('penjualan.index') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 mb-4">
                        <i data-feather="arrow-left" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Kembali</span>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Penjualan</h1>
                    <p class="text-gray-500 text-sm mt-1">Perbarui informasi penjualan.</p>
                </div>

                <div class="max-w-4xl">
                    <div class="bg-white rounded-xl shadow border p-6">
                        <form action="{{ route('penjualan.update', $penjualan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <div>
                                    <label for="kode_penjualan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode Penjualan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="kode_penjualan" id="kode_penjualan"
                                        value="{{ old('kode_penjualan', $penjualan->kode_penjualan) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('kode_penjualan') border-red-500 @enderror"
                                        readonly>
                                    @error('kode_penjualan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tanggal_penjualan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Penjualan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_penjualan" id="tanggal_penjualan"
                                        value="{{ old('tanggal_penjualan', $penjualan->tanggal_penjualan->format('Y-m-d')) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('tanggal_penjualan') border-red-500 @enderror">
                                    @error('tanggal_penjualan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="produk_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Produk <span class="text-red-500">*</span>
                                    </label>
                                    <select name="produk_id" id="produk_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('produk_id') border-red-500 @enderror"
                                        onchange="updateHargaStok()">
                                        <option value="">Pilih Produk</option>
                                        @foreach ($produks as $produk)
                                            <option value="{{ $produk->id }}" 
                                                data-harga="{{ $produk->harga_jual }}"
                                                data-stok="{{ $produk->stok }}"
                                                data-satuan="{{ $produk->satuan }}"
                                                {{ old('produk_id', $penjualan->produk_id) == $produk->id ? 'selected' : '' }}>
                                                {{ $produk->nama_produk }} (Stok: {{ $produk->stok }} {{ $produk->satuan }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('produk_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p id="stokInfo" class="text-xs text-gray-500 mt-1"></p>
                                </div>

                                <div>
                                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="jumlah" id="jumlah"
                                        value="{{ old('jumlah', $penjualan->jumlah) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror"
                                        min="1" onchange="hitungTotal()">
                                    @error('jumlah')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="harga_satuan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Harga Satuan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="harga_satuan" id="harga_satuan"
                                        value="{{ old('harga_satuan', $penjualan->harga_satuan) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('harga_satuan') border-red-500 @enderror"
                                        step="0.01" onchange="hitungTotal()">
                                    @error('harga_satuan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="total_harga_display" class="block text-sm font-medium text-gray-700 mb-2">
                                        Total Harga
                                    </label>
                                    <input type="text" id="total_harga_display"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                        placeholder="Rp 0" readonly>
                                </div>

                                <div>
                                    <label for="nama_pembeli" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Pembeli (Opsional)
                                    </label>
                                    <input type="text" name="nama_pembeli" id="nama_pembeli"
                                        value="{{ old('nama_pembeli', $penjualan->nama_pembeli) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        placeholder="Nama pembeli">
                                </div>

                            </div>

                            <div class="mt-4">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan (Opsional)
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Catatan penjualan...">{{ old('keterangan', $penjualan->keterangan) }}</textarea>
                            </div>

                            <div class="flex gap-3 mt-6">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
                                    <span class="text-sm font-medium">Perbarui</span>
                                </button>
                                <a href="{{ route('penjualan.index') }}"
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
    
    @include('components.scripts')
    
    <script>
        function updateHargaStok() {
            const select = document.getElementById('produk_id');
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                const harga = option.getAttribute('data-harga');
                const stok = option.getAttribute('data-stok');
                const satuan = option.getAttribute('data-satuan');
                
                document.getElementById('harga_satuan').value = harga;
                document.getElementById('stokInfo').textContent = `Stok tersedia: ${stok} ${satuan}`;
                
                hitungTotal();
            } else {
                document.getElementById('harga_satuan').value = '';
                document.getElementById('stokInfo').textContent = '';
            }
        }
        
        function hitungTotal() {
            const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
            const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
            const total = jumlah * hargaSatuan;
            
            document.getElementById('total_harga_display').value = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updateHargaStok();
            hitungTotal();
        });
    </script>
@endsection
