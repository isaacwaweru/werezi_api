<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'API'], function () {
  Route::get('/init', 'InitController@init');

  Route::get('/home', 'HomeController@home');

  Route::post('/contact-us', 'ContactUsController@contactUs');

  Route::get('/pages/{page}', 'WebPagesController@show');

  Route::post('/login', 'LoginController@login');
  Route::post('/register', 'RegisterController@register');
  Route::post('/forgot-password', 'ForgotPasswordController@reset');
  Route::post('/logout', 'LoginController@logout');

  // Books
  Route::post('/books/offers', 'BooksController@offers');

  Route::get('/resource/{slug}', 'ResourceController@fetch');

  Route::post('/search', 'SearchController@search');
  Route::post('/full-search', 'SearchController@fullSearch');

  Route::get('/categories', 'CategoriesController@index');

  Route::post('/seller/register', 'SellerApplicationController@store');

  Route::group(['middleware' => 'auth:api'], function () {
      Route::get('/orders', 'OrdersController@index');
      Route::post('/orders', 'OrdersController@store');
      Route::get('/orders/{ref}', 'OrdersController@show');
      Route::get('/orders/{ref}/amount', 'OrdersController@getAmount');
      Route::post('/orders/{ref}/pay', 'OrdersController@pay');
      Route::post('/orders/stk', 'OrdersController@requestStk');

      Route::post('/products/rating', 'ProductsController@rate');

      Route::get('/account/overview', 'AccountController@overview');
      Route::post('/account/profile', 'ProfileController@update');
  });
});

Route::post('/mobile/confirmation', 'MpesaController@confirmation');
Route::post('/mobile/validation', 'MpesaController@validation');