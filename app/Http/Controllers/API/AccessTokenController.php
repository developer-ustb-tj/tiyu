<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessTokenController extends Controller
{
    public function index(){
        $app=app('wechat.official_account');
        $access_token = $app->access_token;
        return $access_token->getToken()['access_token'];
    }
}
