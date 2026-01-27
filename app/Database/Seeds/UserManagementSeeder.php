<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserManagementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id'         => 1,
            'name'       => 'Admin',
            'email'      => 'admin@gmail.com',
            'phone'      => '1234325344',
            'role_id'    => 1,
            'status'     => 1,
            'created_at' => '2026-01-22 04:21:13',
            'updated_at' => '2026-01-22 04:21:13',
            'password'   => password_hash('Admin@123', PASSWORD_DEFAULT),
        ];

        $this->db->table('user_management')->insert($data);
    }
}
