<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoiceWorksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'invoice_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'service_description' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'service_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('invoice_id', 'invoice_master', 'id', 'CASCADE', 'CASCADE'); // optional FK
        $this->forge->createTable('invoice_works');
    }

    public function down()
    {
        $this->forge->dropTable('invoice_works');
    }
}
