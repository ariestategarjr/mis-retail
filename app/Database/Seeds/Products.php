<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Products extends Seeder
{
    public function run()
    {
        $products_data = [
            [
                'kodebarcode' => '890378467',
                'namaproduk' => 'Biskuat 10gr',
                'produk_satid' => 'SAT001',
                'produk_katid' => 'KAT001',
                'stok_tersedia' => 12,
                'harga_beli' => 920,
                'harga_jual' => 1000,
                'gambar' => '-',
            ],
            [
                'kodebarcode' => '746782712',
                'namaproduk' => 'Teh Gelas 180ml',
                'produk_satid' => 'SAT002',
                'produk_katid' => 'KAT002',
                'stok_tersedia' => 12,
                'harga_beli' => 920,
                'harga_jual' => 1000,
                'gambar' => '-',
            ],
        ];

        foreach ($products_data as $data) {
            $this->db->table('produk')->insert($data);
        }
    }
}
