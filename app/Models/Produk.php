<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori_id',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum',
        'satuan',
        'barcode',
        'gambar',
        'is_active'
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function isStokRendah()
    {
        return $this->stok <= $this->stok_minimum;
    }

    public function getMarginAttribute()
    {
        return $this->harga_jual - $this->harga_beli;
    }

    public function getMarginPersenAttribute()
    {
        if ($this->harga_beli == 0) return 0;
        return (($this->harga_jual - $this->harga_beli) / $this->harga_beli) * 100;
    }
}
