<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';

    protected $allowedFields = [
        'name',
        'phone',
        'address',
        'desc',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $createdField = 'created';
    protected $updatedField = 'updated';
}