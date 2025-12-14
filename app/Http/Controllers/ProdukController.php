<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->get();
        $totalProduk = $produks->count();
        $totalStok = $produks->sum('stok');
        $totalKategori = \App\Models\Kategori::count();
        
        return view('pages.produk.index', compact('produks', 'totalProduk', 'totalStok', 'totalKategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = \App\Models\Kategori::all();
        $kode_produk = $this->generateKodeProduk();
        
        // AJAX Request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'kode_produk' => $kode_produk,
                'kategoris' => $kategoris
            ]);
        }

        // Regular Request
        return view('pages.produk.create', compact('kategoris', 'kode_produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|string|unique:produks,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'barcode' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'kode_produk.required' => 'Kode produk wajib diisi',
            'kode_produk.unique' => 'Kode produk sudah digunakan',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'harga_beli.required' => 'Harga beli wajib diisi',
            'harga_jual.required' => 'Harga jual wajib diisi',
            'stok.required' => 'Stok wajib diisi',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $produk = Produk::create($validated);

        // AJAX Request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'data' => $produk->load('kategori')
            ]);
        }

        // Regular Request
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $produk->load('kategori');
        return view('pages.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategoris = \App\Models\Kategori::all();
        
        // AJAX Request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $produk->load('kategori'),
                'kategoris' => $kategoris
            ]);
        }

        // Regular Request
        return view('pages.produk.edit', compact('produk', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|string|unique:produks,kode_produk,' . $produk->id,
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'barcode' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'kode_produk.required' => 'Kode produk wajib diisi',
            'kode_produk.unique' => 'Kode produk sudah digunakan',
            'nama_produk.required' => 'Nama produk wajib diisi',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'harga_beli.required' => 'Harga beli wajib diisi',
            'harga_jual.required' => 'Harga jual wajib diisi',
            'stok.required' => 'Stok wajib diisi',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $produk->update($validated);

        // AJAX Request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui',
                'data' => $produk->load('kategori')
            ]);
        }

        // Regular Request
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        try {
            $produk->delete();
            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('produk.index')
                ->with('error', 'Produk tidak dapat dihapus karena masih digunakan');
        }
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
}
