<?php

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/me', 'Auth\UserController@me');
Route::post('logout', 'Auth\LoginController@logout');