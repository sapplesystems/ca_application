<?php

/**
 * Permission Helper
 * 
 * Contains permission and role checking functions
 */

if (!function_exists('hasPermission')) {
    /**
     * Check if user has permission for a specific action
     * 
     * @param string $permissionSlug - The permission slug (e.g., 'work_master.view', 'company.view')
     * @param int|null $roleId - Optional role ID (if not provided, uses current logged-in user's role)
     * 
     * @return bool - Returns true if user has permission, false otherwise
     */
    function hasPermission($permissionSlug, $roleId = null) {
        $db = \Config\Database::connect();
        
        // If roleId not provided, get current user's role
        if (!$roleId) {
            $session = session();
            $admin = $session->get('admin');
            
            if (!$admin || !isset($admin['id'])) {
                return false;
            }
            
            $userRole = $db->table('user_management')
                ->select('role_id')
                ->where('id', $admin['id'])
                ->get()
                ->getRow();
            
            if (!$userRole) {
                return false;
            }
            
            $roleId = $userRole->role_id;
        }
        
        if (!$roleId) {
            return false;
        }
        
        // Get role details
        $role = $db->table('roles')
            ->select('permission_type')
            ->where('id', $roleId)
            ->get()
            ->getRow();
        
        // If role has 'all' permission type, grant access
        if ($role && $role->permission_type === 'all') {
            return true;
        }
        
        // Check specific permission
        $hasPermission = $db->table('role_permissions')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', $roleId)
            ->where('permissions.permission_slug', $permissionSlug)
            ->get()
            ->getRow();
        
        return $hasPermission ? true : false;
    }
}

if (!function_exists('getUserRole')) {
    /**
     * Get current logged-in user's role ID
     * 
     * @return int|null - Returns role ID or null if user not logged in
     */
    function getUserRole() {
        $session = session();
        $admin = $session->get('admin');
        
        if (!$admin || !isset($admin['id'])) {
            return null;
        }
        
        $db = \Config\Database::connect();
        $userRole = $db->table('user_management')
            ->select('role_id')
            ->where('id', $admin['id'])
            ->get()
            ->getRow();
        
        return $userRole ? $userRole->role_id : null;
    }
}
