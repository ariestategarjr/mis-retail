<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'unique' => true
            ],
            'nama_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100 
            ],
            'created_at' => [
                'type' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME ON UPDATE CURRENT_TIMESTAMP'
            ]
        ]);

		$this->forge->addKey('id_kategori', TRUE);
		$this->forge->createTable('tb_kategori', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_kategori');
    }
}
