<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public function getArgsAttribute(){
        $result = json_decode($this->arguments);
        return $result;
    }
}
