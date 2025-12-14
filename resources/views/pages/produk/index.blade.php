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

                    {{-- Header Produk --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Produk</h1>
                            <p class="text-gray-500 text-sm mt-1">Kelola semua produk di toko Anda.</p>
                        </div>

                        <button onclick="openCreateModals()" type="button"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow transition-colors">
                            <i data-feather="plus" class="w-4"></i>
                            Tambah Produk
                        </button>
                    </div>

                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow">
                            <span class="text-sm">{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                                <i data-feather="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow">
                            <span class="text-sm">{{ session('error') }}</span>
                            <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                                <i data-feather="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Card Statistik --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                        <div class="bg-white rounded-xl shadow border p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Total Produk</p>
                                    <h3 class="text-2xl font-bold mt-1">{{ $totalProduk }}</h3>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-lg">
                                    <i data-feather="package" class="w-8 h-8 text-blue-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow border p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Total Stok</p>
                                    <h3 class="text-2xl font-bold mt-1">{{ number_format($totalStok) }}</h3>
                                </div>
                                <div class="p-3 bg-green-50 rounded-lg">
                                    <i data-feather="layers" class="w-8 h-8 text-green-600"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow border p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Kategori</p>
                                    <h3 class="text-2xl font-bold mt-1">{{ $totalKategori }}</h3>
                                </div>
                                <div class="p-3 bg-purple-50 rounded-lg">
                                    <i data-feather="grid" class="w-8 h-8 text-purple-600"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Tabel Produk --}}
                    <div class="bg-white shadow border rounded-xl p-6">

                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Daftar Produk</h3>

                            <div class="flex items-center gap-2">
                                <input type="text" id="searchInput" placeholder="Cari produk..."
                                    class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                                <select id="filterKategori" class="px-3 py-2 text-sm border rounded-lg focus:outline-none">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($produks->pluck('kategori.nama_kategori')->unique()->filter() as $kategori)
                                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table class="w-full text-left text-sm">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="py-3 px-2">Kode</th>
                                    <th class="py-3 px-2">Nama Produk</th>
                                    <th class="py-3 px-2">Kategori</th>
                                    <th class="py-3 px-2">Harga Jual</th>
                                    <th class="py-3 px-2">Stok</th>
                                    <th class="py-3 px-2">Status</th>
                                    <th class="py-3 px-2 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="tableBody">
                                @forelse ($produks as $produk)
                                    <tr class="border-b hover:bg-gray-50"
                                        data-kategori="{{ $produk->kategori->nama_kategori ?? '' }}">
                                        <td class="py-3 px-2 font-mono text-xs">{{ $produk->kode_produk }}</td>
                                        <td class="py-3 px-2 font-medium text-gray-900">{{ $produk->nama_produk }}</td>
                                        <td class="py-3 px-2 text-gray-600">{{ $produk->kategori->nama_kategori ?? '-' }}
                                        </td>
                                        <td class="py-3 px-2 text-gray-900">Rp
                                            {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                                        <td class="py-3 px-2">
                                            <span
                                                class="px-2 py-1 rounded text-xs {{ $produk->isStokRendah() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $produk->stok }} {{ $produk->satuan }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2">
                                            <span
                                                class="px-2 py-1 rounded text-xs {{ $produk->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                {{ $produk->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" onclick="editProduk({{ $produk->id }})"
                                                    class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                                                    <i data-feather="edit" class="w-4 h-4"></i>
                                                </button>

                                                <form action="{{ route('produk.destroy', $produk) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="emptyRow">
                                        <td colspan="7" class="py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i data-feather="inbox" class="w-12 h-12 mb-2 text-gray-400"></i>
                                                <p>Belum ada produk. Tambahkan produk pertama Anda!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </main>
                @include('components.footer')

            </div>

        </div>
        {{-- SCRIPT --}}
        @include('components.scripts')

        <script>
            const searchInput = document.getElementById('searchInput');
            const filterKategori = document.getElementById('filterKategori');
            const tableBody = document.getElementById('tableBody');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const kategoriValue = filterKategori.value.toLowerCase();
                const rows = tableBody.querySelectorAll('tr:not(#emptyRow)');
                let visibleCount = 0;

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const kategori = row.getAttribute('data-kategori').toLowerCase();

                    const matchSearch = text.includes(searchValue);
                    const matchKategori = kategoriValue === '' || kategori === kategoriValue;

                    if (matchSearch && matchKategori) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide empty state
                const emptyRow = document.getElementById('emptyRow');
                if (emptyRow) {
                    emptyRow.style.display = visibleCount === 0 ? '' : 'none';
                }
            }

            searchInput.addEventListener('keyup', filterTable);
            filterKategori.addEventListener('change', filterTable);

            // Open Create Modal
            async function openCreateModals() {
                try {
                    const response = await fetch('/produk/create', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('create_kode_produk').value = data.kode_produk;

                        const kategoriSelect = document.getElementById('create_kategori_id');
                        kategoriSelect.innerHTML = '<option value="">Pilih Kategori</option>';
                        data.kategoris.forEach(kat => {
                            kategoriSelect.innerHTML += `<option value="${kat.id}">${kat.nama_kategori}</option>`;
                        });

                        openModal('createModal');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Submit Create
            async function submitCreate(event) {
                event.preventDefault();

                document.getElementById('createBtnText').classList.add('hidden');
                document.getElementById('createBtnLoading').classList.remove('hidden');

                const formData = new FormData(event.target);

                try {
                    const response = await fetch('/produk', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        closeModal('createModal');
                        showAlert('success', data.message);
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    document.getElementById('createBtnText').classList.remove('hidden');
                    document.getElementById('createBtnLoading').classList.add('hidden');
                }
            }

            // Edit Produk
            async function editProduk(id) {
                try {
                    const response = await fetch(`/produk/${id}/edit`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('edit_produk_id').value = data.data.id;
                        document.getElementById('edit_kode_produk').value = data.data.kode_produk;
                        document.getElementById('edit_nama_produk').value = data.data.nama_produk;
                        document.getElementById('edit_deskripsi').value = data.data.deskripsi || '';
                        document.getElementById('edit_harga_beli').value = data.data.harga_beli;
                        document.getElementById('edit_harga_jual').value = data.data.harga_jual;
                        document.getElementById('edit_stok').value = data.data.stok;
                        document.getElementById('edit_stok_minimum').value = data.data.stok_minimum;
                        document.getElementById('edit_satuan').value = data.data.satuan;
                        document.getElementById('edit_barcode').value = data.data.barcode || '';
                        document.getElementById('edit_is_active').checked = data.data.is_active;

                        const kategoriSelect = document.getElementById('edit_kategori_id');
                        kategoriSelect.innerHTML = '';
                        data.kategoris.forEach(kat => {
                            const selected = kat.id === data.data.kategori_id ? 'selected' : '';
                            kategoriSelect.innerHTML +=
                                `<option value="${kat.id}" ${selected}>${kat.nama_kategori}</option>`;
                        });

                        openModal('editModal');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Submit Edit
            async function submitEdit(event) {
                event.preventDefault();

                const id = document.getElementById('edit_produk_id').value;

                document.getElementById('editBtnText').classList.add('hidden');
                document.getElementById('editBtnLoading').classList.remove('hidden');

                const formData = new FormData(event.target);

                try {
                    const response = await fetch(`/produk/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        closeModal('editModal');
                        showAlert('success', data.message);
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    document.getElementById('editBtnText').classList.remove('hidden');
                    document.getElementById('editBtnLoading').classList.add('hidden');
                }
            }

            // Show Alert
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' :
                    'bg-red-100 border-red-400 text-red-700';
                const alert = document.createElement('div');
                alert.className = `${alertClass} px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow`;
                alert.innerHTML = `
                    <span class="text-sm">${message}</span>
                    <button onclick="this.parentElement.remove()" class="${type === 'success' ? 'text-green-700 hover:text-green-900' : 'text-red-700 hover:text-red-900'}">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                `;

                const main = document.querySelector('main');
                main.insertBefore(alert, main.firstChild);
                feather.replace();

                setTimeout(() => alert.remove(), 5000);
            }
        </script>

        {{-- Create Modal --}}
        <x-modal id="createModal" title="Tambah Produk Baru">
            <form id="createForm" onsubmit="submitCreate(event)">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Produk <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="kode_produk" id="create_kode_produk" readonly required
                            class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-900 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_produk" id="create_nama_produk" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span
                                class="text-red-500">*</span></label>
                        <select name="kategori_id" id="create_kategori_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                            <option value="">Pilih Kategori</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="create_deskripsi" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Beli <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="harga_beli" id="create_harga_beli" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Jual <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="harga_jual" id="create_harga_jual" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="stok" id="create_stok" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok Minimum <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="stok_minimum" id="create_stok_minimum" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Satuan <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="satuan" id="create_satuan" required
                            placeholder="pcs, kg, liter, dll"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Barcode</label>
                        <input type="text" name="barcode" id="create_barcode"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" id="create_is_active" checked
                                class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-sm text-gray-700">Produk Aktif</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 mt-4 border-t">
                    <button type="button" onclick="closeModal('createModal')"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all">
                        <span id="createBtnText">Simpan</span>
                        <span id="createBtnLoading" class="hidden">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Edit Modal --}}
        <x-modal id="editModal" title="Edit Produk">
            <form id="editForm" onsubmit="submitEdit(event)">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_produk_id">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Produk <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="kode_produk" id="edit_kode_produk" readonly required
                            class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-900 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_produk" id="edit_nama_produk" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span
                                class="text-red-500">*</span></label>
                        <select name="kategori_id" id="edit_kategori_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Beli <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="harga_beli" id="edit_harga_beli" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Jual <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="harga_jual" id="edit_harga_jual" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="stok" id="edit_stok" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok Minimum <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="stok_minimum" id="edit_stok_minimum" required min="0"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Satuan <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="satuan" id="edit_satuan" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Barcode</label>
                        <input type="text" name="barcode" id="edit_barcode"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" id="edit_is_active"
                                class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-sm text-gray-700">Produk Aktif</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 mt-4 border-t">
                    <button type="button" onclick="closeModal('editModal')"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all">
                        <span id="editBtnText">Update</span>
                        <span id="editBtnLoading" class="hidden">Mengupdate...</span>
                    </button>
                </div>
            </form>
        </x-modal>
    @endsection
