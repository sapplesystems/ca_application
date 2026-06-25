<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CA Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url();?>public/assets/style.css">
    <link href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>

</head>

<body>
    <div class="bg-blur"></div>

    <header class="top-header">
        <div class="logo-wrap">
            <div>
        <img src="<?= base_url('public/images/ca_logo.png') ?>" 
             alt="CA Logo" 
             style="width:100%; height:70px;">
    </div>
        </div>
        <div class="user-info">
            Welcome! <span><?= $session->get('admin')['name'] ?? 'Guest'; ?></span>
            <a href="<?= base_url('logout'); ?>">LOGOUT</a>
        </div>
    </header>

    <!-- NAVBAR -->
    <?php 
    $admin = $session->get('admin');
    $db = \Config\Database::connect();

    // Get user's role
    $userRole = $db->table('user_management')->select('role_id')->where('id', $admin['id'])->get()->getRow();
    
    // Function to check permission
    function hasPermission($permissionSlug, $roleId, $db) {
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
    ?>

    <nav class="menu-bar">
         <?php if ($userRole && hasPermission('work_master.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('home'); ?>" class="menu-link">
            <div class="menu-item">Home</div>
        </a>
        <?php endif; ?>
        <?php if ($userRole && hasPermission('work_master.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('work_master'); ?>" class="menu-link">
            <div class="menu-item">Master Work List</div>
        </a>
        <?php endif; ?>

        <?php if ($userRole && hasPermission('company.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('company_master'); ?>" class="menu-link">
            <div class="menu-item">Company Master</div>
        </a>
        <?php endif; ?>

        <?php if ($userRole && hasPermission('client.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('Client_Master'); ?>" class="menu-link">
            <div class="menu-item"> Client Master</div>
        </a>
        <?php endif; ?>

        <?php if ($userRole && hasPermission('invoice.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('InvoiceManagment'); ?>" class="menu-link">
            <div class="menu-item">Party Ledger</div>
        </a>
        <?php endif; ?>

        <?php if ($userRole && hasPermission('receipt.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('invoice-mangement'); ?>" class="menu-link">
            <div class="menu-item"> Invoice Management</div>
        </a>
        <?php endif; ?>

        <?php if ($userRole && hasPermission('report_register.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('reports_registers'); ?>" class="menu-link">
            <div class="menu-item">Reports & Registers</div>
        </a>
        <?php endif; ?>

        <?php if ($userRole && hasPermission('pdf_output.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('pdf_outputs'); ?>" class="menu-link">
            <div class="menu-item">PDF Outputs</div>
        </a>
        <?php endif; ?>
        <?php if ($userRole && hasPermission('user.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('/UserManagment'); ?>" class="menu-link">
            <div class="menu-item">User Managment</div>
        </a>
        <?php endif; ?>

        <?php if ($userRole && hasPermission('role.view', $userRole->role_id, $db)): ?>
        <a href="<?= base_url('roles'); ?>" class="menu-link">
            <div class="menu-item"> Manage Roles</div>
        </a>
        <?php endif; ?>

    </nav>

    <script>
        document.querySelectorAll('.menu-bar .menu-link').forEach(function(link) {

    link.addEventListener('click', function() {

        const href = link.href.toLowerCase();

        if (href.includes('invoicemanagment')) {
            localStorage.setItem('activeMenu', 'partyledger');
        }

        if (href.includes('invoice-mangement')) {
            localStorage.setItem('activeMenu', 'invoicemanagement');
        }

    });

});
        
        document.addEventListener('DOMContentLoaded', function () {

    const currentPath = window.location.pathname.toLowerCase();

    const modules = {
        home: [
            '/home'
        ],

        workmaster: [
            '/work_master'
        ],

        companymaster: [
            '/company_master'
        ],

        clientmaster: [
            '/client_master'
        ],

        partyledger: [
            '/invoicemanagment',
            '/manageinvoice',
            '/invoice/view',
            '/ledger',
            '/debitnotelist',
        ],

        invoicemanagement: [
            '/invoice-mangement',
            '/generate-invoice',
            '/credit-note',
            '/debit-note',
            '/invoice/edit',
            '/preview'
        ],

        reports: [
            '/reports_registers'
        ],

        pdfoutputs: [
            '/pdf_outputs'
        ],

        users: [
            '/usermanagment'
        ],

        roles: [
            '/roles'
        ]
    };

    let activeModule = null;

    Object.keys(modules).forEach(function(module){

        if (
            modules[module].some(url =>
                currentPath.includes(url)
            )
        ) {
            activeModule = module;
        }

    });

    document.querySelectorAll('.menu-link').forEach(function(link){

        const href = link.href.toLowerCase();
        const item = link.querySelector('.menu-item');

        item.classList.remove('active');

        if (
            activeModule === 'home' &&
            href.includes('/home')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'workmaster' &&
            href.includes('/work_master')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'companymaster' &&
            href.includes('/company_master')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'clientmaster' &&
            href.includes('/client_master')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'partyledger' &&
            href.includes('/invoicemanagment')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'invoicemanagement' &&
            href.includes('/invoice-mangement')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'reports' &&
            href.includes('/reports_registers')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'pdfoutputs' &&
            href.includes('/pdf_outputs')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'users' &&
            href.includes('/usermanagment')
        ) {
            item.classList.add('active');
        }

        if (
            activeModule === 'roles' &&
            href.includes('/roles')
        ) {
            item.classList.add('active');
        }

    });

});
</script>
</body>

</html>