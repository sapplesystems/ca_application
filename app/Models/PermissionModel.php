<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['permission_name', 'permission_slug', 'module', 'description', 'status'];

    public function getByModule($module)
    {
        return $this->where('module', $module)->where('status', 1)->findAll();
    }
}