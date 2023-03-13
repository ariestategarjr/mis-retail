<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUnitsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'unique' => true
            ],
            'nama_satuan' => [
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

        $this->forge->addKey('id_satuan', TRUE);
        $this->forge->createTable('tb_satuan', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_satuan');
    }
}
