<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchasesDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_dbeli' => [
				'type'		=> 'VARCHAR',
				'constraint' => 11,
				'unique' => true,
			],
			'faktur_dbeli' => [
				'type'		=> 'VARCHAR',
				'constraint' => 20,
				'null'		=> false,
			],
			'kode_barcode_dbeli' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
                'unique' => true,
			],
			'harga_beli_dbeli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'harga_beli_dbeli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'jumlah_dbeli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'subtotal_dbeli' => [
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

		$this->forge->addKey('id_dbeli', TRUE);
		$this->forge->addForeignKey('id_dbeli', 'tb_pembelian', 'id_beli', 'cascade');
		$this->forge->addForeignKey('kode_barcode_dbeli', 'tb_produk', 'kode_barcode', 'cascade');
		$this->forge->createTable('tb_pembelian_detail', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_pembelian_detail');
    }
}
