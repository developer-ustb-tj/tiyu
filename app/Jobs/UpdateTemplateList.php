<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Template;
use EasyWeChat;

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
        \DB::table('templates')->delete();
        $accounts=['default'];
        foreach($accounts as $account){
            $list = $this->getTemplateList('default');
            $this->storeTemplateList($list);
        }
        
    }

    protected function getTemplateList($name){
        $app=\EasyWeChat::officialAccount($name);
        $list = $app->template_message->getPrivateTemplates()['template_list'];
        return $list;
    }

    protected function storeTemplateList($list){
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
            $record->id=$this->hashTemplateId($id);
            $record->template_id=$id;
            $record->arguments=trim($args);
            $record->save();
        }
    }
    
    protected function hashTemplateId($template_id){
        $result = 0;
        $length = strlen($template_id);
        for($i=0;$i<43;$i++){
            $result+=ord($template_id[$i]);
        }
        return $result;
    }
}
