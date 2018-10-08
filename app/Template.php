<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public function getArgsAttribute(){
        $arguments = trim($this->arguments);
        $result = preg_split('/ /', $arguments);
        return $result;
    }
}
