<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddInventario extends Migration
{
    public function up()
    {
        // Definición de la estructura de la tabla
        $this->forge->addField([
            'idInventario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Producto' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => false,
            ],
            'Cantidad' => [
                'type' => 'INT',
                'constraint' => 200,
                'null' => false,
            ],
            'Cantidad_Minima' => [
                'type' => 'INT',
                'constraint' => 200,
                'null' => false,
            ],
            'idUsuario_fk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'create_at' => [
                'type' => 'TIMESTAMP',    
                'null' => true, 
                'default' => new RawSql('CURRENT_TIMESTAMP'),                                              
            ],
            'update_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);

        // Definición de claves y restricciones
        $this->forge->addPrimaryKey('idInventario');
        $this->forge->addForeignKey('idUsuario_fk', 'usuarios', 'idUsuario', 'CASCADE', 'CASCADE');

        // Creación de la tabla
        $this->forge->createTable('inventarios', true);
    }

    public function down()
    {
        // Eliminación de la tabla
        $this->forge->dropTable('inventarios', true);
    }
}
