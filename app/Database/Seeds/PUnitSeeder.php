<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PUnitSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'    => 'Pcs',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'Box',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('p_unit')->insertBatch($data);
    }
}