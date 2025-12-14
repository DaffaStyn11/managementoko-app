@extends('layouts.app')

@section('content')
    <div class="flex">

        {{-- SIDEBAR --}}
        @include('components.sidebar')

        {{-- MAIN --}}
        <div id="mainContent" class="ml-64 w-full transition-all duration-300 min-h-screen flex flex-col">

            {{-- HEADER --}}
            @include('components.header')

            {{-- PAGE CONTENT --}}
            <main class="p-6 flex-grow">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Penjualan</h1>
                        <p class="text-gray-500 text-sm mt-1">Catat dan pantau transaksi penjualan setiap hari.</p>
                    </div>

                    <button onclick="openCreateModals()" type="button"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow transition-colors">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Penjualan
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

                {{-- Statistik --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Penjualan Hari Ini</p>
                                <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="dollar-sign" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Jumlah Transaksi</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $jumlahTransaksi }}</h3>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <i data-feather="shopping-bag" class="w-8 h-8 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border shadow p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Produk Terlaris</p>
                                <h3 class="text-xl font-semibold mt-1">{{ $produkTerlaris->produk->nama_produk ?? '-' }}
                                </h3>
                            </div>
                            <div class="p-3 bg-orange-50 rounded-lg">
                                <i data-feather="award" class="w-8 h-8 text-orange-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABEL PENJUALAN --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Transaksi</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari kode/produk..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">Kode</th>
                                <th class="py-3 px-2">Produk</th>
                                <th class="py-3 px-2">Jumlah</th>
                                <th class="py-3 px-2">Harga</th>
                                <th class="py-3 px-2">Total</th>
                                <th class="py-3 px-2">Tanggal</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($penjualans as $penjualan)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-2 font-mono text-xs">{{ $penjualan->kode_penjualan }}</td>
                                    <td class="py-3 px-2 font-medium text-gray-700">{{ $penjualan->produk->nama_produk }}
                                    </td>
                                    <td class="py-3 px-2">{{ $penjualan->jumlah }} {{ $penjualan->produk->satuan }}</td>
                                    <td class="py-3 px-2">Rp {{ number_format($penjualan->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="py-3 px-2 font-semibold">Rp
                                        {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-3 px-2">{{ $penjualan->tanggal_penjualan->format('d/m/Y') }}</td>
                                    <td class="py-3 px-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" onclick="editPenjualan({{ $penjualan->id }})"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                                                <i data-feather="edit" class="w-4 h-4"></i>
                                            </button>

                                            <form action="{{ route('penjualan.destroy', $penjualan) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus penjualan ini? Stok produk akan dikembalikan.')">
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
                                            <p>Belum ada transaksi penjualan. Tambahkan penjualan pertama Anda!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </main>

            {{-- FOOTER --}}
            @include('components.footer')
        </div>
    </div>

    {{-- SCRIPT --}}
    @include('components.scripts')

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#tableBody tr:not(#emptyRow)');
            let visibleCount = 0;

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) {
                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        });

        // Open Create Modal
        async function openCreateModals() {
            try {
                const response = await fetch('/penjualan/create', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();

                if (data.success) {
                    document.getElementById('create_kode_penjualan').value = data.kode_penjualan;

                    const produkSelect = document.getElementById('create_produk_id');
                    produkSelect.innerHTML = '<option value="">Pilih Produk</option>';

                    data.produks.forEach(p => {
                        const label = `${p.nama_produk} (Stok: ${p.stok})`;
                        produkSelect.innerHTML +=
                            `<option value="${p.id}" data-harga="${p.harga_jual}">${label}</option>`;
                    });

                    openModal('createModal');
                }
            } catch (error) {
                console.error(error);
            }
        }

        // Handle Product Selection Change (Create)
        document.getElementById('create_produk_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            if (harga) {
                document.getElementById('create_harga_satuan').value = harga;
                calculateTotal('create');
            }
        });

        document.getElementById('create_jumlah').addEventListener('input', () => calculateTotal('create'));
        document.getElementById('create_harga_satuan').addEventListener('input', () => calculateTotal('create'));

        function calculateTotal(prefix) {
            const jumlah = document.getElementById(`${prefix}_jumlah`).value || 0;
            const harga = document.getElementById(`${prefix}_harga_satuan`).value || 0;
            const total = jumlah * harga;
            document.getElementById(`${prefix}_total_display`).textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                total);
        }

        // Submit Create
        async function submitCreate(event) {
            event.preventDefault();
            const btnText = document.getElementById('createBtnText');
            const btnLoad = document.getElementById('createBtnLoading');

            btnText.classList.add('hidden');
            btnLoad.classList.remove('hidden');

            const formData = new FormData(event.target);

            try {
                const response = await fetch('/penjualan', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    closeModal('createModal');
                    showAlert('success', data.message);
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    if (data.errors) showAlert('error', Object.values(data.errors).flat()[0]);
                }
            } catch (error) {
                console.error(error);
                showAlert('error', 'Gagal menyimpan data.');
            } finally {
                btnText.classList.remove('hidden');
                btnLoad.classList.add('hidden');
            }
        }

        // Edit Penjualan
        async function editPenjualan(id) {
            try {
                const response = await fetch(`/penjualan/${id}/edit`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();

                if (data.success) {
                    document.getElementById('edit_penjualan_id').value = data.data.id;
                    document.getElementById('edit_kode_penjualan').value = data.data.kode_penjualan;
                    document.getElementById('edit_tanggal_penjualan').value = data.data.tanggal_penjualan.split('T')[0];
                    document.getElementById('edit_jumlah').value = data.data.jumlah;
                    document.getElementById('edit_harga_satuan').value = data.data.harga_satuan;
                    document.getElementById('edit_nama_pembeli').value = data.data.nama_pembeli || '';
                    document.getElementById('edit_keterangan').value = data.data.keterangan || '';

                    const produkSelect = document.getElementById('edit_produk_id');
                    produkSelect.innerHTML = '<option value="">Pilih Produk</option>';
                    data.produks.forEach(p => {
                        const selected = p.id === data.data.produk_id ? 'selected' : '';
                        const label = `${p.nama_produk} (Stok: ${p.stok})`;
                        produkSelect.innerHTML +=
                            `<option value="${p.id}" data-harga="${p.harga_jual}" ${selected}>${label}</option>`;
                    });

                    calculateTotal('edit');
                    openModal('editModal');
                }
            } catch (error) {
                console.error(error);
            }
        }

        // Handle Product Selection Change (Edit)
        document.getElementById('edit_produk_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            if (harga) {
                document.getElementById('edit_harga_satuan').value = harga;
                calculateTotal('edit');
            }
        });

        document.getElementById('edit_jumlah').addEventListener('input', () => calculateTotal('edit'));
        document.getElementById('edit_harga_satuan').addEventListener('input', () => calculateTotal('edit'));

        // Submit Edit
        async function submitEdit(event) {
            event.preventDefault();
            const id = document.getElementById('edit_penjualan_id').value;
            const btnText = document.getElementById('editBtnText');
            const btnLoad = document.getElementById('editBtnLoading');

            btnText.classList.add('hidden');
            btnLoad.classList.remove('hidden');

            const formData = new FormData(event.target);

            try {
                const response = await fetch(`/penjualan/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();

                if (data.success) {
                    closeModal('editModal');
                    showAlert('success', data.message);
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    if (data.errors) showAlert('error', Object.values(data.errors).flat()[0]);
                }
            } catch (error) {
                console.error(error);
                showAlert('error', 'Gagal mengupdate data.');
            } finally {
                btnText.classList.remove('hidden');
                btnLoad.classList.add('hidden');
            }
        }

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
    <x-modal id="createModal" title="Tambah Penjualan Baru">
        <form id="createForm" onsubmit="submitCreate(event)">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Penjualan</label>
                    <input type="text" name="kode_penjualan" id="create_kode_penjualan" readonly
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-900 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penjualan <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_penjualan" id="create_tanggal_penjualan"
                        value="{{ date('Y-m-d') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produk <span
                            class="text-red-500">*</span></label>
                    <select name="produk_id" id="create_produk_id" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                        <option value="">Pilih Produk</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" id="create_jumlah" required min="1"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Satuan <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="harga_satuan" id="create_harga_satuan" required min="0"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div class="col-span-2 bg-blue-50 p-3 rounded-xl flex justify-between items-center">
                    <span class="text-sm font-medium text-blue-700">Total Harga:</span>
                    <span id="create_total_display" class="text-lg font-bold text-blue-800">Rp 0</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pembeli</label>
                    <input type="text" name="nama_pembeli" id="create_nama_pembeli" placeholder="Umum"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" id="create_keterangan" rows="2"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none resize-none"></textarea>
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
    <x-modal id="editModal" title="Edit Penjualan">
        <form id="editForm" onsubmit="submitEdit(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_penjualan_id">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Penjualan</label>
                    <input type="text" name="kode_penjualan" id="edit_kode_penjualan" readonly
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-900 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penjualan <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_penjualan" id="edit_tanggal_penjualan" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Produk <span
                            class="text-red-500">*</span></label>
                    <select name="produk_id" id="edit_produk_id" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" id="edit_jumlah" required min="1"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Satuan <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="harga_satuan" id="edit_harga_satuan" required min="0"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div class="col-span-2 bg-blue-50 p-3 rounded-xl flex justify-between items-center">
                    <span class="text-sm font-medium text-blue-700">Total Harga:</span>
                    <span id="edit_total_display" class="text-lg font-bold text-blue-800">Rp 0</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pembeli</label>
                    <input type="text" name="nama_pembeli" id="edit_nama_pembeli"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" id="edit_keterangan" rows="2"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 transition-all outline-none resize-none"></textarea>
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
