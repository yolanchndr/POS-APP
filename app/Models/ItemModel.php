<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'p_item';
    protected $primaryKey = 'item_id';

    protected $allowedFields = [
        'barcode',
        'name',
        'category_id',
        'unit_id',
        'price_a',
        'price',
        'stock',
        'min_stock',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $createdField = 'created';
    protected $updatedField = 'updated';
}