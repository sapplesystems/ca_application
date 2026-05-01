<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomepageController extends BaseController
{
    public function index()
    {
        echo view('common/header');
        echo view('home/index');
        echo view('common/footer');
    }
}
