<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'permission_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'permission_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'module' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('permissions', true, [
            'ENGINE' => 'MyISAM',
            'DEFAULT CHARSET' => 'utf8mb4',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('permissions', true);
    }
}
