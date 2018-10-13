<?php

namespace App\Http\Controllers;

use App\Http\Model\GetNumber;
use Illuminate\Http\Request;

class ValidatationController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function getonce(Request $request){

        $echostr=$request->input("echostr");//ok
        $msg=GetNumber::where('student_id','=',$echostr)->firstOrFail()->toArray();
//        return $msg;
//        return view('search')->with('msg',$echostr);
        return view('search',[
            'echostr'=>$msg
        ]);

    }
}
