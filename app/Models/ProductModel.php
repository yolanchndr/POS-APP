<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'p_item';
    protected $primaryKey       = 'item_id';
    
    protected $returnType       = 'array'; 
 
    protected $useTimestamps    = false; 

    protected $allowedFields    = [
        'barcode',
        'name',
        'category_id',
        'unit_id',
        'price_a',
        'price',
        'stock',
        'min_stock',
    ];
}