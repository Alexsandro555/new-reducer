<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/product', function () {
  Route::get('/', function() {
    $temp = 10;
    dd($temp);
  });
  //Route::get('/', 'ProductController@index');
  Route::post('/', 'ProductController@create');
  Route::patch('/', 'ProductController@save');
});


