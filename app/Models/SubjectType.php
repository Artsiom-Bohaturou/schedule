<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectType extends Model
{
    protected $fillable = ['abbreviated_name', 'full_name', 'exam', 'long'];
    public $timestamps = false;
}
