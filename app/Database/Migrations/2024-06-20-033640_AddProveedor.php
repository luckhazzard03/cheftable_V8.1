<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddProveedor extends Migration
{
    public function up()
    {
        // Definición de la estructura de la tabla
        $this->forge->addField([
            'idProveedor' => [
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
            'Direccion' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'Telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false,
            ],
            'Tipo' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'idUsuario_fk' => [
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
        $this->forge->addPrimaryKey('idProveedor');

        // Definición de índice y clave externa (foreign key)
        $this->forge->addForeignKey('idUsuario_fk', 'usuarios', 'idUsuario', 'CASCADE', 'CASCADE');

        // Creación de la tabla
        $this->forge->createTable('proveedores');
    }

    public function down()
    {
        // Eliminación de la tabla
        $this->forge->dropTable('proveedor');
    }
}
