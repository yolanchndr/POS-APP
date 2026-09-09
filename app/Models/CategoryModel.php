<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'p_category';
    protected $primaryKey = 'category_id';

    protected $allowedFields = [
        'name',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $createdField = 'created';
    protected $updatedField = 'updated';
}