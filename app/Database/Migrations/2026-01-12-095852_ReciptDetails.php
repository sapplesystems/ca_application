<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReciptDetails extends Migration
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

            'recipt_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'date' => [
                'type' => 'DATE',
            ],

            'mode_of_payment' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'cheque_date' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'cheque_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],

            'drawen_bank' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'bill_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],

            'tds_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
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
        $this->forge->createTable('recipt_details');
    }

    public function down()
    {
        $this->forge->dropTable('recipt_details');
    }
}
