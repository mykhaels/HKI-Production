<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


Route::get('product-category/get-category/{id}', 'ProductCategoryController@getCategories');
Route::patch('product-category/status/{productCategory}', 'ProductCategoryController@updateStatus');
Route::resource('product-category', 'ProductCategoryController');
Route::patch('product/status/{product}', 'ProductController@updateStatus');
Route::resource('product', 'ProductController');
Route::get('delivery-note/get-delivery-request','DeliveryNoteController@getDeliveryRequest');
Route::resource('delivery-note', 'DeliveryNoteController');
Route::get('production-order/search_product','ProductionOrderController@searchProduct');
Route::resource('production-order', 'ProductionOrderController');
Route::get('/delivery-request/{deliveryRequest}/pdf','DeliveryRequestController@print');
Route::resource('delivery-request', 'DeliveryRequestController');
Route::get('production-result/get-production-order','ProductionResultController@getProductionOrder');
Route::resource('production-result', 'ProductionResultController');
Route::resource('supplier', 'SupplierController');
Route::get('purchase-order/get-price','PurchaseOrderController@getPrice');
Route::patch('purchase-order/updateStatus/{purchaseOrder}','PurchaseOrderController@updateStatus');
Route::resource('purchase-order', 'PurchaseOrderController');
Route::get('initial-payment/getPurchaseOrder','InitialPaymentController@getPurchaseOrder');
Route::get('initial-payment/getListPOSupplier','InitialPaymentController@getListPOSupplier');
Route::resource('initial-payment', 'InitialPaymentController');
Route::resource('good-receipt', 'GoodReceiptController');
Route::get('retur/getGoodReceipt','ReturController@getGoodReceipt');
Route::get('retur/getListBPBSupplier','ReturController@getListBPBSupplier');
Route::resource('retur', 'ReturController');
Route::patch('invoice/updateStatus/{invoice}','InvoiceController@updateStatus');
Route::get('invoice/getListBPBSupplier','InvoiceController@getListBPBSupplier');
Route::get('invoice/getGoodReceiptPO','InvoiceController@getGoodReceiptPO');
Route::resource('invoice', 'InvoiceController');
Route::get('settlement/getNotSettledInvoice','SettlementController@getNotSettledInvoice');
Route::resource('settlement', 'SettlementController');
Route::resource('writeoff', 'WriteOffController');

