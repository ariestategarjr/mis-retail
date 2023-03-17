<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualandetail extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'detjual_id' => [
				'type'		=> 'VARCHAR',
				'constraint' => 11,
			],
			'detjual_faktur' => [
				'type'		=> 'CHAR',
				'constraint' => 20,
			],
			'detjual_kodebarcode' => [
				'type'		=> 'CHAR',
				'constraint' => 50,
			],
			'detjual_hargabeli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detjual_hargajual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detjual_jml' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detjual_subtotal' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			]
		]);

		$this->forge->addPrimaryKey('detjual_id');
		$this->forge->addForeignKey('detjual_faktur', 'penjualan', 'jual_faktur', 'cascade');
		$this->forge->addForeignKey('detjual_kodebarcode', 'produk', 'kodebarcode', 'cascade');
		$this->forge->createTable('penjualan_detail');
	}

	public function down()
	{
		$this->forge->dropTable('penjualan_detail');
	}
}
