<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Estoque extends Migration
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
            'idcliente' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true
            ],
            'idveiculo' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true
            ],
            'data_compra' => [
                'type' => 'DATE',
                'null' => true
            ],
            'preco_compra' => [
                'type'       => 'DECIMAL',
                'default'    => 0,
                'constraint' => '11,2',
            ],
            'vendido' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => 'n',
            ],
            'reservado' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => 'n',
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
        $this->forge->addForeignKey('iduser', 'usuarios', 'id', 'CASCADE', 'NO ACTION', 'esto_user');
        $this->forge->addForeignKey('idcliente', 'cliente', 'id', 'CASCADE', 'NO ACTION', 'esto_clie');
        $this->forge->addForeignKey('idveiculo', 'veiculo_modelo', 'id', 'CASCADE', 'NO ACTION', 'esto_veic');
        $this->forge->createTable('estoque');
    }

    public function down()
    {
        $this->forge->dropTable('estoque');
    }
}
