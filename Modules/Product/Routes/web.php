<?php

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

Route::prefix('attribute')->group(function() {
  Route::get('/', 'AttributeController@index');
  Route::get('/bindings', 'AttributeController@binding');
  Route::patch('/bindings', 'AttributeController@saveBindings');
  Route::get('/{id}', 'AttributeController@attributes');
  Route::post('/save', 'AttributeController@store');
  Route::patch('/', 'AttributeController@save');
  Route::post('/', 'AttributeController@create');
  Route::patch('/remove-bind-attributes', 'AttributeController@removeBindAttributes');
});

Route::prefix('category')->group(function() {
  Route::get('/{parentId?}', 'CategoryController@index');
  Route::post('/', 'CategoryController@create');
  Route::patch('/', 'CategoryController@store');
});

Route::prefix('product-category')->group(function() {
  Route::get('/', 'ProductCategoryController@index');
  Route::post('/', 'ProductCategoryController@create');
  Route::patch('/', 'ProductCategoryController@save');
});

Route::prefix('typeproduct')->group(function() {
  Route::get('/', 'TypeProductController@index');
  Route::post('/', 'TypeProductController@create');
  Route::patch('/', 'TypeProductController@save');
});

Route::prefix('line-product')->group(function() {
  Route::get('/', 'LineProductController@index');
  Route::post('/', 'LineProductController@create');
  Route::patch('/', 'LineProductController@save');
});

Route::prefix('attribute-unit')->group(function() {
  Route::get('/', 'AttributeUnitController@index');
  Route::post('/', 'AttributeUnitController@create');
  Route::patch('/', 'AttributeUnitController@save');
});

Route::prefix('attribute-group')->group(function() {
  Route::get('/', 'AttributeGroupController@index');
  Route::post('/', 'AttributeGroupController@create');
  Route::patch('/', 'AttributeGroupController@save');
});

Route::prefix('tnved')->group(function() {
  Route::get('/', 'TnvedController@index');
  Route::patch('/', 'TnvedController@save');
});

Route::prefix('attribute-list-value')->group(function() {
  Route::get('/', 'AttributeListValueController@index');
  Route::patch('/', 'AttributeListValueController@save');
  Route::delete('/', 'AttributeListValueController@delete');
});

Route::prefix('producer')->group(function() {
  Route::get('/', 'ProducerController@index');
  Route::post('/', 'ProducerController@create');
  Route::patch('/', 'ProducerController@save');
});

Route::prefix('trade-offer')->group(function() {
  Route::get('/', 'TradeOfferController@index');
  Route::post('/', 'TradeOfferController@create');
});

Route::prefix('sku')->group(function() {
  Route::get('/', 'SkuController@index');
  Route::post('/', 'SkuController@save');
  Route::patch('/', 'SkuController@save');
});

Route::prefix('sku-options')->group(function() {
  Route::get('/', 'SkuOptionsController@index');
  Route::post('/', 'SkuOptionsController@save');
  Route::patch('/', 'SkuOptionsController@save');
});

Route::prefix('attribute-type')->group(function() {
  Route::get('/', 'AttributeTypeController@index');
});

Route::prefix('attribute-value')->group(function() {
  Route::get('/', 'AttributeValueController@index');
  Route::patch('/', 'AttributeValueController@save');
});