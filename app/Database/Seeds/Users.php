<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data_users = [
            [
                'id_user' => 'USR1',
                'nama_user' => 'Alif',
                'username' => 'alif1',
                'password' => md5('alif2023'),
                'role' => 'admin'
            ],
            [
                'id_user' => 'USR2',
                'nama_user' => 'Bela',
                'username' => 'bela2',
                'password' => md5('bela2023'),
                'role' => 'kasir'
            ]
        ];

        foreach($data_users as $data) {
            $this->db->table('tb_user')->insert($data);
        }
    }
}
