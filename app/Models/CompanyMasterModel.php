<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyMasterModel extends Model
{
    protected $table            = 'company_master';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = [ 
         'type_of_company',      // ya jo actual column name ho
        'name',
        'date_of_incorp',
        'category',
        'registered_office',
        'head_office',
        'email',
        'telephone',
        'website',
        'invoice_format',
        'pan',
        'gstin',
        'iec',
        'sister_concerns',
        'branches',             // iske liye JSON rakhenge
        'bank_ac_no',           // ya bank_account, jo bhi column ho
        'logo',                 // logo ka filename
        'status',
        'nature_of_business',
        'nature_of_service',
        'nature_of_product',
        'condition_and_terms',
        'bank_name',
        'bank_ifsc',
        'created_at',
        'updated_at',
        'gst_state',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
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

     public function findCompanyById(int $id)
    {
        return $this->where('id', $id)->first();
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