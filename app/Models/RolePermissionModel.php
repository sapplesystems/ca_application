<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permissions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['role_id', 'permission_id'];

    public function getPermissionsByRole($roleId)
    {
        return $this->select('role_permissions.id, permissions.id as permission_id, permissions.permission_name, permissions.permission_slug, permissions.module')
                    ->join('permissions', 'permissions.id = role_permissions.permission_id')
                    ->where('role_permissions.role_id', $roleId)
                    ->findAll();
    }

    public function assignPermissions($roleId, $permissionIds)
    {
        $this->where('role_id', $roleId)->delete();
        
        foreach ($permissionIds as $permissionId) {
            $this->insert(['role_id' => $roleId, 'permission_id' => $permissionId]);
        }
    }
}