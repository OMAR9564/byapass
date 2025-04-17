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
        // Hassas bilgileri loglamamalıyız
        log_message('info', 'Giriş denemesi yapıldı');

        if ($password === $adminPassword) {
            // Don't destroy the session - just set the value
            session()->set('logged_in', true);
            
            log_message('info', 'Kullanıcı başarıyla giriş yaptı');
            
            return $this->response->setJSON(['success' => true]);
        } else {
            log_message('info', 'Giriş başarısız');
            return $this->response->setJSON(['success' => false, 'message' => 'Geçersiz şifre!']);
        }
    }

    public function logout()
    {
        $session = session();
        $session->remove('logged_in');
        $session->remove('generated_password');
        $session->remove('generated_site');
        
        session()->setFlashdata('success', 'Başarıyla çıkış yapıldı.');
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