<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembelian — Dashboard Supermarket</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        .sidebar-expanded {
            width: 256px;
        }

        .sidebar-collapsed {
            width: 72px;
        }

        .sidebar-transition {
            transition: width 0.25s ease;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="sidebar-transition sidebar-expanded fixed h-screen bg-white border-r border-gray-200 flex flex-col justify-between p-4">
            <div>
                <h1 id="sidebarTitle" class="text-[#0d141c] text-lg font-semibold tracking-wide mb-4">Managemen
                    Toko</h1>

                <nav id="menuList" class="flex flex-col gap-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <i data-feather="home" class="w-5"></i> <span class="text-sm">Beranda</span>
                    </a>
                    <a href="{{ route('produk') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <i data-feather="package" class="w-5"></i> <span class="text-sm">Produk</span>
                    </a>
                    <a href="{{ route('pemasok') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <i data-feather="truck" class="w-5"></i> <span class="text-sm">Pemasok</span>
                    </a>
                    <a href="{{ route('stok') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <i data-feather="archive" class="w-5"></i> <span class="text-sm">Stok</span>
                    </a>
                    <a href="{{ route('penjualan') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <i data-feather="shopping-cart" class="w-5"></i> <span class="text-sm">Penjualan</span>
                    </a>
                    <a href="{{ route('pembelian') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg bg-[#e7edf4] text-[#0d141c] font-medium">
                        <i data-feather="credit-card" class="w-5"></i> <span class="text-sm">Pembelian</span>
                    </a>
                    <a href="{{ route('laporan') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <i data-feather="bar-chart-2" class="w-5"></i> <span class="text-sm">Laporan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- MAIN -->
        <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">
            <!-- HEADER -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
                <div class="px-4 py-4 flex items-center justify-between">
                    <button id="toggleSidebar"
                        class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200">
                        <i id="toggleIcon" data-feather="menu" class="w-5 h-5"></i>
                    </button>

                    <div class="relative">
                        <button id="adminButton"
                            class="flex items-center gap-3 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-100">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <i data-feather="user" class="w-4 h-4 text-white"></i>
                            </div>
                            <span class="text-gray-700 font-semibold text-sm hidden sm:block">Admin</span>
                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </button>

                        <div id="adminDropdown"
                            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">
                            <div class="p-3 border-b">
                                <p class="text-xs text-gray-500">Masuk sebagai</p>
                                <p class="font-semibold text-gray-900 text-sm">Administrator</p>
                            </div>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm"><i
                                    data-feather="user" class="w-4 h-4"></i> Profil Saya</a>
                            <form class="p-2 border-t">
                                <button
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-50 text-red-600"><i
                                        data-feather="log-out" class="w-4 h-4"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="p-6 flex-grow">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Pembelian</h1>
                        <p class="text-gray-500 text-sm mt-1">Catat dan pantau seluruh transaksi pembelian dari pemasok.
                        </p>
                    </div>
                    <a href="#"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        <i data-feather="plus" class="w-4"></i> Tambah Pembelian
                    </a>
                </div>

                <!-- STATISTIK -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Total Pengeluaran Hari Ini</p>
                        <h3 class="text-2xl font-bold mt-1">Rp 3.850.000</h3>
                    </div>
                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Jumlah Pembelian</p>
                        <h3 class="text-2xl font-bold mt-1">14 Transaksi</h3>
                    </div>
                    <div class="bg-white rounded-xl border shadow p-5">
                        <p class="text-gray-600 text-sm">Pemasok Teraktif</p>
                        <h3 class="text-xl font-semibold mt-1">PT Sumber Jaya</h3>
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

                <!-- TABEL PEMBELIAN -->
                <div class="bg-white shadow border rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Riwayat Pembelian</h3>
                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Cari pembelian..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <select class="px-3 py-2 text-sm border rounded-lg">
                                <option>Semua Tanggal</option>
                                <option>Hari Ini</option>
                                <option>Minggu Ini</option>
                                <option>Bulan Ini</option>
                            </select>
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Produk</th>
                                <th class="py-3 px-2">Pemasok</th>
                                <th class="py-3 px-2">Jumlah</th>
                                <th class="py-3 px-2">Harga Satuan</th>
                                <th class="py-3 px-2">Total</th>
                                <th class="py-3 px-2">Tanggal</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="py-3 px-2 font-medium text-gray-700">Indomie Goreng</td>
                                <td class="py-3 px-2">PT Sumber Jaya</td>
                                <td class="py-3 px-2">150</td>
                                <td class="py-3 px-2">Rp 2.000</td>
                                <td class="py-3 px-2 font-semibold">Rp 300.000</td>
                                <td class="py-3 px-2">2025-12-06</td>
                                <td class="py-3 px-2 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Edit --}}
                                        <button class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>

                                        {{-- Delete --}}
                                        <button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-3 px-2 font-medium text-gray-700">Gula Pasir</td>
                                <td class="py-3 px-2">PT Manis Makmur</td>
                                <td class="py-3 px-2">80 kg</td>
                                <td class="py-3 px-2">Rp 12.000</td>
                                <td class="py-3 px-2 font-semibold">Rp 960.000</td>
                                <td class="py-3 px-2">2025-12-06</td>
                                <td class="py-3 px-2 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- Edit --}}
                                        <button class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </button>

                                        {{-- Delete --}}
                                        <button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>

            <footer class="p-4 text-center text-gray-500 text-sm border-t bg-white">
                © 2025 Managemen Toko — Dashboard Supermarket
            </footer>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");
        const sidebarTitle = document.getElementById("sidebarTitle");
        const menuList = document.getElementById("menuList");
        const toggleSidebar = document.getElementById("toggleSidebar");
        const toggleIcon = document.getElementById("toggleIcon");

        let isCollapsed = false;
        toggleSidebar.addEventListener("click", () => {
            isCollapsed = !isCollapsed;
            if (isCollapsed) {
                sidebar.classList.add("sidebar-collapsed");
                sidebar.classList.remove("sidebar-expanded");
                mainContent.classList.add("ml-[72px]");
                mainContent.classList.remove("ml-64");
                sidebarTitle.classList.add("hidden");
                menuList.querySelectorAll("span").forEach(e => e.classList.add("hidden"));
                toggleIcon.dataset.feather = "x";
            } else {
                sidebar.classList.add("sidebar-expanded");
                sidebar.classList.remove("sidebar-collapsed");
                mainContent.classList.add("ml-64");
                mainContent.classList.remove("ml-[72px]");
                sidebarTitle.classList.remove("hidden");
                menuList.querySelectorAll("span").forEach(e => e.classList.remove("hidden"));
                toggleIcon.dataset.feather = "menu";
            }
            feather.replace();
        });

        const adminBtn = document.getElementById("adminButton");
        const dropdown = document.getElementById("adminDropdown");

        adminBtn.addEventListener("click", () => dropdown.classList.toggle("hidden"));

        document.addEventListener("click", e => {
            if (!adminBtn.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add("hidden");
        });

        feather.replace();
    </script>
</body>

</html>
