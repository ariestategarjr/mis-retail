<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_jual' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
				'unique' => true,
			],
			'faktur_jual' => [
				'type'		=> 'VARCHAR',
				'constraint' => 20,
				'null'		=> false,
			],
			'tanggal_jual' => [
				'type'		=> 'DATE',
				'null'		=> false,
			],
            'waktu_jual' => [
                'type' => 'TIME',
                'null' => false,
            ],
			'id_pelanggan_jual' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
				'unique' => true
			],
			'total_jual' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00,
			],
			'bayar' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00,
            ],
            'kembali' => [
                'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00,
            ],
            'id_kasir' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'unique' => true,
			],
			'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP',
            ]
		]);
 
		$this->forge->addKey('id_jual', TRUE);
		$this->forge->addForeignKey('id_pelanggan_jual', 'tb_pelanggan', 'id_pelanggan', 'cascade');
		$this->forge->createTable('tb_penjualan', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_penjualan');
    }
}
