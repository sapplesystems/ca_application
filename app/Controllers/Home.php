<?php

namespace App\Controllers;
use App\Models\LoginModel;

class Home extends BaseController
{
    protected $session;
    protected $login;

    public function __construct()
    {
        // yahan common initialization
        $this->session = \Config\Services::session();
        $this->login = new LoginModel();
    }
    public function index(): string
    {

        return view('login');
    }

    public function loginAs()
    {
        echo "<pre>";print_r($_POST);

    }

}
