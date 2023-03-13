<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Purchases extends Seeder
{
    public function run()
    {
        $purchases_data = [
            [
                'id_beli' => 'PMB1',
                'faktur_beli' => '101',
                'tanggal_beli' => '2023/03/03',
                'waktu_beli' => '',
                'jenis_bayar_beli' => 'Tempo',
                'id_pemasok_beli' => 'PEM1',
                'diskon_persen_beli' => 50000,
                'diskon_uang_beli' => 100000,
                'total_kotor_beli' => 50000,
                'total_bersih_beli' => 1000000,
            ],
            [
                'id_beli' => 'PMB2',
                'faktur_beli' => '102',
                'tanggal_beli' => '2023/03/13',
                'waktu_beli' => '',
                'jenis_bayar_beli' => 'Cash',
                'id_pemasok_beli' => 'PEM2',
                'diskon_persen_beli' => 20000,
                'diskon_uang_beli' => 100000,
                'total_kotor_beli' => 20000,
                'total_bersih_beli' => 1000000,
            ],
            [
                'id_beli' => 'PMB3',
                'faktur_beli' => '103',
                'tanggal_beli' => '2023/03/23',
                'waktu_beli' => '',
                'jenis_bayar_beli' => 'Tempo',
                'id_pemasok_beli' => 'PEM3',
                'diskon_persen_beli' => 30000,
                'diskon_uang_beli' => 400000,
                'total_kotor_beli' => 30000,
                'total_bersih_beli' => 4000000,
            ]
        ];

        foreach($purchases_data as $data) {
            $this->db->table('tb_pembelian')->insert($data);
        }
    }
}
