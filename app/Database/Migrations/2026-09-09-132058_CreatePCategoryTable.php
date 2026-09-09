<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
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
        $this->forge->addKey('category_id', true);
        $this->forge->createTable('p_category');
    }

    public function down()
    {
        $this->forge->dropTable('p_category');
    }
}