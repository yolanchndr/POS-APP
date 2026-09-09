<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 't_cart';
    protected $primaryKey = 'cart_id';

    protected $allowedFields = [
        'item_id',
        'price',
        'qty',
        'discount_item',
        'total',
        'tot_price_a',
        'user_id',
    ];

    protected $returnType = 'array';
}