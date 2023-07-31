<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'jual_faktur' => [
				'type'		=> 'CHAR',
				'constraint' => 20,
			],
			'jual_tgl' => [
				'type'		=> 'DATE',
			],
			'jual_pelkode' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
			],
			'jual_dispersen' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'jual_disuang' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'jual_totalkotor' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'jual_totalbersih' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'jual_jmluang' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'jual_sisauang' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			]
		]);

		$this->forge->addPrimaryKey('jual_faktur');
		$this->forge->addForeignKey('jual_pelkode', 'pelanggan', 'pel_kode', 'cascade');
		$this->forge->createTable('penjualan');
	}

	public function down()
	{
		$this->forge->dropTable('penjualan');
	}
}
