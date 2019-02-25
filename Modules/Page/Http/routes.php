<?php

Route::group(['middleware' => 'web', 'prefix' => 'page', 'namespace' => 'Modules\Page\Http\Controllers'], function()
{
  Route::get('/', 'PageController@index');
  Route::post('/', 'PageController@save');
  Route::patch('/', 'PageController@save');
  Route::delete('/', 'PageController@destroy');

  Route::get('/list', 'PageController@list');
  Route::get('/{slug}', 'PageController@show');
});
