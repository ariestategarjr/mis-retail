<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_pemasok' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
				'unique' => true
			],
			'nama_pemasok' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => false,
			],
			'alamat_pemasok' => [
				'type' => 'TEXT',
			],
			'kontak_pemasok' => [
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

		$this->forge->addKey('id_pemasok', TRUE);
		$this->forge->createTable('tb_pemasok', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_pemasok', TRUE);
    }
}
