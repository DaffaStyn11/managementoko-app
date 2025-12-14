<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('produk')->latest()->get();
        
        // Statistik
        $today = now()->toDateString();
        $totalHariIni = Penjualan::whereDate('tanggal_penjualan', $today)->sum('total_harga');
        $jumlahTransaksi = Penjualan::whereDate('tanggal_penjualan', $today)->count();
        
        // Produk terlaris
        $produkTerlaris = Penjualan::with('produk')
            ->selectRaw('produk_id, SUM(jumlah) as total_terjual')
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->first();
        
        return view('pages.penjualan.index', compact(
            'penjualans',
            'totalHariIni',
            'jumlahTransaksi',
            'produkTerlaris'
        ));
    }

    public function create()
    {
        $produks = \App\Models\Produk::where('is_active', true)->get();
        $kode_penjualan = $this->generateKodePenjualan();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'kode_penjualan' => $kode_penjualan,
                'produks' => $produks
            ]);
        }

        return view('pages.penjualan.create', compact('produks', 'kode_penjualan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_penjualan' => 'required|string|unique:penjualans,kode_penjualan',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_penjualan' => 'required|date',
            'nama_pembeli' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string'
        ], [
            'kode_penjualan.required' => 'Kode penjualan wajib diisi',
            'kode_penjualan.unique' => 'Kode penjualan sudah digunakan',
            'produk_id.required' => 'Produk wajib dipilih',
            'jumlah.required' => 'Jumlah wajib diisi',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'tanggal_penjualan.required' => 'Tanggal penjualan wajib diisi'
        ]);

        // Cek stok
        $produk = Produk::find($validated['produk_id']);
        if ($produk->stok < $validated['jumlah']) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Stok {$produk->nama_produk} tidak mencukupi. Stok tersedia: {$produk->stok} {$produk->satuan}");
        }

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga_satuan'];

        $penjualan = Penjualan::create($validated);

        // LOGIKA CREATE: Kurangi stok produk
        $produk->stok -= $validated['jumlah'];
        $produk->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Penjualan berhasil ditambahkan dan stok produk telah dikurangi'
            ]);
        }

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan berhasil ditambahkan dan stok produk telah dikurangi');
    }

    public function edit(Penjualan $penjualan)
    {
        $produks = \App\Models\Produk::where('is_active', true)->get();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $penjualan->load('produk'),
                'produks' => $produks
            ]);
        }

        return view('pages.penjualan.edit', compact('penjualan', 'produks'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $validated = $request->validate([
            'kode_penjualan' => 'required|string|unique:penjualans,kode_penjualan,' . $penjualan->id,
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_penjualan' => 'required|date',
            'nama_pembeli' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string'
        ], [
            'kode_penjualan.required' => 'Kode penjualan wajib diisi',
            'kode_penjualan.unique' => 'Kode penjualan sudah digunakan',
            'produk_id.required' => 'Produk wajib dipilih',
            'jumlah.required' => 'Jumlah wajib diisi',
            'harga_satuan.required' => 'Harga satuan wajib diisi',
            'tanggal_penjualan.required' => 'Tanggal penjualan wajib diisi'
        ]);

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga_satuan'];

        // LOGIKA UPDATE: Sesuaikan stok produk
        $produkLama = Produk::find($penjualan->produk_id);
        $produkBaru = Produk::find($validated['produk_id']);

        // Kembalikan stok lama
        $produkLama->stok += $penjualan->jumlah;
        $produkLama->save();

        // Cek stok baru
        if ($produkBaru->stok < $validated['jumlah']) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Stok {$produkBaru->nama_produk} tidak mencukupi. Stok tersedia: {$produkBaru->stok} {$produkBaru->satuan}");
        }

        // Kurangi stok baru
        $produkBaru->stok -= $validated['jumlah'];
        $produkBaru->save();

        $penjualan->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Penjualan berhasil diperbarui dan stok produk telah disesuaikan'
            ]);
        }

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan berhasil diperbarui dan stok produk telah disesuaikan');
    }

    public function destroy(Penjualan $penjualan)
    {
        try {
            // LOGIKA DELETE: Kembalikan stok produk
            $produk = Produk::find($penjualan->produk_id);
            $produk->stok += $penjualan->jumlah;
            $produk->save();

            $penjualan->delete();
            
            return redirect()->route('penjualan.index')
                ->with('success', 'Penjualan berhasil dihapus dan stok produk telah dikembalikan');
        } catch (\Exception $e) {
            return redirect()->route('penjualan.index')
                ->with('error', 'Penjualan tidak dapat dihapus');
        }
    }

    private function generateKodePenjualan()
    {
        $lastPenjualan = Penjualan::orderBy('kode_penjualan', 'desc')->first();
        
        if ($lastPenjualan && preg_match('/PJL(\d+)/', $lastPenjualan->kode_penjualan, $matches)) {
            $number = intval($matches[1]) + 1;
        } else {
            $number = 1;
        }
        
        return 'PJL' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
