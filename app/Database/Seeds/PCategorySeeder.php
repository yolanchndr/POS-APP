<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'    => 'Kategori Lorem',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'Kategori Ipsum',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('p_category')->insertBatch($data);
    }
}