<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        $categories_data = [
            [
                'katid' => 'KAT001',
                'katnama' => 'makanan',
            ],
            [
                'katid' => 'KAT002',
                'katnama' => 'minuman',
            ]
        ];

        foreach ($categories_data as $data) {
            $this->db->table('kategori')->insert($data);
        }
    }
}
