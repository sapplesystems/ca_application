<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWorkMasterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'service_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'service_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'sac_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'unit' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'default_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => '0.00',
            ],
            'gst_applicable' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => '1',
            ],
            'gst_percent' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => '0.00',
            ],
            'frequency' => [
                'type'       => 'ENUM',
                'constraint' => ['Monthly', 'Quarterly', 'Annually'],
                'null'       => true,
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('service_code', 'uk_service_code');

        $this->forge->createTable('work_master', true, [
            'ENGINE' => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('work_master', true);
    }
}
