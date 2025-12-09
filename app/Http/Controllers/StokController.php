<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->get();
        $totalProduk = $produks->count();
        $stokRendah = $produks->filter(function($produk) {
            return $produk->isStokRendah();
        })->count();
        $totalKategori = \App\Models\Kategori::count();
        
        return view('pages.stok.index', compact('produks', 'totalProduk', 'stokRendah', 'totalKategori'));
    }
}
