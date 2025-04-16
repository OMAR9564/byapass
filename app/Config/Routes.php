<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Ana sayfa doğrudan şifre oluşturma sayfasına yönlendirilecek
$routes->get('/', 'Generate::index');

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Generate routes
$routes->get('generate', 'Generate::index');
$routes->get('generate/advanced', 'Generate::advanced');
$routes->post('generate/process', 'Generate::process');
$routes->get('generate/display', 'Generate::display');
$routes->get('generate/qr-code', 'Generate::qrCode');

// Add login routes
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('login/logout', 'Login::logout');
