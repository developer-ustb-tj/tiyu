<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DateTime;
class LogController extends Controller
{
    public function list(){
        $parser = new \Kassner\LogParser\LogParser();
        $lines=file(env('NGINX_LOG_PATH'),FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $collection=collect([]);
        $parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" \"%{User-Agent}i"');
        foreach ($lines as $line) {
            $entry = $parser->parse($line);
            $entry->time = DateTime::createFromFormat('d/M/Y:H:i:s P',$entry->time)->format('Y-m-d H:i:s');
            $collection->push($entry);
        }
        return $collection;
    }
}
