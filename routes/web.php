<?php

Route::get('/', function(){
    return redirect()->route('plans');
});

Route::get('/plans', 'PlansController@getAll')->name('plans');
Route::get('/plans/{id}', 'PlansController@getOne');
Route::get('/checkout/{id}', 'PaymentsController@checkout');
Route::post('/checkout', 'PaymentsController@payment')->name('checkout');

