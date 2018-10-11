<?php

function static_resource($path) {
    $base = env('STATIC_RESOURCE_URL');
    $base = $base[strlen($base)-1]=="/"?$base:$base.'/';
    $path = $path[0]=="/"?substr($path,1):$path;
    return $base.$path;
}
