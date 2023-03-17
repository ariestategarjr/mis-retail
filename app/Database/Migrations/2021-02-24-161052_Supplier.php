<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Supplier extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'sup_kode' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
			],
			'sup_nama' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'sup_alamat' => [
				'type' => 'TEXT'
			],
			'sup_telp' => [
				'type' => 'CHAR',
				'constraint' => 20
			]
		]);

		$this->forge->addKey('sup_kode', true);
		$this->forge->createTable('supplier');
	}

	public function down()
	{
		$this->forge->dropTable('supplier');
	}
}
