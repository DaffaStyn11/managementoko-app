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

                {{-- Header Kategori --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Kategori</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola kategori produk toko Anda.</p>
                    </div>

                    <button onclick="openModal('createModal')" type="button"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow transition-colors">
                        <i data-feather="plus" class="w-4"></i>
                        Tambah Kategori
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
                                <p class="text-gray-600 text-sm">Total Kategori</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $kategoris->count() }}</h3>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <i data-feather="folder" class="w-8 h-8 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Kategori Aktif</p>
                                <h3 class="text-2xl font-bold mt-1">{{ $kategoris->count() }}</h3>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg">
                                <i data-feather="check-circle" class="w-8 h-8 text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow border p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Ditambahkan Bulan Ini</p>
                                <h3 class="text-2xl font-bold mt-1">
                                    {{ $kategoris->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            </div>
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <i data-feather="calendar" class="w-8 h-8 text-purple-600"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Tabel Kategori --}}
                <div class="bg-white shadow border rounded-xl p-6">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Kategori</h3>

                        <div class="flex items-center gap-2">
                            <input type="text" id="searchInput" placeholder="Cari kategori..."
                                class="px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="py-3 px-2">No</th>
                                <th class="py-3 px-2">Nama Kategori</th>
                                <th class="py-3 px-2">Deskripsi</th>
                                <th class="py-3 px-2">Tanggal Pembuatan</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            @forelse ($kategoris as $index => $kategori)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-2">{{ $index + 1 }}</td>
                                    <td class="py-3 px-2 font-medium text-gray-900">{{ $kategori->nama_kategori }}</td>
                                    <td class="py-3 px-2 text-gray-600">
                                        {{ $kategori->deskripsi ? Str::limit($kategori->deskripsi, 50) : '-' }}
                                    </td>
                                    <td class="py-3 px-2 text-gray-600">{{ $kategori->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3 px-2 text-center">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Edit --}}
                                            <button type="button" onclick="editKategori({{ $kategori->id }})"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                                                <i data-feather="edit" class="w-4 h-4"></i>
                                            </button>

                                            {{-- Delete --}}
                                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                                    <td colspan="5" class="py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="inbox" class="w-12 h-12 mb-2 text-gray-400"></i>
                                            <p>Belum ada kategori. Tambahkan kategori pertama Anda!</p>
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

    {{-- Create Modal --}}
    <x-modal id="createModal" title="Tambah Kategori Baru">
        <form id="createForm" onsubmit="submitCreate(event)">
            @csrf
            <div class="space-y-4">
                <!-- Nama Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kategori" id="create_nama_kategori" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                        placeholder="Contoh: Elektronik">
                    <div id="create_nama_kategori_error" class="text-red-600 text-xs mt-1 hidden"></div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="create_deskripsi" rows="4"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none resize-none"
                        placeholder="Deskripsi kategori (opsional)"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4">
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
            </div>
        </form>
    </x-modal>

    {{-- Edit Modal --}}
    <x-modal id="editModal" title="Edit Kategori">
        <form id="editForm" onsubmit="submitEdit(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_kategori_id">
            
            <div class="space-y-4">
                <!-- Nama Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kategori" id="edit_nama_kategori" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none"
                        placeholder="Contoh: Elektronik">
                    <div id="edit_nama_kategori_error" class="text-red-600 text-xs mt-1 hidden"></div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" rows="4"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none resize-none"
                        placeholder="Deskripsi kategori (opsional)"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4">
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
            </div>
        </form>
    </x-modal>

    <script>
        // Search functionality
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

            // Show/hide empty state
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) {
                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        });

        // Submit Create Form
        function submitCreate(event) {
            event.preventDefault();
            
            // Show loading
            document.getElementById('createBtnText').classList.add('hidden');
            document.getElementById('createBtnLoading').classList.remove('hidden');
            
            // Clear previous errors
            document.getElementById('create_nama_kategori_error').classList.add('hidden');
            document.getElementById('create_nama_kategori').classList.remove('border-red-500');
            
            const formData = new FormData(event.target);
            
            fetch('{{ route('kategori.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    closeModal('createModal');
                    
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Reload page to show new data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.response) {
                    error.response.json().then(err => {
                        if (err.errors) {
                            // Show validation errors
                            if (err.errors.nama_kategori) {
                                document.getElementById('create_nama_kategori_error').textContent = err.errors.nama_kategori[0];
                                document.getElementById('create_nama_kategori_error').classList.remove('hidden');
                                document.getElementById('create_nama_kategori').classList.add('border-red-500');
                            }
                        }
                    });
                }
            })
            .finally(() => {
                // Hide loading
                document.getElementById('createBtnText').classList.remove('hidden');
                document.getElementById('createBtnLoading').classList.add('hidden');
            });
        }

        // Edit Kategori
        function editKategori(id) {
            fetch(`/kategori/${id}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fill form
                    document.getElementById('edit_kategori_id').value = data.data.id;
                    document.getElementById('edit_nama_kategori').value = data.data.nama_kategori;
                    document.getElementById('edit_deskripsi').value = data.data.deskripsi || '';
                    
                    // Open modal
                    openModal('editModal');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Submit Edit Form
        function submitEdit(event) {
            event.preventDefault();
            
            const id = document.getElementById('edit_kategori_id').value;
            
            // Show loading
            document.getElementById('editBtnText').classList.add('hidden');
            document.getElementById('editBtnLoading').classList.remove('hidden');
            
            // Clear previous errors
            document.getElementById('edit_nama_kategori_error').classList.add('hidden');
            document.getElementById('edit_nama_kategori').classList.remove('border-red-500');
            
            const formData = new FormData(event.target);
            
            fetch(`/kategori/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    closeModal('editModal');
                    
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Reload page to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.response) {
                    error.response.json().then(err => {
                        if (err.errors) {
                            // Show validation errors
                            if (err.errors.nama_kategori) {
                                document.getElementById('edit_nama_kategori_error').textContent = err.errors.nama_kategori[0];
                                document.getElementById('edit_nama_kategori_error').classList.remove('hidden');
                                document.getElementById('edit_nama_kategori').classList.add('border-red-500');
                            }
                        }
                    });
                }
            })
            .finally(() => {
                // Hide loading
                document.getElementById('editBtnText').classList.remove('hidden');
                document.getElementById('editBtnLoading').classList.add('hidden');
            });
        }

        // Show Alert
        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
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
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
@endsection
