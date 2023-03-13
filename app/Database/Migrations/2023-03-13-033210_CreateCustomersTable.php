<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_pelanggan' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
				'unique' => true,
			],
			'nama_pelanggan' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => false,
			],
			'alamat_pelanggan' => [
				'type' => 'TEXT',
			],
			'kontak_pelanggan' => [
				'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP',
            ]
		]);

		$this->forge->addKey('id_pelanggan', TRUE);
		$this->forge->createTable('tb_pelanggan', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_pelanggan', TRUE);
    }
}
