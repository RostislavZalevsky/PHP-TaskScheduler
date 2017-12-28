<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "TaskController@Task");

Route::post('SignUP', 'PersonArea\RegistrationController@Registration');
Route::post('SignIN', 'PersonArea\AuthorizationController@Authorization');

Route::post('NewTask', 'TaskController@AddTask');
Route::post('EditTask', 'TaskController@EditTask');
Route::post('DeleteTask', 'TaskController@DeleteTask');

Route::get('Logout', 'PersonArea\AuthorizationController@LogoutAccount');
