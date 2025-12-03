<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WorkMasterModel;

class MasterWork extends BaseController
{
    protected $session;
    protected $WorkMaster;
    public function __construct()
    {
        // common initialization
        $this->session = \Config\Services::session();
        $this->WorkMaster   = new WorkMasterModel();
        helper(['form']);
    }
    public function index()
    {
        $data['workListData'] = $this->WorkMaster->find();
        echo view('common/header');
        echo view('master_work/masterwork_list',$data);
        echo view('common/footer');
    }
    public function addServices()
    {

        if ($this->request->getMethod() == 'POST') {

      
            // Validation Rules
            $rules = [
                'service_code'  => 'required',
                'service_name'  => 'required',
                'sac_code'      => 'required|numeric',
                'unit'          => 'required',
                'default_rate'  => 'required|numeric',
                'gst_percent'   => 'required|numeric',
                'gst'           => 'required',
                'frequency'     => 'required',
                'status'        => 'required'
            ];

            if (! $this->validate($rules)) {
                return view('master_work/masterwork_list', [
                    'validation' => $this->validator
                ]);
            }

            $work_master_data = [
                'service_code'   => $this->request->getPost('service_code'),
                'service_name'   => $this->request->getPost('service_name'),
                'sac_code'       => $this->request->getPost('sac_code'),
                'unit'           => $this->request->getPost('unit'),
                'default_rate'   => $this->request->getPost('default_rate'),
                'gst_percent'    => $this->request->getPost('gst_percent'),
                'gst_applicable' => $this->request->getPost('gst'),
                'frequency'      => $this->request->getPost('frequency'),
                'status'         => $this->request->getPost('status'),
            ];
           
            // Save Data
           $this->WorkMaster->insert($work_master_data);

            return redirect()->to('/work_master')->with('success', 'Service Added Successfully');
        }else{
           return redirect()->to('/work_master');
        }

        
    }

    public function getService()
    {
        $id = $this->request->getPost('id');

        $data = $this->WorkMaster->where('id', $id)->first();

        return $this->response->setJSON($data);
    }

    public function updateServices($id)
    {

       if ($this->request->getMethod() == 'POST') {

            // Validation Rules
            $rules = [
                'service_code'  => 'required',
                'service_name'  => 'required',
                'sac_code'      => 'required|numeric',
                'unit'          => 'required',
                'default_rate'  => 'required|numeric',
                'gst_percent'   => 'required|numeric',
                'gst'           => 'required',
                'frequency'     => 'required',
                'status'        => 'required'
            ];

            if (! $this->validate($rules)) {
                return view('master_work/masterwork_list', [
                    'validation' => $this->validator
                ]);
            }

            $work_master_data = [
                'service_code'   => $this->request->getPost('service_code'),
                'service_name'   => $this->request->getPost('service_name'),
                'sac_code'       => $this->request->getPost('sac_code'),
                'unit'           => $this->request->getPost('unit'),
                'default_rate'   => $this->request->getPost('default_rate'),
                'gst_percent'    => $this->request->getPost('gst_percent'),
                'gst_applicable' => $this->request->getPost('gst'),
                'frequency'      => $this->request->getPost('frequency'),
                'status'         => $this->request->getPost('status'),
            ];
           
            // Save Data
           $this->WorkMaster->update($id,$work_master_data);

            return redirect()->to('/work_master')->with('success', 'Service Updated Successfully');
        }else{
           return redirect()->to('/work_master');
        }
    }
    
}
