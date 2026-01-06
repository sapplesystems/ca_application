<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ManageInvoiceController extends BaseController
{
    public function index()
    {
          echo view('common/header');
    echo view('InvoiceMaster/Manage_invoice');
    echo view('common/footer');
    }
}