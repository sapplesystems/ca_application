<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'client_master';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'cin_no',
        'legal_name',
        'trade_name',
        'roc_code',
        'registration_no',
        'date_of_incorporation',
        'coi_file',
        'company_category',
        'company_sub_category',
        'registered_office',
        'corporate_office',
        'telephone',
        'fax',
        'website',
        'authorised_share_capital',
        'number_of_shares',
        'face_value',
        'paid_up_share_capital',
        'pan',
        'gstin',
        'esi_no',
        'iec_code',
        'bank_account_no',
        'directors_count',
        'subsidiary_names',
        'nature_of_business',
        'nature_of_service',
        'nature_of_product',
        'billing_emails',
        'payment_terms',
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

    public function findClientById(int $id)
    {
        return $this->where('id', $id)->first();
    }
}