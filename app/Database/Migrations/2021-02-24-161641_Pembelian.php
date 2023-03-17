<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembelian extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'beli_faktur' => [
				'type'		=> 'CHAR',
				'constraint' => 20,
			],
			'beli_tgl' => [
				'type'		=> 'DATE',
			],
			'beli_jenisbayar' => [
				'type' => 'ENUM',
				'constraint' => ['T', 'K'],
				'default' => 'T'
			],
			'beli_supkode' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
			],
			'beli_dispersen' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'beli_disuang' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'beli_totalkotor' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'beli_totalbersih' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
		]);

		$this->forge->addPrimaryKey('beli_faktur');
		$this->forge->addForeignKey('beli_supkode', 'supplier', 'sup_kode', 'cascade');
		$this->forge->createTable('pembelian');
	}

	public function down()
	{
		$this->forge->dropTable('pembelian');
	}
}
