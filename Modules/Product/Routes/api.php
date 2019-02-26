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
Route::middleware('auth:api')->prefix('product')->group(function() {
  Route::get('/', 'ProductController@index');
  Route::post('/', 'ProductController@create');
  Route::patch('/', 'ProductController@save');
});


Route::middleware('auth:api')->prefix('attribute')->group(function() {
  Route::get('/', 'AttributeController@index');
  Route::get('/bindings', 'AttributeController@binding');
  Route::patch('/bindings', 'AttributeController@saveBindings');
  Route::get('/{id}', 'AttributeController@attributes');
  Route::post('/save', 'AttributeController@store');
  Route::patch('/', 'AttributeController@save');
  Route::post('/', 'AttributeController@create');
  Route::patch('/remove-bind-attributes', 'AttributeController@removeBindAttributes');
});


Route::middleware('auth:api')->prefix('category')->group(function() {
  Route::get('/{parentId?}', 'CategoryController@index');
  Route::post('/', 'CategoryController@create');
  Route::patch('/', 'CategoryController@store');
});


Route::middleware('auth:api')->prefix('product-category')->group(function() {
  Route::get('/', 'ProductCategoryController@index');
  Route::post('/', 'ProductCategoryController@create');
  Route::patch('/', 'ProductCategoryController@save');
});

Route::middleware('auth:api')->prefix('typeproduct')->group(function() {
  Route::get('/', 'TypeProductController@index');
  Route::post('/', 'TypeProductController@create');
  Route::patch('/', 'TypeProductController@save');
});

Route::middleware('auth:api')->prefix('line-product')->group(function() {
  Route::get('/', 'LineProductController@index');
  Route::post('/', 'LineProductController@create');
  Route::patch('/', 'LineProductController@save');
});

Route::middleware('auth:api')->prefix('attribute-unit')->group(function() {
  Route::get('/', 'AttributeUnitController@index');
  Route::post('/', 'AttributeUnitController@create');
  Route::patch('/', 'AttributeUnitController@save');
});

Route::middleware('auth:api')->prefix('attribute-group')->group(function() {
  Route::get('/', 'AttributeGroupController@index');
  Route::post('/', 'AttributeGroupController@create');
  Route::patch('/', 'AttributeGroupController@save');
});

Route::middleware('auth:api')->prefix('tnved')->group(function() {
  Route::get('/', 'TnvedController@index');
  Route::patch('/', 'TnvedController@save');
});

Route::middleware('auth:api')->prefix('attribute-list-value')->group(function() {
  Route::get('/', 'AttributeListValueController@index');
  Route::patch('/', 'AttributeListValueController@save');
  Route::delete('/', 'AttributeListValueController@delete');
});

Route::middleware('auth:api')->prefix('producer')->group(function() {
  Route::get('/', 'ProducerController@index');
  Route::post('/', 'ProducerController@create');
  Route::patch('/', 'ProducerController@save');
});

Route::middleware('auth:api')->prefix('trade-offer')->group(function() {
  Route::get('/', 'TradeOfferController@index');
  Route::post('/', 'TradeOfferController@create');
});

Route::middleware('auth:api')->prefix('sku')->group(function() {
  Route::get('/', 'SkuController@index');
  Route::post('/', 'SkuController@save');
  Route::patch('/', 'SkuController@save');
});

Route::middleware('auth:api')->prefix('sku-options')->group(function() {
  Route::get('/', 'SkuOptionsController@index');
  Route::post('/', 'SkuOptionsController@save');
  Route::patch('/', 'SkuOptionsController@save');
});

Route::middleware('auth:api')->prefix('attribute-type')->group(function() {
  Route::get('/', 'AttributeTypeController@index');
});

Route::middleware('auth:api')->prefix('attribute-value')->group(function() {
  Route::get('/', 'AttributeValueController@index');
  Route::patch('/', 'AttributeValueController@save');
});