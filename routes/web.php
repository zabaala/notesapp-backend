<?php
// Core Web Routes

//// If you want to use Laravel UI Auth, remove login route and put this one instead
//Auth::routes();
Route::get('/login', 'HomeCoreController@loginTemp')->name('login');

Route::get('/home', 'HomeCoreController@index')->name('home');


