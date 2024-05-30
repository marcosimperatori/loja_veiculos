<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Manutencao extends Migration
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
            'iduser' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true
            ],
            'idestoque' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true
            ],
            'data_manu' => [
                'type' => 'DATE',
                'null' => true
            ],
            'preco' => [
                'type'       => 'DECIMAL',
                'default'    => 0,
                'constraint' => '11,2',
            ],
            'descricao' => [
                'type'       => 'TEXT',
                'null'       => true
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('iduser', 'usuarios', 'id', 'CASCADE', 'NO ACTION', 'manu_user');
        $this->forge->addForeignKey('idestoque', 'estoque', 'id', 'CASCADE', 'CASCADE', 'manu_clie');
        $this->forge->createTable('manutencao');
    }

    public function down()
    {
        $this->forge->dropTable('manutencao');
    }
}
