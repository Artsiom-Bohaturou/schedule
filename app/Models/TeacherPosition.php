<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPosition extends Model
{
    protected $fillable = ['abbreviated_name', 'full_name'];
    public $timestamps = false;

    public function teacher()
    {
        return $this->hasMany(Teacher::class);
    }
}
