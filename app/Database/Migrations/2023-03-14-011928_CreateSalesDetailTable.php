<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalesDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_djual' => [
				'type'		=> 'VARCHAR',
				'constraint' => 11,
				'unique' => true,
			],
			'faktur_djual' => [
				'type'		=> 'VARCHAR',
				'constraint' => 20,
				'null'		=> false,
			],
			'kode_barcode_djual' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
                'unique' => true,
			],
			'harga_beli_djual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'harga_jual_djual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'jumlah_djual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'subtotal_djual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP',
            ]
		]);

		$this->forge->addKey('id_djual', TRUE);
		$this->forge->addForeignKey('id_djual', 'tb_penjualan', 'id_jual', 'cascade');
		$this->forge->addForeignKey('kode_barcode_djual', 'tb_produk', 'kode_barcode', 'cascade');
		$this->forge->createTable('tb_penjualan_detail', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_penjualan_detail');
    }
}
