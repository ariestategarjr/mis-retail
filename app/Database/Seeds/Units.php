<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Units extends Seeder
{
    public function run()
    {
        $data_units = [
            [
                'id_satuan' => 'STN1',
                'nama_satuan' => 'buah'
            ],
            [
                'id_satuan' => 'STN2',
                'nama_satuan' => 'lusin'
            ],
            [
                'id_satuan' => 'STN3',
                'nama_satuan' => 'kilogram'
            ]
        ];

        foreach ($data_units as $data) {
            $this->db->table('tb_satuan')->insert($data);
        }
    }
}
