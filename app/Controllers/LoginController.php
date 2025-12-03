<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class LoginController extends BaseController
{

    protected $session;
    protected $login;

    public function __construct()
    {
        // common initialization
        $this->session = \Config\Services::session();
        $this->login   = new LoginModel();
    }

    // GET: /login
    public function login(): string
    {
        // yahan sirf view return karo, echo ki jagah return
        return view('login');
    }

    // POST: /login-for-entry
   public function loginforentry()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('pass');

        // Basic validation
        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Please enter username & password.');
            return redirect()->to('/login')->withInput();
        }

        // Fetch user row
        $user = $this->login
                    ->where('username', $username)
                    ->first();

        // User found?
        if (!$user) {
            session()->setFlashdata('error', 'Invalid Username or Password!');
            return redirect()->to('/login')->withInput();
        }

        // Password check (secure)
        if ($user['password'] !== $password) { 
            // If password hashing used → password_verify($password, $user['password'])
            session()->setFlashdata('error', 'Invalid Username or Password!');
            return redirect()->to('/login')->withInput();
        }

            // Create session
        $sessionData = [
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'logged_in' => true
        ];

        $this->session->set($sessionData);

        // Login success
        session()->setFlashdata('success', 'Login Successful!');
        return redirect()->to('/work_master');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to('login');
    }



}
