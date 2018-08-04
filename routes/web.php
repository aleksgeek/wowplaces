<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function() {
	View::addExtension('html', 'php');
	return View::make('index');
    //return view('index'); 
});

/*
Route::get('/objects', ['uses'=>'PagesController@showObjects', 'as'=>'objects-page']);

// auth
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () { 
	Route::get('/login', ['uses'=>'AuthController@loginForm', 'as'=>'auth.login-form']);
	Route::get('/register', ['uses'=>'AuthController@registerForm', 'as'=>'auth.register-form']);
	Route::get('/logout', ['uses'=>'AuthController@logout', 'as'=>'auth.logout']);

	Route::post('/login', ['uses'=>'AuthController@loginUser', 'as'=>'auth.login-user']);
	Route::post('/register', ['uses'=>'AuthController@registerUser', 'as'=>'auth.register-user']);
});
*/
