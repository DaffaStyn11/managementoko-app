<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function index()
    {
        $pemasoks = Pemasok::latest()->get();
        $totalPemasok = $pemasoks->count();
        $totalKategori = $pemasoks->pluck('kategori_pemasok')->unique()->filter()->count();
        $transaksiAktif = \App\Models\Pembelian::whereIn('status', ['pending', 'proses'])->count();
        
        return view('pages.pemasok.index', compact('pemasoks', 'totalPemasok', 'totalKategori', 'transaksiAktif'));
    }

    public function create()
    {
        return view('pages.pemasok.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'produk_yang_dipasok' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kategori_pemasok' => 'nullable|string|max:255'
        ], [
            'nama_pemasok.required' => 'Nama pemasok wajib diisi',
            'produk_yang_dipasok.required' => 'Produk yang dipasok wajib diisi',
            'kontak.required' => 'Kontak wajib diisi',
            'alamat.required' => 'Alamat wajib diisi'
        ]);

        Pemasok::create($validated);

        return redirect()->route('pemasok.index')
            ->with('success', 'Pemasok berhasil ditambahkan');
    }

    public function edit(Pemasok $pemasok)
    {
        return view('pages.pemasok.edit', compact('pemasok'));
    }

    public function update(Request $request, Pemasok $pemasok)
    {
        $validated = $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'produk_yang_dipasok' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kategori_pemasok' => 'nullable|string|max:255'
        ], [
            'nama_pemasok.required' => 'Nama pemasok wajib diisi',
            'produk_yang_dipasok.required' => 'Produk yang dipasok wajib diisi',
            'kontak.required' => 'Kontak wajib diisi',
            'alamat.required' => 'Alamat wajib diisi'
        ]);

        $pemasok->update($validated);

        return redirect()->route('pemasok.index')
            ->with('success', 'Pemasok berhasil diperbarui');
    }

    public function destroy(Pemasok $pemasok)
    {
        try {
            $pemasok->delete();
            return redirect()->route('pemasok.index')
                ->with('success', 'Pemasok berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pemasok.index')
                ->with('error', 'Pemasok tidak dapat dihapus karena masih digunakan');
        }
    }
}
