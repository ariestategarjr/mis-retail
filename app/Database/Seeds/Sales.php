<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Sales extends Seeder
{
    public function run()
    {
        $sales_data = [
            [
                'id_jual' => 'PNJ1',
                'faktur_jual' => '101',
                'tanggal_jual' => '2023/03/03',
                'waktu_jual' => '',
                'id_pelanggan_jual' => 'PEL1',
                'total_jual' => 50000,
                'bayar' => 100000,
                'kembali' => 50000,
                'id_kasir' => 'KSR1'
            ],
            [
                'id_jual' => 'PNJ2',
                'faktur_jual' => '102',
                'tanggal_jual' => '2023/03/13',
                'waktu_jual' => '',
                'id_pelanggan_jual' => 'PEL2',
                'total_jual' => 1000,
                'bayar' => 2000,
                'kembali' => 1000,
                'id_kasir' => 'KSR2'
            ],
            [
                'id_jual' => 'PNJ3',
                'faktur_jual' => '103',
                'tanggal_jual' => '2023/03/23',
                'waktu_jual' => '',
                'id_pelanggan_jual' => 'PEL3',
                'total_jual' => 36000,
                'bayar' => 50000,
                'kembali' => 14000,
                'id_kasir' => 'KSR3'
            ]
        ];

        foreach($sales_data as $data) {
            $this->db->table('tb_penjualan')->insert($data);
        }
    }
}
