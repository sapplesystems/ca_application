<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientModel;

class ClientMasterController extends BaseController
{
    public function index()
    {
       
        if ($this->request->getMethod() == 'POST') {
            $clientId = $this->request->getPost('clientid');
            $result=[];
            $html="";
             $clientModel = new ClientModel();
             $client = $clientModel->findClientById($clientId);
             $html ="";
             
                $html .= '<form method="post" id="editClientForm" action="' . base_url('clients/update') . '" enctype="multipart/form-data">';
                $html .= '<input type="hidden" name="client_id" value="' . $client['id'] . '">';

                $html .= '<div class="clientm"><div class="form-grid">';
            
                $html .= '<div class="form-row-full"><div class="input-group">';
                $html .= '<div style="flex:0 0 28%;"><label>CIN No</label>';
                $html .= '<input type="text" name="cin_no" class="input" value="' . $client['cin_no'] . '"></div>';

                $html .= '<div style="flex:1;"><label>Name (Legal) <span class="req">*</span></label>';
                $html .= '<input type="text" name="legal_name" class="input" value="' . $client['legal_name'] . '" required></div>';

                $html .= '<div style="flex:0 0 28%;"><label>Trade Name (Alias)</label>';
                $html .= '<input type="text" name="trade_name" class="input" value="' . $client['trade_name'] . '"></div>';

                $html .= '</div></div>';

                // ROC / Registration
                $html .= '<div><label>ROC Code</label>';
                $html .= '<input type="text" name="roc_code" class="input" value="' . $client['roc_code'] . '"></div>';

                $html .= '<div><label>Registration No</label>';
                $html .= '<input type="text" name="registration_no" class="input" value="' . $client['registration_no'] . '"></div>';

                // Date / Certificate
                $html .= '<div><label>Date of Incorporation</label>';
                $html .= '<input type="date" name="date_of_incorporation" class="input" value="' . $client['date_of_incorporation'] . '"></div>';

                $html .= '<div><label>Certificate of Incorporation</label><div class="file-input">';
                $html .= '<label class="btn-upload">Upload Certificate<input type="file" name="coi"></label>';

                if (!empty($client['coi_file'])) {
                    $html .= '<small>Current file: <a href="' . base_url('writable/uploads/' . $client['coi_file']) . '" target="_blank">' . $client['coi_file'] . '</a></small>';
                }

                $html .= '</div></div>';

                // Company Category / Subcategory
                $html .= '<div><label>Company Category</label><select name="company_category" class="select">';
                $html .= '<option value="">Select category</option>';
                $html .= '<option value="Category1"' . ($client['company_category'] == 'Category1' ? ' selected' : '') . '>Category1</option>';
                $html .= '<option value="Category2"' . ($client['company_category'] == 'Category2' ? ' selected' : '') . '>Category2</option>';
                $html .= '</select></div>';

                $html .= '<div><label>Company Sub-Category</label><select name="company_sub_category" class="select">';
                $html .= '<option value="">Select sub-category</option>';
                $html .= '<option value="Sub1"' . ($client['company_sub_category'] == 'Sub1' ? ' selected' : '') . '>Sub1</option>';
                $html .= '<option value="Sub2"' . ($client['company_sub_category'] == 'Sub2' ? ' selected' : '') . '>Sub2</option>';
                $html .= '</select></div>';

                // Registered / Corporate Office
                $html .= '<div class="form-row-full"><label>Registered Office</label>';
                $html .= '<textarea name="registered_office" class="textarea">' . $client['registered_office'] . '</textarea></div>';

                $html .= '<div class="form-row-full"><label>Corporate Office</label>';
                $html .= '<textarea name="corporate_office" class="textarea">' . $client['corporate_office'] . '</textarea></div>';

                // Contact info
                $html .= '<div><label>Tel No</label><input type="text" name="telephone" class="input" value="' . $client['telephone'] . '"></div>';
                $html .= '<div><label>Fax No</label><input type="text" name="fax" class="input" value="' . $client['fax'] . '"></div>';
                $html .= '<div class="form-row-full"><label>Website</label><input type="text" name="website" class="input" value="' . $client['website'] . '"></div>';
                // Share capital
                $html .= '<div><label>Authorised Share Capital</label><input type="text" name="authorised_share_capital" class="input" value="' . $client['authorised_share_capital'] . '"></div>';
                $html .= '<div><label>Number of Shares</label><input type="number" name="number_of_shares" class="input" value="' . $client['number_of_shares'] . '"></div>';
                $html .= '<div><label>Face Value</label><input type="text" name="face_value" class="input" value="' . $client['face_value'] . '"></div>';
                $html .= '<div><label>Paid-up Share Capital</label><input type="text" name="paid_up_share_capital" class="input" value="' . $client['paid_up_share_capital'] . '"></div>';

                // PAN / GST / ESI
                $html .= '<div><label>PAN</label><input type="text" name="pan" class="input" value="' . $client['pan'] . '"></div>';
                $html .= '<div><label>GSTIN</label><input type="text" name="gstin" class="input" value="' . $client['gstin'] . '"></div>';
                $html .= '<div><label>ESI Number</label><input type="text" name="esi_no" class="input" value="' . $client['esi_no'] . '"></div>';
                $html .= '<div><label>GST State</label><input type="text" name="gst_state" class="input" value="' . $client['gst_state'] . '"></div>';
                // IEC / Bank
                $html .= '<div><label>Export & Import Code</label><input type="text" name="iec_code" class="input" value="' . $client['iec_code'] . '"></div>';
                $html .= '<div class="form-row-full"><label>Bank Account Number</label><input type="text" name="bank_account_no" class="input" value="' . $client['bank_account_no'] . '"></div>';

                // Directors
                $html .= '<div><label>Number of Directors / Shareholders</label><input type="number" name="directors_count" class="input" value="' . $client['directors_count'] . '"></div>';
                $html .= '<div class="form-row-full"><label>Name of Subsidiary / Sister Concern</label><input type="text" name="subsidiary_names" class="input" value="' . $client['subsidiary_names'] . '"></div>';

                // Business
                $html .= '<div class="form-row-full"><label>Nature of Business</label><textarea name="nature_of_business" class="textarea">' . $client['nature_of_business'] . '</textarea></div>';
                $html .= '<div><label>Nature of Service</label><textarea name="nature_of_service" class="textarea">' . $client['nature_of_service'] . '</textarea></div>';
                $html .= '<div><label>Nature of Product</label><textarea name="nature_of_product" class="textarea">' . $client['nature_of_product'] . '</textarea></div>';

                // Billing
                $html .= '<div class="form-row-full"><label>Billing Emails</label><input type="email" name="billing_emails" class="input" value="' . $client['billing_emails'] . '"></div>';
                $html .= '<div><label>Payment Terms</label><select name="payment_terms" class="select">';
                $html .= '<option value="">Select terms</option>';
                $html .= '<option value="Net 7"' . ($client['payment_terms'] == 'Net 7' ? ' selected' : '') . '>Net 7</option>';
                $html .= '<option value="Net 15"' . ($client['payment_terms'] == 'Net 15' ? ' selected' : '') . '>Net 15</option>';
                $html .= '<option value="Net 30"' . ($client['payment_terms'] == 'Net 30' ? ' selected' : '') . '>Net 30</option>';
                $html .= '</select></div>';

                
                $html .= '<div class="form-row-full" style="text-align:right; margin-top:20px;">';
                $html .= '<button type="submit" class="btn btn-primary">Update Client</button>';
                $html .= '</div>';
                $html .= '</div></div>';
                $html .= '</form>';
                if(!empty($html))
                {
                     $result = [
                        "status" => True,
                        "html"  =>$html
                    ]; 
                } else {
                    $result = [
                        "status" => false,
                        "html"  =>""
                    ]; 
                }    
                echo json_encode($result);   
        }
        else{
            $clientModel = new ClientModel();

            // Fetch data (all clients)
            $clients = $clientModel->findAll();

            // Prepare data array to send to the view
            $data = [
                'clients' => $clients
            ];
            echo view('common/header');
            echo view('ClientMaster/ClientMaster_list', $data); 
            echo view('common/footer');
        }
    }

    public function store()
    {
        $clientModel = new ClientModel();

        // Handle file upload
        $coiFile = $this->request->getFile('coi');
        $fileName = null;

        if ($coiFile && $coiFile->isValid()) {
            $fileName = $coiFile->getRandomName();
            $coiFile->move(WRITEPATH . 'uploads', $fileName);
        }

        $data = [
            'cin_no'                   => $this->request->getPost('cin_no'),
            'legal_name'               => $this->request->getPost('legal_name'),
            'trade_name'               => $this->request->getPost('trade_name'),
            'roc_code'                 => $this->request->getPost('roc_code'),
            'registration_no'          => $this->request->getPost('registration_no'),
            'date_of_incorporation'    => $this->request->getPost('date_of_incorporation'),
            'coi_file'                 => $fileName,
            'company_category'         => $this->request->getPost('company_category'),
            'company_sub_category'     => $this->request->getPost('company_sub_category'),
            'registered_office'        => $this->request->getPost('registered_office'),
            'corporate_office'         => $this->request->getPost('corporate_office'),
            'telephone'                => $this->request->getPost('telephone'),
            'fax'                      => $this->request->getPost('fax'),
            'website'                  => $this->request->getPost('website'),
            'authorised_share_capital' => $this->request->getPost('authorised_share_capital'),
            'number_of_shares'         => $this->request->getPost('number_of_shares'),
            'pan'                      => $this->request->getPost('pan'),
            'gstin'                    => $this->request->getPost('gstin'),
            'esi_no'                   => $this->request->getPost('esi_no'),
            'iec_code'                 => $this->request->getPost('iec_code'),
            'face_value'               => $this->request->getPost('face_value'),
            'paid_up_share_capital'    => $this->request->getPost('paid_up_share_capital'),
            'bank_account_no'          => $this->request->getPost('bank_account_no'),
            'directors_count'          => $this->request->getPost('directors_count'),
            'subsidiary_names'         => $this->request->getPost('subsidiary_names'),
            'nature_of_business'       => $this->request->getPost('nature_of_business'),
            'nature_of_service'        =>$this->request->getPost('nature_of_service'),
            'nature_of_product'        =>$this->request->getPost('nature_of_product'),
            'billing_emails'           => $this->request->getPost('billing_emails'),
            'payment_terms'            => $this->request->getPost('payment_terms'),
            'gst_state'               => $this->request->getPost('gst_state'),
        ];

        $result = $clientModel->insert($data);
       if($result){
            return redirect()->back()->with('success', 'Client added successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add client');
        }
    }

    // Handle form submission
    public function update()
    {
        $clientModel = new ClientModel();

        // Get client ID from hidden input
        $id = (int) $this->request->getPost('client_id');
        if (!$id) {
            return redirect()->to('/Client_Master')->with('error', 'Id not found');
        }
        $client = $clientModel->find($id);
        
        if (!$client) {
            return redirect()->to('/Client_Master')->with('error', 'Client not found');
        }

        // Handle file upload (Certificate of Incorporation)
        $coiFile = $this->request->getFile('coi');
        $fileName = $client['coi_file']; // Keep old file by default

        if ($coiFile && $coiFile->isValid()) {
            // Delete old file if exists
            if ($fileName && file_exists(WRITEPATH . 'uploads/' . $fileName)) {
                unlink(WRITEPATH . 'uploads/' . $fileName);
            }
            $fileName = $coiFile->getRandomName();
            $coiFile->move(WRITEPATH . 'uploads', $fileName);
        }

        // Prepare updated data
        $data = [
            'cin_no'                   => $this->request->getPost('cin_no'),
            'legal_name'               => $this->request->getPost('legal_name'),
            'trade_name'               => $this->request->getPost('trade_name'),
            'roc_code'                 => $this->request->getPost('roc_code'),
            'registration_no'          => $this->request->getPost('registration_no'),
            'date_of_incorporation'    => $this->request->getPost('date_of_incorporation'),
            'coi_file'                 => $fileName,
            'company_category'         => $this->request->getPost('company_category'),
            'company_sub_category'     => $this->request->getPost('company_sub_category'),
            'registered_office'        => $this->request->getPost('registered_office'),
            'corporate_office'         => $this->request->getPost('corporate_office'),
            'telephone'                => $this->request->getPost('telephone'),
            'fax'                      => $this->request->getPost('fax'),
            'website'                  => $this->request->getPost('website'),
            'authorised_share_capital' => $this->request->getPost('authorised_share_capital'),
            'number_of_shares'         => $this->request->getPost('number_of_shares'),
            'face_value'               => $this->request->getPost('face_value'),
            'paid_up_share_capital'    => $this->request->getPost('paid_up_share_capital'),
            'pan'                      => $this->request->getPost('pan'),
            'gstin'                    => $this->request->getPost('gstin'),
            'esi_no'                   => $this->request->getPost('esi_no'),
            'iec_code'                 => $this->request->getPost('iec_code'),
            'bank_account_no'          => $this->request->getPost('bank_account_no'),
            'directors_count'          => $this->request->getPost('directors_count'),
            'subsidiary_names'         => $this->request->getPost('subsidiary_names'),
            'nature_of_business'       => $this->request->getPost('nature_of_business'),
            'nature_of_service'        => $this->request->getPost('nature_of_service'),
            'nature_of_product'        => $this->request->getPost('nature_of_product'),
            'billing_emails'           => $this->request->getPost('billing_emails'),
            'payment_terms'            => $this->request->getPost('payment_terms'),
            'gst_state'               => $this->request->getPost('gst_state'),
        ];

        // Update the client
        $result = $clientModel->update($id, $data);

if ($result) {
            return redirect()->to('/Client_Master')->with('success', 'Client updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update client');
        }
    }


   public function show()
{
    // Make sure it's a POST request (recommended for AJAX)
    if ($this->request->getMethod() === 'POST') {
        $clientId = (int) $this->request->getPost('client_id'); // match your AJAX key

        if (!$clientId) {
            return $this->response->setJSON([
                'status' => false,
                'html' => '',
                'message' => 'Client ID missing'
            ]);
        }

        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId); // standard CI4 find

        if (!$client) {
            return $this->response->setJSON([
                'status' => false,
                'html' => '',
                'message' => 'Client not found'
            ]);
        }


$html  = '<div class="clientm">';
$html .= '<div class="form-grid">';

// CIN / Legal / Trade
$html .= '<div class="form-row-full">';
$html .= '  <div class="input-group">';

$html .= '    <div style="flex:0 0 28%;">';
$html .= '      <label>CIN No</label>';
$html .= '      <input type="text" class="input" value="'.esc($client['cin_no'] ?? '').'" disabled>';
$html .= '    </div>';

$html .= '    <div style="flex:1">';
$html .= '      <label>Name (Legal)</label>';
$html .= '      <input type="text" class="input" value="'.esc($client['legal_name'] ?? '').'" disabled>';
$html .= '    </div>';

$html .= '    <div style="flex:0 0 28%;">';
$html .= '      <label>Trade Name (Alias)</label>';
$html .= '      <input type="text" class="input" value="'.esc($client['trade_name'] ?? '').'" disabled>';
$html .= '    </div>';

$html .= '  </div>';
$html .= '</div>';

// ROC / Reg No
$html .= '<div>';
$html .= '  <label>ROC Code</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['roc_code'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Registration No</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['registration_no'] ?? '').'" disabled>';
$html .= '</div>';

// Date / COI
$html .= '<div>';
$html .= '  <label>Date of Incorporation</label>';
$html .= '  <input type="date" class="input" value="'.esc($client['date_of_incorporation'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Certificate of Incorporation</label>';
$html .= '  <div class="file-input">';
$html .= '    <span class="input" style="padding:8px;">'.esc($client['coi_file'] ?? 'No file').'</span>';
$html .= '  </div>';
$html .= '</div>';

// Category
$html .= '<div>';
$html .= '  <label>Company Category</label>';
$html .= '  <input type="text" class="input select" value="'.esc($client['company_category'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Company Sub-Category</label>';
$html .= '  <input type="text" class="input select" value="'.esc($client['company_sub_category'] ?? '').'" disabled>';
$html .= '</div>';

// Registered / Corporate office
$html .= '<div class="form-row-full">';
$html .= '  <label>Registered Office</label>';
$html .= '  <textarea class="textarea" disabled>'.esc($client['registered_office'] ?? '').'</textarea>';
$html .= '</div>';

$html .= '<div class="form-row-full">';
$html .= '  <label>Corporate Office</label>';
$html .= '  <textarea class="textarea" disabled>'.esc($client['corporate_office'] ?? '').'</textarea>';
$html .= '</div>';

// Contact
$html .= '<div>';
$html .= '  <label>Tel No</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['telephone'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Fax No</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['fax'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div class="form-row-full">';
$html .= '  <label>Website</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['website'] ?? '').'" disabled>';
$html .= '</div>';

// Share capital
$html .= '<div>';
$html .= '  <label>Authorised Share Capital</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['authorised_share_capital'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Number of Shares</label>';
$html .= '  <input type="number" class="input" value="'.esc($client['number_of_shares'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Face Value</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['face_value'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Paid-up Share Capital</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['paid_up_share_capital'] ?? '').'" disabled>';
$html .= '</div>';

// PAN / GST / ESI
$html .= '<div>';
$html .= '  <label>PAN</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['pan'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>GSTIN</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['gstin'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>ESI Number</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['esi_no'] ?? '').'" disabled>';
$html .= '</div>';

// IEC / Bank
$html .= '<div>';
$html .= '  <label>Export & Import Code</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['iec_code'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div class="form-row-full">';
$html .= '  <label>Bank Account Number</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['bank_account_no'] ?? '').'" disabled>';
$html .= '</div>';

// Directors
$html .= '<div>';
$html .= '  <label>Number of Directors / Shareholders</label>';
$html .= '  <input type="number" class="input" value="'.esc($client['directors_count'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div class="form-row-full">';
$html .= '  <label>Name of Subsidiary / Sister Concern</label>';
$html .= '  <input type="text" class="input" value="'.esc($client['subsidiary_names'] ?? '').'" disabled>';
$html .= '</div>';

// Business
$html .= '<div class="form-row-full">';
$html .= '  <label>Nature of Business</label>';
$html .= '  <textarea class="textarea" disabled>'.esc($client['nature_of_business'] ?? '').'</textarea>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Nature of Service</label>';
$html .= '  <textarea class="textarea" disabled>'.esc($client['nature_of_service'] ?? '').'</textarea>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Nature of Product</label>';
$html .= '  <textarea class="textarea" disabled>'.esc($client['nature_of_product'] ?? '').'</textarea>';
$html .= '</div>';

// Billing
$html .= '<div class="form-row-full">';
$html .= '  <label>Billing Emails</label>';
$html .= '  <input type="email" class="input" value="'.esc($client['billing_emails'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '<div>';
$html .= '  <label>Payment Terms</label>';
$html .= '  <input type="text" class="input select" value="'.esc($client['payment_terms'] ?? '').'" disabled>';
$html .= '</div>';

$html .= '</div>'; // .form-grid
$html .= '</div>'; // .clientm

// yahi pe sirf ek hi return rakho:
return $this->response->setJSON([
    'status' => true,
    'html'   => $html,
]);

    }

    // Invalid request method
    return $this->response->setJSON([
        'status' => false,
        'html' => '',
        'message' => 'Invalid request'
    ]);
}
  public function updateStatus()
{
    $data = $this->request->getJSON(true);

    $status = $data['status'];   // 1 or 0
    $userId = $data['id'];

    $model = new ClientModel();
$client = $model->find($userId);
    if ($model->update($userId, ['status' => $status])) {

        $statusText = ($status == 1) ? 'Activated' : 'Deactivated';
$clientName = $client['legal_name'] ?? 'Client';
        return $this->response->setJSON([
            'status'  => true,
            'message' => "{$clientName} {$statusText} successfully"
        ]);
    }

    return $this->response->setJSON([
        'status'  => false,
        'message' => 'Failed to update status'
    ]);
}



}