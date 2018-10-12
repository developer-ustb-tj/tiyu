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

// TODO: nginx 日志解析需要改写为后端分页的形式
// Route::get('nginx',function(){
//     return view('nginx/list');
// });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/upload', 'Admin\UploadController@upload');
Route::any('/a', 'Admin\UploadController@a');
Route::any('/b','ValidatationController@getonce');
Route::any('/write', 'Admin\UploadController@write');
Route::get('/download', 'Admin\DownloadController@download');

/* API 路由 */

Route::namespace('API')->prefix('api')->group(function(){
    Route::get('/account/{name}/access_token','AccessTokenController@index');
    Route::post('/template','TemplateController@store');   
    Route::get('/template/test/{name}','AccessTokenController@test');
    Route::any('/weixin', 'WeixinController@serve');
    // Route::get('/log', 'LogController@list');
});

Route::namespace('Admin')->middleware('auth')->prefix('admin')->group(function(){
    Route::get('/upload', 'UploadController@create');
    Route::post('/upload', 'UploadController@store');
    Route::get('/upload/success', 'UploadController@success');
    Route::get('/upload/sample','UploadController@sample');
});
