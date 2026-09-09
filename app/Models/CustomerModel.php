<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    protected $allowedFields = [
        'name',
        'gender',
        'phone',
        'address',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $createdField = 'created';
    protected $updatedField = 'updated';
}