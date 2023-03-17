<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Temppenjualan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'detjual_id' => [
				'type'		=> 'VARCHAR',
				'constraint' => 11,
			],
			'detjual_faktur' => [
				'type'		=> 'char',
				'constraint' => '20',
			],
			'detjual_kodebarcode' => [
				'type'		=> 'char',
				'constraint' => '50',
			],
			'detjual_hargabeli' => [
				'type' => 'double',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detjual_hargajual' => [
				'type' => 'double',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detjual_jml' => [
				'type' => 'double',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detjual_subtotal' => [
				'type' => 'double',
				'constraint' => '11,2',
				'default' => 0.00
			]
		]);

		$this->forge->addPrimaryKey('detjual_id');
		$this->forge->createTable('temp_penjualan');
	}

	public function down()
	{
		$this->forge->dropTable('temp_penjualan');
	}
}
