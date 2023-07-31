<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Units extends Seeder
{
    public function run()
    {
        $units_data = [
            [
                'satid' => 'SAT001',
                'satnama' => 'buah',
            ],
            [
                'satid' => 'SAT002',
                'satnama' => 'pcs',
            ]
        ];

        foreach ($units_data as $data) {
            $this->db->table('satuan')->insert($data);
        }
    }
}
