<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WorkMasterModel;

class MasterWork extends BaseController
{
    protected $session;
    protected $WorkMaster;

    public function __construct()
    {
        $this->session    = \Config\Services::session();
        $this->WorkMaster = new WorkMasterModel();
        helper(['form']);
    }

    // LIST PAGE
    public function index()
    {
        $data['workListData'] = $this->WorkMaster->findAll();
        $data['validation']   = session('validation');

        echo view('common/header');
        echo view('master_work/masterwork_list', $data);
        echo view('common/footer');
    }

    // ADD SERVICE (AJAX)
    public function addServices()
    {
        if (! $this->request->isAJAX()) {
            return redirect()->to('/work_master');
        }

        $rules = [
            // 'service_code'  => 'required',
            'service_name'  => 'required',
            'sac_code'      => 'required|numeric',
            // 'unit'          => 'required',
            'default_rate'  => 'required|numeric',
            'gst_percent'   => 'required|numeric',
            // 'gst'           => 'required',
            // 'frequency'     => 'required',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $work_master_data = [
            // 'service_code'   => $this->request->getPost('service_code'),
            'service_name'   => $this->request->getPost('service_name'),
            'sac_code'       => $this->request->getPost('sac_code'),
            // 'unit'           => $this->request->getPost('unit'),
            'default_rate'   => $this->request->getPost('default_rate'),
            'gst_percent'    => $this->request->getPost('gst_percent'),
            // 'gst_applicable' => $this->request->getPost('gst'),
            // 'frequency'      => $this->request->getPost('frequency'),
            'status'         => 1,
        ];

        $this->WorkMaster->insert($work_master_data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Service Added Successfully',
        ]);
    }

    // UPDATE SERVICE STATUS (toggle)
   public function updateStatus()
{
    $data = $this->request->getJSON(true);

    $status = $data['status'];   // 1 or 0
    $userId = $data['id'];

    $model = new WorkMasterModel();
    $WorkMaster= $model->find($userId);
    if ($model->update($userId, ['status' => $status])) {

        $statusText = ($status == 1) ? 'Activated' : 'Deactivated';
        // $workName = $WorkMaster['service_code']; 

        return $this->response->setJSON([
            'status'  => true,
            'message' => " {$statusText} successfully"
        ]);
    } else {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Failed to update status'
        ]);
    }}
    // GET SERVICE (for edit popup)
    public function getService()
    {
        $id   = $this->request->getPost('id');
        $data = $this->WorkMaster->where('id', $id)->first();

        return $this->response->setJSON($data);
    }

    // UPDATE SERVICE (AJAX)
    public function updateServices($id)
    {
        if (! $this->request->isAJAX()) {
            return redirect()->to('/work_master');
        }

        $rules = [
            // 'service_code'  => 'required',
            'service_name'  => 'required',
            'sac_code'      => 'required|numeric',
            // 'unit'          => 'required',
            'default_rate'  => 'required|numeric',
            'gst_percent'   => 'required|numeric',
            // 'gst'           => 'required',
            // 'frequency'     => 'required',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $work_master_data = [
            // 'service_code'   => $this->request->getPost('service_code'),
            'service_name'   => $this->request->getPost('service_name'),
            'sac_code'       => $this->request->getPost('sac_code'),
            // 'unit'           => $this->request->getPost('unit'),
            'default_rate'   => $this->request->getPost('default_rate'),
            'gst_percent'    => $this->request->getPost('gst_percent'),
            // 'gst_applicable' => $this->request->getPost('gst'),
            // 'frequency'      => $this->request->getPost('frequency'),
        ];

        $this->WorkMaster->update($id, $work_master_data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Service Updated Successfully',
        ]);
    }
}