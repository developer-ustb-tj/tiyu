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
                case 'text':
                    $content = $message['Content'];
                    return $this->processText($content);
                    break;
                default:
                    return '感谢关注';
                    break;
            }
        });

        return $app->server->serve();
    }

    private function processText($text) {
        $mediaId = collect([
            '礼拜一' => function(){return new Image('mcnrPviQh7M7W3MO-V4H4aNqupSYaXMrMQwXa2s0q1x2uwAEmfeujVPo8dKeLeL0');},
            '礼拜二' => function(){return new Image('m5uPPWWCitA3YGf0DgsDKLifUL_sslHVfFvnqvL8poImi3XRHQZvoHbP1TROQAMa');},
            '礼拜三' => function(){return new Image('aQJtwcmi51mS__2MQwI5n1REmm3vGEGb8451o7AdJCN9yrjj42KCYag3QnCsuDDC');},
            '礼拜四' => function(){return new Image('3M-k7jYqd6ki5yOn6A5y0GwXahjkOiS7KWOwMmLSb4GFiw8zjC7jYCDDcmY5nLFz');},
            '礼拜五' => function(){return new Image('cwU5NYovMK--_21pXYOhiVvuY0sH8YBF5kSNu5VE12O6AS9vZ93U2UDInolgfFbi');},
            '礼拜六' => function(){return '没课';},
            '礼拜天' => function(){return '没课';},
        ]);
        $dateList = collect([
            '礼拜一',
            '礼拜二',
            '礼拜三',
            '礼拜四',
            '礼拜五',
            '礼拜六',
            '礼拜天',
        ]);
        if($text == "第几周") {
            return "第".\DB::table('date_conversion')->select('week')->where('date',\Carbon\Carbon::now()->toDateString())->first()->week.'周';
        }
        if($dateList->contains($text)){
            return $mediaId[$text]();
        }
        return '感谢关注';
    }
}