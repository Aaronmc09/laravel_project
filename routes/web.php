<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\PageController@home');

Route::post('/save', 'App\Http\Controllers\ContactController@saveContact');

Route::post('/update', 'App\Http\Controllers\ContactController@updateContact');
Route::get('/update', 'App\Http\Controllers\ContactController@getContactData');

Route::get('/delete', 'App\Http\Controllers\ContactController@deleteContact');