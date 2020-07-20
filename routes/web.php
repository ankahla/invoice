<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

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

Route::get('/', 'WebsiteController@index')->name('homepage');

Auth::routes();

Route::group(array('before' => 'auth'), function () {
    Route::group(array('before' => 'admin'), function () {
        Route::post('admin/application', 'AdminController@application');
        Route::resource('admin', 'AdminController')->name('index', 'admin');
        Route::resource('language', 'LanguageController');
        //Route::post('language/2/edit',					'LanguageController');
        Route::get('user/{id}/{name}', function ($id, $name) {
            //
        })->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
        Route::post('language/translate', 'LanguageController@translate')->name('translate');
        Route::get('user', 'UserController@index');
    });

    Route::resource('dashboard', 'DashboardController')->name('index', 'dashboard');
    Route::resource('setting', 'SettingController');
    Route::resource('quotation', 'QuotationController');
    Route::post('quotation/{id}/validate', 'QuotationController@promote');
    Route::get('quotationpdf/{id}/{theme}', 'PdfController@showQuotation');
    Route::post('quotationemail/{id}/{theme}', 'EmailController@showQuotation');
    Route::get('invoice/received/{id}', 'InvoiceController@show');
    Route::get('pdf/received/{id}', 'PdfController@show');
    Route::post('setting/defaultLanguage', 'SettingController@defaultLanguage');
    Route::put('user/{id}', 'UserController@update');
    Route::get('user/view', array(
        'as' => 'userView',
        'uses' => 'UserController@view'
    ));
    Route::get('user/create', array(
        'as' => 'userCreate',
        'uses' => 'UserController@create'
    ));
    Route::post('user', array(
        'as' => 'userStore',
        'uses' => 'UserController@store'
    ));

    Route::group(array('before' => 'user'), function () {
        Route::resource('client', 'ClientController');
        Route::resource('currency', 'CurrencyController');
        Route::resource('invoice', 'InvoiceController');
        Route::resource('newsletter', 'NewsletterController');
        Route::resource('product', 'ProductController');
        Route::resource('payment', 'PaymentController');
        Route::resource('report', 'ReportController');
        Route::resource('tax', 'TaxController');

        Route::post('email/{id}', 'EmailController@show');
        Route::get('pdf/{id}', 'PdfController@show');
        Route::resource('upload-logo', 'UploadController');

        Route::post('invoice/add-payment/{id}', 'InvoiceController@addPayment');
        Route::post('invoice/edit-status/{id}', 'InvoiceController@updateStatus');
        Route::post('invoice/edit-due-date/{id}', 'InvoiceController@updateDueDate');
        Route::post('invoice/number', 'InvoiceController@storeInvoiceNumber');
        Route::post('invoice/code', 'InvoiceController@storeInvoiceCode');
        Route::post('invoice/text', 'InvoiceController@storeInvoiceText');

        /* === AJAX === */
        Route::post('/currency/currencyPosition', array('uses' => 'CurrencyController@currencyPosition', 'as' => 'currency.currencyPosition'));
        Route::post('/invoice/deleteProduct', array('uses' => 'InvoiceController@deleteProduct', 'as' => 'invoice.deleteProduct'));
        Route::post('/setting/defaultCurrency', array('uses' => 'SettingController@defaultCurrency', 'as' => 'setting.defaultCurrency'));
        Route::post('/ajax/productPrice', array('uses' => 'AjaxController@productPrice', 'as' => 'ajax.productPrice'));
        /* === END AJAX === */
    });
});
