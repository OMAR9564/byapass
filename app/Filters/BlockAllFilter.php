<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BlockAllFilter implements FilterInterface
{
    /**
     * Tüm istekleri engelle ve engellendi sayfasına yönlendir.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Her zaman herkesin erişimini engelle
        return redirect()->to(base_url('engellendi'))
            ->with('error', 'Uygulama şu anda bakım modundadır. Lütfen daha sonra tekrar deneyin.');
    }

    /**
     * Filters rota çalıştırıldıktan sonra yapılacaklar.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Herhangi bir işlem yapma
    }
} 