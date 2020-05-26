<?php
// Core API Routes
Route::get('/', ['as'=>'api.index', 'uses'=>'ApiCoreController@index']);
Route::get('details', ['as'=>'api.details', 'uses'=>'ApiCoreController@details']);
