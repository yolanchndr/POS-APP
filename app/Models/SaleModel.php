<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table = 't_sale';
    protected $primaryKey = 'sale_id';

    protected $allowedFields = [
        'invoice',
        'customer_id',
        'total_price',
        'tot_price_a',
        'discount',
        'final_price',
        'cash',
        'uang_kembalian',
        'note',
        'date',
        'user_id',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = false;
    protected $createdField = 'created';
}