<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleDetailModel extends Model
{
    protected $table = 't_sale_detail';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'sale_id',
        'item_id',
        'price',
        'qty',
        'discount_item',
        'total',
        'tot_price_a',
    ];

    protected $returnType = 'array';
}