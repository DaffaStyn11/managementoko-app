<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $fillable = [
        'nama_pemasok',
        'produk_yang_dipasok',
        'kontak',
        'alamat',
        'kategori_pemasok'
    ];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}
