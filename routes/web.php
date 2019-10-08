<?php

Route::get('/menu-left', 'SiteController@menuLeft');
Route::get('/admin', ['uses' => '\Modules\Auth\Http\Controllers\AdminController@index', 'as' => 'master']);


Route::get('/', 'SiteController@index')->name('main');
Route::get('/equipment', ['uses' => 'SiteController@equipment', 'as' => 'equipment']);
Route::get('/sale', ['uses' => 'SiteController@sale', 'as' => 'sale']);
Route::get('/special', ['uses' => 'SiteController@special', 'as' => 'special']);
Route::get('/find/{text?}', ['uses' => 'FindController@index', 'as' => 'find']);
Route::get('/filter/{lineProductId}', 'SiteController@filter');
Route::get('/catalog/detail/{slug}',['uses' => 'SiteController@detail', 'as' => 'catalog.detail']);
Route::get('/catalog/attributes/{id}', 'SiteController@lineProductAttributes');
Route::get('/catalog/{slug}', ['uses'=>'SiteController@catalog', 'as'=>'catalog.product-category']);
Route::get('/catalog/{slugProductCategory}/{slug}', ['uses' => 'SiteController@typeProduct', 'as'=>'catalog.type-product']);
Route::get('/catalog/{slugProductCategory}/{slugTypeProduct}/{slug}', ['uses' => 'SiteController@lineProduct', 'as'=>'catalog.line-product']);
Route::get('/{slug}', '\Modules\Page\Http\Controllers\PagesController@show');