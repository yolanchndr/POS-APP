<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TSaleDetailSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'sale_id'       => 1,
                'item_id'       => 1,
                'price'         => 15000,
                'qty'           => 2,
                'discount_item' => 0,
                'total'         => 30000,
                'tot_price_a'   => 20000,
            ],
        ];

        $this->db->table('t_sale_detail')->insertBatch($data);
    }
}