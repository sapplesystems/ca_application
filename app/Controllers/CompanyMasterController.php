<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyMasterModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BranchModel;

class CompanyMasterController extends BaseController
{
    protected $session;
    protected $companyModel;
    public function __construct()
    {
        $this->session      = \Config\Services::session();
        $this->companyModel = new CompanyMasterModel();   // <-- yaha object
    }
    public function index()
    {
       
          if ($this->request->getMethod() == 'POST') {
            $companyId = $this->request->getPost('companyid');
            $result=[];
            $html="";
            $companyModel = new CompanyMasterModel();
            $company = $companyModel->findCompanyById($companyId);
            $branchModel = new BranchModel();
            $branches=$branchModel->findCompanyBranches($companyId);
            
            $html ="";
 
               $html  = '<form class="cmg-form" method="POST" action="' . base_url('company-master/update') . '" enctype="multipart/form-data">';
                $html .= csrf_field();
                $html .= '<input type="hidden" name="company_id" value="' . esc($company['id']) . '">';

                $html .= '<div class="cmg-grid">';

                /* ================= Type of Company ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Type of Company <span class="cmg-required">*</span></label>
                    <select class="cmg-select" name="company_type">
                        <option value="Consultancy Master" ' . ($company['type_of_company']=='Consultancy Master'?'selected':'') . '>Consultancy Master</option>
                        <option value="Charted Account Master" ' . ($company['type_of_company']=='Charted Account Master'?'selected':'') . '>Charted Account Master</option>
                    </select>
                </div>';

                /* ================= Name ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Name <span class="cmg-required">*</span></label>
                    <input type="text" class="cmg-input" name="name" value="' . esc($company['name']) . '">
                </div>';

                /* ================= Date ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Date of Incorporation</label>
                    <input type="date" class="cmg-input" name="date_of_incorporation" value="' . esc($company['date_of_incorp']) . '">
                </div>';

                /* ================= Category ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Category</label>
                    <input type="text" class="cmg-input" name="category" value="' . esc($company['category']) . '">
                </div>';

                /* ================= Addresses ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Registered Office</label>
                    <textarea class="cmg-textarea" name="registered_office">' . esc($company['registered_office']) . '</textarea>
                </div>';

                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Head Office</label>
                    <textarea class="cmg-textarea" name="head_office">' . esc($company['head_office']) . '</textarea>
                </div>';

                /* ================= Condition ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Condition And Terms</label>
                    <textarea class="cmg-textarea" name="condition_and_terms">' . esc($company['condition_and_terms']) . '</textarea>
                </div>';

                /* ================= Contact ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Email</label>
                    <input type="email" class="cmg-input" name="email" value="' . esc($company['email']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Phone</label>
                    <input type="text" class="cmg-input" name="phone" value="' . esc($company['telephone']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Website</label>
                    <input type="text" class="cmg-input" name="website" value="' . esc($company['website']) . '">
                </div>';

                /* ================= GST ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">PAN</label>
                    <input type="text" class="cmg-input" name="pan" value="' . esc($company['pan']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">GSTIN</label>
                    <input type="text" class="cmg-input" name="gstin" value="' . esc($company['gstin']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">IEC</label>
                    <input type="text" class="cmg-input" name="iec" value="' . esc($company['iec']) . '">
                </div>';

                /* ================= Branches ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                <label class="cmg-label">Branches</label>
                <div class="cmg-branches"><div id="branchesList">';

                if (!empty($branches)) {
                    foreach ($branches as $b) {
                        $html .= '<div class="cmg-branches__item">
                        <div class="cmg-branches__item-main">
                            <input type="text" class="cmg-input" name="branches[_i_][name]" value="'.esc($b['name']).'" placeholder="Branch name">
                            <input type="text" class="cmg-input" name="branches[_i_][phone]" value="'.esc($b['phone']).'" placeholder="Phone">
                            <input type="email" class="cmg-input" name="branches[_i_][email]" value="'.esc($b['email']).'" placeholder="Email">
                            <textarea class="cmg-input" name="branches[_i_][address]" placeholder="Address">'.esc($b['address']).'</textarea>
                        </div>
                        <div class="cmg-branches__item-actions">
                            <button type="button" class="cmg-btn cmg-btn--tiny cmg-btn--danger btn-branch-delete">Delete</button>
                        </div>
                        </div>';
                    }
                }

                $html .= '</div></div></div>';

                /* ================= Business ================= */
                $html .= '<div class="form-row-full">
                <label>Nature of Business</label>
                <textarea name="nature_of_business" class="textarea">'.esc($company['nature_of_business']).'</textarea>
                </div>';

                $html .= '<div>
                <label>Nature of Service</label>
                <textarea name="nature_of_service" class="textarea">'.esc($company['nature_of_service']).'</textarea>
                </div>';

                $html .= '<div>
                <label>Nature of Product</label>
                <textarea name="nature_of_product" class="textarea">'.esc($company['nature_of_product']).'</textarea>
                </div>';

                $html .= '</div>';

                /* ================= Footer ================= */
                $html .= '<div class="cmg-footer">
                <button type="submit" class="cmg-btn cmg-btn--primary">Update Company</button>
                </div>';

                $html .= '</form>';

  

                if(!empty($html))
                {
                     $result = [
                        "status" => True,
                        "html"  =>$html,
                        "msg"=>"data updated successfully"
                    ]; 
                } else {
                    $result = [
                        "status" => false,
                        "html"  =>""
                    ]; 
                }    
                echo json_encode($result);   
        }else{
            $companies = $this->companyModel
                        ->orderBy('id', 'DESC')
                        ->findAll();   // ya where('status','active') agar sirf active chahiye

    $data = [
        'companies' => $companies,
    ];
   
        echo view('common/header');
        echo view('CompanyMaster/CompanyMaster_list',$data);
        echo view('common/footer');
        }
          
    }
    public function store()
    {
        $request = $this->request;

        // 1️⃣ Branches data (ANOTHER TABLE)
        $branches = $request->getPost('branches'); 

        // 2️⃣ Company data (MAIN TABLE)
        $data = [
            'type_of_company'   => $request->getPost('company_type'),
            'name'              => $request->getPost('name'),
            'date_of_incorp'    => $request->getPost('date_of_incorporation'),
            'category'          => $request->getPost('category'),
            'registered_office' => $request->getPost('registered_office'),
            'head_office'       => $request->getPost('head_office'),
            'email'             => $request->getPost('email'),
            'telephone'         => $request->getPost('phone'),
            'website'           => $request->getPost('website'),
            'invoice_format'    => $request->getPost('invoice_format'),
            'pan'               => $request->getPost('pan'),
            'gstin'             => $request->getPost('gstin'),
            'iec'               => $request->getPost('iec'),
            'sister_concerns'   => $request->getPost('sister_concerns'),
            'bank_ac_no'        => $request->getPost('bank_account'),
            'status'            => $request->getPost('status'),
            'nature_of_business'  => $request->getPost('nature_of_business'),
            'nature_of_service'   => $request->getPost('nature_of_service'),
            'nature_of_product'   => $request->getPost('nature_of_product'),
            'condition_and_terms' => $request->getPost('condition_and_terms'),
        ];

        // 3️⃣ Logo upload (optional)
        $logoFile = $request->getFile('logo');
        if ($logoFile && $logoFile->isValid() && ! $logoFile->hasMoved()) {
            $newName = $logoFile->getRandomName();
            $logoFile->move(WRITEPATH . 'uploads/company_logo', $newName);
            $data['logo'] = $newName;
        }

        // 4️⃣ Insert company
        $this->companyModel->insert($data);
        $companyId = $this->companyModel->getInsertID(); // VERY IMPORTANT

        // 5️⃣ Save branches in ANOTHER TABLE
        if (!empty($branches)) {
            $branchModel = new \App\Models\BranchModel();

            $branchData = [];

            foreach ($branches as $branch) {

                // skip empty branch rows
                if (empty($branch['name'])) {
                    continue;
                }

                $branchData[] = [
                    'company_id' => $companyId,
                    'name'       => $branch['name'],
                    'phone'      => $branch['phone'] ?? null,
                    'email'      => $branch['email'] ?? null,
                    'address'    => $branch['address'] ?? null,
                ];
            }
            
            if (!empty($branchData)) {
                $branchModel->insertBatch($branchData);
            }
        }

        return redirect()->to(base_url('company_master'))
                        ->with('success', 'Company created successfully.');
    }

   public function update()
{
    $request = $this->request;

    $companyId = $request->getPost('company_id');
    if (!$companyId) {
        return redirect()->back()->with('error', 'Invalid Company');
    }

    /* =======================
        1️⃣ COMPANY DATA
    ======================== */
    $data = [
         'type_of_company'   => $request->getPost('company_type'),
        'name'                 => $request->getPost('name'),
        'date_of_incorp'       => $request->getPost('date_of_incorporation'),
        'category'             => $request->getPost('category'),
        'registered_office'    => $request->getPost('registered_office'),
        'head_office'          => $request->getPost('head_office'),
        'email'                => $request->getPost('email'),
        'telephone'            => $request->getPost('phone'),
        'website'              => $request->getPost('website'),
        'invoice_format'       => $request->getPost('invoice_format'),
        'pan'                  => $request->getPost('pan'),
        'gstin'                => $request->getPost('gstin'),
        'iec'                  => $request->getPost('iec'),
        'sister_concerns'      => $request->getPost('sister_concerns'),
        'bank_ac_no'           => $request->getPost('bank_account'),
        'status'               => $request->getPost('status'),
        'nature_of_business'   => $request->getPost('nature_of_business'),
        'nature_of_service'    => $request->getPost('nature_of_service'),
        'nature_of_product'    => $request->getPost('nature_of_product'),
        'condition_and_terms'  => $request->getPost('condition_and_terms'),
    ];

    /* =======================
        2️⃣ LOGO UPDATE (OPTIONAL)
    ======================== */
    $logoFile = $request->getFile('logo');
    if ($logoFile && $logoFile->isValid() && ! $logoFile->hasMoved()) {
        $newName = $logoFile->getRandomName();
        $logoFile->move(WRITEPATH . 'uploads/company_logo', $newName);
        $data['logo'] = $newName;
    }

    /* =======================
        3️⃣ UPDATE COMPANY
    ======================== */
    $this->companyModel->update($companyId, $data);

    /* =======================
        4️⃣ UPDATE BRANCHES
    ======================== */
    $branches = $request->getPost('branches');
    $branchModel = new \App\Models\BranchModel();

    // ❗ Delete old branches first
    $branchModel->where('company_id', $companyId)->delete();

    if (!empty($branches)) {

        $branchData = [];

        foreach ($branches as $branch) {

            // Skip empty rows
            if (empty($branch['name'])) {
                continue;
            }

            $branchData[] = [
                'company_id' => $companyId,
                'name'       => $branch['name'],
                'phone'      => $branch['phone'] ?? null,
                'email'      => $branch['email'] ?? null,
                'address'    => $branch['address'] ?? null,
            ];
        }

        if (!empty($branchData)) {
            $branchModel->insertBatch($branchData);
        }
    }

    /* =======================
        5️⃣ REDIRECT
    ======================== */
    return redirect()
        ->to(base_url('company_master'))
        ->with('success', 'Company updated successfully');
}

     public function show()
{
    // Make sure it's a POST request (recommended for AJAX)
    if ($this->request->getMethod() === 'POST') {
        $companyId = (int) $this->request->getPost('companyid'); // match your AJAX key

        if (!$companyId) {
            return $this->response->setJSON([
                'status' => false,
                'html' => '',
                'message' => 'Company ID missing'
            ]);
        }

        $companyModel = new CompanyMasterModel();
        $company = $companyModel->find($companyId);
                    $branchModel = new BranchModel();
            $branches=$branchModel->findCompanyBranches($companyId);
            
            $html ="";
 
               $html  = '<form class="cmg-form" method="POST" action="' . base_url('company-master/update') . '" enctype="multipart/form-data">';
                $html .= csrf_field();
                $html .= '<input type="hidden" name="company_id" value="' . esc($company['id']) . '">';

                $html .= '<div class="cmg-grid">';

                /* ================= Type of Company ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Type of Company <span class="cmg-required">*</span></label>
                    <select class="cmg-select" name="company_type">
                        <option value="Consultancy Master" ' . ($company['type_of_company']=='Consultancy Master'?'selected':'') . '>Consultancy Master</option>
                        <option value="Charted Account Master" ' . ($company['type_of_company']=='Charted Account Master'?'selected':'') . '>Charted Account Master</option>
                    </select>
                </div>';

                /* ================= Name ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Name <span class="cmg-required">*</span></label>
                    <input type="text" class="cmg-input" name="name" value="' . esc($company['name']) . '">
                </div>';

                /* ================= Date ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Date of Incorporation</label>
                    <input type="date" class="cmg-input" name="date_of_incorporation" value="' . esc($company['date_of_incorp']) . '">
                </div>';

                /* ================= Category ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Category</label>
                    <input type="text" class="cmg-input" name="category" value="' . esc($company['category']) . '">
                </div>';

                /* ================= Addresses ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Registered Office</label>
                    <textarea class="cmg-textarea" name="registered_office">' . esc($company['registered_office']) . '</textarea>
                </div>';

                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Head Office</label>
                    <textarea class="cmg-textarea" name="head_office">' . esc($company['head_office']) . '</textarea>
                </div>';

                /* ================= Condition ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Condition And Terms</label>
                    <textarea class="cmg-textarea" name="condition_and_terms">' . esc($company['condition_and_terms']) . '</textarea>
                </div>';

                /* ================= Contact ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Email</label>
                    <input type="email" class="cmg-input" name="email" value="' . esc($company['email']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Phone</label>
                    <input type="text" class="cmg-input" name="phone" value="' . esc($company['telephone']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Website</label>
                    <input type="text" class="cmg-input" name="website" value="' . esc($company['website']) . '">
                </div>';

                /* ================= GST ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">PAN</label>
                    <input type="text" class="cmg-input" name="pan" value="' . esc($company['pan']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">GSTIN</label>
                    <input type="text" class="cmg-input" name="gstin" value="' . esc($company['gstin']) . '">
                </div>';

                $html .= '<div class="cmg-field">
                    <label class="cmg-label">IEC</label>
                    <input type="text" class="cmg-input" name="iec" value="' . esc($company['iec']) . '">
                </div>';

                /* ================= Branches ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                <label class="cmg-label">Branches</label>
                <div class="cmg-branches"><div id="branchesList">';

                if (!empty($branches)) {
                    foreach ($branches as $b) {
                        $html .= '<div class="cmg-branches__item">
                        <div class="cmg-branches__item-main">
                            <input type="text" class="cmg-input" name="branches[_i_][name]" value="'.esc($b['name']).'" placeholder="Branch name">
                            <input type="text" class="cmg-input" name="branches[_i_][phone]" value="'.esc($b['phone']).'" placeholder="Phone">
                            <input type="email" class="cmg-input" name="branches[_i_][email]" value="'.esc($b['email']).'" placeholder="Email">
                            <textarea class="cmg-input" name="branches[_i_][address]" placeholder="Address">'.esc($b['address']).'</textarea>
                        </div>
                        <div class="cmg-branches__item-actions">
                            <button type="button" class="cmg-btn cmg-btn--tiny cmg-btn--danger btn-branch-delete">Delete</button>
                        </div>
                        </div>';
                    }
                }

                $html .= '</div></div></div>';

                /* ================= Business ================= */
                $html .= '<div class="form-row-full">
                <label>Nature of Business</label>
                <textarea name="nature_of_business" class="textarea">'.esc($company['nature_of_business']).'</textarea>
                </div>';

                $html .= '<div>
                <label>Nature of Service</label>
                <textarea name="nature_of_service" class="textarea">'.esc($company['nature_of_service']).'</textarea>
                </div>';

                $html .= '<div>
                <label>Nature of Product</label>
                <textarea name="nature_of_product" class="textarea">'.esc($company['nature_of_product']).'</textarea>
                </div>';

                $html .= '</div>';

                $html .= '</form>'; // standard CI4 find

        if (!$company) {
            return $this->response->setJSON([
                'status' => false,
                'html' => '',
                'message' => 'Company not found'
            ]);
        }




        // Return JSON
        return $this->response->setJSON([
            'status' => true,
            'html' => $html
        ]);
    }

    // Invalid request method
    return $this->response->setJSON([
        'status' => false,
        'html' => '',
        'message' => 'Invalid request'
    ]);
}


}