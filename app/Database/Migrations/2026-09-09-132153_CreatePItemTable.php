<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'barcode' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'unit_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'price_a' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'price' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'min_stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 5,
            ],
            'created' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('item_id', true);
        $this->forge->addUniqueKey('barcode');
        $this->forge->addForeignKey('category_id', 'p_category', 'category_id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('unit_id', 'p_unit', 'unit_id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('p_item');
    }

    public function down()
    {
        $this->forge->dropTable('p_item');
    }
}