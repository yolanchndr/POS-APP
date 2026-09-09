<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TSaleSeeder extends Seeder
{
    public function run()
    {
        $invoice = 'INV-' . date('YmdHis') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        $data = [
            [
                'invoice'        => $invoice,
                'customer_id'    => 1,
                'total_price'    => 30000,
                'tot_price_a'    => 20000,
                'discount'       => 0,
                'final_price'    => 30000,
                'cash'           => 50000,
                'uang_kembalian' => 20000,
                'note'           => 'Transaksi test lorem ipsum',
                'date'           => date('Y-m-d'),
                'user_id'        => 2,
                'created'        => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('t_sale')->insertBatch($data);
    }
}