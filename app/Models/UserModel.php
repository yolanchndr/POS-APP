<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    protected $allowedFields = [
        'username',
        'password',
        'name',
        'address',
        'level'
    ];

    protected $returnType = 'array';

    public function getByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }
}