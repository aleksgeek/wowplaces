<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware'=>'throttle'], function () { 
    Route::get('/objects', ['uses'=>'ObjectsController@getObjects', 'as'=>'get-objects']);
    Route::get('/objects/{id_object}', ['uses'=>'ObjectsController@getObjectById', 'as'=>'get-object']);

    // auth
    Route::post('/authenticate', ['uses'=>'AuthController@authenticate', 'as'=>'post-auth']);
    Route::any('/register', ['uses'=>'AuthController@register', 'as'=>'post-register']);
    Route::post('/register/mail', ['uses'=>'AuthController@sendRegisterApproveMail']);
    Route::get('/register/approve/{approve_param}', ['uses'=>'AuthController@registerApprove', 'as'=>'register-approve']);

    Route::group(['middleware'=>['jwt.auth']], function () {        
        Route::post('/vote', ['uses'=>'VoteController@makeVoting', 'as'=>'post-vote']); 
    });
});


