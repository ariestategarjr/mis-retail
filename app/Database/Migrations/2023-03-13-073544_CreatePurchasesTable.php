<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_beli' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'unique' => true,
            ],
			'faktur_beli' => [
				'type'		=> 'VARCHAR',
				'constraint' => 20,
				'null'		=> false
			],
			'tanggal_beli' => [
				'type'		=> 'DATE',
				'null'		=> false,
			],
            'waktu_beli' => [
                'type' => 'TIME',
                'null' => false,
            ],
			'jenis_bayar_beli' => [
				'type' => 'ENUM',
				'constraint' => ['Tempo', 'Cash'],
				'default' => 'Tempo',
			],
			'id_pemasok_beli' => [
				'type' => 'VARCHAR',
				'constraint' => 11,
				'unique' => true
			],
			'diskon_persen_beli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'diskon_uang_beli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'total_kotor_beli' => [
				'type' => 'DOUBLE',
				'constraint' => '11,2',
				'default' => 0.00
			],
			'total_bersih_beli' => [
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
 
		$this->forge->addKey('id_beli', TRUE);
		$this->forge->addForeignKey('id_pemasok_beli', 'tb_pemasok', 'id_pemasok', 'cascade');
		$this->forge->createTable('tb_pembelian', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_pembelian');
    }
}
