<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Template;
use EasyWeChat;
use DB;

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
        $accounts=['default'];
        foreach($accounts as $account){
            $list = $this->getTemplateList($account);
            $this->storeTemplateList($list);
        }
        
    }

    protected function getTemplateList($name){
        $app=\EasyWeChat::officialAccount($name);
        $list = $app->template_message->getPrivateTemplates()['template_list'];
        return $list;
    }

    protected function storeTemplateList($list){
        $result = [];
        foreach($list as $template){    
            preg_match_all('/(?:\{\{)(.*?)(?:\.DATA\}\})/',$template['content'], $mathches);
            $id = $this->hashTemplateId($template['content']);
            $template_id = $template['template_id'];
            $arguments = json_encode($mathches[1]);
            array_push($result, compact('id','template_id','arguments'));
        }
        DB::transaction(function() use ($result){
            DB::table('templates')->delete();
            DB::table('templates')->insert($result);
        });
    }
    
    /**
     * 将所有字符的 ascii 码相加
     * @param string $template_id
     * @return integer
     */
    protected function hashTemplateId($template_id){
        $result = 0;
        $length = strlen($template_id);
        for($i=0;$i<$length;$i++){
            $result+=ord($template_id[$i]);
        }
        return $result;
    }
}
