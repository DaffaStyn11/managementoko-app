<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'kode_penjualan',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'tanggal_penjualan',
        'nama_pembeli',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'harga_satuan' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
