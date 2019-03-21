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

Route::get('/', function () {
    return view('welcome');
});




Route::get('/login','Web\LoginController@login');           //登录
Route::post('/login','Web\LoginController@loginDo');        //登录


Route::get('/user/center','Web\LoginController@uCenter')->middleware('check.login');       //个人中心