<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'name'     => 'Lorem Administrator',
                'address'  => 'Lorem ipsum dolor sit amet',
                'level'    => '1'
            ],
            [
                'username' => 'kasir',
                'password' => password_hash('kasir123', PASSWORD_DEFAULT),
                'name'     => 'Ipsum Kasir',
                'address'  => 'Conconsectetur adipiscing elit',
                'level'    => '2'
            ],
        ];

        $this->db->table('user')->insertBatch($data);
    }
}