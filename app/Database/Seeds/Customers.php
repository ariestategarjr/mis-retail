<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Customers extends Seeder
{
    public function run()
    {
        $customers_data = [
            [
                'id_pelanggan' => 'PEL1',
                'nama_pelanggan' => 'Alif',
                'alamat_pelanggan' => 'Karanganyar',
                'kontak_pelanggan' => '089789678567',
            ],
            [
                'id_pelanggan' => 'PEL2',
                'nama_pelanggan' => 'Budi',
                'alamat_pelanggan' => 'Adimulyo',
                'kontak_pelanggan' => '086567234123',
            ],
            [
                'id_pelanggan' => 'PEL3',
                'nama_pelanggan' => 'Cece',
                'alamat_pelanggan' => 'Gombong',
                'kontak_pelanggan' => '085456345312',
            ]
        ];

        foreach($customers_data as $data) {
            $this->db->table('tb_pelanggan')->insert($data);
        }
    }
}
