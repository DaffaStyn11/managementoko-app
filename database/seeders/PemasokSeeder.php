<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pemasok::create([
            'nama_pemasok' => 'PT Sumber Makmur',
            'produk_yang_dipasok' => 'Beras, Gula, Minyak',
            'kontak' => '081234567890',
            'alamat' => 'Jl. Raya Industri No. 123, Jakarta Timur',
            'kategori_pemasok' => 'Sembako'
        ]);

        \App\Models\Pemasok::create([
            'nama_pemasok' => 'CV Mitra Sejahtera',
            'produk_yang_dipasok' => 'Minuman Ringan, Air Mineral',
            'kontak' => '082345678901',
            'alamat' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan',
            'kategori_pemasok' => 'Minuman'
        ]);

        \App\Models\Pemasok::create([
            'nama_pemasok' => 'UD Berkah Jaya',
            'produk_yang_dipasok' => 'Camilan, Snack',
            'kontak' => '083456789012',
            'alamat' => 'Jl. Sudirman No. 78, Bandung',
            'kategori_pemasok' => 'Camilan'
        ]);
    }
}
