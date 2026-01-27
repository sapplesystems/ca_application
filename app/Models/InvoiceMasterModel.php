<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceMasterModel extends Model
{
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'client_id',
        'invoice_no',
        'company_id',
        'tax_apply_name',
        'tax_rate_master_id',
        'advance_received',
        'invoice_date',
        'term_condition',
        'invoice_status',
        'total_invoice_amount',
        'created_by',
        'created_on',
        'updated_on',
        'is_active',
        'report_status',
        'service_description',
        'service_amount',
        'service_value',
        'expense_total',
        'grand_total'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

public function getInvoiceWithCompany($clientId)
{
    return $this->select('
            invoices.*,
            company_master.name AS company_name,
            MAX(recipt_details.date) AS recipt_date,
            MAX(recipt_details.recipt_no) AS recipt_no,
            SUM(recipt_details.tds_amount) AS tds_amount,
            GROUP_CONCAT(DISTINCT invoice_works.service_name SEPARATOR ",\n ") AS service_names
        ')
        ->join('company_master', 'company_master.id = invoices.company_id', 'left')
        ->join('recipt_details', 'recipt_details.invoice_id = invoices.id', 'left')
        ->join('invoice_works', 'invoice_works.invoice_id = invoices.id', 'left')
        ->where('invoices.client_id', $clientId)
        ->groupBy('invoices.id')
        ->orderBy('invoices.id', 'DESC')
        ->findAll();
}



        public function generateInvoiceNo($org, $branch)
    {
        // Financial Year (India style)
        $year = date('Y');
        $month = date('m');

        if ($month >= 4) {
            $fy = substr($year, 2) . substr($year + 1, 2);
        } else {
            $fy = substr($year - 1, 2) . substr($year, 2);
        }

        // Get last sequence
        $lastInvoice = $this->select('id')
            ->orderBy('id', 'DESC')
            ->first();

        $seq = $lastInvoice ? $lastInvoice['id'] + 1 : 1;

        return "{$org}/{$branch}/{$fy}/{$seq}";
    }
}
