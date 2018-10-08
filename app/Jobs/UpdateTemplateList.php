<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Template;

class UpdateTemplateList implements ShouldQueue
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
        $app = app('wechat.official_account');
        $list = $app->template_message->getPrivateTemplates()['template_list'];
        \DB::table('templates')->delete();
        $i=1;
        foreach($list as $template){    
            $content = $template['content'];
            $id = $template['template_id'];
            preg_match_all('/(?:\{\{)(.*?)(?:\.DATA\}\})/',$content,$result);
            $results = $result[1];
            $args = "";
            foreach($results as $result){
                $args = $args." ".$result;
            }
            $record = new Template;
            $record->id=$i;
            $i++;
            $record->template_id=$id;
            $record->arguments=trim($args);
            $record->save();
        }
    }
}
