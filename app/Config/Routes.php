<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//Login Routes
$routes->get('/login', 'LoginController::login');
$routes->get('/', 'LoginController::login');
$routes->get('login', 'LoginController::login');
$routes->post('login-for-entry', 'LoginController::loginforentry');
$routes->get('logout', 'LoginController::logout');

//Master Work Routes
$routes->get('/work_master', 'MasterWork::index');
$routes->post('/work_master/update-status', 'MasterWork::updateStatus');
$routes->post('add-services', 'MasterWork::addServices');
$routes->post('get-service', 'MasterWork::getService');
$routes->post('update-service/(:num)', 'MasterWork::updateServices/$1');

//Client Master Routes
$routes->match(['get', 'post'], 'Client_Master', 'ClientMasterController::index', ['as' => 'client.master']);
$routes->post('clients/store', 'ClientMasterController::store');
$routes->post('clients/update', 'ClientMasterController::update');
$routes->post('clients/show', 'ClientMasterController::show');
$routes->post('client/update-status', 'ClientMasterController::updateStatus');

//Company Master Routes
$routes->post('company-master/store', 'CompanyMasterController::store');
$routes->match(['get', 'post'], 'company_master', 'CompanyMasterController::index', ['as' => 'company.master']);
$routes->post('company-master/update', 'CompanyMasterController::update');
$routes->post('company-master/show', 'CompanyMasterController::show');
$routes->post('company-master/update-status', 'CompanyMasterController::updateStatus');

//Invoice Master Routes
$routes->get('/InvoiceManagment', 'InvoiceMasterController::index');
$routes->get('/ManageInvoice/(:num)', 'InvoiceMasterController::manageInvoice/$1');
$routes->post('/preview', 'InvoiceMasterController::previewInvoice');
$routes->post('/saveInvoice', 'InvoiceMasterController::saveInvoice');
$routes->get('invoice/print/(:num)', 'InvoiceMasterController::print/$1');
$routes->get('invoice/pdf/(:num)', 'InvoiceMasterController::pdf/$1');
$routes->get('invoice/edit/(:num)', 'InvoiceMasterController::edit/$1');
$routes->delete('invoice/delete/(:num)', 'InvoiceMasterController::delete/$1');
$routes->get('invoice/receipt/(:num)', 'InvoiceMasterController::receipt/$1');
$routes->post('debit-note/store','InvoiceMasterController::storeDebitNote');
$routes->post('/savedebit','InvoiceMasterController::saveDebitNote');
$routes->get('/DebitNote/(:num)', 'InvoiceMasterController::debitNote/$1');
$routes->get('DebitNotePDF/(:num)', 'InvoiceMasterController::debitNotePDF/$1');
$routes->post('ManageInvoice/saveReceipt', 'InvoiceMasterController::saveReceipt');
$routes->get('ManageInvoice/getInvoiceDetails/(:num)', 'InvoiceMasterController::getInvoiceDetails/$1');
$routes->post('ManageInvoice/updateReceipt', 'InvoiceMasterController::updateReceipt');
$routes->post('ManageInvoice/deleteReceipt/(:num)', 'InvoiceMasterController::deleteReceipt/$1');
$routes->get('ManageInvoice/printReceipt/(:num)', 'InvoiceMasterController::printReceipt/$1');
$routes->get('ManageInvoice/receiptPdf/(:num)', 'InvoiceMasterController::receiptPdf/$1');






