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

Route::get('/setDate', function() {
    $start = \Carbon\Carbon::create(2018,9,3,0,0,0);
    $end = \Carbon\Carbon::create(2019,1,6,0,0,0);
    $holidayStart=\Carbon\Carbon::create(2018,10,1,0,0,0);
    $holidayEnd=\Carbon\Carbon::create(2018,10,7,0,0,0);
    $i = $start->copy();
    $week = 0;
    while($i->lt($end)){ // 只有礼拜一会撞到这个判断
        $nextMon = $i->copy()->addWeek(1); // 下一个礼拜一
        while($i->lt($nextMon)){ // 这个循环完成对这周的写入,从周一写到周日
            if($i->gte($holidayStart) && $i->lte($holidayEnd)){ // 如果今天在国庆之间
                \DB::table('date_conversion')->insert([
                    'date' => $i->toDateString(),
                    'week' => -1
                ]);
                $i->addDay(1);
                $week = 3;
                continue;
            } 
            \DB::table('date_conversion')->insert([
                'date' => $i->toDateString(),
                'week' => $week
            ]);
            $i->addDay(1);
        }
        $week++; // 这个礼拜写入完成，周数增加
    }
    return $week;
    
});
