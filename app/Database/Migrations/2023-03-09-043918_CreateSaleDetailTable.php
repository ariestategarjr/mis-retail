<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaleDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jual_detail' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true
            ],
            'no_faktur' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true
            ],
            'kode_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ],
            'harga_jual' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'kuantitas' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'total_harga_produk' => [
                'type' => 'INT',
                'constraint' => 20,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP'
            ]
        ]);

        $this->forge->addKey('id_jual_detail', TRUE);
        $this->forge->createTable('tb_jual_detail', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_jual_detail');
    }
}
