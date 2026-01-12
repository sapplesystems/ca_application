<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientModel;
use App\Models\CompanyMasterModel;
use App\Models\DebitNotes;
use App\Models\WorkMasterModel;
use App\Models\InvoiceMasterModel;
use App\Models\ExpenseModel;
use Dompdf\Dompdf;
use Dompdf\Options;
class InvoiceMasterController extends BaseController
{
    public function index()
{
    $clientModel = new ClientModel();

    $clients = $clientModel
        ->select('id, legal_name')
        ->findAll();
    $companyModel = new CompanyMasterModel();
        $companies= $companyModel
        ->select('id, name,type_of_company')->findAll();

    echo view('common/header');
    echo view('InvoiceMaster/index', ['clients' => $clients, 'companies' => $companies]);
    echo view('common/footer');
}

    public function manageInvoice($id)
    {
        $clientModel = new ClientModel();

        $clients = $clientModel
            ->select('id, legal_name')
            ->where('id', $id)
            ->findAll();

        $companyModel = new CompanyMasterModel();
        $companies = $companyModel
        ->select('id, name,type_of_company')
        ->findAll();
        $workModel = new WorkMasterModel();
        $works = $workModel->select('id, service_name ,sac_code,frequency')->findAll();
        $invoiceModel = new InvoiceMasterModel();
        $invoice=  $invoiceModel->getInvoiceWithCompany($id);
      

        echo view('common/header');
        
        echo view('InvoiceMaster/Manage_invoice', [
            'companies' => $companies,
            'clients' => $clients,
            'works' => $works,
            'invoices' => $invoice,
             
        ]);
        echo view('common/footer');
    }
  public function previewInvoice()
{
    $client_id = $this->request->getPost('client_id');
    $workIds   = $this->request->getPost('work_ids');
    $companyId = $this->request->getPost('company_id');
    $taxType   = $this->request->getPost('tax');

    if (empty($workIds) || empty($companyId)) {
        return redirect()->back()->with('error', 'Please select company and works');
    }

    // ---------------- TAX LOGIC ----------------
    if ($taxType === 'igst') {
        $cgst = 0;
        $sgst = 0;
        $igst = 18;
    } else {
        // Default / CGST & SGST
        $cgst = 9;
        $sgst = 9;
        $igst = 0;
    }
    // -------------------------------------------

    // Fetch company
    $companyModel = new CompanyMasterModel();
    $company = $companyModel->find($companyId);

    // Fetch works
    $workModel = new WorkMasterModel();
    $works = $workModel->whereIn('id', $workIds)->findAll();

    // Fetch client
    $clientModel = new ClientModel();
    $client = $clientModel->find($client_id);

    $invoiceModel = new InvoiceMasterModel();
    $invoiceNo = $invoiceModel->generateInvoiceNo('INV', '001');

    return view('common/header')
        . view('InvoiceMaster/invoice_preview', [
            'company' => $company,
            'works'   => $works,
            'client'  => $client,

            // ✅ PASS TAX DATA TO VIEW
            'cgst' => $cgst,
            'sgst' => $sgst,
            'igst' => $igst,
            'taxType' => $taxType,
            'invoiceNo' => $invoiceNo 
        ])
        . view('common/footer');
}

        public function saveInvoice(){
          
        $invoiceModel = new InvoiceMasterModel();

                // Collect POST data
                $data = [
                    'service_description' => $this->request->getPost('service_description'),
                    'service_amount'=> $this->request->getPost('service_amount'),
                    'service_value' => $this->request->getPost('service_value'),
                    'expense_total' => $this->request->getPost('expense_total'),
                    'grand_total'   => $this->request->getPost('grand_total'),
                    'cgst_amount'   => $this->request->getPost('cgst_amount'),
                    'sgst_amount'   => $this->request->getPost('sgst_amount'),
                    'igst_amount'   => $this->request->getPost('igst_amount'),  
                    'advance_received'    => $this->request->getPost('advance_received'),
                    'total_invoice_amount'=> $this->request->getPost('net_amount'),
                    'client_id'           => $this->request->getPost('client_id'),
                    'company_id'          => $this->request->getPost('company_id'),
                    'invoice_no'          => $this->request->getPost('invoice_no'),
                    'term_condition'      => $this->request->getPost('term_condition'),
                    'tax_apply_name'      => $this->request->getPost('tax_apply_name'), 
                    'invoice_date'        => $this->request->getPost('invoice_date'),
                    'invoice_status'      => $this->request->getPost('invoice_status') ?? 'new',
                    'created_by'          => $this->request->getPost('created_by'),
                    'is_active'           => 1,
                    'report_status'       => 0,
                ];

                 $insertId = $invoiceModel->insert($data);

                if($insertId){
                    return $this->response->setJSON([
                        'status' => 'success',
                        'invoice_id' => $insertId
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error'
                    ]);
                }

        }
       public function print($id)
{
    $invoiceModel = new InvoiceMasterModel();

    // Get invoice by ID
    $invoice = $invoiceModel->find($id);

    if (!$invoice) {
        return redirect()->to('/invoice')->with('error', 'Invoice not found.');
    }

    // Load company and client info if needed
    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    $company = $companyModel->find($invoice['company_id']);
    $client  = $clientModel->find($invoice['client_id']);

    // Pass data to view
    $data = [
        'invoice' => $invoice,
        'company' => $company,
        'client'  => $client
    ];

    echo view('InvoiceMaster/print_invoice', $data);
}

public function pdf($id)
{
    $invoiceModel = new InvoiceMasterModel();
    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    $invoice = $invoiceModel->find($id);

    if (!$invoice) {
        return redirect()->to('/invoice')->with('error', 'Invoice not found');
    }

    $data = [
        'invoice' => $invoice,
        'company' => $companyModel->find($invoice['company_id']),
        'client'  => $clientModel->find($invoice['client_id'])
    ];

    // Load HTML view
    $html = view('InvoiceMaster/print_invoice', $data);

    // Dompdf options
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);

    // A4 size, portrait
    $dompdf->setPaper('A4', 'portrait');

    // Render PDF
    $dompdf->render();

    // Output PDF (force download)
    $dompdf->stream(
        'Invoice_' . $invoice['invoice_no'] . '.pdf',
        ['Attachment' => true]
    );
}


 public function edit($id)
    {
        $invoiceModel = new InvoiceMasterModel();
        $invoice = $invoiceModel->find($id);
        
        $companyId = $invoice['company_id'];
        // Fetch company
        $companyModel = new CompanyMasterModel();
        $company = $companyModel->find($companyId);

        $clientId = $invoice['client_id'];
        // Fetch client
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);
        

        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice not found');
        }

        return view('common/header').view('InvoiceMaster/edit_invoice_preview', [
            'invoice' => $invoice,
            'company' => $company,
            'client' => $client,  

        ]). view('common/footer');
    }
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request'
            ]);
        }
        $invoiceModel = new InvoiceMasterModel();
        $invoice = $invoiceModel->find($id);

        if (!$invoice) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invoice not found'
            ]);
        }

        $invoiceModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Invoice deleted successfully'
        ]);
    }

    public function receipt($id)
    {
        print_r($id); exit;
        $invoiceModel = new InvoiceMasterModel();

        // Get invoice by ID
        $invoice = $invoiceModel->find($id);

        if (!$invoice) {
            return redirect()->to('/invoice')->with('error', 'Invoice not found.');
        }

        // Load company and client info if needed
        $companyModel = new CompanyMasterModel();
        $clientModel  = new ClientModel();

        $company = $companyModel->find($invoice['company_id']);
        $client  = $clientModel->find($invoice['client_id']);

        // Pass data to view
        $data = [
            'invoice' => $invoice,
            'company' => $company,
            'client'  => $client
        ];

        echo view('InvoiceMaster/receipt_invoice', $data);
    }

public function storeDebitNote()
    {
        
         $companyId = $this->request->getPost('company_debit');
         $clientId = $this->request->getPost('client_id');

         $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);
        //  print_r($companyId); exit;
        $companyModel = new CompanyMasterModel();
        $company = $companyModel->find($companyId);
        
        return view('common/header')
            . view('InvoiceMaster/DebitNote', ['company' => $company, 'client' => $client])
            . view('common/footer');
    }

   public function saveDebitNote()
{
    // Load models
    $DebitModel   = new DebitNotes();
    $ExpenseModel = new ExpenseModel();

    // Collect debit note data
    $data = [
        'debit_no'                  => $this->request->getPost('debit_no'),
        'total_recoverable_expenses' => $this->request->getPost('expense_total'),
        'advance_amount'            => $this->request->getPost('advance_received'),
        'total_amount'              => $this->request->getPost('net_amount'),
        'client_id'                 => $this->request->getPost('client_id'),
        'company_id'                => $this->request->getPost('company_id'),
        'terms_and_conditions'      => $this->request->getPost('term_condition'),
        'date'                      => $this->request->getPost('debit_date'),
        'created_by'                => $this->request->getPost('created_by'),
    ];

    // Insert debit note
    $insertId = $DebitModel->insert($data);

    // If insert successful, save expenses
    if ($insertId) {

        $descriptions = $this->request->getPost('expense_description');
        $amounts      = $this->request->getPost('expense_amount');

        $expenseData = [];

        foreach ($descriptions as $i => $desc) {
            // Skip empty rows
            if (empty($desc) || empty($amounts[$i])) {
                continue;
            }

            $expenseData[] = [
                'debit_id'             => $insertId, // link to the debit note
                'expense_description'  => $desc,
                'expense_amount'       => $amounts[$i],
                'created_at'           => date('Y-m-d H:i:s')
            ];
        }

        // Insert all expenses in batch
        if (!empty($expenseData)) {
            $ExpenseModel->insertBatch($expenseData);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'invoice_id' => $insertId
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error'
        ]);
    }
}

public function debitNote($id)
{
    $debitModel = new DebitNotes();

    // Get debit note by ID
    $debitNote = $debitModel->find($id);

    $ExpenseModel = new ExpenseModel();
    $expenses = $ExpenseModel->where('debit_id', $id)->findAll();

    if (!$debitNote) {
        return redirect()->to('/debit-notes')->with('error', 'Debit Note not found.');
    }

    // Load company and client info if needed
    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    $company = $companyModel->find($debitNote['company_id']);
    $client  = $clientModel->find($debitNote['client_id']);

    // Pass data to view
    $data = [
        'debitNote' => $debitNote,
        'company'   => $company,
        'client'    => $client,
        'expenses'  => $expenses,
    ];

    echo view('InvoiceMaster/debitprint', $data);



}

public function debitNotePDF($id)
{
    $debitModel = new DebitNotes();

    // Get debit note by ID
    $debitNote = $debitModel->find($id);

    $ExpenseModel = new ExpenseModel();
    $expenses = $ExpenseModel->where('debit_id', $id)->findAll();

    if (!$debitNote) {
        return redirect()->to('/debit-notes')->with('error', 'Debit Note not found.');
    }

    // Load company and client info if needed
    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    $company = $companyModel->find($debitNote['company_id']);
    $client  = $clientModel->find($debitNote['client_id']);

    // Pass data to view
    $data = [
        'debitNote' => $debitNote,
        'company'   => $company,
        'client'    => $client,
        'expenses'  => $expenses,
    ];

    // Load HTML view
    $html = view('InvoiceMaster/debitprint', $data);

    // Dompdf options
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);

    // A4 size, portrait
    $dompdf->setPaper('A4', 'portrait');

    // Render PDF
    $dompdf->render();

    // Output PDF (force download)
    $dompdf->stream(
        'Debit_Note_' . $debitNote['debit_no'] . '.pdf',
        ['Attachment' => true]
    );
}
}