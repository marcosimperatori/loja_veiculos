<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModeloVeiculo extends Migration
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
            'idtipo' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true
            ],
            'idfabricante' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true
            ],
            'modelo' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false
            ],
            'potencia' => [
                'type'       => 'VARCHAR',
                'constraint' => 12,
                'null'       => true,
                'default'    => '1.0'
            ],
            'combustivel' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => false
            ],
            'portas' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => false,
                'default'    => 1
            ],
            'extras' => [
                'type'       => 'TEXT',
                'null'       => true
            ],
            'ativo' => [
                'type'    => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addForeignKey('idtipo', 'veiculo_tipo', 'id', 'CASCADE', 'NO ACTION', 'veic_tipo');
        $this->forge->addForeignKey('idfabricante', 'veiculo_fabricante', 'id', 'CASCADE', 'NO ACTION', 'veic_fabr');
        $this->forge->createTable('veiculo_modelo');
    }

    public function down()
    {
        $this->forge->dropTable('veiculo_modelo');
    }
}
