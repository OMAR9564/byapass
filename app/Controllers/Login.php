<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends BaseController
{
    private $envPath;

    public function __construct()
    {
        $this->envPath = ROOTPATH . '.env';
    }

    public function index()
    {
        // Zaten oturum açılmışsa generate sayfasına yönlendir
        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            return redirect()->to(base_url('generate'));
        }
        
        return view('login/index');
    }

    public function authenticate()
    {
        $password = $this->request->getPost('password');
        $adminPassword = getenv('ADMIN_PASSWORD');

        if ($password === $adminPassword) {
            $session = session();
            $session->set('isLoggedIn', true);
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Geçersiz şifre!']);
        }
    }

    public function logout()
    {
        $session = session();
        $session->remove('isLoggedIn');
        return redirect()->to('/login');
    }
    
    private function getPasswordFromEnv()
    {
        if (!file_exists($this->envPath)) {
            return null;
        }
        
        $env = file_get_contents($this->envPath);
        $pattern = '/^ADMIN_PASSWORD\s*=\s*"?([^"\r\n]*)"?$/m';
        
        if (preg_match($pattern, $env, $matches)) {
            return $matches[1];
        }
        
        return null;
    }
} 