<?php
use EasyWeChat\Factory;

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
}