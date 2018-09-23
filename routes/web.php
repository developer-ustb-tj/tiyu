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
// 微信的 api 路由，添加 csrf exception
Route::any('/api/weixin', 'WeixinController@serve');
// nginx log 的 api 路由
Route::get('/api/log', 'Admin\LogController@list');
// nginx log 的页面路由
Route::get('nginx',function(){
    return view('nginx/list');
});

Route::get('/qr', function(){
    $data = 'https://www.youtube.com/watch?v=DLzxrzFCyOs&t=43s';
    for($i=8;$i<=10;$i++){
        for($j=1;$j<=4;$j++){
            for($k=1;$k<=10;$k++){
                $room=100*$j+$k;
                $filename=$i.$room.'.png';
                $path_prefix=$i.'/';
                $prefix='https://report.sspider.cn/issues/create?';
                is_writable(storage_path($i))?'':mkdir(storage_path($i));
                $uri='alley='.$i.'&room='.$room;
                $options = new \chillerlan\QRCode\QROptions([
                    'cachefile'=> storage_path($path_prefix.$filename),
                ]);
                $qrcode = new \chillerlan\QRCode\QRCode($options);
                $qrcode->render($prefix.$uri);
            }
        }
    }
    return 'hello world';
});
