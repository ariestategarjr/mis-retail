<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'nama_user' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'create_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ]
        ]);

        $this->forge->addKey('id_user', TRUE);
        $this->forge->createTable('tb_user', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_user');
    }
}
