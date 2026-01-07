<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type'       => 'INT',
                'constraint' => 20,
                'null'       => true,
            ],
            'invoice_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'company_id' => [
                'type'       => 'INT',
                'constraint' => 20,
                'null'       => true,
            ],
            'tax_apply_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'tax_rate_master_id' => [
                'type'       => 'INT',
                'constraint' => 20,
                'null'       => true,
            ],
            'advance_received' => [
                'type'       => 'FLOAT',
                'constraint' => '20,2',
                'null'       => true,
            ],
            'invoice_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'term_condition' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'invoice_status' => [
                'type'       => 'ENUM',
                'constraint' => ['new', 'modify'],
                'default'    => 'new',
            ],
            'total_invoice_amount' => [
                'type'       => 'FLOAT',
                'constraint' => '20,2',
                'null'       => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_on' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
           'updated_on' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'report_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('company_id');

        $this->forge->createTable('invoices', true);
    }

    public function down()
    {
         $this->forge->dropTable('invoices', true);
    }
}
