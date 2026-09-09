<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'    => 'PT Lorem Supplier',
                'phone'   => '0215551234',
                'address' => 'Jl. Lorem Ipsum No. 45',
                'desc'    => 'Supplier utama barang-barang lorem.',
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('supplier')->insertBatch($data);
    }
}