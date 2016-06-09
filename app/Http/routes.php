<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', function(){
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware'=>'oauth'], function(){

    Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);

    Route::group(['prefix'=>'project'], function(){
        Route::resource('', 'ProjectController', ['except' => ['create', 'edit']]);

        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note', 'ProjectController@store');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::delete('{id}/note/{noteId}', 'ProjectController@destroy');
        Route::put('{id}/note/{noteId}', 'ProjectController@update');

        Route::get('{id}/task', 'ProjectTasksController@index');
        Route::post('{id}/task', 'ProjectTasksController@store');
        Route::get('{id}/task/{taskId}', 'ProjectTasksController@show');
        Route::put('{id}/task/{taskId}', 'ProjectTasksController@update');
        Route::delete('{id}/task/{taskId}', 'ProjectTasksController@destroy');

        Route::get('{id}/members', 'ProjectController@members');
        Route::post('{id}/members', 'ProjectController@addMember');
        Route::delete('{id}/members/{userId}', 'ProjectController@removeMember');
        Route::get('{id}/members/{userId}', 'ProjectController@isMember');
    });

});
