<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminPermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $admin = $session->get('admin');

        // Allow login routes without filter
        $currentUri = $request->getUri()->getPath();
        if (strpos($currentUri, '/login') !== false || $currentUri === '/') {
            return;
        }

        if (!$admin) {
            return redirect()->route('admin.login.form')->with('error', 'Please login first');
        }

        if (!isset($admin['is_active']) || $admin['is_active'] != 1) {
            $session->destroy();
            return redirect()->route('admin.login.form')->with('error', 'Your account is inactive');
        }

        // Check if user has permission for this route
        if (!$this->hasPermission($admin['id'], $currentUri)) {
            return redirect()->back()->with('error', 'You do not have permission to access this page');
        }

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }

    private function hasPermission($userId, $currentUri)
    {
        // Get user's role from ca_user table
        $db = \Config\Database::connect();
        $userRole = $db->table('ca_user')->select('role_id')->where('id', $userId)->get()->getRow();

        if (!$userRole || !$userRole->role_id) {
            return false;
        }

        // Check if role has "all" permissions
        $role = $db->table('roles')->select('permission_type')->where('id', $userRole->role_id)->get()->getRow();
        
        if ($role && $role->permission_type === 'all') {
            return true; // Allow all access
        }

        // Get the module/permission from the current URI
        $permission = $this->getPermissionFromUri($currentUri);

        if (!$permission) {
            return true; // Allow if no specific permission found
        }

        // Check if user's role has this permission
        $hasPermission = $db->table('role_permissions')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', $userRole->role_id)
            ->where('permissions.permission_slug', $permission)
            ->get()
            ->getRow();

        return $hasPermission ? true : false;
    }

    private function getPermissionFromUri($uri)
    {
        // Map URIs to permission slugs
        $permissionMap = [
            'work_master' => 'work_master.view',
            'company_master' => 'company.view',
            'Client_Master' => 'client.view',
            'InvoiceManagment' => 'invoice.view',
            'ManageInvoice' => 'invoice.view',
            'invoice' => 'invoice.view',
            'receipt_notes' => 'receipt.view',
            'debit_notes' => 'debit.view',
            'debit' => 'debit.view',
            'DebitNote' => 'debit.view',
            'reports_registers' => 'report.view',
            'pdf_outputs' => 'pdf.view',
            'roles' => 'role.view',
            'UserManagment' => 'user.view',
            'permissions' => 'permission.view',
        ];

        foreach ($permissionMap as $path => $permission) {
            if (strpos($uri, $path) !== false) {
                return $permission;
            }
        }

        return null;
    }
}