<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddUsuario extends Migration
{
    public function up()
    {
        // Definición de la estructura de la tabla
        $this->forge->addField([
            'idUsuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'Password' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => false,
            ],
            'Email' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'Telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false,
            ],
            'idRoles_fk' => [
                'type' => 'INT',
                'constraint' => 11,
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

        // Definición de la clave primaria
        $this->forge->addPrimaryKey('idUsuario');

        // Definición de índice y clave externa (foreign key)
        $this->forge->addForeignKey('idRoles_fk', 'roles', 'idRoles', 'CASCADE', 'CASCADE');

        // Creación de la tabla
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        // Eliminación de la tabla
        $this->forge->dropTable('usuarios');
    }
}
