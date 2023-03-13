<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'unique' => true,
            ],
			'kode_barcode' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
                'unique' => true,
			],
			'nama_produk' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'id_satuan_produk' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
                'unique' => true,
			],
			'id_kategori_produk' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
                'unique' => true,
			],
			'stok' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'harga_beli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'harga_jual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
            ],
            'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP'
            ]
		]);

		$this->forge->addKey('id_produk', TRUE);
		$this->forge->addForeignKey('id_satuan_produk', 'tb_satuan', 'id_satuan', 'cascade');
		$this->forge->addForeignKey('id_kategori_produk', 'tb_kategori', 'id_kategori', 'cascade');
		$this->forge->createTable('tb_produk', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_produk');
    }
}
