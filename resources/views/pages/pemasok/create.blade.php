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
                    <a href="{{ route('pemasok.index') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 mb-4">
                        <i data-feather="arrow-left" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Kembali</span>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Tambah Pemasok</h1>
                    <p class="text-gray-500 text-sm mt-1">Tambahkan pemasok baru ke sistem.</p>
                </div>

                {{-- Form Card --}}
                <div class="max-w-4xl">
                    <div class="bg-white rounded-xl shadow border p-6">
                        <form action="{{ route('pemasok.store') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                {{-- Nama Pemasok --}}
                                <div>
                                    <label for="nama_pemasok" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Pemasok <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_pemasok" id="nama_pemasok"
                                        value="{{ old('nama_pemasok') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nama_pemasok') border-red-500 @enderror"
                                        placeholder="Contoh: PT Sumber Makmur">
                                    @error('nama_pemasok')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Produk yang Dipasok --}}
                                <div class="md:col-span-2">
                                    <label for="produk_yang_dipasok" class="block text-sm font-medium text-gray-700 mb-2">
                                        Produk yang Dipasok <span class="text-red-500">*</span>
                                    </label>
                                    <select name="produk_yang_dipasok[]" id="produk_yang_dipasok" multiple
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('produk_yang_dipasok') border-red-500 @enderror">
                                        @foreach($produks as $produk)
                                            <option value="{{ $produk->nama_produk }}" 
                                                {{ in_array($produk->nama_produk, old('produk_yang_dipasok', [])) ? 'selected' : '' }}>
                                                {{ $produk->nama_produk }} ({{ $produk->kategori->nama_kategori ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-gray-500 text-xs mt-1">Pilih satu atau lebih produk yang dipasok oleh pemasok ini</p>
                                    @error('produk_yang_dipasok')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kontak --}}
                                <div>
                                    <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kontak <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="kontak" id="kontak"
                                        value="{{ old('kontak') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('kontak') border-red-500 @enderror"
                                        placeholder="Contoh: 081234567890">
                                    @error('kontak')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kategori Pemasok --}}
                                <div>
                                    <label for="kategori_pemasok" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kategori Pemasok (Opsional)
                                    </label>
                                    <input type="text" name="kategori_pemasok" id="kategori_pemasok"
                                        value="{{ old('kategori_pemasok') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        placeholder="Contoh: Sembako, Minuman">
                                </div>

                            </div>

                            {{-- Alamat --}}
                            <div class="mt-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror"
                                    placeholder="Alamat lengkap pemasok...">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-3 mt-6">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
                                    <span class="text-sm font-medium">Simpan</span>
                                </button>
                                <a href="{{ route('pemasok.index') }}"
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

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#produk_yang_dipasok').select2({
                placeholder: 'Pilih produk yang dipasok...',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
