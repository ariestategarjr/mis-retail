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
                'constraint' => 10,
                'unique' => true
            ],
            'kode_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ],
            'nama_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'id_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'unique' => true
            ],
            'id_satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'unique' => true
            ],
            'harga_beli' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'harga_jual' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP'
            ]
        ]);

        $this->forge->addKey('id_produk', TRUE);
        $this->forge->createTable('tb_produk', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_produk');
    }
}
