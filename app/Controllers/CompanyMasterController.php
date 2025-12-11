<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CompanyMasterController extends BaseController
{
    protected $session;
    public function __construct()
    {
        // common initialization
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        //echo "<pre>";print_r($this->session->get());die;
        echo view('common/header');
        echo view('CompanyMaster_list');
        echo view('common/footer');
    }
}