<?php

Route::group(['middleware' => 'web', 'prefix' => 'page', 'namespace' => 'Modules\Page\Http\Controllers'], function()
{
  Route::get('/', 'PageController@index');
  Route::post('/', 'PageController@save');
  Route::patch('/', 'PageController@save');
  Route::get('/list', 'PageController@list');
  Route::delete('/', 'PageController@destroy');
  Route::get('/{slug}', 'PageController@show');
});
