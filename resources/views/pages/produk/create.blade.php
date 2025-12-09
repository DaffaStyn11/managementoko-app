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
                    <a href="{{ route('produk.index') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 mb-4">
                        <i data-feather="arrow-left" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Kembali</span>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Tambah Produk</h1>
                    <p class="text-gray-500 text-sm mt-1">Tambahkan produk baru ke inventori.</p>
                </div>

                {{-- Form Card --}}
                <div class="max-w-4xl">
                    <div class="bg-white rounded-xl shadow border p-6">
                        <form action="{{ route('produk.store') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                {{-- Kode Produk --}}
                                <div>
                                    <label for="kode_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode Produk <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="kode_produk" id="kode_produk"
                                        value="{{ old('kode_produk', $kode_produk) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('kode_produk') border-red-500 @enderror"
                                        placeholder="PRD00001">
                                    @error('kode_produk')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nama Produk --}}
                                <div>
                                    <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Produk <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_produk" id="nama_produk"
                                        value="{{ old('nama_produk') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nama_produk') border-red-500 @enderror"
                                        placeholder="Contoh: Beras Premium 5kg">
                                    @error('nama_produk')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kategori --}}
                                <div>
                                    <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kategori_id" id="kategori_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('kategori_id') border-red-500 @enderror">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Barcode --}}
                                <div>
                                    <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">
                                        Barcode (Opsional)
                                    </label>
                                    <input type="text" name="barcode" id="barcode"
                                        value="{{ old('barcode') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        placeholder="8991234567890">
                                </div>

                                {{-- Harga Beli --}}
                                <div>
                                    <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-2">
                                        Harga Beli <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="harga_beli" id="harga_beli"
                                        value="{{ old('harga_beli') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('harga_beli') border-red-500 @enderror"
                                        placeholder="50000" step="0.01">
                                    @error('harga_beli')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Harga Jual --}}
                                <div>
                                    <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-2">
                                        Harga Jual <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="harga_jual" id="harga_jual"
                                        value="{{ old('harga_jual') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('harga_jual') border-red-500 @enderror"
                                        placeholder="65000" step="0.01">
                                    @error('harga_jual')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div>
                                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                                        Stok <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="stok" id="stok"
                                        value="{{ old('stok', 0) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('stok') border-red-500 @enderror"
                                        placeholder="100">
                                    @error('stok')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Stok Minimum --}}
                                <div>
                                    <label for="stok_minimum" class="block text-sm font-medium text-gray-700 mb-2">
                                        Stok Minimum <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="stok_minimum" id="stok_minimum"
                                        value="{{ old('stok_minimum', 10) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('stok_minimum') border-red-500 @enderror"
                                        placeholder="10">
                                    @error('stok_minimum')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Satuan --}}
                                <div>
                                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Satuan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="satuan" id="satuan"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('satuan') border-red-500 @enderror">
                                        <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                        <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                                        <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                        <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                                        <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>Pack</option>
                                        <option value="lusin" {{ old('satuan') == 'lusin' ? 'selected' : '' }}>Lusin</option>
                                    </select>
                                    @error('satuan')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- Deskripsi --}}
                            <div class="mt-4">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi (Opsional)
                                </label>
                                <textarea name="deskripsi" id="deskripsi" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Deskripsi produk...">{{ old('deskripsi') }}</textarea>
                            </div>

                            {{-- Status Aktif --}}
                            <div class="mt-4">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">Produk Aktif</span>
                                </label>
                            </div>

                            <div class="flex gap-3 mt-6">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
                                    <span class="text-sm font-medium">Simpan</span>
                                </button>
                                <a href="{{ route('produk.index') }}"
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
@endsection
