<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'Produk elektronik seperti smartphone, laptop, dan aksesoris'
            ],
            [
                'nama_kategori' => 'Pakaian',
                'deskripsi' => 'Pakaian pria, wanita, dan anak-anak'
            ],
            [
                'nama_kategori' => 'Makanan & Minuman',
                'deskripsi' => 'Produk makanan dan minuman kemasan'
            ],
            [
                'nama_kategori' => 'Kesehatan & Kecantikan',
                'deskripsi' => 'Produk perawatan kesehatan dan kecantikan'
            ],
            [
                'nama_kategori' => 'Rumah Tangga',
                'deskripsi' => 'Peralatan dan perlengkapan rumah tangga'
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi' => 'Peralatan dan perlengkapan olahraga'
            ],
            [
                'nama_kategori' => 'Buku & Alat Tulis',
                'deskripsi' => 'Buku, majalah, dan alat tulis kantor'
            ],
            [
                'nama_kategori' => 'Mainan & Hobi',
                'deskripsi' => 'Mainan anak dan peralatan hobi'
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
