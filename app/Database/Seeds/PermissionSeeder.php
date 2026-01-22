<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Work Master Permissions
            ['permission_name' => 'View Work Master', 'permission_slug' => 'work_master.view', 'module' => 'work_master', 'description' => 'View work master list', 'status' => 1],
            ['permission_name' => 'Create Work', 'permission_slug' => 'work_master.create', 'module' => 'work_master', 'description' => 'Create new work', 'status' => 1],
            ['permission_name' => 'Edit Work', 'permission_slug' => 'work_master.edit', 'module' => 'work_master', 'description' => 'Edit work details', 'status' => 1],
            ['permission_name' => 'Delete Work', 'permission_slug' => 'work_master.delete', 'module' => 'work_master', 'description' => 'Delete work', 'status' => 1],

            // Client Master Permissions
            ['permission_name' => 'View Client Master', 'permission_slug' => 'client.view', 'module' => 'client', 'description' => 'View client list', 'status' => 1],
            ['permission_name' => 'Create Client', 'permission_slug' => 'client.create', 'module' => 'client', 'description' => 'Create new client', 'status' => 1],
            ['permission_name' => 'Edit Client', 'permission_slug' => 'client.edit', 'module' => 'client', 'description' => 'Edit client details', 'status' => 1],
            ['permission_name' => 'Delete Client', 'permission_slug' => 'client.delete', 'module' => 'client', 'description' => 'Delete client', 'status' => 1],

            // Company Master Permissions
            ['permission_name' => 'View Company Master', 'permission_slug' => 'company.view', 'module' => 'company', 'description' => 'View company list', 'status' => 1],
            ['permission_name' => 'Create Company', 'permission_slug' => 'company.create', 'module' => 'company', 'description' => 'Create new company', 'status' => 1],
            ['permission_name' => 'Edit Company', 'permission_slug' => 'company.edit', 'module' => 'company', 'description' => 'Edit company details', 'status' => 1],
            ['permission_name' => 'Delete Company', 'permission_slug' => 'company.delete', 'module' => 'company', 'description' => 'Delete company', 'status' => 1],

            // Invoice Permissions
            ['permission_name' => 'View Invoice', 'permission_slug' => 'invoice.view', 'module' => 'invoice', 'description' => 'View invoices', 'status' => 1],
            ['permission_name' => 'Create Invoice', 'permission_slug' => 'invoice.create', 'module' => 'invoice', 'description' => 'Create new invoice', 'status' => 1],
            ['permission_name' => 'Edit Invoice', 'permission_slug' => 'invoice.edit', 'module' => 'invoice', 'description' => 'Edit invoice details', 'status' => 1],
            ['permission_name' => 'Delete Invoice', 'permission_slug' => 'invoice.delete', 'module' => 'invoice', 'description' => 'Delete invoice', 'status' => 1],
            ['permission_name' => 'Print Invoice', 'permission_slug' => 'invoice.print', 'module' => 'invoice', 'description' => 'Print invoice', 'status' => 1],

            // Receipt Permissions
            ['permission_name' => 'View Receipt', 'permission_slug' => 'receipt.view', 'module' => 'receipt', 'description' => 'View receipts', 'status' => 1],
            ['permission_name' => 'Create Receipt', 'permission_slug' => 'receipt.create', 'module' => 'receipt', 'description' => 'Create new receipt', 'status' => 1],
            ['permission_name' => 'Edit Receipt', 'permission_slug' => 'receipt.edit', 'module' => 'receipt', 'description' => 'Edit receipt details', 'status' => 1],
            ['permission_name' => 'Delete Receipt', 'permission_slug' => 'receipt.delete', 'module' => 'receipt', 'description' => 'Delete receipt', 'status' => 1],
            ['permission_name' => 'Print Receipt', 'permission_slug' => 'receipt.print', 'module' => 'receipt', 'description' => 'Print receipt', 'status' => 1],

            // Debit Note Permissions
            ['permission_name' => 'View Debit Note', 'permission_slug' => 'debit.view', 'module' => 'debit', 'description' => 'View debit notes', 'status' => 1],
            ['permission_name' => 'Create Debit Note', 'permission_slug' => 'debit.create', 'module' => 'debit', 'description' => 'Create new debit note', 'status' => 1],
            ['permission_name' => 'Edit Debit Note', 'permission_slug' => 'debit.edit', 'module' => 'debit', 'description' => 'Edit debit note details', 'status' => 1],
            ['permission_name' => 'Delete Debit Note', 'permission_slug' => 'debit.delete', 'module' => 'debit', 'description' => 'Delete debit note', 'status' => 1],
            ['permission_name' => 'Print Debit Note', 'permission_slug' => 'debit.print', 'module' => 'debit', 'description' => 'Print debit note', 'status' => 1],

            // Role Permissions
            ['permission_name' => 'View Role', 'permission_slug' => 'role.view', 'module' => 'role', 'description' => 'View roles', 'status' => 1],
            ['permission_name' => 'Create Role', 'permission_slug' => 'role.create', 'module' => 'role', 'description' => 'Create new role', 'status' => 1],
            ['permission_name' => 'Edit Role', 'permission_slug' => 'role.edit', 'module' => 'role', 'description' => 'Edit role details', 'status' => 1],
            ['permission_name' => 'Delete Role', 'permission_slug' => 'role.delete', 'module' => 'role', 'description' => 'Delete role', 'status' => 1],

             // ===================== PDF Output Module =====================
            ['permission_name' => 'View PDF Output', 'permission_slug' => 'pdf_output.view', 'module' => 'pdf_output', 'description' => 'View PDF output list', 'status' => 1],
            ['permission_name' => 'Generate PDF', 'permission_slug' => 'pdf_output.generate', 'module' => 'pdf_output', 'description' => 'Generate PDF file', 'status' => 1],
            ['permission_name' => 'Download PDF', 'permission_slug' => 'pdf_output.download', 'module' => 'pdf_output', 'description' => 'Download PDF file', 'status' => 1],
            ['permission_name' => 'Print PDF', 'permission_slug' => 'pdf_output.print', 'module' => 'pdf_output', 'description' => 'Print PDF file', 'status' => 1],
            ['permission_name' => 'Delete PDF', 'permission_slug' => 'pdf_output.delete', 'module' => 'pdf_output', 'description' => 'Delete generated PDF', 'status' => 1],
            // ===================== Report Register Module =====================
            ['permission_name' => 'View Report Register', 'permission_slug' => 'report_register.view', 'module' => 'report_register', 'description' => 'View report register list', 'status' => 1],
            ['permission_name' => 'Generate Report', 'permission_slug' => 'report_register.generate', 'module' => 'report_register', 'description' => 'Generate report', 'status' => 1],
            ['permission_name' => 'Export Report', 'permission_slug' => 'report_register.export', 'module' => 'report_register', 'description' => 'Export report data', 'status' => 1],
            ['permission_name' => 'Print Report', 'permission_slug' => 'report_register.print', 'module' => 'report_register', 'description' => 'Print report', 'status' => 1],
            ['permission_name' => 'Delete Report', 'permission_slug' => 'report_register.delete', 'module' => 'report_register', 'description' => 'Delete report entry', 'status' => 1],
        ];

$table = $this->db->table('permissions');

    foreach ($data as $row) {
        $existing = $table
            ->where('permission_slug', $row['permission_slug'])
            ->get()
            ->getRowArray();

        if ($existing) {
            // UPDATE
            $table
                ->where('permission_slug', $row['permission_slug'])
                ->update($row);
        } else {
            // INSERT
            $table->insert($row);
        }
    }    }
}