<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientsTable extends Migration
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

            // Company identity
            'cin_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'legal_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'trade_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            // Registration details
            'roc_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'registration_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'date_of_incorporation' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'coi_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            // Company category
            'company_category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'company_sub_category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            // Address
            'registered_office' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'corporate_office' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Contact
            'telephone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'fax' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            // Share capital
            'authorised_share_capital' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'number_of_shares' => [
                'type' => 'INT',
                'null' => true,
            ],
            'face_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'paid_up_share_capital' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],

            // Statutory
            'pan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'gstin' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'esi_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'iec_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],

            // Bank
            'bank_account_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],

            // Management
            'directors_count' => [
                'type' => 'INT',
                'null' => true,
            ],
            'subsidiary_names' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Business nature
            'nature_of_business' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nature_of_service' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nature_of_product' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Billing
            'billing_emails' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'payment_terms' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],

            // Timestamps
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
        $this->forge->createTable('client_master');
    }

    public function down()
    {
        $this->forge->dropTable('clients');
    }
}