<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Units extends Seeder
{
    public function run()
    {
        $units_data = [
            [
                'id_satuan' => 'SAT1',
                'nama_satuan' => 'buah'
            ],
            [
                'id_satuan' => 'SAT2',
                'nama_satuan' => 'kilogram'
            ],
            [
                'id_satuan' => 'SAT3',
                'nama_satuan' => 'lembar'
            ]
        ];

        foreach($units_data as $data) {
            $this->db->table('tb_satuan')->insert($data);
        }
    }
}
