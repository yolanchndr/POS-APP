<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTCartTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cart_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('cart_id', true);
        $this->forge->addForeignKey('item_id', 'p_item', 'item_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_cart');
    }

    public function down()
    {
        $this->forge->dropTable('t_cart');
    }
}