<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PItemSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'barcode'     => '9876543210123',
                'name'        => 'Produk Barang Lorem A',
                'category_id' => 1,
                'unit_id'     => 1,
                'price_a'     => 10000,
                'price'       => 15000,
                'stock'       => 20,
                'min_stock'   => 5,
                'created'     => date('Y-m-d H:i:s'),
                'updated'     => date('Y-m-d H:i:s'),
            ],
            [
                'barcode'     => '9876543210456',
                'name'        => 'Produk Barang Ipsum B',
                'category_id' => 2,
                'unit_id'     => 2,
                'price_a'     => 25000,
                'price'       => 35000,
                'stock'       => 10,
                'min_stock'   => 3,
                'created'     => date('Y-m-d H:i:s'),
                'updated'     => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('p_item')->insertBatch($data);
    }
}