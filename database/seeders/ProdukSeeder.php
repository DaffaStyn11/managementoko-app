<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = Kategori::all();

        if ($kategoris->isEmpty()) {
            $this->command->warn('Tidak ada kategori. Jalankan KategoriSeeder terlebih dahulu.');
            return;
        }

        $produks = [
            [
                'kode_produk' => 'PRD00001',
                'nama_produk' => 'Smartphone Samsung Galaxy A54',
                'kategori_id' => $kategoris->where('nama_kategori', 'Elektronik')->first()->id ?? 1,
                'deskripsi' => 'Smartphone dengan layar 6.4 inch, RAM 8GB, Storage 256GB',
                'harga_beli' => 4500000,
                'harga_jual' => 5200000,
                'stok' => 15,
                'stok_minimum' => 5,
                'satuan' => 'pcs',
                'barcode' => '8801234567890',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00002',
                'nama_produk' => 'Laptop ASUS VivoBook 14',
                'kategori_id' => $kategoris->where('nama_kategori', 'Elektronik')->first()->id ?? 1,
                'deskripsi' => 'Laptop dengan processor Intel Core i5, RAM 8GB, SSD 512GB',
                'harga_beli' => 6500000,
                'harga_jual' => 7800000,
                'stok' => 8,
                'stok_minimum' => 3,
                'satuan' => 'pcs',
                'barcode' => '8801234567891',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00003',
                'nama_produk' => 'Kaos Polos Cotton Combed',
                'kategori_id' => $kategoris->where('nama_kategori', 'Pakaian')->first()->id ?? 2,
                'deskripsi' => 'Kaos polos berbahan cotton combed 30s, nyaman dipakai',
                'harga_beli' => 35000,
                'harga_jual' => 55000,
                'stok' => 150,
                'stok_minimum' => 30,
                'satuan' => 'pcs',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00004',
                'nama_produk' => 'Celana Jeans Pria',
                'kategori_id' => $kategoris->where('nama_kategori', 'Pakaian')->first()->id ?? 2,
                'deskripsi' => 'Celana jeans pria model slim fit, bahan denim berkualitas',
                'harga_beli' => 120000,
                'harga_jual' => 185000,
                'stok' => 45,
                'stok_minimum' => 15,
                'satuan' => 'pcs',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00005',
                'nama_produk' => 'Beras Premium 5kg',
                'kategori_id' => $kategoris->where('nama_kategori', 'Makanan & Minuman')->first()->id ?? 3,
                'deskripsi' => 'Beras premium kualitas terbaik, pulen dan wangi',
                'harga_beli' => 55000,
                'harga_jual' => 68000,
                'stok' => 200,
                'stok_minimum' => 50,
                'satuan' => 'kg',
                'barcode' => '8991234567892',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00006',
                'nama_produk' => 'Minyak Goreng 2 Liter',
                'kategori_id' => $kategoris->where('nama_kategori', 'Makanan & Minuman')->first()->id ?? 3,
                'deskripsi' => 'Minyak goreng kemasan 2 liter, jernih dan tidak berbau',
                'harga_beli' => 28000,
                'harga_jual' => 35000,
                'stok' => 120,
                'stok_minimum' => 40,
                'satuan' => 'liter',
                'barcode' => '8991234567893',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00007',
                'nama_produk' => 'Shampoo Anti Ketombe 200ml',
                'kategori_id' => $kategoris->where('nama_kategori', 'Kesehatan & Kecantikan')->first()->id ?? 4,
                'deskripsi' => 'Shampoo anti ketombe dengan formula khusus',
                'harga_beli' => 18000,
                'harga_jual' => 25000,
                'stok' => 80,
                'stok_minimum' => 20,
                'satuan' => 'pcs',
                'barcode' => '8991234567894',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00008',
                'nama_produk' => 'Sabun Mandi Cair 500ml',
                'kategori_id' => $kategoris->where('nama_kategori', 'Kesehatan & Kecantikan')->first()->id ?? 4,
                'deskripsi' => 'Sabun mandi cair dengan aroma segar',
                'harga_beli' => 22000,
                'harga_jual' => 32000,
                'stok' => 65,
                'stok_minimum' => 25,
                'satuan' => 'pcs',
                'barcode' => '8991234567895',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00009',
                'nama_produk' => 'Panci Set Stainless Steel',
                'kategori_id' => $kategoris->where('nama_kategori', 'Rumah Tangga')->first()->id ?? 5,
                'deskripsi' => 'Set panci stainless steel isi 5 pcs',
                'harga_beli' => 250000,
                'harga_jual' => 350000,
                'stok' => 25,
                'stok_minimum' => 10,
                'satuan' => 'set',
                'is_active' => true
            ],
            [
                'kode_produk' => 'PRD00010',
                'nama_produk' => 'Bola Sepak Size 5',
                'kategori_id' => $kategoris->where('nama_kategori', 'Olahraga')->first()->id ?? 6,
                'deskripsi' => 'Bola sepak standar FIFA size 5',
                'harga_beli' => 85000,
                'harga_jual' => 125000,
                'stok' => 30,
                'stok_minimum' => 10,
                'satuan' => 'pcs',
                'is_active' => true
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}
