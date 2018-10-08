<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateIssuesQRCode implements ShouldQueue
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
    }
}
