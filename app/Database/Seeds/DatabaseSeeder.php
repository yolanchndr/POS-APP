<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('CustomerSeeder');
        $this->call('PCategorySeeder');
        $this->call('PUnitSeeder');
        $this->call('SupplierSeeder');
        $this->call('StoreSettingsSeeder');
        $this->call('PItemSeeder');
        $this->call('TSaleSeeder');
        $this->call('TSaleDetailSeeder');
        $this->call('TStockSeeder');
    }
}