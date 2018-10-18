<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use EasyWeChat;

class UploadPicture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $account_name;

    /**
     * Create a new job instance.
     * @param string $path
     * @return void
     */
    public function __construct($path, $account_name='default')
    {
        $this->path = $path;
        $this->account_name = $account_name;
    }

    /**
     * 上传一张图片到微信服务器
     *
     * @return void
     */
    public function handle()
    {
        $app = EasyWeChat::official_account($this->account_name);
        $app->uploadImage($this->path);
    }
}
