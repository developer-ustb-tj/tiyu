<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';

    protected $fillable = ['student_id','student_name','student_score'];
}
