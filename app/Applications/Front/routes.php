<?php

Route::get('/', ['as'=>'index', 'uses'=>'FrontendController@index']);
Route::get('about', ['as'=>'index', 'uses'=>'FrontendController@about']);
