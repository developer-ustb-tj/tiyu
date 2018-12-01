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

// TODO: api 路由修改为用 Dingo API 接管
// TODO: API 版本由 header 接管
// TODO: 新建一个项目，require laravel cors 配置跨域资源共享

// TODO: nginx 日志解析需要改写为后端分页的形式
// TODO: nginx 日志 json api 更改为 json-api 格式
// Route::get('nginx',function(){
//     return view('nginx/list');
// });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

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
