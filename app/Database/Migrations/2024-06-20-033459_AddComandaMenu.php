<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddComandaMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Comanda_menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Cantidad_Menu' => [
                'type' => 'INT',                
                'unsigned' => true,
            ],
            'Precio' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned' => true,
            ],
            'Descripcion' => [
                'type' => 'VARCHAR',
                'constraint' => 255, // Ajustar la longitud según tus necesidades
            ],
            'Comanda_fk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'Menu_fk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
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
        $this->forge->addPrimaryKey('Comanda_menu_id');
        $this->forge->addForeignKey('Comanda_fk', 'comandas', 'Comanda_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('Menu_fk', 'menus', 'Menu_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('comanda_menu');
    }

    public function down()
    {
        $this->forge->dropTable('comanda_menu');
    }
}
