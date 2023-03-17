<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'satid'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 11,
			],
			'satnama'       => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
			]
		]);
		$this->forge->addKey('satid', true);
		$this->forge->createTable('satuan');
	}

	public function down()
	{
		$this->forge->dropTable('satuan');
	}
}
