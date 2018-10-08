<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateClassTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
    }
}
