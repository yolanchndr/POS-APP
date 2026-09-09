<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StoreSettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'store_name'     => 'Toko Lorem Mart',
                'store_address'  => 'Jl. Konstitusi No. 99<br>Kota Ipsum',
                'store_phone'    => '081122334455',
                'receipt_footer' => 'Lorem ipsum dolor sit amet.<br>Terima kasih atas kunjungan Anda.',
            ],
        ];

        $this->db->table('store_settings')->insertBatch($data);
    }
}