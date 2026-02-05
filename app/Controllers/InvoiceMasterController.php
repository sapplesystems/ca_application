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
use App\Models\InvoiceWorksModel;
use App\Models\ReciptDetailsModel;
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
            ->select('id, legal_name,gst_state')
            ->where('id', $id)
            ->findAll();

        $companyModel = new CompanyMasterModel();
        $companies = $companyModel
        ->select('id, name,type_of_company,gst_state')
        ->findAll();
        $workModel = new WorkMasterModel();
        $works = $workModel->select('id, service_name ,sac_code,frequency')->findAll();
        $invoiceModel = new InvoiceMasterModel();
        $invoice=  $invoiceModel->getInvoiceWithCompany($id);
        $receiptModel=new ReciptDetailsModel();
        $receipt=$receiptModel->select('*')->findAll();
        $debitModel=new DebitNotes();
        $debit=$debitModel->select('note_type,total_amount')->findAll();

        echo view('common/header');
        
        echo view('InvoiceMaster/Manage_invoice', [
            'companies' => $companies,
            'clients' => $clients,
            'works' => $works,
            'invoices' => $invoice,
            'receipt'=>$receipt,
            'debit'=>$debit
             
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

        public function saveInvoice()
        {
    //    print_r( $this->request->getPost());exit;
        $invoiceModel = new InvoiceMasterModel();
        $ExpenseModel=new ExpenseModel();
        $workModel=new InvoiceWorksModel();
                // Collect POST data
                $data = [
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
                    'amount_in_words'     => $this->request->getPost('amount_in_words'),
                    'is_active'           => 1,
                    'report_status'       => 0,
                ];

                 $insertId = $invoiceModel->insert($data);

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
                'invoice_id'             => $insertId, 
                'expense_description'  => $desc,
                'expense_amount'       => $amounts[$i],
                'created_at'           => date('Y-m-d H:i:s')
            ];
        }

        // Insert all expenses in batch
        if (!empty($expenseData)) {
            $ExpenseModel->insertBatch($expenseData);
        }
    $workTitles   = $this->request->getPost('service_description') ?? [];
    $workAmounts  = $this->request->getPost('service_amount') ?? [];
    $serviceName =$this->request->getPost('service_name') ?? [];
    $serviceUnit=$this->request->getPost('unit') ?? [];
    $workData = [];

    foreach ($workTitles as $i => $title) {
        if (!empty($title) && !empty($workAmounts[$i])) {
            $workData[] = [
                'invoice_id'   => $insertId,
                'service_description'   => $title,
                'service_amount' => $workAmounts[$i],
                'service_name'       => $serviceName[$i] ?? null,
                'service_unit'       => $serviceUnit[$i] ?? null,
                'created_at'           => date('Y-m-d H:i:s')
            ];
        }
        
    }

    if (!empty($workData)) {
        $workModel->insertBatch($workData);
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

     $invoiceWorkModel=new InvoiceWorksModel();
    $invoice_works=$invoiceWorkModel->where('invoice_id', $id)->findAll();
  /* 2️⃣ TOTAL of service_amount */
$totalRow = $invoiceWorkModel
    ->selectSum('service_amount')
    ->where('invoice_id', $id)
    ->get()
    ->getRowArray();

$serviceTotal = $totalRow['service_amount'] ?? 0;
    $ExpenseModel = new ExpenseModel();

     $expenses= $ExpenseModel
    ->where('invoice_id', $id)
    ->findAll();

    // Pass data to view
    $data = [
        'invoice' => $invoice,
        'company' => $company,
        'client'  => $client,
        'invoice_works'=> $invoice_works,
        'serviceTotal' => $serviceTotal,
        'expences'=>$expenses,
    ];

    echo view('InvoiceMaster/print_invoice', $data);
}

public function pdf($id)
{
    $invoiceModel = new InvoiceMasterModel();
    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    $invoice = $invoiceModel->find($id);
     $invoiceWorkModel=new InvoiceWorksModel();
    $invoice_works=$invoiceWorkModel->where('invoice_id', $id)->findAll();

     /* 2️⃣ TOTAL of service_amount */
$totalRow = $invoiceWorkModel
    ->selectSum('service_amount')
    ->where('invoice_id', $id)
    ->get()
    ->getRowArray();

$serviceTotal = $totalRow['service_amount'] ?? 0;

    $ExpenseModel = new ExpenseModel();

     $expenses= $ExpenseModel
    ->where('invoice_id', $id)
    ->findAll();

    if (!$invoice) {
        return redirect()->to('/invoice')->with('error', 'Invoice not found');
    }

    $data = [
        'invoice' => $invoice,
        'company' => $companyModel->find($invoice['company_id']),
        'client'  => $clientModel->find($invoice['client_id']),
        'invoice_works'=> $invoice_works,
        'expences'=>$expenses,
        'serviceTotal' => $serviceTotal,
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
        $ExpenseModel = new ExpenseModel();

     $expenses= $ExpenseModel
    ->where('invoice_id', $id)
    ->findAll();

    $invoiceWorkModel=new InvoiceWorksModel();
    $invoice_works=$invoiceWorkModel->where('invoice_id', $id)->findAll();
        

        if (!$invoice) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invoice not found');
        }

        return view('common/header').view('InvoiceMaster/edit_invoice_preview', [
            'invoice' => $invoice,
            'company' => $company,
            'client' => $client,  
            'expenses'=>$expenses,
            'invoice_works'=> $invoice_works,

        ]). view('common/footer');
    }
    
 public function updateInvoice($id)
{
    // print_r($this->request->getPost()); exit;

    $invoiceModel = new InvoiceMasterModel();
    $expenseModel = new ExpenseModel();
    $workModel    = new InvoiceWorksModel();

    // ======================
    // UPDATE INVOICE MASTER
    // ======================
    $invoiceModel->update($id, [
        'service_value'        => $this->request->getPost('service_value'),
        'expense_total'        => $this->request->getPost('expense_total'),
        'grand_total'          => $this->request->getPost('grand_total'),
        'total_invoice_amount'=> $this->request->getPost('net_amount'),
        'advance_received'     => $this->request->getPost('advance_received'),
        'amount_in_words'     => $this->request->getPost('amount_in_words'),
        'term_condition'      => $this->request->getPost('term_condition'),
        'updated_at'           => date('Y-m-d H:i:s')
    ]);

    // ======================
    // EXPENSE UPDATE / INSERT
    // ======================
    $expenseIds   = $this->request->getPost('expense_id') ?? [];
    $descriptions = $this->request->getPost('expense_description') ?? [];
    $amounts      = $this->request->getPost('expense_amount') ?? [];

    foreach ($descriptions as $i => $desc) {

        if ($desc === '' || empty($amounts[$i])) {
            continue;
        }

        // UPDATE
        if (!empty($expenseIds[$i])) {

            $expenseModel->update($expenseIds[$i], [
                'expense_description' => $desc,
                'expense_amount'      => $amounts[$i],
                'updated_at'          => date('Y-m-d H:i:s')
            ]);
        }
        // INSERT
        else {

            $expenseModel->insert([
                'invoice_id'          => $id,
                'expense_description' => $desc,
                'expense_amount'      => $amounts[$i],
                'created_at'          => date('Y-m-d H:i:s')
            ]);
        }
    }

    // ======================
    // UPDATE / INSERT WORKS
    // ONLY service_amount is updated
    // ======================
    $workIds      = $this->request->getPost('work_id') ?? [];
    $workAmounts  = $this->request->getPost('service_amount') ?? [];
    $workTitles   = $this->request->getPost('service_description') ?? [];
    $serviceNames = $this->request->getPost('service_name') ?? [];
    $serviceUnits = $this->request->getPost('unit') ?? [];

    foreach ($workAmounts as $i => $amount) {

        if (empty($amount)) {
            continue;
        }

        // UPDATE EXISTING → ONLY amount
        if (!empty($workIds[$i])) {

            $workModel->update($workIds[$i], [
                'service_description'=> $workTitles[$i] ?? null,
                'service_amount' => $amount,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
        }
        // INSERT NEW
        else {

            if (empty($workTitles[$i])) {
                continue;
            }

            $workModel->insert([
                'invoice_id'          => $id,
                'service_description' => $workTitles[$i],
                'service_amount'      => $amount,
                'service_name'        => $serviceNames[$i] ?? null,
                'service_unit'        => $serviceUnits[$i] ?? null,
                'created_at'          => date('Y-m-d H:i:s')
            ]);
        }
    }

   return $this->response->setJSON([
    'status'     => 'success',
    'invoice_id' => $id
]);
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
    $invoiceModel = new InvoiceMasterModel();
    $invoice = $invoiceModel->find($id);

    if (!$invoice) {
        return $this->response->setJSON(['error' => 'Invoice not found']);
    }

    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    $company = $companyModel->find($invoice['company_id']);
    $client  = $clientModel->find($invoice['client_id']);

    return $this->response->setJSON([
        'invoice' => $invoice,
        'company' => $company,
        'client'  => $client
    ]);
}



public function storeDebitNote()
    {
        // print_r($this->request->getPost());exit;
         $companyId = $this->request->getPost('company_debit');
         $clientId = $this->request->getPost('client_id');
        $noteType = $this->request->getPost('note_type');
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);
        //  print_r($companyId); exit;
        $companyModel = new CompanyMasterModel();
        $company = $companyModel->find($companyId);
        if($noteType==='debit'){{
            $DebitModel = new DebitNotes();
             $debitNo = $DebitModel->generateInvoiceNo('DN', '001');
        return view('common/header')
            . view('InvoiceMaster/DebitNote', ['company' => $company, 'client' => $client,'debitNo'=>$debitNo])
            . view('common/footer');};
        }else{
             $DebitModel = new DebitNotes();
             $creditNo = $DebitModel->generateInvoiceNo('CN', '001');
            return view('common/header')
                . view('InvoiceMaster/CreditNote', ['company' => $company, 'client' => $client,'creditNo'=>$creditNo])
                . view('common/footer');};
    }

   public function saveDebitNote()
{
    // print_r($this->request->getPost()); exit;
    // Load models
    $DebitModel   = new DebitNotes();
    $ExpenseModel = new ExpenseModel();

    // Collect debit note data
    $data = [
        'debit_no'                  => $this->request->getPost('debit_no'),
        'credit_no'                 => $this->request->getPost('credit_no'),
        'total_recoverable_expenses' => $this->request->getPost('expense_total'),
        'advance_amount'            => $this->request->getPost('advance_received'),
        'total_amount'              => $this->request->getPost('net_amount'),
        'client_id'                 => $this->request->getPost('client_id'),
        'company_id'                => $this->request->getPost('company_id'),
        'terms_and_conditions'      => $this->request->getPost('term_condition'),
        'date'                      => $this->request->getPost('debit_date'),
        'created_by'                => $this->request->getPost('created_by'),
        'note_type'                 => $this->request->getPost('note_type'),
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

public function saveReceipt()
{
 
$data = [
        'recipt_no'       => $this->request->getPost('recipt_no'),
        'date'            => $this->request->getPost('date'),
        'mode_of_payment' => $this->request->getPost('mode_of_payment'),
        'cheque_date'     => $this->request->getPost('cheque_date'),
        'cheque_number'   => $this->request->getPost('cheque_number'),
        'drawen_bank'     => $this->request->getPost('drawen_bank'),
        'bill_amount'     => $this->request->getPost('bill_amount'),
        'tds_amount'      => $this->request->getPost('tds_amount'),
        'invoice_id'      => $this->request->getPost('invoice_id'),
    ];

    $receiptModel = new ReciptDetailsModel();

   if ($receiptModel->insert($data)) {
     $receipt_id = $receiptModel->getInsertID();
        return $this->response->setJSON([
            'success' => true,
            'receipt_id' => $receipt_id
        ]);
    }

    return $this->response->setJSON([
        'success' => false
    ]);
}

public function getInvoiceDetails($invoice_id)
{
    $invoiceModel = new InvoiceMasterModel();
    $companyModel = new CompanyMasterModel();
    $clientModel=new ClientModel();

    // Fetch invoice by ID
    $invoice = $invoiceModel->find($invoice_id);

    if (!$invoice) {
        return $this->response->setJSON(['error' => 'Invoice not found'])->setStatusCode(404);
    }

    // Fetch the company associated with this invoice
    $company = $companyModel->find($invoice['company_id']);
    $client=$clientModel->find($invoice['client_id']);
    // print_r($company);exit;

    if (!$company) {
        return $this->response->setJSON(['error' => 'Company not found'])->setStatusCode(404);
    }

    // Return JSON with invoice + company info
    return $this->response->setJSON([
        'invoice_id'      => $invoice['id'],
        'invoice_no'      => $invoice['invoice_no'],
        'invoice_date'    => $invoice['invoice_date'],
        'company_name'    => $company['name'],
        'company_type'    => $company['type_of_company'],
        'company_address' => $company['registered_office'] ?? '',
        'company_phone'   => $company['telephone'] ?? '',
        'company_email'   => $company['email'] ?? '',
        'client_pan'     =>$client['pan'],
        'client_name'    =>$client['legal_name'],
        'client_address' =>$client['registered_office'],
    ]);
}
public function updateReceipt()
{
    $receiptModel = new ReciptDetailsModel();

    $receipt_id = $this->request->getPost('receipt_id');

    if (!$receipt_id) {
        return $this->response->setJSON(['success' => false]);
    }

    $data = [
        'recipt_no'        => $this->request->getPost('recipt_no'),
        'date'             => $this->request->getPost('date'),
        'mode_of_payment'  => $this->request->getPost('mode_of_payment'),
        'cheque_date'      => $this->request->getPost('cheque_date'),
        'cheque_number'    => $this->request->getPost('cheque_number'),
        'drawen_bank'      => $this->request->getPost('drawen_bank'),
        'bill_amount'      => $this->request->getPost('bill_amount'),
        'tds_amount'       => $this->request->getPost('tds_amount'),
    ];

    $receiptModel->update($receipt_id, $data);

    return $this->response->setJSON(['success' => true]);
}
public function deleteReceipt($id)
{
    $receiptModel = new ReciptDetailsModel();

    $receipt = $receiptModel->find($id);

    if (!$receipt) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Receipt not found'
        ]);
    }

    $receiptModel->delete($id);

    return $this->response->setJSON([
        'success' => true
    ]);
}
public function printReceipt($receipt_id)
{
    $receiptModel = new ReciptDetailsModel();
    $invoiceModel = new InvoiceMasterModel();
    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    $receipt = $receiptModel->find($receipt_id);
    $invoice = $invoiceModel->find($receipt['invoice_id']);
    $company = $companyModel->find($invoice['company_id']);
    $client  = $clientModel->find($invoice['client_id']);

    return view('InvoiceMaster/receipt', [
        'receipt' => $receipt,
        'invoice' => $invoice,
        'company' => $company,
        'client'  => $client
    ]);
}

public function receiptPdf($receipt_id)
{
    $receiptModel = new ReciptDetailsModel();
    $invoiceModel = new InvoiceMasterModel();
    $companyModel = new CompanyMasterModel();
    $clientModel  = new ClientModel();

    // Fetch data
    $receipt = $receiptModel->find($receipt_id);
    if (!$receipt) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Receipt not found');
    }

    $invoice = $invoiceModel->find($receipt['invoice_id']);
    $company = $companyModel->find($invoice['company_id']);
    $client  = $clientModel->find($invoice['client_id']);

    // Load HTML view
    $html = view('InvoiceMaster/receipt', [
        'receipt' => $receipt,
        'invoice' => $invoice,
        'company' => $company,
        'client'  => $client
    ]);

    // Dompdf options
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Download PDF
    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader(
            'Content-Disposition',
            'attachment; filename="Receipt_' . $receipt['recipt_no'] . '.pdf"'
        )
        ->setBody($dompdf->output());
}

public function debitlist($id)
{
    // Load models
    $clientModel  = new ClientModel();
    $debitModel   = new DebitNotes();

    // Get client
    $client = $clientModel->find($id);

    if (!$client) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Client not found');
    }

    // Get debit notes for this client
    $debits = $debitModel
    ->select('debits.*, client_master.legal_name, company_master.name AS company_name')
    ->join('client_master', 'client_master.id = debits.client_id')
    ->join('company_master', 'company_master.id = debits.company_id')
    ->where('client_id',$id)
    ->findAll();


    return view('common/header')
        . view('InvoiceMaster/debit-note-listing', [
            'client'  => $client,
            'debits'  => $debits,
        ])
        . view('common/footer');
}

public function debitDelete($id)
{
     $debitModel = new DebitNotes();
     $debitModel->delete($id);

        return redirect()->to('DebitNoteList/1')->with('success', 'Debit deleted successfully');
}

public function debitEdit($id)
{
    // print_r($id);exit;
    $debitModel   = new DebitNotes();
        $companyModel = new CompanyMasterModel();
        $clientModel  = new ClientModel();
        $expenseModel = new ExpenseModel();

        $debitNote = $debitModel->find($id);

        $data = [
            'debitNote' => $debitNote,
            'company'   => $companyModel->find($debitNote['company_id']),
            'client'    => $clientModel->find($debitNote['client_id']),
            'expenses'  => $expenseModel->where('debit_id', $id)->findAll(),
        ];

        return view('common/header').view('InvoiceMaster/edit_debit_note', $data).view('common/footer');

}
 public function debitUpdate($id)
{
    // print_r($this->request->getPost());exit;
    $DebitModel   = new DebitNotes();
    $ExpenseModel = new ExpenseModel();

    // Collect debit note data (same as save)
    $data = [
        'debit_no'                  => $this->request->getPost('debit_no'),
        'total_recoverable_expenses'=> $this->request->getPost('expense_total'),
        'advance_amount'            => $this->request->getPost('advance_received'),
        'total_amount'              => $this->request->getPost('net_amount'),
        'client_id'                 => $this->request->getPost('client_id'),
        'company_id'                => $this->request->getPost('company_id'),
        'terms_and_conditions'      => $this->request->getPost('term_condition'),
    ];

    // 1️⃣ Update debit note
    $DebitModel->update($id, $data);

    // 2️⃣ Expenses update / insert
    $descriptions = $this->request->getPost('expense_description');
    $amounts      = $this->request->getPost('expense_amount');
    $expenseIds   = $this->request->getPost('expense_id');

    foreach ($descriptions as $i => $desc) {

        if (empty($desc) || empty($amounts[$i])) {
            continue;
        }

        $expenseData = [
            'expense_description' => $desc,
            'expense_amount'      => $amounts[$i],
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        // ✅ Update existing expense
        if (!empty($expenseIds[$i])) {

            $ExpenseModel->update($expenseIds[$i], $expenseData);

        }
        // ✅ Insert new expense
        else {

            $expenseData['debit_id']   = $id;
            $expenseData['created_at'] = date('Y-m-d H:i:s');

            $ExpenseModel->insert($expenseData);
        }
    }

    return $this->response->setJSON([
        'status'     => 'success',
        'mode'       => 'update',
        'invoice_id' => $id
    ]);
}
public function ExpenseDelete()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON(['status' => 'error']);
    }

    $data = $this->request->getJSON(true);
    $expenseId = $data['expense_id'] ?? null;

    if (!$expenseId) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid expense ID'
        ]);
    }

    $expenseModel = new ExpenseModel();

    if ($expenseModel->delete($expenseId)) {
        return $this->response->setJSON(['status' => 'success',]);
    }

    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Unable to delete'
    ]);
}
}