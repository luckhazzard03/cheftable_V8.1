<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddRoles extends Migration
{
    public function up()
    {
        // Definición de la estructura de la tabla
        $this->forge->addField([
            'idRoles' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Rol' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'Descripcion' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
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
        $this->forge->addPrimaryKey('idRoles');

        // Creación de la tabla
        $this->forge->createTable('roles');
    }

    public function down()
    {
        // Eliminación de la tabla
        $this->forge->dropTable('roles');
    }
}