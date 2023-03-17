<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'katid'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 11,
			],
			'katnama'       => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
			]
		]);
		$this->forge->addKey('katid', true);
		$this->forge->createTable('kategori');
	}

	public function down()
	{
		$this->forge->dropTable('kategori');
	}
}
