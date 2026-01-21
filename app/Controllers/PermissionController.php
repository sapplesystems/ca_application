<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class PermissionController extends BaseController
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
    }

    public function index()
    {
        $permissions = $this->permissionModel->findAll();
        return view('permissions/index', ['permissions' => $permissions]);
    }

    public function create()
    {
        return view('permissions/create');
    }

    public function store()
    {
        $rules = [
            'permission_name' => 'required|min_length[3]',
            'permission_slug' => 'required|min_length[3]|is_unique[permissions.permission_slug]',
            'module' => 'required|min_length[3]',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'permission_name' => $this->request->getPost('permission_name'),
            'permission_slug' => $this->request->getPost('permission_slug'),
            'module' => $this->request->getPost('module'),
            'description' => $this->request->getPost('description'),
            'status' => 1,
        ];

        $this->permissionModel->insert($data);
        return redirect()->to('permissions')->with('success', 'Permission created successfully');
    }

    public function edit($id)
    {
        $permission = $this->permissionModel->find($id);
        if (!$permission) {
            return redirect()->to('permissions')->with('error', 'Permission not found');
        }

        return view('permissions/edit', ['permission' => $permission]);
    }

    public function update($id)
    {
        $permission = $this->permissionModel->find($id);
        if (!$permission) {
            return redirect()->to('permissions')->with('error', 'Permission not found');
        }

        $rules = [
            'permission_name' => 'required|min_length[3]',
            'module' => 'required|min_length[3]',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'permission_name' => $this->request->getPost('permission_name'),
            'module' => $this->request->getPost('module'),
            'description' => $this->request->getPost('description'),
        ];

        $this->permissionModel->update($id, $data);
        return redirect()->to('permissions')->with('success', 'Permission updated successfully');
    }

    public function delete($id)
    {
        $permission = $this->permissionModel->find($id);
        if (!$permission) {
            return redirect()->to('permissions')->with('error', 'Permission not found');
        }

        $this->permissionModel->delete($id);
        return redirect()->to('permissions')->with('success', 'Permission deleted successfully');
    }
}