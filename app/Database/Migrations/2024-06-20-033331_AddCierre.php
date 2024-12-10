<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddCierre extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idCierre' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Fecha' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'Total_Dia' => [
                'type' => 'DECIMAL',
                'null' => false,
            ],
            'Total_Semana' => [
                'type' => 'DECIMAL',
                'null' => false,
            ],
            'Total_Mes' => [
                'type' => 'DECIMAL',
                'null' => false,
            ],
            'idUsuario_fk' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'create_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'update_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('idCierre');
        $this->forge->addForeignKey('idUsuario_fk', 'usuarios', 'idUsuario', 'CASCADE', 'CASCADE', 'fk_Cierre_Usuario1');
        $this->forge->createTable('cierres');
    }

    public function down()
    {
        $this->forge->dropTable('cierres');
    }
}
