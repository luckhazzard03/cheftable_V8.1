<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddMenus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Tipo_Menu' => [
                'type' => 'VARCHAR',                
                'unique' => true,
                'constraint' => 45,                
            ],
            'Precio_Menu' => [
                'type' => 'DECIMAL',       
                'constraint' => '10,2', 
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
        $this->forge->addPrimaryKey('Menu_id');
       
        $this->forge->createTable('menus');
    }

    public function down()
    {
        $this->forge->dropTable('menus');
    }
}
