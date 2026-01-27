<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserManagementTable extends Migration
{
       public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'name'=>['type'=>'VARCHAR','constraint'=>100],
            'email'=>['type'=>'VARCHAR','constraint'=>150],
            'phone'=>['type'=>'VARCHAR','constraint'=>15],
            'role_id'=>['type'=>'INT','null'=>true],
            'status'=>['type'=>'TINYINT','default'=>1],
            'password'=>['type'=>'VARCHAR','constraint'=>200],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('user_management', true, ['ENGINE'=>'MyISAM']);
    }

    public function down()
    {
        $this->forge->dropTable('user_management');
    }

}
