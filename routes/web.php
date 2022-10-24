<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
    // return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::get('/evaluation', 'EvaluationController@index')->middleware('auth')->name('evaluation');
Route::get('/evaluation-data', 'EvaluationController@getData')->middleware('auth')->name('evaluation-data');
Route::get('/evaluation/create/{id}', 'EvaluationController@create')->middleware('auth');
Route::get('/evaluation/get-history{id}', 'EvaluationController@getHistory')->middleware('auth');
Route::post('/evaluation', 'EvaluationController@store')->middleware('auth');
Route::delete('/evaluation/{id}', 'EvaluationController@destroy')->middleware('auth');

Route::get('/employee', 'EmployeeController@index')->middleware('auth')->name('employee');
Route::get('/employee/{id}', 'EmployeeController@getById')->middleware('auth');
Route::post('/employee', 'EmployeeController@store')->middleware('auth')->name('save-employee');
Route::delete('/employee/delete/{id}', 'EmployeeController@destroy')->middleware('auth');

Route::get('/position', 'PositionController@index')->middleware('auth')->name('position');
Route::get('/position/detail/{id}', 'PositionController@detail')->middleware('auth');
Route::post('/position', 'PositionController@store')->middleware('auth')->name('save-position');
Route::post('/position/detail', 'PositionController@storeDetail')->middleware('auth');
Route::delete('/position/delete/{id}', 'PositionController@destroy')->middleware('auth');

Route::get('/competency', 'CompetencyController@index')->middleware('auth')->name('competency');

Route::get('/performance', 'PerformanceController@index')->middleware('auth')->name('performance');

Route::get('/user', 'UsersController@index')->middleware('auth')->name('user');
Route::get('/pengguna-data', 'UsersController@userData')->middleware('auth');
Route::get('/pengguna/create', 'UsersController@create')->middleware('auth')->name('create-pengguna');
Route::post('/pengguna/store', 'UsersController@store')->middleware('auth')->name('store-pengguna');
Route::post('/pengguna/deactivate/{id}', 'UsersController@deactivate')->middleware('auth');
Route::post('/pengguna/activate/{id}', 'UsersController@activate')->middleware('auth');
Route::post('/pengguna/reset-password/{id}', 'UsersController@resetPassword')->middleware('auth');
Route::post('/pengguna/change-password', 'UsersController@changePassword')->middleware('auth')->name('change-password');