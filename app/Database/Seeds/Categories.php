<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        $categories_data = [
            [
                'id_kategori' => 'KAT1',
                'nama_kategori' => 'makanan'
            ],
            [
                'id_kategori' => 'KAT2',
                'nama_kategori' => 'minuman'
            ],
            [
                'id_kategori' => 'KAT3',
                'nama_kategori' => 'makanan khas'
            ]
        ];

        foreach($categories_data as $data) {
            $this->db->table('tb_kategori')->insert($data);
        }
    }
}
