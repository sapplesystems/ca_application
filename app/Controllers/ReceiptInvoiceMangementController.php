<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientModel;
use App\Models\WorkMasterModel;
use App\Models\CompanyMasterModel;
use App\Models\InvoiceMasterModel;


class ReceiptInvoiceMangementController extends BaseController
{
    public function index()
    {
        $clientModel   = new ClientModel();
        $workModel     = new WorkMasterModel();
        $companyModel  = new CompanyMasterModel();

        // $data = [
        //     'clients'   => $clientModel->findAll(),
        //     'works'     => $workModel->findAll(),
        //     'companies' => $companyModel->findAll(),
        // ];
        $data = [
    'clients'   => $clientModel->orderBy('legal_name', 'ASC')->findAll(),
    'works'     => $workModel->findAll(),
    'companies' => $companyModel->orderBy('name', 'ASC')->findAll(),
];

        return view('common/header')
            . view('ReceiptInvoiceManagement/index', $data)
            . view('common/footer');
    }

    public function preview()
    {
        $request = service('request');

        $client_id  = $request->getPost('client_id');
        $workIds    = $request->getPost('work_ids');
        $companyId  = $request->getPost('company_id');
        $taxType    = $request->getPost('tax');
        $expenses   = $request->getPost('expenses');
        

        if (empty($client_id) || empty($workIds) || empty($companyId)) {
            return redirect()->back()->with('error', 'Please select client, works and company');
        }

        // TAX LOGIC
        if ($taxType === 'igst') {
            $cgst = 0;
            $sgst = 0;
            $igst = 18;
        } else {
            $cgst = 9;
            $sgst = 9;
            $igst = 0;
        }

        $companyModel = new CompanyMasterModel();
        $workModel    = new WorkMasterModel();
        $clientModel  = new ClientModel();
        $invoiceModel = new InvoiceMasterModel();

        $company = $companyModel->find($companyId);
        $works   = $workModel->whereIn('id', $workIds)->findAll();
        $client  = $clientModel->find($client_id);

        // Invoice number
        $lastInvoice = $invoiceModel->orderBy('id', 'DESC')->first();
        $nextId = $lastInvoice ? $lastInvoice['id'] + 1 : 1;
        $invoiceNo = $company['invoice_format'] . $nextId;

        return view('common/header')
            . view('ReceiptInvoiceManagement/preview', [
                'company'   => $company,
                'works'     => $works,
                'client'    => $client,
                'cgst'      => $cgst,
                'sgst'      => $sgst,
                'igst'      => $igst,
                'taxType'   => $taxType,
                'invoiceNo' => $invoiceNo,
                'expenses'  => $expenses,
            ])
            . view('common/footer');
    }

    public function search()
    {
        $request = service('request');

        $companyId = $request->getPost('company_id');
        $fromDate  = $request->getPost('from_date');
        $toDate    = $request->getPost('to_date');

        $invoiceModel = new InvoiceMasterModel();

        $query = $invoiceModel->select('invoices.id, invoices.invoice_no, invoices.invoice_date, invoices.service_value, invoices.cgst_amount, invoices.sgst_amount, invoices.igst_amount, invoices.grand_total, invoices.tax_apply_name, client_master.legal_name AS party_name, client_master.gstin AS party_gstin, GROUP_CONCAT(DISTINCT invoice_works.sac_code SEPARATOR ", ") AS hsn_code')
            ->join('client_master', 'client_master.id = invoices.client_id', 'left')
            ->join('invoice_works', 'invoice_works.invoice_id = invoices.id', 'left')
            ->groupBy('invoices.id')
            ->orderBy('invoices.invoice_date', 'DESC');

        if (!empty($companyId)) {
            $query->where('invoices.company_id', $companyId);
        }

        if (!empty($fromDate)) {
            $query->where('invoices.invoice_date >=', $fromDate);
        }

        if (!empty($toDate)) {
            $query->where('invoices.invoice_date <=', $toDate);
        }

        $results = $query->findAll();

       
        return $this->response->setJSON($results);
    }

   public function getReceiptDetails()
{
    $clientId  = $this->request->getPost('client_id');
    $companyId = $this->request->getPost('company_id');

    $clientModel = new \App\Models\ClientModel();
    $companyModel = new \App\Models\CompanyMasterModel();

    $client = $clientModel->find($clientId);
    $company = $companyModel->find($companyId);

    return $this->response->setJSON([
        'status'  => true,
        'client'  => $client,
        'company' => $company
    ]);
}

public function getReceiptNumber()
{
    $companyId = $this->request->getPost('company_id');
    $mode      = $this->request->getPost('mode_of_payment');

    $companyModel = new \App\Models\CompanyMasterModel();

    $company = $companyModel->find($companyId);

    if (!$company) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Company not found'
        ]);
    }

    switch ($mode) {

        case 'Cash':
            $format = $company['cash_receipt_format'];
            break;

        case 'Cheque':
            $format = $company['cheque_receipt_format'];
            break;

        case 'TDS':
            $format = $company['tds_receipt_format'];
            break;

        case 'Online':
            $format = $company['online_receipt_format'];
            break;

        default:
            $format = $company['cash_receipt_format'];
    }

    $receiptModel = new \App\Models\ReciptDetailsModel();

    $lastReceipt = $receiptModel
    ->orderBy('id', 'DESC')
    ->first();

$nextSerial = 1;

if ($lastReceipt) {
    $nextSerial = $lastReceipt['id'] + 1;
}


    $receiptNo = $format . '/' . $nextSerial;

    return $this->response->setJSON([
        'receipt_no' => $receiptNo
    ]);
}

public function saveReceipt()
{
    // print_r($this->request->getPost());exit;
    $data = [

        'company_id'      => $this->request->getPost('company_id'),
        'client_id'       => $this->request->getPost('client_id'),
        'recipt_no'       => $this->request->getPost('recipt_no'),
        'date'            => $this->request->getPost('date'),
        'mode_of_payment' => $this->request->getPost('mode_of_payment'),
        'cheque_date'     => $this->request->getPost('cheque_date'),    
        'cheque_number'   => $this->request->getPost('cheque_number'),
        'drawen_bank'     => $this->request->getPost('drawen_bank'),
        'bill_amount'     => $this->request->getPost('bill_amount'),

    ];
    if($this->request->getPost('mode_of_payment') === 'TDS') {
        $data['tds_amount'] = $this->request->getPost('tds_amount_only');
    } else {
        $data['tds_amount'] = $this->request->getPost('tds_amount');
    }

    $receiptModel = new \App\Models\ReciptDetailsModel();
    $receiptId = $receiptModel->insert($data);

    return $this->response->setJSON([
        'success'    => true,
        'receipt_id' => $receiptId
    ]);
}
}
