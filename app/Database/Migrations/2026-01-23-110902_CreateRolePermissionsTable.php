<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolePermissionsTable extends Migration
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
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'permission_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('role_id', false, false, 'role_permissions_role_id_foreign');
        $this->forge->addKey('permission_id', false, false, 'role_permissions_permission_id_foreign');

        $this->forge->createTable('role_permissions', true, [
            'ENGINE' => 'MyISAM',
            'DEFAULT CHARSET' => 'utf8mb4',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('role_permissions', true);
    }

}
