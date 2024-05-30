<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TiposVeiculo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false
            ],
            'ativo' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('descricao');
        $this->forge->createTable('veiculo_tipo');
    }

    public function down()
    {
        $this->forge->dropTable('veiculo_tipo');
    }
}
