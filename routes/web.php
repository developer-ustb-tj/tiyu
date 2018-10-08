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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/upload', 'Admin\UploadController@upload');
Route::any('/a', 'Admin\UploadController@a');
Route::any('/b','ValidatationController@getonce');
Route::any('/write', 'Admin\UploadController@write');
Route::get('/download', 'Admin\DownloadController@download');
// nginx log 的页面路由
Route::get('nginx',function(){
    return view('nginx/list');
});

/* API 路由 */

Route::namespace('API')->prefix('api')->middleware('api')->group(function(){
    Route::get('/account/{name}/access_token','AccessTokenController@index');
    Route::post('/template','TemplateController@store');   
    Route::get('/template/test/{name}','AccessTokenController@test');
});

// 微信的 api 路由，添加 csrf exception
Route::middleware('api')->any('/api/weixin', 'WeixinController@serve');
// nginx log 的 api 路由
Route::get('/api/log', 'Admin\LogController@list');
