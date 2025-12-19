<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'LoginController::login');
$routes->get('/', 'LoginController::login');

$routes->get('/work_master', 'MasterWork::index');
$routes->get('login', 'LoginController::login');
$routes->post('login-for-entry', 'LoginController::loginforentry');
$routes->get('logout', 'LoginController::logout');
$routes->post('add-services', 'MasterWork::addServices');
$routes->post('get-service', 'MasterWork::getService');
$routes->post('update-service/(:num)', 'MasterWork::updateServices/$1');
$routes->match(['get', 'post'], 'Client_Master', 'ClientMasterController::index', ['as' => 'client.master']);
$routes->post('clients/store', 'ClientMasterController::store');
$routes->post('clients/update', 'ClientMasterController::update');
$routes->post('clients/show', 'ClientMasterController::show');

$routes->post('company-master/store', 'CompanyMasterController::store');
$routes->match(['get', 'post'], 'company_master', 'CompanyMasterController::index', ['as' => 'company.master']);
$routes->post('company-master/update', 'CompanyMasterController::update');
$routes->post('company-master/show', 'CompanyMasterController::show');
