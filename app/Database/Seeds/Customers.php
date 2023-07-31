<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Customers extends Seeder
{
    public function run()
    {
        $customers_data = [
            [
                'pel_kode' => '0',
                'pel_nama' => '-',
                'pel_alamat' => '-',
                'pel_telp' => '-',
            ],
            [
                'pel_kode' => 'PEL001',
                'pel_nama' => 'Paiman',
                'pel_alamat' => 'Adimulyo',
                'pel_telp' => '-',
            ],
            [
                'pel_kode' => 'PEL002',
                'pel_nama' => 'Imin',
                'pel_alamat' => 'Karanganyar',
                'pel_telp' => '-',
            ],
        ];

        foreach ($customers_data as $data) {
            $this->db->table('pelanggan')->insert($data);
        }
    }
}
