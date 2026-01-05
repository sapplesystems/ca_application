<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientModel;

class InvoiceMasterController extends BaseController
{
    public function index()
{
    $clientModel = new ClientModel();

    $clients = $clientModel
        ->select('legal_name')
        ->findAll();

    echo view('common/header');
    echo view('InvoiceMaster/index', ['clients' => $clients]);
    echo view('common/footer');
}
}