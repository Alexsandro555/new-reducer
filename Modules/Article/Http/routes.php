<?php

Route::group(['middleware' => 'web', 'prefix' => 'article', 'namespace' => 'Modules\Article\Http\Controllers'], function () {
  Route::get('/', 'ArticleController@index');
  Route::post('/', 'ArticleController@save');
  Route::patch('/', 'ArticleController@save');

  Route::delete('/', 'ArticleController@destroy');
  Route::get('/{slug}', 'ArticleController@show');
  Route::get('/list', 'ArticleController@list');
});
