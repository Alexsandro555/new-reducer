<?php

Route::group(['middleware' => 'web', 'prefix' => 'order', 'namespace' => 'Modules\Order\Http\Controllers'], function()
{
    Route::get('/', 'OrderController@index');
    Route::post('/', 'OrderController@store');
    Route::get('/items', 'OrderController@items');
    Route::get('/{number}', 'OrderController@success');
});
