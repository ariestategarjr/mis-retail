<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Login extends Seeder
{
    public function run()
    {
        $accounts_data = [
            [
                'id' => '1',
                'username' => 'tokotujuh',
                'password' => 'totuj2023',
                'status' => 'admin'
            ],
        ];

        foreach ($accounts_data as $data) {
            $this->db->table('akun')->insert($data);
        }
    }
}
