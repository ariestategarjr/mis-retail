<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jual' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true
            ],
            'no_faktur' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true
            ],
            'tgl_jual' => [
                'type' => 'DATE',
                'null' => true
            ],
            'waktu' => [
                'type' => 'TIME',
                'null' => true
            ],
            'total_jual' => [
                'type' => 'INT',
                'constraint' => 20,
                'null' => true
            ],
            'bayar' => [
                'type' => 'INT',
                'constraint' => 20,
                'null' => true
            ],
            'kembali' => [
                'type' => 'INT',
                'constraint' => 20,
                'null' => true
            ],
            'id_kasir' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'unique' => true
            ],
            'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP'
            ]
        ]);

        $this->forge->addKey('id_jual', TRUE);
        $this->forge->createTable('tb_jual', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_jual');
    }
}
