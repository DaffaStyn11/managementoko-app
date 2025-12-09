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
                    <a href="{{ route('kategori.index') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 mb-4">
                        <i data-feather="arrow-left" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Kembali</span>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Kategori</h1>
                    <p class="text-gray-500 text-sm mt-1">Perbarui informasi kategori.</p>
                </div>

                {{-- Form Card --}}
                <div class="max-w-2xl">
                    <div class="bg-white rounded-xl shadow border p-6">
                        <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_kategori" id="nama_kategori"
                                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kategori') border-red-500 @enderror"
                                    placeholder="Contoh: Elektronik, Pakaian, Makanan">
                                @error('nama_kategori')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi (Opsional)
                                </label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            </div>

                            <div class="flex gap-3">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
                                    <span class="text-sm font-medium">Perbarui</span>
                                </button>
                                <a href="{{ route('kategori.index') }}"
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
