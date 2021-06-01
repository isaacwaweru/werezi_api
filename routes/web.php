<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'RedirectController@redirect');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('login', 'Auth\LoginController@login');
Route::get('forgot-password', 'Auth\ForgotPasswordController@show')->name('forgot-password');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('email_verification/{code}', 'API\RegisterController@emailVerification');

Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin'], function() {
    Route::get('', 'DashboardController@dashboard')->name('dashboard');

    Route::resource('categories', 'CategoriesController');

    Route::resource('authors', 'AuthorsController');

    Route::resource('publishers', 'PublishersController');

    Route::resource('sellers', 'SellersController');

    Route::resource('users', 'UsersController');

    Route::resource('orders', 'OrdersController');
    Route::get('orders/invoice/{id}', 'OrdersController@invoice')->name('orders.invoice');
    Route::get('orders/shipping-list/{id}', 'OrdersController@shippingList')->name('orders.shipping-list');

    Route::resource('home-page-slides', 'HomePageSlidesController');

    Route::resource('featured-items', 'FeaturedItemsController');

    Route::resource('books', 'BooksController');
    Route::post('books/add-copy', 'BooksController@addCopy')->name('books.add-copy');
    Route::post('books/delete-copy', 'BooksController@deleteCopy')->name('books.delete-copy');
    Route::post('books/make-main-copy', 'BooksController@makeMainCopy')->name('books.make-main-copy');
});


// MPESA
Route::post('/mpesa/confirmation', 'MpesaController@confirm');
Route::post('/mpesa/validation', 'MpesaController@validate');