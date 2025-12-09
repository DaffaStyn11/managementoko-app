<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary Cards
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('stok');
        $totalPemasok = Pemasok::count();
        $totalKategori = Kategori::count();
        $stokRendah = Produk::whereColumn('stok', '<=', 'stok_minimum')->count();
        
        // Penjualan & Pembelian Hari Ini
        $today = Carbon::today();
        $penjualanHariIni = Penjualan::whereDate('tanggal_penjualan', $today)->sum('total_harga');
        $pembelianHariIni = Pembelian::whereDate('tanggal_pembelian', $today)
            ->where('status', 'selesai')
            ->sum('total_harga');
        
        // Penjualan & Pembelian Bulan Ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $penjualanBulanIni = Penjualan::whereMonth('tanggal_penjualan', $bulanIni)
            ->whereYear('tanggal_penjualan', $tahunIni)
            ->sum('total_harga');
        $pembelianBulanIni = Pembelian::whereMonth('tanggal_pembelian', $bulanIni)
            ->whereYear('tanggal_pembelian', $tahunIni)
            ->where('status', 'selesai')
            ->sum('total_harga');
        
        // Produk Terlaris (Top 5)
        $produkTerlaris = Penjualan::with('produk')
            ->selectRaw('produk_id, SUM(jumlah) as total_terjual')
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();
        
        // Stok Rendah (Top 5)
        $produkStokRendah = Produk::with('kategori')
            ->whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        // Data untuk grafik penjualan 7 hari terakhir
        $penjualan7Hari = [];
        $labels7Hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels7Hari[] = $date->format('d M');
            $penjualan7Hari[] = Penjualan::whereDate('tanggal_penjualan', $date)->sum('total_harga');
        }
        
        // Data untuk grafik pembelian 7 hari terakhir
        $pembelian7Hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $pembelian7Hari[] = Pembelian::whereDate('tanggal_pembelian', $date)
                ->where('status', 'selesai')
                ->sum('total_harga');
        }
        
        // Transaksi Terbaru
        $transaksiTerbaru = Penjualan::with('produk')
            ->latest('created_at')
            ->limit(5)
            ->get();
        
        return view('pages.dashboard.index', compact(
            'totalProduk',
            'totalStok',
            'totalPemasok',
            'totalKategori',
            'stokRendah',
            'penjualanHariIni',
            'pembelianHariIni',
            'penjualanBulanIni',
            'pembelianBulanIni',
            'produkTerlaris',
            'produkStokRendah',
            'penjualan7Hari',
            'pembelian7Hari',
            'labels7Hari',
            'transaksiTerbaru'
        ));
    }
}
