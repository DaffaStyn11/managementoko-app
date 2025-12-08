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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <p class="text-gray-600 text-sm">Total Produk</p>
                        <h3 class="text-2xl font-bold mt-1">120</h3>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <p class="text-gray-600 text-sm">Jumlah Stok</p>
                        <h3 class="text-2xl font-bold mt-1">3.270</h3>
                    </div>

                    <div class="p-5 bg-white rounded-xl shadow border">
                        <p class="text-gray-600 text-sm">Total Supplier</p>
                        <h3 class="text-2xl font-bold mt-1">24</h3>
                    </div>

                </div>

            </main>

            {{-- FOOTER --}}
            @include('components.footer')

        </div>
    </div>
    {{-- SCRIPT --}}
    @include('components.scripts')
@endsection
