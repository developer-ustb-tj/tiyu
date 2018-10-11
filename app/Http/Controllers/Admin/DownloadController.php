<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class DownloadController extends Controller
{
    public function download()
    {
        if (!Auth::check()){
            return view('auth.login');
        }
        return response()->download(storage_path('slwd/slwd.xlsx'));
        
    }
}
