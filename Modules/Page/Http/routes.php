<?php

Route::group(['middleware' => 'web', 'prefix' => 'page', 'namespace' => 'Modules\Page\Http\Controllers'], function()
{
  Route::get('/list', 'PageController@list');
  Route::get('/{slug}', 'PageController@show');
});

Route::middleware('auth:api')->prefix('pages')->group(function() {
  Route::get('/', 'PageController@index');
  Route::post('/', 'PageController@load');
  Route::post('/default', 'PageController@create');
  Route::patch('/', 'PageController@save');
  Route::delete('/', 'PageController@destroy');
});
