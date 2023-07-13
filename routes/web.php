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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        // Pages goes here

        // Product
        Route::get('/product/product-list', 'Product\ProductController@productList')->name('product.product-list');
        Route::get('/product/product-add', 'Product\ProductController@addProduct')->name('product.product-add');
        Route::get('/product/product-edit/{id}', 'Product\ProductController@editProduct')->name('product.product-edit');
        Route::get('/product/product-update/{id}', 'Product\ProductController@updateProduct')->name('product.product-update');
        Route::get('/product/product-delete/{id}', 'Product\ProductController@deleteProduct')->name('product.product-delete');
        // Product Filter
        Route::get('/product/product-filer-category-product-list', 'Product\ProductController@categoryFilter');
        Route::get('/product/product-search-filter-product-list', 'Product\ProductController@searchFilter');

        // Product Stock
        Route::get('/product/product-stock', 'Product\ProductController@productStock')->name('product.product-stock');
        Route::get('/product/product-stock-edit-import/{id}', 'Product\ProductController@editProductStock')->name('product.product-stock-edit-import');
        Route::get('/product/product-stock-update-import/{id}', 'Product\ProductController@updateProductStock')->name('product.product-stock-update-import');
        // Product Stock Filter
        Route::get('/product/product-filter-category-product-stock', 'Product\ProductController@categoryStockFilter');
        Route::get('/product/product-filter-search-product-stock', 'Product\ProductController@searchStockFilter');

        // Cashier
        Route::get('/cashier/cashier-home', 'CashierController@cashier')->name('cashier.cashier-home');
        Route::get('/cashier/cashier-get-product-detail/{id}', 'CashierController@getProductDetail')->name('cashier.cashier-get-product-detail');
        Route::get('/cashier/cashier-get-product-detail-order/{id}', 'CashierController@getProductDetailOrder')->name('cashier.cashier-get-product-detail-order');
        Route::get('/cashier/cashier-purchase-order', 'CashierController@purchaseOrder');

        // User Management
        Route::get('/user-management/user-management', 'UserManagementController@userManagement')->name('user-management.user-management-home');
        Route::get('/user-management/add-user', 'UserManagementController@addUser');
        Route::get('/user-management/edit-user-data/{id}', 'UserManagementController@editUser');
        Route::get('/user-management/update-user-data/{id}', 'UserManagementController@updateUser');
        Route::get('/user-management/delete-user/{id}', 'UserManagementController@deleteUser');

        // Report
        Route::get('/report/report-page', 'ReportController@index')->name('report.report-page');

        // Report Sold Product Detail
        Route::get('/report/report-totalsolditemtoday', 'ReportController@totalSoldProductToday');
        Route::get('/report/report-totalsolditemthismonth', 'ReportController@totalSoldProductThisMonth');
        Route::get('/report/report-totalsolditemthisyear', 'ReportController@totalSoldProductThisYear');
        
        // Export PDF
        Route::get('preview', 'ReportController@preview');
        Route::get('/report/export/report-pdf', 'ReportController@exportPdf')->name('download');
    });
});