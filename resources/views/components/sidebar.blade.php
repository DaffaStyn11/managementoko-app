<aside id="sidebar"
    class="sidebar-transition sidebar-expanded fixed h-screen bg-white border-r border-gray-200 flex flex-col justify-between p-4">

    <div>
        <h1 id="sidebarTitle" class="text-[#0d141c] text-lg font-semibold tracking-wide mb-4">
            Managemen Toko
        </h1>

        {{-- MENU --}}
        <nav id="menuList" class="flex flex-col gap-1">

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('dashboard') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="home" class="w-5"></i>
                <span class="text-sm">Beranda</span>
            </a>

            
            <a href="{{ route('kategori.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('kategori*') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="tag" class="w-5"></i>
                <span class="text-sm">Kategori</span>
            </a>

            <a href="{{ route('produk.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('produk*') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="package" class="w-5"></i>
                <span class="text-sm">Produk</span>
            </a>


            <a href="{{ route('stok.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('stok*') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="archive" class="w-5"></i>
                <span class="text-sm">Stok</span>
            </a>

            <a href="{{ route('pemasok.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('pemasok*') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="truck" class="w-5"></i>
                <span class="text-sm">Pemasok</span>
            </a>

            <a href="{{ route('penjualan.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('penjualan*') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="shopping-cart" class="w-5"></i>
                <span class="text-sm">Penjualan</span>
            </a>

            <a href="{{ route('pembelian.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('pembelian*') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="credit-card" class="w-5"></i>
                <span class="text-sm">Pembelian</span>
            </a>

            <a href="{{ route('laporan') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg
                {{ Route::is('laporan*') ? 'bg-[#e7edf4] text-[#0d141c] font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
                <i data-feather="bar-chart-2" class="w-5"></i>
                <span class="text-sm">Laporan</span>
            </a>

        </nav>
    </div>

</aside>
