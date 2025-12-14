<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pemasok;
use App\Models\Produk;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('pemasok')->latest()->get();
        $totalPembelian = $pembelians->count();
        $totalNilai = $pembelians->sum('total_harga');
        $pembelianPending = $pembelians->where('status', 'pending')->count();
        
        return view('pages.pembelian.index', compact('pembelians', 'totalPembelian', 'totalNilai', 'pembelianPending'));
    }

    public function create()
    {
        $pemasoks = \App\Models\Pemasok::all();
        $kode_pembelian = $this->generateKodePembelian();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'kode_pembelian' => $kode_pembelian,
                'pemasoks' => $pemasoks
            ]);
        }

        return view('pages.pembelian.create', compact('pemasoks', 'kode_pembelian'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pembelian' => 'required|string|unique:pembelians,kode_pembelian',
            'pemasok_id' => 'required|exists:pemasoks,id',
            'nama_produk' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
            'status' => 'required|in:pending,proses,selesai,dibatalkan',
            'keterangan' => 'nullable|string'
        ], [
            'kode_pembelian.required' => 'Kode pembelian wajib diisi',
            'kode_pembelian.unique' => 'Kode pembelian sudah digunakan',
            'pemasok_id.required' => 'Pemasok wajib dipilih',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'tanggal_pembelian.required' => 'Tanggal pembelian wajib diisi'
        ]);

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga_satuan'];

        $pembelian = Pembelian::create($validated);

        // LOGIKA CREATE: Update stok produk jika status selesai
        if ($validated['status'] === 'selesai') {
            $this->updateStokProduk($validated['nama_produk'], $validated['jumlah'], 'tambah');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembelian berhasil ditambahkan'
            ]);
        }

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil ditambahkan');
    }

    public function edit(Pembelian $pembelian)
    {
        $pemasoks = \App\Models\Pemasok::all();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pembelian->load('pemasok'),
                'pemasoks' => $pemasoks
            ]);
        }

        return view('pages.pembelian.edit', compact('pembelian', 'pemasoks'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $validated = $request->validate([
            'kode_pembelian' => 'required|string|unique:pembelians,kode_pembelian,' . $pembelian->id,
            'pemasok_id' => 'required|exists:pemasoks,id',
            'nama_produk' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
            'status' => 'required|in:pending,proses,selesai,dibatalkan',
            'keterangan' => 'nullable|string'
        ], [
            'kode_pembelian.required' => 'Kode pembelian wajib diisi',
            'kode_pembelian.unique' => 'Kode pembelian sudah digunakan',
            'pemasok_id.required' => 'Pemasok wajib dipilih',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'tanggal_pembelian.required' => 'Tanggal pembelian wajib diisi'
        ]);

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga_satuan'];

        // LOGIKA UPDATE: Sesuaikan stok produk
        // Jika pembelian lama sudah selesai, kurangi stok lama
        if ($pembelian->status === 'selesai') {
            $this->updateStokProduk($pembelian->nama_produk, $pembelian->jumlah, 'kurang');
        }
        
        // Jika pembelian baru statusnya selesai, tambahkan stok baru
        if ($validated['status'] === 'selesai') {
            $this->updateStokProduk($validated['nama_produk'], $validated['jumlah'], 'tambah');
        }

        $pembelian->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pembelian berhasil diperbarui'
            ]);
        }

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil diperbarui');
    }

    public function destroy(Pembelian $pembelian)
    {
        try {
            // LOGIKA DELETE: Kurangi stok produk jika pembelian sudah selesai
            if ($pembelian->status === 'selesai') {
                $this->updateStokProduk($pembelian->nama_produk, $pembelian->jumlah, 'kurang');
            }
            
            $pembelian->delete();
            return redirect()->route('pembelian.index')
                ->with('success', 'Pembelian berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pembelian.index')
                ->with('error', 'Pembelian tidak dapat dihapus');
        }
    }

    /**
     * Update stok produk berdasarkan nama produk
     * Jika produk belum ada, buat produk baru
     */
    private function updateStokProduk($namaProduk, $jumlah, $operasi = 'tambah')
    {
        // Cari produk berdasarkan nama (case insensitive)
        $produk = Produk::whereRaw('LOWER(nama_produk) = ?', [strtolower($namaProduk)])->first();
        
        if ($produk) {
            // Produk sudah ada, update stok
            if ($operasi === 'tambah') {
                $produk->stok += $jumlah;
            } else {
                $produk->stok -= $jumlah;
            }
            $produk->save();
        } else {
            // Produk belum ada, buat produk baru (hanya jika operasi tambah)
            if ($operasi === 'tambah') {
                try {
                    $kode_produk = $this->generateKodeProduk();
                    
                    // Double check: pastikan kode produk belum ada
                    $maxAttempts = 10;
                    $attempt = 0;
                    while (Produk::where('kode_produk', $kode_produk)->exists() && $attempt < $maxAttempts) {
                        $kode_produk = $this->generateKodeProduk();
                        $attempt++;
                    }
                    
                    Produk::create([
                        'kode_produk' => $kode_produk,
                        'nama_produk' => $namaProduk,
                        'kategori_id' => 1, // Default kategori (sesuaikan dengan kebutuhan)
                        'harga_beli' => 0,
                        'harga_jual' => 0,
                        'stok' => $jumlah,
                        'stok_minimum' => 10,
                        'satuan' => 'pcs',
                        'is_active' => true
                    ]);
                } catch (\Exception $e) {
                    // Jika tetap error, log dan skip
                    \Log::error('Error creating product: ' . $e->getMessage());
                }
            }
        }
    }

    private function generateKodePembelian()
    {
        // Ambil kode pembelian tertinggi berdasarkan urutan kode, bukan created_at
        $lastPembelian = Pembelian::orderBy('kode_pembelian', 'desc')->first();
        
        if ($lastPembelian && preg_match('/PBL(\d+)/', $lastPembelian->kode_pembelian, $matches)) {
            $number = intval($matches[1]) + 1;
        } else {
            $number = 1;
        }
        
        return 'PBL' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    private function generateKodeProduk()
    {
        // Ambil kode produk tertinggi berdasarkan urutan kode, bukan created_at
        $lastProduk = Produk::orderBy('kode_produk', 'desc')->first();
        
        if ($lastProduk && preg_match('/PRD(\d+)/', $lastProduk->kode_produk, $matches)) {
            $number = intval($matches[1]) + 1;
        } else {
            $number = 1;
        }
        
        return 'PRD' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    /**
     * API untuk mendapatkan produk dari pemasok
     */
    public function getProdukPemasok($pemasokId)
    {
        $pemasok = Pemasok::find($pemasokId);
        if ($pemasok) {
            // Split produk yang dipasok menjadi array
            $produkList = array_map('trim', explode(',', $pemasok->produk_yang_dipasok));
            return response()->json(['produk' => $produkList]);
        }
        return response()->json(['produk' => []]);
    }
}
