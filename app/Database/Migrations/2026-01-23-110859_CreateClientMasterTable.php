<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientMasterTable extends Migration
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
            'registered_office' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'corporate_office' => [
                'type' => 'TEXT',
                'null' => true,
            ],
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
            'authorised_share_capital' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'number_of_shares' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
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
            'bank_account_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'directors_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'subsidiary_names' => [
                'type' => 'TEXT',
                'null' => true,
            ],
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
            'billing_emails' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'payment_terms' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'gst_state' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('pan', 'uk_client_pan');
        $this->forge->addUniqueKey('gstin', 'uk_client_gstin');

        $this->forge->createTable('client_master', true, [
            'ENGINE' => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('client_master', true);
    }
}
