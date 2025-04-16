<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Ana sayfa doğrudan şifre oluşturma sayfasına yönlendirilsin
        return redirect()->to(base_url('generate'));
    }
}
