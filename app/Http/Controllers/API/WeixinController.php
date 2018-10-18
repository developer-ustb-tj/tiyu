<?php
namespace App\Http\Controllers\API;
use Log;
use EasyWeChat\Kernel\Messages\Image;
use App\Http\Controllers\Controller;

class WeixinController extends Controller {
    
    /**
     * TODO: 学生查询体测成绩的逻辑
     */
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

    /**
     * TODO: 设一个定时任务，定时分配上传图片的队列任务
     */
    private function processText($text) {
        $mediaId = collect([
            '礼拜一' => function(){return new Image('mcnrPviQh7M7W3MO-V4H4aNqupSYaXMrMQwXa2s0q1x2uwAEmfeujVPo8dKeLeL0');},
            '礼拜二' => function(){return new Image('m5uPPWWCitA3YGf0DgsDKLifUL_sslHVfFvnqvL8poImi3XRHQZvoHbP1TROQAMa');},
            '礼拜三' => function(){return new Image('aQJtwcmi51mS__2MQwI5n1REmm3vGEGb8451o7AdJCN9yrjj42KCYag3QnCsuDDC');},
            '礼拜四' => function(){return new Image('3M-k7jYqd6ki5yOn6A5y0GwXahjkOiS7KWOwMmLSb4GFiw8zjC7jYCDDcmY5nLFz');},
            '礼拜五' => function(){return new Image('cwU5NYovMK--_21pXYOhiVvuY0sH8YBF5kSNu5VE12O6AS9vZ93U2UDInolgfFbi');},
            '礼拜六' => function(){return '没课';},
            '礼拜天' => function(){return '没课';},
            '第几周' => function(){return "第".\DB::table('date_conversion')->select('week')->where('date',\Carbon\Carbon::now()->toDateString())->first()->week.'周'; },
            '今天' => function() {
                // 日期
                $now = \Carbon\Carbon::now();
                $date = $now->toDayDateTimeString();
                $day = $now->dayOfWeek;
                $week = \DB::table('date_conversion')->select('week')->where('date',\Carbon\Carbon::now()->toDateString())->first()->week;
                // 天气
                $url = 'https://restapi.amap.com/v3/weather/weatherInfo';
                $client = new \GuzzleHttp\Client();
                $query = [
                    'key' => config('services.weather.key'),
                    'city' => '天津',
                    'output' => 'json'
                ];
                $response = $client->get($url, ['query' => $query])->getBody()->getContents();
                $response = json_decode($response)->lives[0];
                // 课程
                $course = $this->course($day, $week);
                $number = $course->count();
                $courseString="";
                foreach($course as $item) {
                    $alley = $item->alley;
                    $room = $item->room;
                    $name = $item->name;
                    $courseString=$courseString."$name\n$alley 教 $room\n";
                }
                // 组装
                $result = "$date\n$response->weather $response->temperature 摄氏度\n你今天有 $number 节课\n$courseString";
                return $result;
            }
        ]);
        $dateList = collect([
            '礼拜一',
            '礼拜二',
            '礼拜三',
            '礼拜四',
            '礼拜五',
            '礼拜六',
            '礼拜天',
            '第几周',
            '今天'
        ]);
        if($dateList->contains($text)){
            return $mediaId[$text]();
        }
        return '感谢关注';
    }

    private function course($day, $week) {
        $course=collect();
        return \DB::table('course')->where('day',$day)->get()->filter(function($value, $key) use ($week) {
            $turn = preg_split("/,/",$value->turn);
            $turn = collect($turn);
            return $turn->contains($week);
        });
    }
}