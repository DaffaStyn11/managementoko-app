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

                {{-- Header Pemasok --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Pemasok</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola semua pemasok di toko Anda.</p>
                    </div>

                    <button onclick="openCreateModals()" type="button"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow transition-colors">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Pemasok
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
                                <p class="text-gray-600 text-sm">Total Pemasok</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $totalPemasok }}</h3>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <i data-feather="users" class="w-8 h-8 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Kategori Pemasok</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $totalKategori }}</h3>
                            </div>
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <i data-feather="tag" class="w-8 h-8 text-purple-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Transaksi Aktif</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $transaksiAktif }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="activity" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Tabel Pemasok --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Pemasok</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari pemasok..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                            <select id="filterKategori" class="px-3 py-2 text-sm border rounded-lg focus:outline-none">
                                <option value="">Semua Kategori</option>
                                @foreach ($pemasoks->pluck('kategori_pemasok')->unique()->filter() as $kategori)
                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Nama Pemasok</th>
                                <th class="py-3 px-2">Produk Dipasok</th>
                                <th class="py-3 px-2">Kontak</th>
                                <th class="py-3 px-2">Alamat</th>
                                <th class="py-3 px-2">Kategori</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            @forelse ($pemasoks as $pemasok)
                                <tr class="border-b hover:bg-gray-50"
                                    data-kategori="{{ $pemasok->kategori_pemasok ?? '' }}">
                                    <td class="py-3 px-2 font-medium text-gray-900">{{ $pemasok->nama_pemasok }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ $pemasok->produk_yang_dipasok }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ $pemasok->kontak }}</td>
                                    <td class="py-3 px-2 text-gray-600">{{ Str::limit($pemasok->alamat, 30) }}</td>
                                    <td class="py-3 px-2">
                                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                            {{ $pemasok->kategori_pemasok ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" onclick="editPemasok({{ $pemasok->id }})"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                                                <i data-feather="edit" class="w-4 h-4"></i>
                                            </button>

                                            <form action="{{ route('pemasok.destroy', $pemasok) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemasok ini?')">
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
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="inbox" class="w-12 h-12 mb-2 text-gray-400"></i>
                                            <p>Belum ada pemasok. Tambahkan pemasok pertama Anda!</p>
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
                const response = await fetch('/pemasok/create', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();

                if (data.success) {
                    const produkContainer = document.getElementById('create_produk_wrapper');
                    produkContainer.innerHTML = '';

                    if (data.produks && data.produks.length > 0) {
                        data.produks.forEach(produk => {
                            const wrapper = document.createElement('label');
                            wrapper.className =
                                'flex items-center gap-2 p-2 border rounded-lg cursor-pointer hover:bg-gray-50';
                            wrapper.innerHTML = `
                                <input type="checkbox" name="produk_yang_dipasok[]" value="${produk.nama_produk}" class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-700">${produk.nama_produk}</span>
                            `;
                            produkContainer.appendChild(wrapper);
                        });
                    } else {
                        produkContainer.innerHTML =
                            '<p class="text-sm text-gray-500 italic p-2">Belum ada data produk.</p>';
                    }

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
                const response = await fetch('/pemasok', {
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
                } else {
                    if (data.errors) {
                        showAlert('error', Object.values(data.errors).flat()[0]);
                    } else {
                        showAlert('error', 'Terjadi kesalahan saat menyimpan data.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan sistem.');
            } finally {
                document.getElementById('createBtnText').classList.remove('hidden');
                document.getElementById('createBtnLoading').classList.add('hidden');
            }
        }

        // Edit Pemasok
        async function editPemasok(id) {
            try {
                const response = await fetch(`/pemasok/${id}/edit`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();

                if (data.success) {
                    document.getElementById('edit_pemasok_id').value = data.data.id;
                    document.getElementById('edit_nama_pemasok').value = data.data.nama_pemasok;
                    document.getElementById('edit_kontak').value = data.data.kontak;
                    document.getElementById('edit_alamat').value = data.data.alamat;
                    document.getElementById('edit_kategori_pemasok').value = data.data.kategori_pemasok || '';

                    const produkContainer = document.getElementById('edit_produk_wrapper');
                    produkContainer.innerHTML = '';

                    const existingProducts = data.data.produk_yang_dipasok ? data.data.produk_yang_dipasok.split(', ')
                        .map(s => s.trim()) : [];

                    if (data.produks && data.produks.length > 0) {
                        data.produks.forEach(produk => {
                            const isChecked = existingProducts.includes(produk.nama_produk) ? 'checked' : '';
                            const wrapper = document.createElement('label');
                            wrapper.className =
                                'flex items-center gap-2 p-2 border rounded-lg cursor-pointer hover:bg-gray-50';
                            wrapper.innerHTML = `
                                <input type="checkbox" name="produk_yang_dipasok[]" value="${produk.nama_produk}" ${isChecked} class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-700">${produk.nama_produk}</span>
                            `;
                            produkContainer.appendChild(wrapper);
                        });
                    } else {
                        produkContainer.innerHTML =
                            '<p class="text-sm text-gray-500 italic p-2">Belum ada data produk.</p>';
                    }

                    openModal('editModal');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Submit Edit
        async function submitEdit(event) {
            event.preventDefault();

            const id = document.getElementById('edit_pemasok_id').value;

            document.getElementById('editBtnText').classList.add('hidden');
            document.getElementById('editBtnLoading').classList.remove('hidden');

            const formData = new FormData(event.target);

            try {
                const response = await fetch(`/pemasok/${id}`, {
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
                } else {
                    if (data.errors) {
                        showAlert('error', Object.values(data.errors).flat()[0]);
                    } else {
                        showAlert('error', 'Terjadi kesalahan saat mengupdate data.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan sistem.');
            } finally {
                document.getElementById('editBtnText').classList.remove('hidden');
                document.getElementById('editBtnLoading').classList.add('hidden');
            }
        }

        // Show Alert
        function showAlert(type, message) {
            const existingAlerts = document.querySelectorAll('.alert-dynamic');
            existingAlerts.forEach(a => a.remove());

            const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' :
                'bg-red-100 border-red-400 text-red-700';
            const alert = document.createElement('div');
            alert.className =
                `${alertClass} alert-dynamic px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow`;
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
    <x-modal id="createModal" title="Tambah Pemasok Baru">
        <form id="createForm" onsubmit="submitCreate(event)">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemasok <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemasok" id="create_nama_pemasok" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produk Yang Dipasok <span
                            class="text-red-500">*</span></label>
                    <div id="create_produk_wrapper"
                        class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-2 border border-gray-200 rounded-xl bg-gray-50">
                        {{-- Checkboxes will be inserted via JS --}}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih produk.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="kontak" id="create_kontak" required placeholder="Email atau No. Telp"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat <span
                            class="text-red-500">*</span></label>
                    <textarea name="alamat" id="create_alamat" required rows="3"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Pemasok</label>
                    <input type="text" name="kategori_pemasok" id="create_kategori_pemasok"
                        placeholder="Contoh: Elektronik, Makanan (Opsional)"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
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
    <x-modal id="editModal" title="Edit Pemasok">
        <form id="editForm" onsubmit="submitEdit(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_pemasok_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemasok <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemasok" id="edit_nama_pemasok" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produk Yang Dipasok <span
                            class="text-red-500">*</span></label>
                    <div id="edit_produk_wrapper"
                        class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-2 border border-gray-200 rounded-xl bg-gray-50">
                        {{-- Checkboxes will be inserted via JS --}}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih produk.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="kontak" id="edit_kontak" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat <span
                            class="text-red-500">*</span></label>
                    <textarea name="alamat" id="edit_alamat" required rows="3"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Pemasok</label>
                    <input type="text" name="kategori_pemasok" id="edit_kategori_pemasok"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
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
