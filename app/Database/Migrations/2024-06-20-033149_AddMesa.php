<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddMesa extends Migration
{
    public function up()
    {
        // Definición de la estructura de la tabla
        $this->forge->addField([
            'idMesa' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'No_Orden' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'Estado' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'Capacidad' => [
                'type' => 'INT',
                'constraint' => 11,
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

        // Definición de la clave primaria
        $this->forge->addPrimaryKey('idMesa');

        // Creación de la tabla
        $this->forge->createTable('mesas', true);
    }

    public function down()
    {
        // Eliminación de la tabla
        $this->forge->dropTable('mesas', true);
    }
}
