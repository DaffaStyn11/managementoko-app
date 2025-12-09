<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter periode
        $periode = $request->get('periode', 'hari_ini');
        $tanggal = $request->get('tanggal');
        $jenis = $request->get('jenis', 'semua');
        
        // Query berdasarkan periode
        $query = $this->getQueryByPeriode($periode, $tanggal);
        
        // Total Penjualan
        $totalPenjualan = Penjualan::when($query['start'], function($q) use ($query) {
            return $q->whereDate('tanggal_penjualan', '>=', $query['start'])
                     ->whereDate('tanggal_penjualan', '<=', $query['end']);
        })->sum('total_harga');
        
        // Total Pembelian
        $totalPembelian = Pembelian::when($query['start'], function($q) use ($query) {
            return $q->whereDate('tanggal_pembelian', '>=', $query['start'])
                     ->whereDate('tanggal_pembelian', '<=', $query['end']);
        })->where('status', 'selesai')->sum('total_harga');
        
        // Selisih (Penjualan - Pembelian)
        $selisih = $totalPenjualan - $totalPembelian;
        
        // Data untuk tabel ringkasan dengan pagination
        $laporanData = $this->getLaporanDataPaginated($query, $jenis, $request);
        
        return view('pages.laporan.index', compact(
            'totalPenjualan',
            'totalPembelian',
            'selisih',
            'laporanData',
            'periode',
            'jenis'
        ));
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        // Filter periode
        $periode = $request->get('periode', 'hari_ini');
        $tanggal = $request->get('tanggal');
        $jenis = $request->get('jenis', 'semua');
        
        // Query berdasarkan periode
        $query = $this->getQueryByPeriode($periode, $tanggal);
        
        // Total Penjualan
        $totalPenjualan = Penjualan::when($query['start'], function($q) use ($query) {
            return $q->whereDate('tanggal_penjualan', '>=', $query['start'])
                     ->whereDate('tanggal_penjualan', '<=', $query['end']);
        })->sum('total_harga');
        
        // Total Pembelian
        $totalPembelian = Pembelian::when($query['start'], function($q) use ($query) {
            return $q->whereDate('tanggal_pembelian', '>=', $query['start'])
                     ->whereDate('tanggal_pembelian', '<=', $query['end']);
        })->where('status', 'selesai')->sum('total_harga');
        
        // Selisih
        $selisih = $totalPenjualan - $totalPembelian;
        
        // Data untuk export
        $laporanData = $this->getLaporanData($query, $jenis)->toArray();
        
        // Generate filename
        $filename = 'laporan_' . date('YmdHis') . '.xlsx';
        
        // Download Excel
        return Excel::download(
            new LaporanExport($laporanData, $totalPenjualan, $totalPembelian, $selisih),
            $filename
        );
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        // Filter periode
        $periode = $request->get('periode', 'hari_ini');
        $tanggal = $request->get('tanggal');
        $jenis = $request->get('jenis', 'semua');
        
        // Query berdasarkan periode
        $query = $this->getQueryByPeriode($periode, $tanggal);
        
        // Total Penjualan
        $totalPenjualan = Penjualan::when($query['start'], function($q) use ($query) {
            return $q->whereDate('tanggal_penjualan', '>=', $query['start'])
                     ->whereDate('tanggal_penjualan', '<=', $query['end']);
        })->sum('total_harga');
        
        // Total Pembelian
        $totalPembelian = Pembelian::when($query['start'], function($q) use ($query) {
            return $q->whereDate('tanggal_pembelian', '>=', $query['start'])
                     ->whereDate('tanggal_pembelian', '<=', $query['end']);
        })->where('status', 'selesai')->sum('total_harga');
        
        // Selisih
        $selisih = $totalPenjualan - $totalPembelian;
        
        // Data untuk PDF
        $laporanData = $this->getLaporanData($query, $jenis);
        
        return view('exports.laporan-pdf', compact(
            'totalPenjualan',
            'totalPembelian',
            'selisih',
            'laporanData'
        ));
    }

    private function getQueryByPeriode($periode, $tanggal = null)
    {
        $start = null;
        $end = null;
        
        switch ($periode) {
            case 'hari_ini':
                $start = $end = Carbon::today();
                break;
            case 'minggu_ini':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                break;
            case 'bulan_ini':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
            case 'tahun_ini':
                $start = Carbon::now()->startOfYear();
                $end = Carbon::now()->endOfYear();
                break;
            case 'custom':
                if ($tanggal) {
                    $start = $end = Carbon::parse($tanggal);
                }
                break;
        }
        
        return ['start' => $start, 'end' => $end];
    }
    
    private function getLaporanData($query, $jenis)
    {
        $data = collect();
        
        // Ambil data penjualan
        if ($jenis == 'semua' || $jenis == 'penjualan') {
            $penjualans = Penjualan::with('produk')
                ->when($query['start'], function($q) use ($query) {
                    return $q->whereDate('tanggal_penjualan', '>=', $query['start'])
                             ->whereDate('tanggal_penjualan', '<=', $query['end']);
                })
                ->latest('tanggal_penjualan')
                ->get()
                ->map(function($item) {
                    return [
                        'kategori' => 'Penjualan',
                        'deskripsi' => $item->produk->nama_produk . ' (' . $item->jumlah . ' ' . $item->produk->satuan . ')',
                        'nominal' => $item->total_harga,
                        'tanggal' => $item->tanggal_penjualan->format('Y-m-d'),
                        'type' => 'penjualan'
                    ];
                });
            
            $data = $data->merge($penjualans);
        }
        
        // Ambil data pembelian
        if ($jenis == 'semua' || $jenis == 'pembelian') {
            $pembelians = Pembelian::with('pemasok')
                ->when($query['start'], function($q) use ($query) {
                    return $q->whereDate('tanggal_pembelian', '>=', $query['start'])
                             ->whereDate('tanggal_pembelian', '<=', $query['end']);
                })
                ->where('status', 'selesai')
                ->latest('tanggal_pembelian')
                ->get()
                ->map(function($item) {
                    return [
                        'kategori' => 'Pembelian',
                        'deskripsi' => $item->nama_produk . ' dari ' . $item->pemasok->nama_pemasok,
                        'nominal' => $item->total_harga,
                        'tanggal' => $item->tanggal_pembelian->format('Y-m-d'),
                        'type' => 'pembelian'
                    ];
                });
            
            $data = $data->merge($pembelians);
        }
        
        return $data->sortByDesc('tanggal')->values();
    }

    private function getLaporanDataPaginated($query, $jenis, $request)
    {
        $data = collect();
        
        // Ambil data penjualan
        if ($jenis == 'semua' || $jenis == 'penjualan') {
            $penjualans = Penjualan::with('produk')
                ->when($query['start'], function($q) use ($query) {
                    return $q->whereDate('tanggal_penjualan', '>=', $query['start'])
                             ->whereDate('tanggal_penjualan', '<=', $query['end']);
                })
                ->latest('tanggal_penjualan')
                ->get()
                ->map(function($item) {
                    return [
                        'kategori' => 'Penjualan',
                        'deskripsi' => $item->produk->nama_produk . ' (' . $item->jumlah . ' ' . $item->produk->satuan . ')',
                        'nominal' => $item->total_harga,
                        'tanggal' => $item->tanggal_penjualan->format('Y-m-d'),
                        'type' => 'penjualan'
                    ];
                });
            
            $data = $data->merge($penjualans);
        }
        
        // Ambil data pembelian
        if ($jenis == 'semua' || $jenis == 'pembelian') {
            $pembelians = Pembelian::with('pemasok')
                ->when($query['start'], function($q) use ($query) {
                    return $q->whereDate('tanggal_pembelian', '>=', $query['start'])
                             ->whereDate('tanggal_pembelian', '<=', $query['end']);
                })
                ->where('status', 'selesai')
                ->latest('tanggal_pembelian')
                ->get()
                ->map(function($item) {
                    return [
                        'kategori' => 'Pembelian',
                        'deskripsi' => $item->nama_produk . ' dari ' . $item->pemasok->nama_pemasok,
                        'nominal' => $item->total_harga,
                        'tanggal' => $item->tanggal_pembelian->format('Y-m-d'),
                        'type' => 'pembelian'
                    ];
                });
            
            $data = $data->merge($pembelians);
        }
        
        // Sort data
        $data = $data->sortByDesc('tanggal')->values();
        
        // Manual pagination
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $items = $data->slice($offset, $perPage)->values();
        
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $data->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );
    }
}
