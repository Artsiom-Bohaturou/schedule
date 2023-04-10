<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectTime extends Model
{
    protected $fillable = ['time_start', 'time_end'];
    public $timestamps = false;
}
