<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'ca_user';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['username', 'password', 'is_active', 'is_enable', 'created_by', 'created_at', 'updated_at', 'deleted_at'];
}