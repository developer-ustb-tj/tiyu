<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Template;

class TemplateController extends Controller
{
    public function store(Request $request){
        $touser = $request->input('touser');
        $id = $request->input('id');
        $url = $request->input('url');
        // 查表对应 ID
        $template= Template::find($id);
        $template_id=$template->template_id;
        $args=$template->args;
        $data = collect();
        foreach($args as $item){
            $data->push($request->input($item));
        }
        $data = $data->toArray();
        $app = app('wechat.official_account');
        $status = $app->template_message->send(compact(['touser','template_id','url','data']));
        if($status['errcode'] == 0){
            $return = [
                'code' => 'success',
            ];
            return response()->json($return, 201);
        }
        $return = [
            'code' => $status['errmsg']
        ];
        return response()->json($return,404);
    }
}
