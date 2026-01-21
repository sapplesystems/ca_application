<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersManagementTable extends Migration
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

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'unique'     => true,
            ],

            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],

            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'comment'    => 'user1, user2',
            ],

            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => '1=Active, 0=Inactive',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('user_management');
    }

    public function down()
    {
        $this->forge->dropTable('user_management');
    }
}