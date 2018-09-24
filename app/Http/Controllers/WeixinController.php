<?php
namespace App\Http\Controllers;
use Log;
use EasyWeChat\Kernel\Messages\Image;

class WeixinController extends Controller {

    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function($message){
            switch($message['MsgType']) {
                case 'image':
                    return new Image('8aF4R8nSXuF3o7jaU15DZvmclJFQhF5mD7hSJSe2fzXAIpNFAt4WgavOE_qb30PL');
                    break;
                default:
                    return '感谢关注';
                    break;
            }
        });

        return $app->server->serve();
    }
}