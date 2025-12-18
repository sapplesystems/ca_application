<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyMasterModel;
use CodeIgniter\HTTP\ResponseInterface;

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
     public function store()
    {
        $request = $this->request;

        // branches (array) => JSON string
        $branches = $request->getPost('branches'); // ['0'=>['title'=>..,'address'=>..],...]
        $branchesJson = $branches ? json_encode($branches) : null;

        // normal fields
        $data = [
            'type_of_company'  => $request->getPost('company_type'),
            'name'             => $request->getPost('name'),
            'date_of_incorp'   => $request->getPost('date_of_incorporation'),
            'category'         => $request->getPost('category'),
            'registered_office'=> $request->getPost('registered_office'),
            'head_office'      => $request->getPost('head_office'),
            'email'            => $request->getPost('email'),
            'telephone'        => $request->getPost('phone'),
            'website'          => $request->getPost('website'),
            'invoice_format'   => $request->getPost('invoice_format'),
            'pan'              => $request->getPost('pan'),
            'gstin'            => $request->getPost('gstin'),
            'iec'              => $request->getPost('iec'),
            'sister_concerns'  => $request->getPost('sister_concerns'),
            'branches'         => $branchesJson,
            'bank_ac_no'       => $request->getPost('bank_account'),
            'status'           => $request->getPost('status'),
        ];

        // logo upload (optional)
        $logoFile = $request->getFile('logo');
        if ($logoFile && $logoFile->isValid() && ! $logoFile->hasMoved()) {
            $newName = $logoFile->getRandomName();
            $logoFile->move(WRITEPATH . 'uploads/company_logo', $newName); // ya public path jaha chaho
            $data['logo'] = $newName;
        }

        $this->companyModel->insert($data);


        return redirect()->to(base_url('company-master')) // apni route ke hisab se
                         ->with('success', 'Company created successfully.');
    }
}