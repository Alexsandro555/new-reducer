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

Route::prefix('files')->group(function() {
  Route::post('/upload',
    [
      'before' => 'csrf',
      'uses' => 'FilesController@store'
    ]);
  Route::post('/wysiwyg/image', 'WysiwygController@store');
  Route::post('/get-images', ['before' => 'csrf', 'uses' => 'FilesController@getImages']);
  Route::get('/delete-file/{id}', 'FilesController@deleteFile');

  Route::get('/product-image/{id}', 'FilesController@productImage');
  Route::get('/figure/{id}/{type}/{product_id?}', 'FilesController@figure');
  // манипуляция типом файла
  Route::get('/type-files', 'TypeFileController@index');
  Route::post('/type-files/add',
    [
      'before' => 'csrf',
      'uses' => 'TypeFileController@create'
    ]);
  Route::post('/type-files/add-format',
    [
      'before' => 'csrf',
      'uses' => 'TypeFileController@addFormat'
    ]);
  Route::post('/type-files/del-format',
    [
      'before' => 'csrf',
      'uses' => 'TypeFileController@delFormat'
    ]);
  Route::post('/type-files/update',
    [
      'before' => 'csrf',
      'uses' => 'TypeFileController@update'
    ]);
});

