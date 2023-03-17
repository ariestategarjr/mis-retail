<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'pel_kode' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
			],
			'pel_nama' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'pel_alamat' => [
				'type' => 'TEXT'
			],
			'pel_telp' => [
				'type' => 'CHAR',
				'constraint' => 20
			]
		]);

		$this->forge->addKey('pel_kode', true);
		$this->forge->createTable('pelanggan');
	}

	public function down()
	{
		$this->forge->dropTable('pelanggan');
	}
}
