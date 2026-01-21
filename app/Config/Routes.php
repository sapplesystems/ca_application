<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Login Routes (NO FILTER)
$routes->get('/login', 'LoginController::login', ['as' => 'admin.login.form']);
$routes->get('/', 'LoginController::login', ['as' => 'home']);
$routes->post('login-for-entry', 'LoginController::loginforentry', ['as' => 'admin.login']);
$routes->get('logout', 'LoginController::logout', ['as' => 'admin.logout']);

// Master Work Routes
$routes->get('/work_master', 'MasterWork::index', ['as' => 'work_master.index', 'filter' => 'adminPermission']);
$routes->post('/work_master/update-status', 'MasterWork::updateStatus', ['filter' => 'adminPermission']);
$routes->post('add-services', 'MasterWork::addServices', ['filter' => 'adminPermission']);
$routes->post('get-service', 'MasterWork::getService', ['filter' => 'adminPermission']);
$routes->post('update-service/(:num)', 'MasterWork::updateServices/$1', ['filter' => 'adminPermission']);

// Client Master Routes
$routes->match(['get', 'post'], 'Client_Master', 'ClientMasterController::index', ['as' => 'client.master', 'filter' => 'adminPermission']);
$routes->post('clients/store', 'ClientMasterController::store', ['filter' => 'adminPermission']);
$routes->post('clients/update', 'ClientMasterController::update', ['filter' => 'adminPermission']);
$routes->post('clients/show', 'ClientMasterController::show', ['filter' => 'adminPermission']);
$routes->post('client/update-status', 'ClientMasterController::updateStatus', ['filter' => 'adminPermission']);

// Company Master Routes
$routes->match(['get', 'post'], 'company_master', 'CompanyMasterController::index',['as' => 'company.master', 'filter' => 'adminPermission']);
$routes->post('company-master/store', 'CompanyMasterController::store', ['filter' => 'adminPermission']);
$routes->post('company-master/update', 'CompanyMasterController::update', ['filter' => 'adminPermission']);
$routes->post('company-master/update-status', 'CompanyMasterController::updateStatus', ['filter' => 'adminPermission']);
$routes->post('company-master/show', 'CompanyMasterController::show', ['filter' => 'adminPermission']);
// Invoice Management Routes//Invoice Master Routes
$routes->get('/InvoiceManagment', 'InvoiceMasterController::index',['as' => 'invoice.index', 'filter' => 'adminPermission']);
$routes->get('/ManageInvoice/(:num)', 'InvoiceMasterController::manageInvoice/$1', ['filter' => 'adminPermission']);
$routes->post('/preview', 'InvoiceMasterController::previewInvoice', ['filter' => 'adminPermission']);
$routes->post('/saveInvoice', 'InvoiceMasterController::saveInvoice',   ['filter' => 'adminPermission']);
$routes->get('invoice/print/(:num)', 'InvoiceMasterController::print/$1', ['filter' => 'adminPermission']);
$routes->get('invoice/pdf/(:num)', 'InvoiceMasterController::pdf/$1', ['filter' => 'adminPermission']);
$routes->get('invoice/edit/(:num)', 'InvoiceMasterController::edit/$1', ['filter' => 'adminPermission']);
$routes->post('updateInvoice/(:num)', 'InvoiceMasterController::updateInvoice/$1',  ['filter' => 'adminPermission']);
$routes->delete('invoice/delete/(:num)', 'InvoiceMasterController::delete/$1', ['filter' => 'adminPermission']);
$routes->get('invoice/receipt/(:num)', 'InvoiceMasterController::receipt/$1', ['filter' => 'adminPermission']);
$routes->post('debit-note/store','InvoiceMasterController::storeDebitNote', ['filter' => 'adminPermission']);
$routes->post('/savedebit','InvoiceMasterController::saveDebitNote', ['filter' => 'adminPermission']);
$routes->get('/DebitNote/(:num)', 'InvoiceMasterController::debitNote/$1', ['filter' => 'adminPermission']);
$routes->get('DebitNotePDF/(:num)', 'InvoiceMasterController::debitNotePDF/$1', ['filter' => 'adminPermission']);
$routes->post('ManageInvoice/saveReceipt', 'InvoiceMasterController::saveReceipt', ['filter' => 'adminPermission']);
$routes->get('ManageInvoice/getInvoiceDetails/(:num)', 'InvoiceMasterController::getInvoiceDetails/$1', ['filter' => 'adminPermission']);
$routes->post('ManageInvoice/updateReceipt', 'InvoiceMasterController::updateReceipt', ['filter' => 'adminPermission']);
$routes->post('ManageInvoice/deleteReceipt/(:num)', 'InvoiceMasterController::deleteReceipt/$1', ['filter' => 'adminPermission']);
$routes->get('ManageInvoice/printReceipt/(:num)', 'InvoiceMasterController::printReceipt/$1', ['filter' => 'adminPermission']);
$routes->get('ManageInvoice/receiptPdf/(:num)', 'InvoiceMasterController::receiptPdf/$1', ['filter' => 'adminPermission']);
$routes->get('DebitNoteList/(:num)','InvoiceMasterController::debitlist/$1', ['filter' => 'adminPermission']);
$routes->get('debits/delete/(:num)', 'InvoiceMasterController::debitDelete/$1', ['filter' => 'adminPermission']);
$routes->get('debits/edit/(:num)', 'InvoiceMasterController::debitEdit/$1', ['filter' => 'adminPermission']);
$routes->post('debits/update/(:num)', 'InvoiceMasterController::debitUpdate/$1', ['filter' => 'adminPermission']);
$routes->post('Expense/delete', 'InvoiceMasterController::ExpenseDelete', ['filter' => 'adminPermission']);

// Role Management Routes
$routes->get('roles', 'RoleController::index', ['as' => 'roles.index', 'filter' => 'adminPermission']);
$routes->get('roles/create', 'RoleController::create', ['as' => 'roles.create', 'filter' => 'adminPermission']);
$routes->post('roles/store', 'RoleController::store', ['as' => 'roles.store', 'filter' => 'adminPermission']);
$routes->get('roles/edit/(:num)', 'RoleController::edit/$1', ['as' => 'roles.edit', 'filter' => 'adminPermission']);
$routes->post('roles/update/(:num)', 'RoleController::update/$1', ['as' => 'roles.update', 'filter' => 'adminPermission']);
$routes->get('roles/delete/(:num)', 'RoleController::delete/$1', ['as' => 'roles.delete', 'filter' => 'adminPermission']);
$routes->get('roles/permissions/(:any)', 'RoleController::getPermissionsByModule/$1', ['as' => 'roles.permissions']);







