<?php
namespace App\Http\Controllers;
use EasyWeChat\Factory;
use Log;

class WeixinController extends Controller {
    public function verify() {
        $config = [
            'app_id' => 'wx8e19b6be727a39f2',
            'secret' => 'd76ef29ba420ffe1529a737755e09c15',
            'token' => 'makefun',
            'response_type' => 'array',
        
            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];
        
        $app = Factory::officialAccount($config);
        
        $response = $app->server->serve();
        
        return $response;
    }

    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function($message){
            return "欢迎关注 overtrue！";
        });

        return $app->server->serve();
    }
}