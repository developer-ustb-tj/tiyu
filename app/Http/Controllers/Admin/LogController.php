<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function list(){
        $parser = new \Kassner\LogParser\LogParser();
        $lines=file(env('NGINX_LOG_PATH'),FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $collection=collect([]);
        $parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" \"%{User-Agent}i"');
        foreach ($lines as $line) {
            $entry = $parser->parse($line);
            $collection->push($entry);
        }
        return $collection;
    }
}
