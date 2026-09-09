<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table = 't_stock';
    protected $primaryKey = 'stock_id';

    protected $allowedFields = [
        'item_id',
        'type',
        'detail',
        'supplier_id',
        'qty',
        'ket_stok',
        'date',
        'user_id',
        'status_stock',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $createdField = 'created';
}