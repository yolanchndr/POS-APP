<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTSaleTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sale_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'customer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'total_price' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'tot_price_a' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'discount' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'final_price' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'cash' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'uang_kembalian' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'note' => [
                'type' => 'TEXT',
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('sale_id', true);
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('t_sale');
    }

    public function down()
    {
        $this->forge->dropTable('t_sale');
    }
}