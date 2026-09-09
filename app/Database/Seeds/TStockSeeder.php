<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TStockSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'item_id'      => 1,
                'type'         => 'in',
                'detail'       => 'Restock awal lorem',
                'supplier_id'  => 1,
                'qty'          => 20,
                'ket_stok'     => 'Stok masuk dari supplier lorem.',
                'date'         => date('Y-m-d'),
                'created'      => date('Y-m-d H:i:s'),
                'user_id'      => 1,
                'status_stock' => 'diterima',
            ],
        ];

        $this->db->table('t_stock')->insertBatch($data);
    }
}