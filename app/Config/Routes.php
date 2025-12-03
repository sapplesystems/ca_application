<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'LoginController::login');
$routes->get('/', 'LoginController::login');

$routes->get('/work_master', 'MasterWork::index');
$routes->get('/company_master', 'CompanyMasterController::index');
$routes->get('login', 'LoginController::login');
$routes->post('login-for-entry', 'LoginController::loginforentry');