<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $table = 'p_unit';
    protected $primaryKey = 'unit_id';

    protected $allowedFields = [
        'name',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $createdField = 'created';
    protected $updatedField = 'updated';
}