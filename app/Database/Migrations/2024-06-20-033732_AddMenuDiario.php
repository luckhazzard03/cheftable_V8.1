<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddMenuDiario extends Migration
{
    public function up()
    {
        // Definición de la estructura de la tabla Menu_Diario
        $this->forge->addField([
            'idDiario' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Dia' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => false,
            ],
            'Descripcion' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false,
            ],
            'Menu_id_fk' => [
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

        // Definición de claves y restricciones
        $this->forge->addKey('idDiario', true);
        $this->forge->addForeignKey('Menu_id_fk', 'menus', 'Menu_id', 'CASCADE', 'CASCADE');

        // Creación de la tabla
        $this->forge->createTable('menudiarios');
    }

    public function down()
    {
        // Eliminación de la tabla
        $this->forge->dropTable('menudiarios');
    }
}
