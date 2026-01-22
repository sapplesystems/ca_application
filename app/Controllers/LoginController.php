<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserManagementModel;

class LoginController extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new UserManagementModel();
    }

    // GET: /login
    public function login()
    {
        // If already logged in, redirect to dashboard
        $session = session();
        if ($session->get('admin')) {
            return redirect()->route('work_master.index');
        }

        return view('auth/login');
    }

    // POST: /login-for-entry
    public function loginforentry()
    {
        $session = session();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('pass');

        $rules = [
            'email' => 'required|valid_email',
            'pass' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if email exists
        $admin = $this->adminModel->where('email', $email)->first();

        if (!$admin) {
            $session->setFlashdata('error', 'Email not found');
            return redirect()->back()->withInput();
        }

        // Check if password is hashed or plain text
        if (strpos($admin['password'], '$2') === 0) {
            // Hashed password
            $passwordValid = password_verify($password, $admin['password']);
        } else {
            // Plain text password (legacy)
            $passwordValid = ($password === $admin['password']);
        }

        if (!$passwordValid) {
            $session->setFlashdata('error', 'Invalid password');
            return redirect()->back()->withInput();
        }

        if ($admin['status'] != 1) {
            $session->setFlashdata('error', 'Your account is inactive');
            return redirect()->back();
        }

        // Get user's role
        $db = \Config\Database::connect();
        $userRole = $db->table('user_management')->select('role_id')->where('id', $admin['id'])->get()->getRow();

        // Set session data (use only existing columns)
        $session->set('admin', [
            'id' => $admin['id'],
            'email' => $admin['email'],
            'status' => $admin['status'],
            'name' => $admin['name'],
            'created_at' => $admin['created_at'],
            'role_id' => $userRole ? $userRole->role_id : null,
        ]);

        $session->setFlashdata('success', 'Login successful');
        
        // Redirect based on user's role and permissions
        return $this->redirectByRole($userRole, $db);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->route('admin.login.form')->with('success', 'Logged out successfully');
    }

    private function redirectByRole($userRole, $db)
    {
        // If no role assigned, go to work master
        if (!$userRole) {
            return redirect()->route('work_master.index');
        }

        // Get role details
        $role = $db->table('roles')->select('permission_type')->where('id', $userRole->role_id)->get()->getRow();

        // If role has all permissions
        if ($role && $role->permission_type === 'all') {
            return redirect()->route('work_master.index');
        }

        // Check which modules user has access to and redirect to first available
        $permissionRoutes = [
            'work_master.view' => 'work_master.index',
            'company.view' => 'company.master',
            'client.view' => 'client.master',
            'invoice.view' => 'invoice.index',
            'receipt.view' => 'receipt.index',
            'debit.view' => 'debit.index',
            'report.view' => 'report.index',
            'pdf.view' => 'pdf.index',
            'role.view' => 'roles.index',
            'permission.view' => 'permissions.index',
        ];

        foreach ($permissionRoutes as $permission => $route) {
            if ($this->hasPermission($permission, $userRole->role_id, $db)) {
                return redirect()->route($route);
            }
        }

        // If no permission found, redirect to work master
        return redirect()->route('work_master.index');
    }

    private function hasPermission($permissionSlug, $roleId, $db)
    {
        if (!$roleId) return false;

        $role = $db->table('roles')->select('permission_type')->where('id', $roleId)->get()->getRow();

        if ($role && $role->permission_type === 'all') {
            return true;
        }

        $hasPermission = $db->table('role_permissions')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', $roleId)
            ->where('permissions.permission_slug', $permissionSlug)
            ->get()
            ->getRow();

        return $hasPermission ? true : false;
    }
}
