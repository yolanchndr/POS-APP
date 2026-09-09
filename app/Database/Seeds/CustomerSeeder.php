<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'    => 'Lorem Customer Satu',
                'gender'  => 'L',
                'phone'   => '081234567890',
                'address' => 'Lorem ipsum street No. 123',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'Ipsum Customer Dua',
                'gender'  => 'P',
                'phone'   => '089876543210',
                'address' => 'Dolor sit amet block A',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('customer')->insertBatch($data);
    }
}