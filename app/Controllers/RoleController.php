<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $rolePermissionModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    public function index()
    {
        $roles = $this->roleModel->findAll();
        return view('roles/index', ['roles' => $roles]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('permissions');
        $modules = $builder->distinct()->select('module')->where('status', 1)->get()->getResultArray();
        
        $permissions = $this->permissionModel->where('status', 1)->findAll();
        
        return view('roles/create', ['modules' => $modules, 'permissions' => $permissions]);
    }

    public function store()
    {
        $rules = [
            'role_name' => 'required|min_length[3]|max_length[100]|is_unique[roles.role_name]',
            'description' => 'required|min_length[5]',
            'permission_type' => 'required|in_list[all,custom]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $roleData = [
            'role_name' => $this->request->getPost('role_name'),
            'description' => $this->request->getPost('description'),
            'permission_type' => $this->request->getPost('permission_type'),
            'status' => 1,
        ];

        $roleId = $this->roleModel->insert($roleData);

        if ($this->request->getPost('permission_type') === 'custom') {
            $permissions = $this->request->getPost('permissions') ?? [];
            if (!empty($permissions)) {
                $this->rolePermissionModel->assignPermissions($roleId, $permissions);
            }
        }

        return redirect()->to('roles')->with('success', 'Role created successfully');
    }

    public function edit($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('roles')->with('error', 'Role not found');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('permissions');
        $modules = $builder->distinct()->select('module')->where('status', 1)->get()->getResultArray();
        
        $allPermissions = $this->permissionModel->where('status', 1)->findAll();
        $rolePermissions = $this->rolePermissionModel->getPermissionsByRole($id);
        $permissionIds = array_column($rolePermissions, 'permission_id');

        return view('roles/edit', [
            'role' => $role,
            'modules' => $modules,
            'allPermissions' => $allPermissions,
            'rolePermissions' => $rolePermissions,
            'permissionIds' => $permissionIds,
        ]);
    }

    public function update($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('roles')->with('error', 'Role not found');
        }

        $rules = [
            'role_name' => 'required|min_length[3]|max_length[100]',
            'description' => 'required|min_length[5]',
            'permission_type' => 'required|in_list[all,custom]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'role_name' => $this->request->getPost('role_name'),
            'description' => $this->request->getPost('description'),
            'permission_type' => $this->request->getPost('permission_type'),
        ];

        $this->roleModel->update($id, $updateData);

        if ($this->request->getPost('permission_type') === 'custom') {
            $permissions = $this->request->getPost('permissions') ?? [];
            $this->rolePermissionModel->assignPermissions($id, $permissions);
        } else {
            $this->rolePermissionModel->where('role_id', $id)->delete();
        }

        return redirect()->to('roles')->with('success', 'Role updated successfully');
    }

    public function delete($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            return redirect()->to('roles')->with('error', 'Role not found');
        }

        $this->roleModel->delete($id);
        $this->rolePermissionModel->where('role_id', $id)->delete();

        return redirect()->to('roles')->with('success', 'Role deleted successfully');
    }

    public function getPermissionsByModule($module)
    {
        $permissions = $this->permissionModel->where('module', $module)->where('status', 1)->findAll();
        return $this->response->setJSON(['permissions' => $permissions]);
    }
}