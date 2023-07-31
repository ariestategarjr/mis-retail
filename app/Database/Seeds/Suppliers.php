<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Suppliers extends Seeder
{
    public function run()
    {
        $suppliers_data = [
            [
                'sup_kode' => '0',
                'sup_nama' => '-',
                'sup_alamat' => '-',
                'sup_telp' => '-',
            ],
            [
                'sup_kode' => 'SUP001',
                'sup_nama' => 'Indomarco',
                'sup_alamat' => 'Kebumen',
                'sup_telp' => '-',
            ],
            [
                'sup_kode' => 'SUP002',
                'sup_nama' => 'Unilever',
                'sup_alamat' => 'Kebumen',
                'sup_telp' => '-',
            ],
        ];

        foreach ($suppliers_data as $data) {
            $this->db->table('supplier')->insert($data);
        }
    }
}
