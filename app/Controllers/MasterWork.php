<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MasterWork extends BaseController
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
        return view('master_work/masterwork_list');
    }
}
