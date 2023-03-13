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
                'nama_kategori' => 'Makanan'
            ],
            [
                'id_kategori' => 'KAT2',
                'nama_kategori' => 'Minuman'
            ],
            [
                'id_kategori' => 'KAT3',
                'nama_kategori' => 'Jajanan'
            ]
        ];

        foreach($categories_data as $data) {
            $this->db->table('tb_kategori')->insert($data);
        }
    }
}
