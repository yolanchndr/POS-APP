<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTSaleDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'sale_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'item_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'price' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'discount_item' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'total' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'tot_price_a' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('sale_id', 't_sale', 'sale_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('item_id', 'p_item', 'item_id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('t_sale_detail');
    }

    public function down()
    {
        $this->forge->dropTable('t_sale_detail');
    }
}