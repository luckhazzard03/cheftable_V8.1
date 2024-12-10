<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddComanda extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Comanda_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'Fecha' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'Hora' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'Total_platos' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'Precio_Total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
            ],
            'Tipo_Menu' => [
                'type' => 'VARCHAR',         
                'constraint' => 45, 
                'null' => false, 
            ],
            // Campo adicional para almacenar los adicionales
            'Adicionales' => [
                'type' => 'DECIMAL', // Puedes usar TEXT o VARCHAR dependiendo de cómo quieras almacenar los adicionales
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => true, // Permitir que este campo sea nulo si no se seleccionan adicionales
            ],
            'idUsuario_fk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'idMesa_fk' => [
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
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addPrimaryKey('Comanda_id'); 
         // Definición de índice y clave externa (foreign key)
         $this->forge->addForeignKey('idUsuario_fk', 'usuarios', 'idUsuario', 'CASCADE', 'CASCADE');      
         $this->forge->addForeignKey('idMesa_fk', 'mesas', 'idMesa', 'CASCADE', 'CASCADE');      
        $this->forge->createTable('comandas');
    }

    public function down()
    {
        $this->forge->dropTable('comandas');
    }
}
