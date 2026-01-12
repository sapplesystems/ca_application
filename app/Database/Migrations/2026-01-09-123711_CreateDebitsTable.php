<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDebitsTable extends Migration
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

            'company_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'client_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'debit_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],

            'total_recoverable_expenses' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],

            'advance_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],

            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],

            'terms_and_conditions' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'date' => [
                'type' => 'DATE',
            ],

            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],

            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->createTable('debits');
    }

    public function down()
    {
        $this->forge->dropTable('debits');
    }
}
