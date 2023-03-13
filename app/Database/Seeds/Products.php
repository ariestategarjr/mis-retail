<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Products extends Seeder
{
    public function run()
    {
        $products_data = [
            [
                'id_produk' => 'PRO1',
                'kode_barcode' => '112657893123',
                'nama_produk' => 'Lanting',
                'id_satuan_produk' => 'SAT1',
                'id_kategori_produk' => 'KAT3',
                'stok' => 12,
                'harga_beli' => 9000,
                'harga_jual' => 12000,
            ],
            [
                'id_produk' => 'PRO2',
                'kode_barcode' => '678938758192',
                'nama_produk' => 'Ciki',
                'id_satuan_produk' => 'SAT1',
                'id_kategori_produk' => 'KAT1',
                'stok' => 20,
                'harga_beli' => 850,
                'harga_jual' => 1000,
            ]
        ];

        foreach($products_data as $data) {
            $this->db->table('tb_produk')->insert($data);
        }
    }
}
