<?php

namespace App\Controllers;

use App\Models\CompanyMasterModel;
use App\Models\InvoiceMasterModel;

class ReportsRegisterController extends BaseController
{
    public function index()
    {
        $companyModel = new CompanyMasterModel();

        $data = [
            'companies' => $companyModel->findAll(),
        ];

        return view('common/header')
            . view('ReportsRegister/index', $data)
            . view('common/footer');
    }

    public function search()
    {
        $request = service('request');

        $companyId = $request->getPost('company_id');
        $fromDate = $request->getPost('from_date');
        $toDate = $request->getPost('to_date');

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
}
