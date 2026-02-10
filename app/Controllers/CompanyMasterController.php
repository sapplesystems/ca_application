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
        $this->companyModel = new CompanyMasterModel();   
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
 
            //    $html  = '<form class="cmg-form" method="POST" action="' . base_url('company-master/update') . '" enctype="multipart/form-data">';
               $html  = '<form class="cmg-form" method="POST" action="' . base_url('company-master/update') . '" enctype="multipart/form-data">';

                $html .= csrf_field();
                $html .= '<input type="hidden" name="company_id" value="' . esc($company['id']) . '">';

                $html .= '<div class="cmg-grid">';

                /* ================= Type of Company ================= */
                // $html .= '<div class="cmg-field">
                //     <label class="cmg-label">Type of Company <span class="cmg-required">*</span></label>
                //     <select class="cmg-select" name="company_type">
                //         <option value="Consultancy Master" ' . ($company['type_of_company']=='Consultancy Master'?'selected':'') . '>Consultancy Master</option>
                //         <option value="Charted Account Master" ' . ($company['type_of_company']=='Charted Account Master'?'selected':'') . '>Charted Account Master</option>
                //     </select>
                // </div>';
              $html .= '<div class="cmg-field">
    <label class="cmg-label">Type of Company <span class="cmg-required">*</span></label>
    
    <input type="text"
           class="cmg-select"
           name="company_type"
           value="' . esc($company['type_of_company']) . '"
           placeholder="Enter company type"
           required>

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
            //      /* ================= Bank Account ================= */
            // $html .= '<div class="cmg-field">
            //     <label class="cmg-label">Bank Account</label>
            //     <input type="text" class="cmg-input" name="bank_account" 
            //         value="' . esc($company['bank_ac_no']) . '" 
            //         placeholder="23456789012345">
            //     <p class="cmg-help-text">
            //         Select default bank account for this company.
            //     </p>
            // </div>';

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
                 $html .= '<div class="cmg-field">
                    <label class="cmg-label">IEC</label>
                    <input type="text" class="cmg-input" name="iec" value="' . esc($company['iec']) . '">
                </div>';
                  /* ================= Invoice Format ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Invoice Format</label>
                    <input type="text" class="cmg-input" name="invoice_format"
                        value="' . esc($company['invoice_format']) . '"
                        placeholder="e.g. ORG/BRANCH/FY/SEQ">
                    <p class="cmg-help-text">
                        Define how invoice numbers will be generated (e.g. ORG/BRANCH/FY/SEQ).
                    </p>
                </div>';
                $html .= '<div class="cmg-field cmg-field--full">
                    <label class="cmg-label">Sister Concerns</label>
                    <textarea class="cmg-textarea" name="sister_concerns" 
                        placeholder="List sister concerns, one per line">'
                        . esc($company['sister_concerns']) .
                    '</textarea>
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

                $html .='<div class="cmg-field">
                    <label class="cmg-label">GST State</label>
                    <input type="text" class="cmg-input" name="gst_state" value="' . esc($company['gst_state']) . '">
                </div>'   ;            

                /* ================= Branches ================= */
                $html .= '<div class="cmg-field cmg-field--full">
                <label class="cmg-label">Branches</label>

                <div class="cmg-branches">

                    <div class="cmg-branches__header">
                        <span>Branches</span>
                        <button type="button"
                                class="cmg-btn cmg-btn--ghost cmg-btn--small"
                                id="editBranchBtn" >
                            + Add Branch
                        </button>
                    </div>

                    <div id="branchesLists">';
                    /* ================= Branch Template (Hidden) ================= */
                    $html .= '
                    <template id="branchTemplate">
                                            <div class="cmg-branches__item">
                                                <div class="cmg-branches__item-main">

                                                    <div class="cmg-branches__row">
                                                        <div class="cmg-branches__field">
                                                            <input type="text" class="cmg-input"
                                                                name="branches[__i__][name]" placeholder="Branch name">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <input type="text" class="cmg-input"
                                                                name="branches[__i__][phone]" placeholder="Phone">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <input type="email" class="cmg-input"
                                                                name="branches[__i__][email]" placeholder="Email">
                                                        </div>

                                                        <div class="cmg-branches__field">
                                                            <textarea class="cmg-input" name="branches[__i__][address]"
                                                                placeholder="Address"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="cmg-branches__item-actions">
                                                    <button type="button"
                                                        class="cmg-btn cmg-btn--tiny cmg-btn--danger btn-branch-delete">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </template>';
                    $index = 0;

               if (!empty($branches)) {
    $index = 0;
    foreach ($branches as $b) {
        $html .= '<div class="cmg-branches__item">
            <div class="cmg-branches__item-main">
                <div class="cmg-branches__row">
                    <div class="cmg-branches__field">
                        <input type="text" class="cmg-input"
                               name="branches['.$index.'][name]"
                               value="'.esc($b['name']).'"
                               placeholder="Branch name">
                    </div>

                    <div class="cmg-branches__field">
                        <input type="text" class="cmg-input"
                               name="branches['.$index.'][phone]"
                               value="'.esc($b['phone']).'"
                               placeholder="Phone">
                    </div>

                    <div class="cmg-branches__field">
                        <input type="email" class="cmg-input"
                               name="branches['.$index.'][email]"
                               value="'.esc($b['email']).'"
                               placeholder="Email">
                    </div>

                    <div class="cmg-branches__field">
                        <textarea class="cmg-input" 
                                  name="branches['.$index.'][address]"
                                  placeholder="Address">'.esc($b['address']).'</textarea>
                    </div>
                </div>
            </div>

            <div class="cmg-branches__item-actions">
                <button type="button"
                        class="cmg-btn cmg-btn--tiny cmg-btn--danger btn-branch-delete">
                    Delete
                </button>
            </div>
        </div>';
        $index++;
    }
}
$html .= '</div></div></div>';



                    $html .= '<div class="cmg-field">
                <label class="cmg-label">Bank Account</label>
                <input type="text" class="cmg-input" name="bank_account" 
                    value="' . esc($company['bank_ac_no']) . '" 
                    placeholder="23456789012345">
                <p class="cmg-help-text">
                    Select default bank account for this company.
                </p>
            </div>';
            $html .= '<div class="cmg-field">
                <label class="cmg-label">Bank Name</label>
                <input type="text" class="cmg-input" name="bank_name" 
                    value="' . esc($company['bank_name']) . '" 
                    placeholder="Bank Name">
               
            </div>';
            $html .= '<div class="cmg-field">
                <label class="cmg-label">Bank Ifsc</label>
                <input type="text" class="cmg-input" name="bank_ifsc" 
                    value="' . esc($company['bank_ifsc']) . '" 
                    placeholder="SBIN0000001">
               
            </div>';
                /* ================= Logo Upload ================= */
                $html .= '<div class="cmg-field">
                    <label class="cmg-label">Logo Upload</label>
                    <div class="cmg-upload">
                        <label class="cmg-btn cmg-btn--primary cmg-btn--small">
                            ⬆ Upload Logo
                            <input type="file" name="logo" class="cmg-upload__input" value="' . esc($company['logo']) . '">
                        </label>
                        <span class="cmg-upload__text"><a href="' . esc($company['logo']) . '" target="_blank">
                                    ' . esc($company['logo']) . '
                                </a></span>
                    </div>
                    <p class="cmg-help-text">
                        Recommended size: 200x200px, Max file size: 2MB.
                    </p></div>
                     ';
                    

                    

                /* ================= Business ================= */
                $html .= '<div class="cmg-field ">
                <label class="cmg-label">Nature of Business</label>
                <textarea name="nature_of_business" class="cmg-textarea">'.esc($company['nature_of_business']).'</textarea>
                </div>';

                $html .= '<div class="cmg-field">
                <label class="cmg-label">Nature of Service</label>
                <textarea name="nature_of_service" class="cmg-textarea">'.esc($company['nature_of_service']).'</textarea>
                </div>';

                $html .= '<div class=" cmg-field cmg-field--full">
                <label class="cmg-label">Nature of Product</label>
                <textarea name="nature_of_product" class="cmg-textarea">'.esc($company['nature_of_product']).'</textarea>
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
                        ->findAll();   

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
        // print_r( $request->getFile('logo'));exit;
        $branches = $request->getPost('branches'); 

        // 2️⃣ 
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
            'nature_of_business'  => $request->getPost('nature_of_business'),
            'nature_of_service'   => $request->getPost('nature_of_service'),
            'nature_of_product'   => $request->getPost('nature_of_product'),
            'condition_and_terms' => $request->getPost('condition_and_terms'),
            'bank_name'      =>$request->getPost('bank_name'),
            'bank_ifsc'      =>$request->getPost('bank_ifsc'),
            'gst_state'      =>$request->getPost('gst_state'),
        ];

        // 3️⃣ Logo upload (optional)
        $logoFile = $request->getFile('logo');
        if ($logoFile && $logoFile->isValid() && ! $logoFile->hasMoved()) {
            $newName = $logoFile->getRandomName();
            $logoFile->move('uploads/company_logo', $newName);
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
    // print_r($this->request->getPost());exit;
    $request = $this->request;

    $companyId = $request->getPost('company_id');
    if (!$companyId) {
        return redirect()->back()->with('error', 'Invalid Company');
    }

    $data = [
        
'nature_of_business'   => $request->getPost('nature_of_business') ?? '',
'nature_of_service'    => $request->getPost('nature_of_service') ?? '',
'nature_of_product'    => $request->getPost('nature_of_product') ?? '',

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
        'nature_of_business'   => $request->getPost('nature_of_business'),
        'nature_of_service'    => $request->getPost('nature_of_service'),
        'nature_of_product'    => $request->getPost('nature_of_product'),
        'condition_and_terms'  => $request->getPost('condition_and_terms'),
        'bank_name'      =>$request->getPost('bank_name'),
        'bank_ifsc'      =>$request->getPost('bank_ifsc'),
        'gst_state'      =>$request->getPost('gst_state'),
    ];

    $logoFile = $request->getFile('logo');
    if ($logoFile && $logoFile->isValid() && ! $logoFile->hasMoved()) {
        $newName = $logoFile->getRandomName();
        $logoFile->move('uploads/company_logo', $newName);
        $data['logo'] = $newName;
    }

    $this->companyModel->update($companyId, $data);

    $branches = $request->getPost('branches');
    $branchModel = new \App\Models\BranchModel();

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

    return redirect()
        ->to(base_url('company_master'))
        ->with('success', 'Company updated successfully');
}



  /* =======================
        code for view 
    ======================== */

    public function show()
{
    // Make sure it's a POST request (recommended for AJAX)
    if ($this->request->getMethod() === 'POST') {
        $companyId = (int) $this->request->getPost('companyid');

        if (!$companyId) {
            return $this->response->setJSON([
                'status' => false,
                'html' => '',
                'message' => 'Company ID missing'
            ]);
        }

        $companyModel = new CompanyMasterModel();
        $company = $companyModel->find($companyId);
        
        if (!$company) {
            return $this->response->setJSON([
                'status' => false,
                'html' => '',
                'message' => 'Company not found'
            ]);
        }

        $branchModel = new BranchModel();
        $branches = $branchModel->findCompanyBranches($companyId);
        
        $html = '<form class="cmg-form" method="POST" action="' . base_url('company-master/update') . '" enctype="multipart/form-data">';
        $html .= csrf_field();
        $html .= '<input type="hidden" name="company_id" value="' . esc($company['id']) . '">';
        $html .= '<div class="cmg-grid">';

        /* ================= Type of Company ================= */
    //     $html .= '<div class="cmg-field">
    //         <label class="cmg-label">Type of Company <span class="cmg-required">*</span></label>
    //         <select class="cmg-select" name="company_type">
    //             <option value="Consultancy Master" ' . ($company['type_of_company']=='Consultancy Master'?'selected':'') . '>Consultancy Master</option>
    //             <option value="Charted Account Master" ' . ($company['type_of_company']=='Charted Account Master'?'selected':'') . '>Charted Account Master</option>
    //   </select>
    //     </div>';
    $html .= '<div class="cmg-field">
    <label class="cmg-label">Type of Company <span class="cmg-required">*</span></label>
    
    <input type="text"
           class="cmg-select"
           value="' . esc($company['type_of_company']) . '"
           disabled>

    <input type="hidden"
           name="company_type"
           value="' . esc($company['type_of_company']) . '">

</div>';


        /* ================= Name ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Name <span class="cmg-required">*</span></label>
            <input type="text" class="cmg-input" name="name" value="' . esc($company['name']) . '" disabled>
        </div>';

        /* ================= Date ================= */
        $html .= '<div class="cmg-field">
            <label class="cmg-label">Date of Incorporation</label>
            <input type="date" class="cmg-input" name="date_of_incorporation" value="' . esc($company['date_of_incorp']) . '" disabled>
        </div>';

        /* ================= Category ================= */
        $html .= '<div class="cmg-field">
            <label class="cmg-label">Category</label>
            <input type="text" class="cmg-input" name="category" value="' . esc($company['category']) . '" disabled>
        </div>';

        /* ================= Addresses ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Registered Office</label>
            <textarea class="cmg-textarea" name="registered_office" disabled>' . esc($company['registered_office']) . '</textarea>
        </div>';

        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Head Office</label>
            <textarea class="cmg-textarea" name="head_office" disabled>' . esc($company['head_office']) . '</textarea>
        </div>';

        /* ================= Condition ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Condition And Terms</label>
            <textarea class="cmg-textarea" name="condition_and_terms" disabled>' . esc($company['condition_and_terms']) . '</textarea>
        </div>';

        /* ================= Sister Concerns ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Sister Concerns</label>
            <textarea class="cmg-textarea" name="sister_concerns" 
                placeholder="List sister concerns, one per line" disabled>' . esc($company['sister_concerns']) . '</textarea>
        </div>';

        /* ================= Invoice Format ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Invoice Format</label>
            <input type="text" class="cmg-input" name="invoice_format" value="' . esc($company['invoice_format']) . '"
                placeholder="e.g. ORG/BRANCH/FY/SEQ" disabled>
            <p class="cmg-help-text">Define how invoice numbers will be generated (e.g. ORG/BRANCH/FY/SEQ).</p>
        </div>';

        /* ================= Contact ================= */
        $html .= '<div class="cmg-field">
            <label class="cmg-label">Email</label>
            <input type="email" class="cmg-input" name="email" value="' . esc($company['email']) . '" disabled>
        </div>';

        $html .= '<div class="cmg-field">
            <label class="cmg-label">Phone</label>
            <input type="text" class="cmg-input" name="phone" value="' . esc($company['telephone']) . '" disabled>
        </div>';

        $html .= '<div class="cmg-field">
            <label class="cmg-label">Website</label>
            <input type="text" class="cmg-input" name="website" value="' . esc($company['website']) . '" disabled>
        </div>';

        /* ================= GST ================= */
        $html .= '<div class="cmg-field">
            <label class="cmg-label">PAN</label>
            <input type="text" class="cmg-input" name="pan" value="' . esc($company['pan']) . '" disabled>
        </div>';

        $html .= '<div class="cmg-field">
            <label class="cmg-label">GSTIN</label>
            <input type="text" class="cmg-input" name="gstin" value="' . esc($company['gstin']) . '" disabled>
        </div>';

        $html .= '<div class="cmg-field">
            <label class="cmg-label">IEC</label>
            <input type="text" class="cmg-input" name="iec" value="' . esc($company['iec']) . '" disabled>
        </div>';

        /* ================= Branches ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Branches</label>
            <div class="cmg-branches">
                <div class="cmg-branches__header">
                    <span>Branches</span>
                </div>
                <div id="branchesList">';

        if (!empty($branches)) {
            foreach ($branches as $index => $b) {
                $html .= '<div class="cmg-branches__item">
                    <div class="cmg-branches__item-main">
                        <div class="cmg-branches__row">
                            <div class="cmg-branches__field">
                                <input type="text" class="cmg-input" name="branches[' . $index . '][name]" 
                                    value="' . esc($b['name']) . '" placeholder="Branch name" disabled>
                            </div>
                            <div class="cmg-branches__field">
                                <input type="text" class="cmg-input" name="branches[' . $index . '][phone]" 
                                    value="' . esc($b['phone']) . '" placeholder="Phone" disabled>
                            </div>
                            <div class="cmg-branches__field">
                                <input type="email" class="cmg-input" name="branches[' . $index . '][email]" 
                                    value="' . esc($b['email']) . '" placeholder="Email" disabled>
                            </div>
                            <div class="cmg-branches__field">
                                <textarea class="cmg-input" name="branches[' . $index . '][address]" 
                                    placeholder="Address" disabled>' . esc($b['address']) . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            $html .= '<p>No branches available.</p>';
        }

        $html .= '</div></div></div>';

        /* ================= Logo Preview ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Current Logo</label>
            <div class="cmg-logo-preview">
                <p class="cmg-help-text">
                    <strong>Current Logo Path:</strong><br>';
        if (!empty($company['logo'])) {
            $html .= '<a href="' . esc($company['logo']) . '" target="_blank">' . esc($company['logo']) . '</a>';
        } else {
            $html .= 'No logo uploaded';
        }
        $html .= '</p></div></div>';

        /* ================= Business Nature ================= */
        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Nature of Business</label>
            <textarea class="cmg-textarea" name="nature_of_business" disabled>' . esc($company['nature_of_business']) . '</textarea>
        </div>';

        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Nature of Service</label>
            <textarea class="cmg-textarea" name="nature_of_service" disabled>' . esc($company['nature_of_service']) . '</textarea>
        </div>';

        $html .= '<div class="cmg-field cmg-field--full">
            <label class="cmg-label">Nature of Product</label>
            <textarea class="cmg-textarea" name="nature_of_product" disabled>' . esc($company['nature_of_product']) . '</textarea>
        </div>';

        $html .= '</div>'; // cmg-grid close
        $html .= '</form>';

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



       public function updateStatus()
{
    $data = $this->request->getJSON(true);

    $status = $data['status'];   // 1 or 0
    $userId = $data['id'];

    $model = new CompanyMasterModel();
    $company = $model->find($userId);
    if ($model->update($userId, ['status' => $status])) {

        $statusText = ($status == 1) ? 'Activated' : 'Deactivated';
        $companyName = $company['name']; 

        return $this->response->setJSON([
            'status'  => true,
            'message' => "{$companyName} {$statusText} successfully"
        ]);
    }

    return $this->response->setJSON([
        'status'  => false,
        'message' => 'Failed to update status'
    ]);
}


}