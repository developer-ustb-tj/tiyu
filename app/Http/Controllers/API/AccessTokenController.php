<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessTokenController extends Controller
{
    public function index(Request $request){
        $name = $request->name;
        $app=\EasyWeChat::officialAccount($name);
        $access_token = $app->access_token;
        return $access_token->getToken()['access_token'];
    }
}
