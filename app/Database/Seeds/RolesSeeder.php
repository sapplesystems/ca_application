<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
       public function run()
    {
        $data = [
            [
                'id'              => 1,
                'role_name'       => 'Admin',
                'description'     => 'Administrator with full access',
                'permission_type' => 'all',
                'status'          => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 2,
                'role_name'       => 'User',
                'description'     => 'Normal user with limited access',
                'permission_type' => 'custom',
                'status'          => 1,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        // Optional: clear table first
        $this->db->table('roles')->truncate();

        $this->db->table('roles')->insertBatch($data);
    }

}
