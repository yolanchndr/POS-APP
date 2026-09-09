<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTStockTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'stock_id' => [
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
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['in', 'out'],
            ],
            'detail' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'supplier_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'ket_stok' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'created' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status_stock' => [
                'type'       => 'ENUM',
                'constraint' => ['minta', 'proses', 'diterima', 'ditolak'],
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('stock_id', true);
        $this->forge->addForeignKey('item_id', 'p_item', 'item_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('supplier_id', 'supplier', 'supplier_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('t_stock');
    }

    public function down()
    {
        $this->forge->dropTable('t_stock');
    }
}