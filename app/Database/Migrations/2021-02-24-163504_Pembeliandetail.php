<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembeliandetail extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'detbeli_id' => [
				'type'		=> 'VARCHAR',
				'constraint' => 11,
			],
			'detbeli_faktur' => [
				'type'		=> 'CHAR',
				'constraint' => 20,
			],
			'detbeli_kodebarcode' => [
				'type'		=> 'CHAR',
				'constraint' => 50,
			],
			'detbeli_hargabeli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detbeli_hargajual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detbeli_jml' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'detbeli_subtotal' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			]
		]);

		$this->forge->addPrimaryKey('detbeli_id');
		$this->forge->addForeignKey('detbeli_faktur', 'pembelian', 'beli_faktur', 'cascade');
		$this->forge->addForeignKey('detbeli_kodebarcode', 'produk', 'kodebarcode', 'cascade');
		$this->forge->createTable('pembelian_detail');
	}

	public function down()
	{
		$this->forge->dropTable('pembelian_detail');
	}
}
