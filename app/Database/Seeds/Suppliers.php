<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Suppliers extends Seeder
{
    public function run()
    {
        $suppliers_data = [
            [
                'id_pemasok' => 'PEM1',
                'nama_pemasok' => 'Unilever',
                'alamat_pemasok' => 'Kebumen',
                'kontak_pemasok' => '089789678567',
            ],
            [
                'id_pemasok' => 'PEM2',
                'nama_pemasok' => 'Indomarco',
                'alamat_pemasok' => 'Kebumen',
                'kontak_pemasok' => '086567234123',
            ],
            [
                'id_pemasok' => 'PEM3',
                'nama_pemasok' => 'Sapar',
                'alamat_pemasok' => 'Karanganyar',
                'kontak_pemasok' => '085456345312',
            ]
        ];

        foreach($suppliers_data as $data) {
            $this->db->table('tb_pemasok')->insert($data);
        }
    }
}
