<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessTokenController extends Controller
{
    /**
     * 可以用來直接代替微信 access token API
     * @param Request $request
     */
    public function index(Request $request){
        $name = $request->name;
        $app=\EasyWeChat::officialAccount($name);
        $access_token = $app->access_token;
        return $access_token->getToken();
    }
}
