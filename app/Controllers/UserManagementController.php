<?php

namespace App\Controllers;
use App\Models\UserManagementModel;



use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;

class UserManagementController extends BaseController
{
     public function index()
    {
       $model=new UserManagementModel();
        $data['users'] = $model->findAll();

        $rolesModel = new RoleModel();
        $data['roles'] = $rolesModel->findAll();
        
        echo view('common/header');
         return view('UserManagment/UserManagment',$data);
        echo view('common/footer');
    }
     public function store()
    {
        $rules = [
            'name'  => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[user_management.email]',
            'phone' => 'required|min_length[10]',
            'password' => 'required|min_length[6]',
            'role'  => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $model = new UserManagementModel();

        $model->insert([
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'phone'  => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'),PASSWORD_DEFAULT),
            'role_id'   => $this->request->getPost('role'),
            
        ]);

        return redirect()->back()->with('success', 'User added successfully');
    }
    public function getUser($id)
{
    $model = new UserManagementModel();
    $user = $model->find($id);

    return $this->response->setJSON($user);
}

public function resetPassword()
{
    $data = $this->request->getJSON(true);

    if (empty($data['password'])) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Password required'
        ]);
    }
    $model = new UserManagementModel();
    $model->update($data['user_id'], [
        'password' => password_hash($data['password'], PASSWORD_DEFAULT)
    ]);

    return $this->response->setJSON([
        'status' => true
    ]);
}

public function update()
{
    $model = new UserManagementModel();

    $id = $this->request->getPost('id');

    if (!$id) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
    }

    $data = [
        'name'  => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'phone' => $this->request->getPost('phone'),
        'password' => password_hash($this->request->getPost('password'),PASSWORD_DEFAULT),
        'role_id'  => $this->request->getPost('role'),
    ];

    $model->update($id, $data);

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'User updated successfully'
    ]);
}
public function delete()
{
    $id = $this->request->getPost('id');

    if (!$id) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
    }

    $model = new UserManagementModel();
    $model->delete($id);

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'User deleted successfully'
    ]);
}
public function toggleStatus()
{
    $id     = $this->request->getPost('id');
    $status = $this->request->getPost('status');

    if (!$id) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid user'
        ]);
    }

    // toggle logic
    $newStatus = ($status == 1) ? 0 : 1;

    $model = new UserManagementModel();
    $model->update($id, ['status' => $newStatus]);

    return $this->response->setJSON([
        'status'     => 'success',
        'new_status' => $newStatus
    ]);
}


}