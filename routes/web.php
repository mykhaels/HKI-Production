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
Route::resource('product-category', 'ProductCategoryController');
Route::resource('product', 'ProductController');
Route::get('delivery-note/get-delivery-request','DeliveryNoteController@getDeliveryRequest');
Route::resource('delivery-note', 'DeliveryNoteController');
Route::get('production-order/search_product','ProductionOrderController@searchProduct');
Route::resource('production-order', 'ProductionOrderController');
Route::resource('delivery-request', 'DeliveryRequestController');

