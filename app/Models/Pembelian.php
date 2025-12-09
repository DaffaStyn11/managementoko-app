<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'kode_pembelian',
        'pemasok_id',
        'nama_produk',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'tanggal_pembelian',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'harga_satuan' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class);
    }
}
